<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Show Building') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('This page is for showing building details') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        <a href="{{ route('buildings.index') }}"
           class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition"
           wire:navigate>
            {{ __('Back') }}
        </a>

        <div class="mt-6 flex justify-center">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-700 w-full max-w-lg transition">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $building->name }}</h3>
                    <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 tracking-wide">ID: {{ $building->id }}</span>
                </div>
                <div class="space-y-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">{{ __('Description') }}:</span>
                        <span>{{ $building->description ?: __('No description') }}</span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">{{ __('Address') }}:</span>
                        <span>{{ $building->address ?: __('No address') }}</span>
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">{{ __('Status') }}:</span>
                        @if($building->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200">
                                {{ __('Active') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200">
                                {{ __('Inactive') }}
                            </span>
                        @endif
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-xs">
                        <span class="font-semibold">{{ __('Created At') }}:</span> {{ $building->created_at->format('Y-m-d H:i') }}
                    </p>
                    <p class="text-gray-500 dark:text-gray-400 text-xs">
                        <span class="font-semibold">{{ __('Updated At') }}:</span> {{ $building->updated_at->format('Y-m-d H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
