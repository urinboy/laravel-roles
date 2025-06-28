<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('User') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('List of all users in the system') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>
    <x-alert-success />
    <div class="flex justify-end items-center mb-6">

        @can('user.create')
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition">
                {{ __('Add User') }}
            </a>
        @endcan
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-900 dark:text-gray-100">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 font-semibold">{{ __('User') }}</th>
                    <th class="px-6 py-3 font-semibold">{{ __('Email') }}</th>
                    <th class="px-6 py-3 font-semibold">{{ __('Phone') }}</th>
                    <th class="px-6 py-3 font-semibold">{{ __('Role') }}</th>
                    <th class="px-6 py-3 font-semibold text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <!-- User info with avatar -->
                        <td class="px-6 py-4 flex items-center gap-3 min-w-[220px]">
                            @php
                                $letters = strtoupper(mb_substr($user->first_name ?? $user->name, 0, 1, 'UTF-8'))
                                    .(isset($user->last_name) ? mb_substr($user->last_name, 0, 1, 'UTF-8') : '');
                            @endphp
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-lg shrink-0">
                                {{ $letters }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $user->first_name ?? '' }} {{ $user->last_name ?? $user->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @ {{ $user->username ?? \Str::slug($user->name, '_') }}
                                </div>
                            </div>
                        </td>
                        <!-- Email -->
                        <td class="px-6 py-4 break-all text-gray-900 dark:text-gray-100">{{ $user->email }}</td>
                        <!-- Phone -->
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $user->phone }}</td>
                        <!-- Roles -->
                        <td class="px-6 py-4">
                            @if($user->roles->count())
                                @foreach($user->roles as $role)
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
                        <!-- Actions -->
                        <td class="px-6 py-4 flex gap-3 justify-center items-center">
                            @can('user.view')
                                <a href="{{ route('users.show', $user->id) }}" title="{{ __('View') }}"
                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition" wire:navigate>
                                    <!-- Eye icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"
                                                fill="none"/>
                                    </svg>
                                </a>
                            @endcan
                            @can('user.edit')
                                <a href="{{ route('users.edit', $user->id) }}" title="{{ __('Edit') }}"
                                   class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-100 transition" wire:navigate>
                                    <!-- Pencil icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                    </svg>
                                </a>
                            @endcan
                            @can('user.delete')
                                <button type="button" title="{{ __('Delete') }}"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition"
                                        wire:click="$emit('openDeleteModal', {{ $user->id }})">
                                    <!-- Trash icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                    </svg>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No users found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
