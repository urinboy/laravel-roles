<div class="relative">
    {{-- Responsible Person Modal --}}
    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 flex items-center justify-center z-50"
        style="background: rgba(38, 50, 56, 0.12);" x-cloak>
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 animate-fade-in">
            <div class="px-7 pt-7 pb-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">
                        @if ($actionType === 'edit')
                            {{ __('Edit Responsible Person') }}
                        @elseif($actionType === 'delete')
                            {{ __('Delete Responsible Person') }}
                        @else
                            {{ __('Add Responsible Person') }}
                        @endif
                    </h3>
                    <button @click="show = false" wire:click="closeModal"
                        class="text-gray-400 hover:text-gray-900 text-2xl font-bold transition leading-none focus:outline-none cursor-pointer">&times;</button>
                </div>
                <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}">
                    @if ($actionType === 'delete')
                        <p class="mb-2 text-gray-800">{{ __('Are you sure you want to delete this responsible person?') }}</p>
                        <p class="text-sm text-gray-600">{{ __('This action cannot be undone.') }}</p>
                        @if ($responsible_person_id)
                            @php $rp_name_display = App\Models\ResponsiblePerson::find($responsible_person_id)->full_name ?? 'N/A'; @endphp
                            <p class="text-sm text-gray-600 mt-2">
                                {{ __('Delete responsible person') }} <strong>{{ $rp_name_display }}</strong>?
                            </p>
                        @endif
                    @else
                        {{-- Responsible Person Form --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Full Name') }} <span class="text-red-600">*</span></label>
                            <input type="text" wire:model.lazy="responsible_person_full_name"
                                placeholder="e.g., John Doe"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                            @error('responsible_person_full_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Phone') }}</label>
                            <input type="text" wire:model.lazy="responsible_person_phone"
                                placeholder="e.g., +1234567890"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                            @error('responsible_person_phone')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">{{ __('Passport PDF Path') }}</label>
                            <input type="text" wire:model.lazy="responsible_person_passport_pdf_path"
                                placeholder="e.g., /docs/passport_john_doe.pdf"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                            @error('responsible_person_passport_pdf_path')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="responsible_person_is_active"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                            </label>
                        </div>
                    @endif

                    <div class="flex justify-end gap-2 mt-6 mb-2">
                        <button type="button" @click="show = false" wire:click="closeModal"
                            class="px-5 py-2 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition cursor-pointer">
                            {{ __('Cancel') }}
                        </button>
                        @if ($actionType === 'delete')
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 transition cursor-pointer">
                                {{ __('Delete') }}
                            </button>
                        @else
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 transition cursor-pointer">
                                {{ $actionType === 'edit' ? __('Update') : __('Create') }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Flash messages section (Success) --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0 translate-y-full"
            class="fixed top-4 right-4 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-md z-50"
            role="alert">
            <svg class="flex-shrink-0 w-6 h-6 mr-2 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0 translate-y-full"
            class="fixed top-4 right-4 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-md z-50"
            role="alert">
            <svg class="flex-shrink-0 w-6 h-6 mr-2 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Responsible People List --}}
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-3 mt-4">{{ __('Responsible People List') }}</h2>
        <div class="mb-6 flex justify-end">
            <button wire:click="openModal('create')"
                class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded hover:bg-blue-100 transition cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __("Add New Responsible Person") }}
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($responsiblePeople as $person)
                    <div
                        class="flex justify-between items-center bg-gray-50 rounded-lg p-3 shadow-sm border border-gray-100">
                        <div>
                            <p class="font-medium text-gray-800">{{ $person->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $person->phone }}</p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="flex items-center">
                                <x-status-icon :active="$person->is_active" />
                            </span>
                            <button wire:click="openModal('edit', {{ $person->id }})"
                                class="text-blue-500 hover:text-blue-700 p-1 rounded-full hover:bg-blue-100 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.172-8.172z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click="openModal('delete', {{ $person->id }})"
                                class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic col-span-full">{{ __('No responsible people found.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
