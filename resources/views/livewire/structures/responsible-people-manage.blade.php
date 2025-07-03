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

                    <div class="flex justify-between gap-2 mt-6 mb-2">
                        <button type="button" @click="show = false" wire:click="closeModal"
                            class="px-5 py-2 rounded-lg font-medium text-gray-700 bg-red-100 hover:bg-red-200 border border-red-200 transition cursor-pointer">
                            <x-icons.cancel class="inline-block font-semibold mr-1" />
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

    <x-flash/>

    {{-- Responsible People List --}}
    <div>
        <div class="mb-6 w-full">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-2 mt-4 text-gray-900 dark:text-white">{{ __('Responsible People List') }}</h2>
                    <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage responsible people') }}</p>
                </div>
                <div class="mb-6 flex justify-end">
                    <button wire:click="openModal('create')"
                        class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:text-white font-medium rounded hover:bg-blue-500 transition cursor-pointer"
                        title="{{ __('Add New') }}">
                        <x-icons.plus />
                        {{ __("Add New") }}
                    </button>
                </div>
            </div>
            <hr class="mb-4 border-gray-200 dark:border-gray-700" />
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
                                <x-icons.edit />
                            </button>
                            <button wire:click="openModal('delete', {{ $person->id }})"
                                class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition cursor-pointer">
                                <x-icons.delete />
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
