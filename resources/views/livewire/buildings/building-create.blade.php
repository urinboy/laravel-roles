<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create Building') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for creating new building') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>
    
    <div>
        <a href="{{ route('buildings.index') }}"
           class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
           wire:navigate>
            {{ __('Back') }}
        </a>

        <div>
            <form wire:submit="submit" class="mt-6 space-y-6">
                <flux:input
                    wire:model.live="name"
                    label="{{ __('Name') }}"
                    placeholder="{{ __('Enter name') }}"
                    :error="$errors->first('name')"
                />
                
                <flux:button type="submit" variant="primary">
                    {{ __('Create Building') }}
                </flux:button>
            </form>
        </div>
    </div>
</div>