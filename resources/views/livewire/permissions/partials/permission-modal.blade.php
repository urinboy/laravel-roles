<div x-data="{ show: @entangle('showModal') }" x-show="show"
    class="fixed inset-0 flex items-center justify-center z-50"
    style="background: rgba(38, 50, 56, 0.12);" x-cloak>
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-lg mx-2 border border-gray-100 dark:border-gray-700 animate-fade-in">
        <div class="px-8 pt-8 pb-2">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                    @if ($modalType === 'edit')
                        {{ __('Edit Permission') }}
                    @elseif($modalType === 'delete')
                        {{ __('Delete Permission') }}
                    @else
                        {{ __('Add Permission') }}
                    @endif
                </h3>
                <button @click="show = false" wire:click="closeModal"
                    class="text-gray-400 hover:text-red-500 text-3xl font-bold transition leading-none focus:outline-none cursor-pointer">&times;</button>
            </div>
            <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}">
                @if ($modalType === 'delete')
                    <p class="mb-2 text-gray-800 dark:text-gray-100">
                        {{ __('Are you sure you want to delete this permission?') }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('This action cannot be undone.') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                        {{ __('Delete permission') }} <strong class="text-red-600">{{ $name }}</strong>?
                    </p>
                @else
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1 text-gray-700 dark:text-gray-200">
                            {{ __('Permission Name') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" wire:model.lazy="name" placeholder="e.g., user.create"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 shadow-sm" />
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="flex justify-end gap-2 mt-8 mb-2">
                    <button type="button" @click="show = false" wire:click="closeModal"
                        class="px-6 py-2 rounded-xl font-medium text-gray-700 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 transition cursor-pointer">
                        {{ __('Cancel') }}
                    </button>
                    @if ($modalType === 'delete')
                        <button type="submit"
                            class="px-6 py-2 rounded-xl font-medium text-white bg-red-600 hover:bg-red-700 transition">
                            {{ __('Delete') }}
                        </button>
                    @else
                        <button type="submit"
                            class="px-6 py-2 rounded-xl font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                            {{ $modalType === 'edit' ? __('Update') : __('Create') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>