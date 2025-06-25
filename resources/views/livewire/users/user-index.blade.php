<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your users') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        <div x-data="{ showSuccess: false, successMessage: '' }" x-on:flash-success.window="showSuccess = true; successMessage = $event.detail.message; setTimeout(() => showSuccess = false, 3000)">
            <div x-show="showSuccess" class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 w-6 h-6 mr-2 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                <span class="font-medium" x-text="successMessage"></span>
            </div>
        </div>

        <div class="flex justify-end mb-6">
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
               wire:navigate>
                {{ __('Create User') }}
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($users as $user)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $user->id }}</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 break-all">{{ $user->email }}</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('users.edit', $user->id) }}"
                           wire:navigate
                           class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ __('Edit') }}
                        </a>
                        <button
                            wire:click="delete({{ $user->id }})"
                            wire:confirm="Are you sure you want to delete this user?"
                            class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-700 rounded hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            {{ __('Delete') }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center p-6 text-gray-500 dark:text-gray-400">
                    {{ __('No users found') }}
                </div>
            @endforelse
        </div>
    </div>
</div>