<div x-data="{ show: @entangle('showModal') }" x-show="show"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 dark:bg-opacity-70 z-50"
     x-cloak>
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full max-w-md border border-gray-200 dark:border-gray-700">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                @if($modalType === 'edit')
                    {{ __('Edit Permission') }}
                @elseif($modalType === 'delete')
                    {{ __('Delete Permission') }}
                @else
                    {{ __('Add Permission') }}
                @endif
            </h3>
            <button @click="show = false" wire:click="closeModal"
                class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300 text-2xl font-bold transition">&times;</button>
        </div>
        <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}">
            @if($modalType === 'delete')
                <p class="mb-2">{{ __('Are you sure you want to delete this permission?') }}</p>
                <p class="font-bold text-red-600 dark:text-red-400">{{ $name }}</p>
            @else
                <input type="text" wire:model.lazy="name"
                    placeholder="{{ __('Permission Name') }}"
                    class="border p-2 w-full mb-3 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                />
                @error('name')
                    <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div>
                @enderror
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
