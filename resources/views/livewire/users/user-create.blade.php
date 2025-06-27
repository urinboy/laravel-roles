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

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        {{ __('Role') }}
                    </label>
                    <select
                        wire:model.live="role"
                        class="block w-full p-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                    >
                        <option value="">{{ __('Select role') }}</option>
                        @foreach($allRoles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->first('role'))
                        <div class="text-red-500 text-xs mt-2">{{ $errors->first('role') }}</div>
                    @endif
                </div>

                <flux:button type="submit" variant="primary">
                    {{ __('Create User') }}
                </flux:button>
            </form>
        </div>
    </div>
</div>
