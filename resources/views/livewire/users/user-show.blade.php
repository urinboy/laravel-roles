<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('User Details') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Information about the selected user') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>
    <div>
        <a href="{{ route('users.index') }}"
           class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
           wire:navigate>
            {{ __('Back') }}
        </a>

        <div class="mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow p-6">
            <div class="mb-4">
                <span class="block text-sm text-gray-600 dark:text-gray-300">{{ __('Name') }}</span>
                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span>
            </div>
            <div class="mb-4">
                <span class="block text-sm text-gray-600 dark:text-gray-300">{{ __('Email') }}</span>
                <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->email }}</span>
            </div>
            <div class="mb-4">
                <span class="block text-sm text-gray-600 dark:text-gray-300">{{ __('Roles') }}</span>
                @if($user->roles->count())
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($user->roles as $role)
                            <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 text-xs">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-400 dark:text-gray-500 text-xs">{{ __('No roles') }}</span>
                @endif
            </div>
            <div class="mb-4">
                <span class="block text-sm text-gray-600 dark:text-gray-300">{{ __('Created At') }}</span>
                <span class="text-base text-gray-900 dark:text-white">{{ $user->created_at->format('Y-m-d H:i') }}</span>
            </div>
            <div>
                <span class="block text-sm text-gray-600 dark:text-gray-300">{{ __('Updated At') }}</span>
                <span class="text-base text-gray-900 dark:text-white">{{ $user->updated_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>
    </div>
</div>
