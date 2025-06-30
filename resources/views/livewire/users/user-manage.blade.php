@can('user.list')
<div>
    <div class="mb-6 w-full">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Users') }}</h1>
        <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your users') }}</p>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div>

    @if (session()->has('success'))
        <div class="mb-4 flex items-center justify-between bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button type="button" wire:click="$set('showModal', false)" class="text-xl font-bold text-green-400 hover:text-green-700">&times;</button>
        </div>
    @endif

    @can('user.create')
    <div class="flex justify-end mb-4">
        <button wire:click="openModal('create')"
            class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded hover:bg-blue-100 transition"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add User') }}
        </button>
    </div>
    @endcan

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">{{ __('Name') }}</th>
                    <th class="px-6 py-3">{{ __('Email') }}</th>
                    <th class="px-6 py-3">{{ __('Phone') }}</th>
                    <th class="px-6 py-3">{{ __('Role') }}</th>
                    <th class="px-6 py-3 text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-3 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                        <td class="px-6 py-3 text-gray-700 dark:text-gray-200">
                            {{ $user->first_name ?? '' }} {{ $user->last_name ?? $user->name }}
                        </td>
                        <td class="px-6 py-3 text-gray-700 dark:text-gray-200 break-all">{{ $user->email }}</td>
                        <td class="px-6 py-3 text-gray-700 dark:text-gray-200">{{ $user->phone }}</td>
                        <td class="px-6 py-3">
                            @if ($user->roles->count())
                                @foreach ($user->roles as $role)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold
                                        @if(strtolower($role->name) === 'admin' || strtolower($role->name) === 'administrator')
                                            bg-red-500 text-white
                                        @else
                                            bg-orange-500 text-white
                                        @endif
                                    ">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-gray-400 dark:text-gray-500 text-xs">{{ __('No role') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 flex flex-row gap-2 justify-center">
                            @can('user.edit')
                            <button wire:click="openModal('edit', {{ $user->id }})"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-100 dark:bg-blue-800 hover:bg-blue-200 dark:hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300"
                                title="{{ __('Edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-200" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                </svg>
                            </button>
                            @endcan
                            @can('user.delete')
                            <button wire:click="openModal('delete', {{ $user->id }})"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300"
                                title="{{ __('Delete') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     class="w-5 h-5 text-red-700 dark:text-red-200" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                </svg>
                            </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-3 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No users found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('livewire.users.partials.user-modal')
</div>
@else
    <div class="text-red-500 p-4">{{ __("You do not have permission to view users.") }}</div>
@endcan
