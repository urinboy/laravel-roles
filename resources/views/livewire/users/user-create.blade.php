<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create User') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for creating new users') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>
    
    <div>
        <a href="{{ route('users.index') }}"
           class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
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
                
                <flux:input
                    wire:model.live="email"
                    label="{{ __('Email') }}"
                    type="email"
                    placeholder="{{ __('Enter email') }}"
                    :error="$errors->first('email')"
                />
                
                <flux:input
                    wire:model.live="password"
                    label="{{ __('Password') }}"
                    type="password"
                    placeholder="{{ __('Enter password') }}"
                    :error="$errors->first('password')"
                />
                
                <flux:input
                    wire:model.live="confirm_password"
                    label="{{ __('Confirm Password') }}"
                    type="password"
                    placeholder="{{ __('Enter confirm password') }}"
                    :error="$errors->first('confirm_password')"
                />
                
                <flux:button type="submit" variant="primary">
                    {{ __('Create User') }}
                </flux:button>
            </form>
        </div>
    </div>
</div>