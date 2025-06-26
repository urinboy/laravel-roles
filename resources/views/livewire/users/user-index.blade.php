<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your users') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        @session('success')
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 w-6 h-6 mr-2 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                <span class="font-medium">{{ $value }}</span>
            </div>
        @endsession

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
                        <th scope="col" class="px-4 py-3 sm:px-6">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 sm:px-6 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                            <td class="px-4 py-3 sm:px-6 text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                            <td class="px-4 py-3 sm:px-6 text-gray-600 dark:text-gray-300 break-all">{{ $user->email }}</td>
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
                            <td colspan="4" class="px-4 py-3 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No users found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>