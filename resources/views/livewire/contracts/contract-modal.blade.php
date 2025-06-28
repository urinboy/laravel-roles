<div x-data="{ show: @entangle('showModal') }" x-show="show"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 dark:bg-opacity-70 z-50"
     x-cloak>
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md w-full max-w-full sm:max-w-lg md:max-w-xl lg:max-w-2xl mx-2 sm:mx-4 md:mx-0 border border-gray-200 dark:border-gray-700">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                @if($modalType === 'edit')
                    {{ __('Edit Contract') }}
                @elseif($modalType === 'delete')
                    {{ __('Delete Contract') }}
                @else
                    {{ __('Add Contract') }}
                @endif
            </h3>
            <button @click="show = false" wire:click="closeModal"
                class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300 text-2xl font-bold transition">&times;</button>
        </div>
        <form wire:submit.prevent="{{ $modalType === 'delete' ? 'delete' : 'save' }}" enctype="multipart/form-data">
            @if($modalType === 'delete')
                <p class="mb-2">{{ __('Are you sure you want to delete this contract?') }}</p>
                <p class="font-bold text-red-600 dark:text-red-400">{{ $number }}</p>
            @else
                <div class="grid gap-3 md:grid-cols-2">
                    <!-- Number -->
                    <div>
                        <input type="text" wire:model.lazy="number"
                            placeholder="{{ __('Contract Number') }}"
                            class="border p-2 w-full rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                        />
                        @error('number') <div class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                    <!-- Date -->
                    <div>
                        <input type="date" wire:model.lazy="date"
                            class="border p-2 w-full rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                        />
                        @error('date') <div class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <!-- Inventory Numbers -->
                <div class="flex gap-2 mt-2">
                    <input type="text"
                        wire:model.defer="inventory_number_input"
                        placeholder="{{ __('Enter inventory number') }}"
                        class="border p-2 flex-1 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                        wire:keydown.enter.prevent="addInventoryNumber"
                    />
                    <button type="button" wire:click="addInventoryNumber"
                        class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        +
                    </button>
                </div>
                @error('inventory_numbers') <div class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</div> @enderror
                <div class="mt-2">
                    @if($inventory_numbers)
                        <div class="flex flex-wrap gap-2">
                            @foreach($inventory_numbers as $inv)
                                <span class="inline-block bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-100 rounded px-2 py-0.5 text-xs">
                                    {{ $inv }}
                                    <button type="button" wire:click="removeInventoryNumber('{{ $inv }}')"
                                        class="ml-1 text-red-500 hover:text-red-700">&times;</button>
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500 text-xs">{{ __('No inventory numbers added') }}</span>
                    @endif
                </div>
                <!-- PDF Upload -->
                <div class="my-2">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Contract PDF') }}</label>
                    <div class="flex items-center gap-2">
                        <label class="flex flex-col items-center px-4 py-2 bg-white dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-500 cursor-pointer shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <span class="text-sm text-gray-600 dark:text-gray-200">{{ __('Select PDF') }}</span>
                            <input type="file" wire:model="pdf_file" accept="application/pdf" class="hidden" />
                        </label>
                        @if($pdf_file)
                            <span class="text-green-600 dark:text-green-400 text-xs">
                                {{ method_exists($pdf_file, 'getClientOriginalName') ? $pdf_file->getClientOriginalName() : __('File selected') }}
                            </span>
                        @elseif($pdf_path)
                            <a href="{{ Storage::disk('public')->url($pdf_path) }}" target="_blank" class="text-blue-600 dark:text-blue-300 underline text-xs">{{ __('Current File') }}</a>
                        @endif
                        @if($pdf_file)
                            <button type="button" wire:click="$set('pdf_file', null)" class="text-red-500 ml-2" title="Remove">
                                &times;
                            </button>
                        @endif
                    </div>
                    @error('pdf_file') <div class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <!-- Description -->
                <textarea wire:model.lazy="description"
                    placeholder="{{ __('Description') }}"
                    rows="3"
                    class="border p-2 w-full mt-2 rounded bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-100"
                ></textarea>
                @error('description') <div class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</div> @enderror
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
            <div wire:loading wire:target="save, pdf_file" class="mt-4 text-blue-600 dark:text-blue-300 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                {{ __('Uploading...') }}
            </div>
        </form>
    </div>
</div>
