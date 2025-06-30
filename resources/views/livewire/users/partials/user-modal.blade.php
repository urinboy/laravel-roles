<div x-data="{ show: @entangle('showModal') }" x-show="show"
     class="fixed inset-0 flex items-center justify-center z-50"
     style="background: rgba(38, 50, 56, 0.12);" x-cloak>
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 animate-fade-in dark:bg-gray-800 dark:border-gray-700">
        <div class="px-7 pt-7 pb-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    @if ($modalType === 'edit')
                        {{ __('Edit User') }}
                    @elseif($modalType === 'delete')
                        {{ __('Delete User') }}
                    @else
                        {{ __('Add User') }}
                    @endif
                </h3>
                <button @click="show = false" wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300 text-2xl font-bold transition leading-none focus:outline-none cursor-pointer">&times;</button>
            </div>
            <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}">
                @if($modalType === 'delete')
                    <p class="mb-2 text-gray-800">{{ __('Are you sure you want to delete this user?') }}</p>
                    <p class="text-sm text-gray-600">{{ __('This action cannot be undone.') }}</p>
                    <p class="font-bold text-red-600 mt-2">{{ $name }} ({{ $email }})</p>
                @else
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Name') }} <span class="text-red-600">*</span></label>
                        <input type="text" wire:model.lazy="name"
                            placeholder="{{ __('Name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                        @error('name') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col md:flex-row gap-2 mb-3">
                        <div class="w-full">
                            <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('First Name') }}</label>
                            <input type="text" wire:model.lazy="first_name"
                                placeholder="{{ __('First Name') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                            @error('first_name') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-full">
                            <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Last Name') }}</label>
                            <input type="text" wire:model.lazy="last_name"
                                placeholder="{{ __('Last Name') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                            @error('last_name') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Phone') }}</label>
                        <input type="text" wire:model.lazy="phone"
                            placeholder="{{ __('Phone') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                        @error('phone') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Email') }} <span class="text-red-600">*</span></label>
                        <input type="email" wire:model.lazy="email"
                            placeholder="{{ __('Email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                        @error('email') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Role') }} <span class="text-red-600">*</span></label>
                        <select wire:model.lazy="role"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500">
                            <option value="">{{ __('Select Role') }}</option>
                            @foreach($roles as $roleOption)
                                <option value="{{ $roleOption->name }}">{{ ucfirst($roleOption->name) }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- PASSWORD INPUT WITH EYE -->
                    <div x-data="{ show: false }" class="relative mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Password') }}{{ $modalType === 'create' ? ' *' : '' }}</label>
                        <input :type="show ? 'text' : 'password'" wire:model.lazy="password"
                            placeholder="{{ __('Password') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                        <button type="button" tabindex="-1"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 cursor-pointer"
                            @click="show = !show">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.969 9.969 0 013.519-4.362m3.127-1.662A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.293 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zm0 0l.01-.011"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3l18 18"/>
                            </svg>
                        </button>
                        @error('password') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- CONFIRM PASSWORD INPUT WITH EYE -->
                    <div x-data="{ show: false }" class="relative mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ $modalType === 'create'
                            ? __('Confirm Password')
                            : __('Confirm Password (leave blank if not changing)')
                        }}</label>
                        <input :type="show ? 'text' : 'password'" wire:model.lazy="confirm_password"
                            placeholder="{{ __('Confirm Password') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                        <button type="button" tabindex="-1"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 cursor-pointer"
                            @click="show = !show">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.969 9.969 0 013.519-4.362m3.127-1.662A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.973 9.973 0 01-4.293 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zm0 0l.01-.011"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3l18 18"/>
                            </svg>
                        </button>
                        @error('confirm_password') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endif
                <div class="flex justify-end gap-2 mt-6 mb-2">
                    <button type="button" @click="show = false" wire:click="closeModal"
                        class="px-5 py-2 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition cursor-pointer">
                        {{ __('Cancel') }}
                    </button>
                    @if ($modalType === 'delete')
                        <button type="submit"
                            class="px-5 py-2 rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 transition  cursor-pointer">
                            {{ __('Delete') }}
                        </button>
                    @else
                        <button type="submit"
                            class="px-5 py-2 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 transition  cursor-pointer">
                            {{ $modalType === 'edit' ? __('Update') : __('Create') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
