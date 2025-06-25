<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create User') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for creating new users') }}</flux:subheading>
        <flux:separator variant="subtitle" />
    </div>

    <div>
        @if (session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 w-6 h-6 mr-2 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div>
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
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
</div>