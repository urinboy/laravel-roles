<div>
    <div class="mb-6 w-full">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Equipment Types') }}</h1>
        <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your equipment types') }}</p>
        <hr class="mb-4 border-gray-200 dark:border-gray-700" />
    </div>

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
            class="mb-4 flex items-center justify-between bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded"
            role="alert">
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button type="button" @click="show = false" class="text-xl font-bold text-green-400 hover:text-green-700">&times;</button>
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <button wire:click="openModal('create')"
            class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded hover:bg-blue-100 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            {{ __('Add Equipment Type') }}
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
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
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full" style="background: {{ $type->color ?? '#e5e7eb' }};">
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
                        <td class="px-6 py-3 flex flex-row gap-2 justify-center">
                            <button wire:click="openModal('edit', {{ $type->id }})"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-100 dark:bg-blue-800 hover:bg-blue-200 dark:hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300"
                                title="{{ __('Edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700 dark:text-blue-200" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                </svg>
                            </button>
                            <button wire:click="openModal('delete', {{ $type->id }})"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-red-100 dark:bg-red-800 hover:bg-red-200 dark:hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300"
                                title="{{ __('Delete') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     class="w-5 h-5 text-red-700 dark:text-red-200" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                </svg>
                            </button>
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
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full
                    border border-gray-200 dark:border-gray-700
                    max-w-full sm:max-w-lg md:max-w-xl lg:max-w-2xl
                    mx-2 sm:mx-4 md:mx-0">
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold">
                    @if($modalType === 'edit')
                        {{ __('Edit Equipment Type') }}
                    @elseif($modalType === 'delete')
                        {{ __('Delete Equipment Type') }}
                    @else
                        {{ __('Add Equipment Type') }}
                    @endif
                </h3>
                <button @click="show = false" wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300 text-2xl font-bold transition">&times;</button>
            </div>
            <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}">
                @if($modalType === 'delete')
                    <p class="mb-2">{{ __('Are you sure you want to delete this equipment type?') }}</p>
                    <p class="font-bold text-red-600 dark:text-red-400">{{ $name }}</p>
                @else
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Name') }} <span class="text-red-600">*</span></label>
                        <input type="text" wire:model.lazy="name"
                            placeholder="{{ __('Name') }}"
                            class="border p-2 w-full rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                        />
                        @error('name') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Icon SVG') }}</label>
                        <textarea wire:model.lazy="icon"
                            placeholder="{{ __('Paste SVG code here') }}"
                            rows="2"
                            class="border p-2 w-full rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                        ></textarea>
                        @error('icon') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror
                        <small class="text-xs text-gray-400">{{ __("Paste SVG code for icon or leave blank.") }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __('Color') }}</label>
                        <input type="color" wire:model.lazy="color"
                            class="border w-12 h-10 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 cursor-pointer align-middle" />
                        <span class="ml-3 text-xs align-middle">{{ $color }}</span>
                        @error('color') <div class="text-red-600 dark:text-red-400 text-xs mb-2">{{ $message }}</div> @enderror
                    </div>
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
</div>
