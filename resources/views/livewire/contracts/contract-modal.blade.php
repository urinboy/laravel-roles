<div x-data="{ show: @entangle('showModal') }" x-show="show"
     class="fixed inset-0 flex items-center justify-center z-50"
     style="background: rgba(38, 50, 56, 0.12);" x-cloak>
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 animate-fade-in">
        <div class="px-7 pt-7 pb-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">
                    @if ($actionType === 'edit')
                        {{ __('Edit Contract') }}
                    @elseif($actionType === 'delete')
                        {{ __('Delete Contract') }}
                    @else
                        {{ __('Add Contract') }}
                    @endif
                </h3>
                <button @click="show = false" wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-900 text-2xl font-bold transition leading-none focus:outline-none">&times;</button>
            </div>
            <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}" enctype="multipart/form-data">
                @if ($actionType === 'delete')
                    <p class="mb-2 text-gray-800">{{ __('Are you sure you want to delete this contract?') }}</p>
                    <p class="text-sm text-gray-600">{{ __('This action cannot be undone.') }}</p>
                    <p class="font-bold text-red-600 mt-2">{{ $number }}</p>
                @else
                    <div class="grid gap-3 md:grid-cols-2">
                        <!-- Number -->
                        <div class="mb-2">
                            <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Contract Number') }} <span class="text-red-600">*</span></label>
                            <input type="text" wire:model.lazy="number"
                                placeholder="{{ __('Contract Number') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500" />
                            @error('number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <!-- Date -->
                        <div class="mb-2">
                            <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Date') }} <span class="text-red-600">*</span></label>
                            <input type="date" wire:model.lazy="date"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500" />
                            @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <!-- Inventory Numbers -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Inventory Numbers') }} <span class="text-red-600">*</span></label>
                        <div class="flex gap-2">
                            <input type="text"
                                wire:model.defer="inventory_number_input"
                                placeholder="{{ __('Enter inventory number') }}"
                                class="border border-gray-300 rounded-lg px-4 py-2 flex-1 bg-gray-50 focus:ring-2 focus:ring-blue-500"
                                wire:keydown.enter.prevent="addInventoryNumber"
                            />
                            <button type="button" wire:click="addInventoryNumber"
                                class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                +
                            </button>
                        </div>
                        <div class="mt-2">
                            @if($inventory_numbers)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($inventory_numbers as $inv)
                                        <span class="inline-block bg-blue-100 text-blue-800 rounded px-2 py-0.5 text-xs">
                                            {{ $inv }}
                                            <button type="button" wire:click="removeInventoryNumber('{{ $inv }}')"
                                                class="ml-1 text-red-500 hover:text-red-700">&times;</button>
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">{{ __('No inventory numbers added') }}</span>
                            @endif
                        </div>
                        @error('inventory_numbers') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- PDF Upload -->
                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-800">{{ __('Contract PDF') }} <span class="text-red-600">*</span></label>
                        <div class="flex items-center gap-2">
                            <label class="flex flex-col items-center px-4 py-2 bg-white rounded-lg border border-gray-300 cursor-pointer shadow-sm hover:bg-gray-50 transition">
                                <span class="text-sm text-gray-600">{{ __('Select PDF') }}</span>
                                <input type="file" wire:model="pdf_file" accept="application/pdf" class="hidden" />
                            </label>
                            @if($pdf_file)
                                <span class="text-green-600 text-xs">
                                    {{ method_exists($pdf_file, 'getClientOriginalName') ? $pdf_file->getClientOriginalName() : __('File selected') }}
                                </span>
                            @elseif($pdf_path)
                                <a href="{{ Storage::disk('public')->url($pdf_path) }}" target="_blank" class="text-blue-600 underline text-xs">{{ __('Current File') }}</a>
                            @endif
                            @if($pdf_file)
                                <button type="button" wire:click="$set('pdf_file', null)" class="text-red-500 ml-2" title="Remove">
                                    &times;
                                </button>
                            @endif
                        </div>
                        @error('pdf_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Description') }}</label>
                        <textarea wire:model.lazy="description"
                            placeholder="{{ __('Description') }}"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 focus:ring-2 focus:ring-blue-500"
                        ></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="flex justify-end gap-2 mt-6 mb-2">
                    <button type="button" @click="show = false" wire:click="closeModal"
                        class="px-5 py-2 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition">
                        {{ __('Cancel') }}
                    </button>
                    @if ($actionType === 'delete')
                        <button type="submit"
                            class="px-5 py-2 rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 transition">
                            {{ __('Delete') }}
                        </button>
                    @else
                        <button type="submit"
                            class="px-5 py-2 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                            {{ $actionType === 'edit' ? __('Update') : __('Create') }}
                        </button>
                    @endif
                </div>
                <div wire:loading wire:target="save, pdf_file" class="mt-4 text-blue-600 text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    {{ __('Uploading...') }}
                </div>
            </form>
        </div>
    </div>
</div>
