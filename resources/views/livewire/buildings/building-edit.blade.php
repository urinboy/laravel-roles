<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Edit Building') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for editing buildings') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        <a href="{{ route('buildings.index') }}"
           class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
           wire:navigate>
            {{ __('Back') }}
        </a>

        <div>
            <form wire:submit="submit" class="mt-6 space-y-6">
                <flux:input
                    wire:model.live="name"
                    label="{{ __('Name') }} *"
                    placeholder="{{ __('Enter building name') }}"
                    :error="$errors->first('name')"
                />

                <flux:textarea
                    wire:model.live="description"
                    label="{{ __('Description') }}"
                    placeholder="{{ __('Enter description') }}"
                    :error="$errors->first('description')"
                />

                <flux:input
                    wire:model.live="address"
                    label="{{ __('Address') }}"
                    placeholder="{{ __('Enter address') }}"
                    :error="$errors->first('address')"
                />

                <div class="flex items-center">
                    <input type="checkbox" id="is_active" wire:model.live="is_active" class="mr-2" />
                    <label for="is_active" class="text-sm">{{ __('Active') }}</label>
                </div>
                @if($errors->first('is_active'))
                    <div class="text-red-500 text-xs">{{ $errors->first('is_active') }}</div>
                @endif

                <flux:button type="submit" variant="primary">
                    {{ __('Submit') }}
                </flux:button>
            </form>
        </div>
    </div>
</div>
