<div>
    {{-- <div class="mb-6 w-full">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Equipment Types') }}</h1>
        <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your equipment types') }}</p>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div> --}}

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
            class="mb-4 flex items-center justify-between bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded"
            role="alert">
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button type="button" @click="show = false" class="text-xl font-bold text-green-400 hover:text-green-700">&times;</button>
        </div>
    @endif

    <div class="mb-6 w-full">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold mb-2 mt-4 text-gray-900 dark:text-white">{{ __('Equipment Types') }}</h2>
                <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage equipment types') }}</p>
            </div>
            <div class="mb-6 flex justify-end">
                <button wire:click="openModal('create')"
                    class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:text-white font-medium rounded hover:bg-blue-500 transition cursor-pointer"
                    title="{{ __('Add Equipment Type') }}">
                    <x-icons.plus />
                    {{ __("Add New") }}
                </button>
            </div>
        </div>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4 mb-6 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">{{ __('Icon') }}</th>
                    <th class="px-6 py-3">{{ __('Color') }}</th>
                    <th class="px-6 py-3">{{ __('Name') }}</th>
                    <th class="px-6 py-3 text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($equipmentTypes as $type)
                    <tr class="border-b dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-3">
                            @if($type->icon)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full" style="background: #e5e7eb;">
                                    {!! $type->icon !!}
                                </span>
                            @else
                                <span class="inline-block w-8 h-8 rounded-full bg-gray-200"></span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-block w-8 h-4 rounded" style="background: {{ $type->color ?? '#e5e7eb' }}"></span>
                            <span class="ml-2 text-xs">{{ $type->color }}</span>
                        </td>
                        <td class="px-6 py-3 text-gray-700 dark:text-gray-200">
                            {{ $type->name }}
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex flex-row gap-1 justify-center">
                                <button wire:click="openModal('edit', {{ $type->id }})"
                                    class="text-blue-500 hover:text-blue-700 p-1 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900 transition cursor-pointer"
                                    title="{{ __('Edit') }}">
                                    <x-icons.edit />
                                </button>
                                <button wire:click="openModal('delete', {{ $type->id }})"
                                    class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition cursor-pointer"
                                    title="{{ __('Delete') }}">
                                    <x-icons.delete />
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No equipment types found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show"
         class="fixed inset-0 flex items-center justify-center z-50"
         style="background: rgba(38, 50, 56, 0.12);" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 dark:border-gray-700 animate-fade-in">
            <div class="px-7 pt-7 pb-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        @if($modalType === 'edit')
                            {{ __('Edit Equipment Type') }}
                        @elseif($modalType === 'delete')
                            {{ __('Delete Equipment Type') }}
                        @else
                            {{ __('Add Equipment Type') }}
                        @endif
                    </h3>
                    <button @click="show = false" wire:click="closeModal"
                        class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-200 text-2xl font-bold transition leading-none focus:outline-none cursor-pointer">&times;</button>
                </div>
                <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}">
                    @if($modalType === 'delete')
                        <p class="mb-2 text-gray-800 dark:text-gray-100">{{ __('Are you sure you want to delete this equipment type?') }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('This action cannot be undone.') }}</p>
                        <p class="font-bold text-red-600 dark:text-red-400 mt-2">{{ $name }}</p>
                    @else
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Name') }} <span class="text-red-600">*</span></label>
                            <input type="text" wire:model.lazy="name"
                                placeholder="{{ __('Name') }}"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                            @error('name') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Icon SVG') }}</label>
                            <textarea wire:model.lazy="icon"
                                placeholder="{{ __('Paste SVG code here') }}"
                                rows="2"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-100"></textarea>
                            @error('icon') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                            <small class="text-xs text-gray-400">{{ __("Paste SVG code for icon or leave blank.") }}</small>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Color') }}</label>
                            <input type="color" wire:model.lazy="color"
                                class="border w-12 h-10 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 cursor-pointer align-middle" />
                            <span class="ml-3 text-xs align-middle dark:text-gray-100">{{ $color }}</span>
                            @error('color') <span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endif
                    <div class="flex justify-end gap-2 mt-6 mb-2">
                        <button type="button" @click="show = false" wire:click="closeModal"
                            class="px-5 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 transition cursor-pointer">
                            {{ __('Cancel') }}
                        </button>
                        @if($modalType === 'delete')
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition cursor-pointer">
                                {{ __('Delete') }}
                            </button>
                        @else
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 transition cursor-pointer">
                                {{ $modalType === 'edit' ? __('Update') : __('Create') }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>