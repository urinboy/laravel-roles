<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Show User') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('This page is for showing user details') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        <a href="{{ route('users.index') }}"
           class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
           wire:navigate>
            {{ __('Back') }}
        </a>

        <div class="mt-6 flex justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 w-full max-w-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">ID: {{ $user->id }}</span>
                </div>
                <div class="space-y-3">
                    <p class="text-gray-600 dark:text-gray-300"><strong>{{ __('Email') }}:</strong> {{ $user->email }}</p>
                    <p class="text-gray-600 dark:text-gray-300"><strong>{{ __('Created At') }}:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>