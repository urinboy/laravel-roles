<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your users') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        <x-alert-success />
        <div class="flex justify-end mb-4">
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
               wire:navigate>
                {{ __('Create User') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 sm:px-6">{{ __('ID') }}</th>
                        <th scope="col" class="px-4 py-3 sm:px-6">{{ __('Name') }}</th>
                        <th scope="col" class="px-4 py-3 sm:px-6">{{ __('Email') }}</th>
                        <th scope="col" class="px-4 py-3 sm:px-6">{{ __('Roles') }}</th>
                        <th scope="col" class="px-4 py-3 sm:px-6">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 sm:px-6 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                            <td class="px-4 py-3 sm:px-6 text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                            <td class="px-4 py-3 sm:px-6 text-gray-600 dark:text-gray-300 break-all">{{ $user->email }}</td>
                            <td class="px-4 py-3 sm:px-6">
                                @if($user->roles->count())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 text-xs">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-xs">{{ __('No roles') }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 sm:px-6 flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('users.show', $user->id) }}"
                                   wire:navigate
                                   class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                    {{ __('Show') }}
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}"
                                   wire:navigate
                                   class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    {{ __('Edit') }}
                                </a>
                                <button
                                    wire:click="delete({{ $user->id }})"
                                    wire:confirm="Are you sure you want to delete this user?"
                                    class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                    {{ __('Delete') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No users found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
