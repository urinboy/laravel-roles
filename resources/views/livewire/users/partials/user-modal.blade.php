<div x-data="{ show: @entangle('showModal') }" x-show="show"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 dark:bg-opacity-70 z-50"
     x-cloak>
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full
                border border-gray-200 dark:border-gray-700
                max-w-full sm:max-w-lg md:max-w-xl lg:max-w-2xl
                mx-2 sm:mx-4 md:mx-0">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                @if($modalType === 'edit')
                    {{ __('Edit User') }}
                @elseif($modalType === 'delete')
                    {{ __('Delete User') }}
                @else
                    {{ __('Add User') }}
                @endif
            </h3>
            <button @click="show = false" wire:click="closeModal"
                class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300 text-2xl font-bold transition">&times;</button>
        </div>
        <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}">
            @if($modalType === 'delete')
                <p class="mb-2">{{ __('Are you sure you want to delete this user?') }}</p>
                <p class="font-bold text-red-600 dark:text-red-400">{{ $name }} ({{ $email }})</p>
            @else
                <input type="text" wire:model.lazy="name"
                    placeholder="{{ __('Name') }}"
                    class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                />
                @error('name') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror

                <div class="flex flex-col md:flex-row gap-2">
                    <input type="text" wire:model.lazy="first_name"
                        placeholder="{{ __('First Name') }}"
                        class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                    />
                    <input type="text" wire:model.lazy="last_name"
                        placeholder="{{ __('Last Name') }}"
                        class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                    />
                </div>
                @error('first_name') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror
                @error('last_name') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror

                <input type="text" wire:model.lazy="phone"
                    placeholder="{{ __('Phone') }}"
                    class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                />
                @error('phone') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror

                <input type="email" wire:model.lazy="email"
                    placeholder="{{ __('Email') }}"
                    class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                />
                @error('email') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror

                <select wire:model.lazy="role"
                    class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100">
                    <option value="">{{ __('Select Role') }}</option>
                    @foreach($roles as $roleOption)
                        <option value="{{ $roleOption->name }}">{{ ucfirst($roleOption->name) }}</option>
                    @endforeach
                </select>
                @error('role') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror

                <!-- PASSWORD INPUT WITH EYE -->
                <div x-data="{ show: false }" class="relative mb-3">
                    <input :type="show ? 'text' : 'password'"
                        wire:model.lazy="password"
                        placeholder="{{ __('Password') }}"
                        class="border p-2 w-full rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 pr-10"
                    />
                    <button type="button" tabindex="-1"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100"
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
                </div>
                @error('password') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror

                <!-- CONFIRM PASSWORD INPUT WITH EYE -->
                <div x-data="{ show: false }" class="relative mb-3">
                    <input :type="show ? 'text' : 'password'"
                        wire:model.lazy="confirm_password"
                        placeholder="{{ $modalType === 'create'
                            ? __('Confirm Password')
                            : __('Confirm Password (leave blank if not changing)')
                        }}"
                        class="border p-2 w-full rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100 pr-10"
                    />
                    <button type="button" tabindex="-1"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100"
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
                </div>
                @error('confirm_password') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror
            @endif
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="show = false" wire:click="closeModal"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                    {{ __('Cancel') }}
                </button>
                @if($modalType === 'delete')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition">
                        {{ __('Delete') }}
                    </button>
                @else
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 transition">
                        {{ $modalType === 'edit' ? __('Update') : __('Create') }}
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
