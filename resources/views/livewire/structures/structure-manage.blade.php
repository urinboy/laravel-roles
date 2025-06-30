{{-- Butun kontentni yagona root div ichiga o'rash --}}
<div class="relative">

    {{-- Modal container --}}
    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 flex items-center justify-center z-50"
        style="background: rgba(38, 50, 56, 0.12);" x-cloak>
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 animate-fade-in">
            <div class="px-7 pt-7 pb-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">
                        @if ($actionType === 'edit')
                            Edit {{ ucfirst(str_replace('-', ' ', $modalType)) }}
                        @elseif($actionType === 'delete')
                            Delete {{ ucfirst(str_replace('-', ' ', $modalType)) }}
                        @else
                            Add {{ ucfirst(str_replace('-', ' ', $modalType)) }}
                        @endif
                    </h3>
                    <button @click="show = false" wire:click="closeModal"
                        class="text-gray-400 hover:text-gray-900 text-2xl font-bold transition leading-none focus:outline-none">&times;</button>
                </div>
                <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}">
                    @if ($actionType === 'delete')
                        <p class="mb-2 text-gray-800">Are you sure you want to delete this {{ str_replace('-', ' ', $modalType) }}?</p>
                        <p class="text-sm text-gray-600">This action cannot be undone.</p>
                        @if($modalType === 'unassign-person-from-room' && $assign_person_room_id && $assign_person_id)
                            @php
                                $room_name_display = App\Models\Room::find($assign_person_room_id)->name ?? 'N/A';
                                $person_name_display = App\Models\ResponsiblePerson::find($assign_person_id)->full_name ?? 'N/A';
                            @endphp
                            <p class="text-sm text-gray-600 mt-2">
                                Unassign <strong>{{ $person_name_display }}</strong> from <strong>{{ $room_name_display }}</strong>?
                            </p>
                        @elseif($modalType === 'responsible-person' && $responsible_person_id)
                             @php $rp_name_display = App\Models\ResponsiblePerson::find($responsible_person_id)->full_name ?? 'N/A'; @endphp
                             <p class="text-sm text-gray-600 mt-2">
                                Delete responsible person <strong>{{ $rp_name_display }}</strong>?
                            </p>
                        @endif
                    @else
                        {{-- Building Form --}}
                        @if ($modalType === 'building')
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Building name <span
                                        class="text-red-600">*</span></label>
                                <input type="text" wire:model.lazy="building_name" placeholder="e.g., Main Campus"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('building_name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Address</label>
                                <input type="text" wire:model.lazy="building_address"
                                    placeholder="e.g., 123 University Ave"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Description</label>
                                <textarea wire:model.lazy="building_description" placeholder="Optional description"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="building_is_active"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Active</span>
                                </label>
                            </div>
                        @endif

                        {{-- Floor Form --}}
                        @if ($modalType === 'floor')
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800">Floor Number <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" wire:model.lazy="floor_number" placeholder="e.g., 1"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                    @error('floor_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800">Level <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" wire:model.lazy="floor_level" placeholder="e.g., 1"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                    @error('floor_level')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Description</label>
                                <textarea wire:model.lazy="floor_description" placeholder="e.g., Faculty of Engineering"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="floor_is_active"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Active</span>
                                </label>
                            </div>
                        @endif

                        {{-- Room Form --}}
                        @if ($modalType === 'room')
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800">Room Number <span
                                            class="text-red-600">*</span></label>
                                    <input type="text" wire:model.lazy="room_number" placeholder="e.g., 101"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                    @error('room_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800">Room Name <span
                                            class="text-red-600">*</span></label>
                                    <input type="text" wire:model.lazy="room_name" placeholder="e.g., Dean's Office"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                    @error('room_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Description</label>
                                <textarea wire:model.lazy="room_description" placeholder="Optional description"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="room_is_active"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Active</span>
                                </label>
                            </div>
                        @endif

                        {{-- Responsible Person Form (yangi) --}}
                        @if ($modalType === 'responsible-person')
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Full Name <span
                                        class="text-red-600">*</span></label>
                                <input type="text" wire:model.lazy="responsible_person_full_name"
                                    placeholder="e.g., John Doe"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('responsible_person_full_name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Phone</label>
                                <input type="text" wire:model.lazy="responsible_person_phone"
                                    placeholder="e.g., +1234567890"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('responsible_person_phone')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Passport PDF Path</label>
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
                                    <span class="ml-2 text-sm text-gray-600">Active</span>
                                </label>
                            </div>
                        @endif


                        {{-- Assign Person to Room Form --}}
                        @if ($modalType === 'assign-person-to-room')
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Select Responsible Person <span class="text-red-600">*</span></label>
                                <select wire:model="assign_person_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select a person</option>
                                    @php
                                        // Xatoga sabab bo'lgan qismni himoyalash
                                        $currentRoom = null;
                                        if ($assign_person_room_id) {
                                            $currentRoom = App\Models\Room::find($assign_person_room_id);
                                        }
                                        $assignedPersonIds = $currentRoom ? $currentRoom->responsiblePeople->pluck('id')->toArray() : [];
                                    @endphp
                                    @foreach($responsiblePeople as $person)
                                        {{-- Faqat bu xonaga allaqachon biriktirilmagan shaxslarni ko'rsatamiz --}}
                                        @if(!in_array($person->id, $assignedPersonIds))
                                            <option value="{{ $person->id }}">{{ $person->full_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('assign_person_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                @error('assign_person_room_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <p class="text-sm text-gray-600">Assigning to Room: <strong>{{ App\Models\Room::find($assign_person_room_id)->name ?? 'N/A' }}</strong></p>
                        @endif
                    @endif

                    <div class="flex justify-end gap-2 mt-6 mb-2">
                        <button type="button" @click="show = false" wire:click="closeModal"
                            class="px-5 py-2 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition">
                            Cancel
                        </button>
                        @if ($actionType === 'delete')
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 transition">
                                Delete
                            </button>
                        @else
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                                {{ $actionType === 'edit' || $modalType === 'assign-person-to-room' ? 'Save' : 'Create' }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Flash messages section (Success) --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-full"
            class="fixed top-4 right-4 flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-md z-50"
            role="alert">
            <svg class="flex-shrink-0 w-6 h-6 mr-2 text-green-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
            </svg>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif
    {{-- Flash messages section (Error) --}}
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0 translate-y-full"
            class="fixed top-4 right-4 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-md z-50"
            role="alert">
            <svg class="flex-shrink-0 w-6 h-6 mr-2 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Main structure display area --}}
    <div class="container mx-auto p-4">
        <div class="mb-6 w-full">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Structure Management') }}</h1>
            <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your structure') }}</p>
            <hr class="mb-4 border-gray-200 dark:border-gray-700" />
        </div>

        {{-- Add Responsible Person & Building Buttons --}}
        <div class="mb-6 flex justify-between items-center">
            <button wire:click="openModal('responsible-person', 'create')"
                class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Add Responsible Person
            </button>
            <button wire:click="openModal('building', 'create')"
                class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Building
            </button>
        </div>

        {{-- Responsible People List (yangi joy) --}}
        <h2 class="text-xl font-bold mb-3 mt-8">Responsible People List</h2>
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($responsiblePeople as $person)
                    <div class="flex justify-between items-center bg-gray-50 rounded-lg p-3 shadow-sm border border-gray-100">
                        <div>
                            <p class="font-medium text-gray-800">{{ $person->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $person->phone }}</p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="text-xs text-gray-400">{{ $person->is_active ? 'Active' : 'Inactive' }}</span>
                            <button wire:click="openModal('responsible-person', 'edit', {{ $person->id }})"
                                class="text-blue-500 hover:text-blue-700 p-1 rounded-full hover:bg-blue-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.172-8.172z"></path></svg>
                            </button>
                            <button wire:click="openModal('responsible-person', 'delete', {{ $person->id }})"
                                class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic col-span-full">No responsible people found.</p>
                @endforelse
            </div>
        </div>


        {{-- Buildings List --}}
        <h2 class="text-xl font-bold mb-3 mt-8">Buildings List</h2>
        <div class="space-y-4">
            @forelse($buildings as $building)
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-4 flex justify-between items-center cursor-pointer"
                        wire:click="expandBuilding({{ $building->id }})">
                        <h3 class="text-lg font-semibold">{{ $building->name }} ({{ $building->address }})</h3>
                        <div class="flex items-center space-x-2">
                            <span
                                class="text-sm text-gray-500">{{ $building->is_active ? 'Active' : 'Inactive' }}</span>
                            <button wire:click.stop="openModal('building', 'edit', {{ $building->id }})"
                                class="text-blue-500 hover:text-blue-700 p-1 rounded-full hover:bg-blue-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.172-8.172z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click.stop="openModal('building', 'delete', {{ $building->id }})"
                                class="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                            <svg class="w-5 h-5 transition-transform duration-300 {{ $expandedBuildingId === $building->id ? 'rotate-90' : '' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>

                    @if ($expandedBuildingId === $building->id)
                        <div class="p-4 border-t border-gray-200 bg-gray-50">
                            <p class="text-sm text-gray-700 mb-4">{{ $building->description }}</p>

                            <h4 class="text-md font-semibold mb-3">Floors:</h4>
                            <button wire:click="openModal('floor', 'create', null, {{ $building->id }})"
                                class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add New Floor
                            </button>

                            <div class="space-y-3 mt-4">
                                @forelse($building->floors->sortBy('floor_number') as $floor)
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                                        <div class="p-3 flex justify-between items-center cursor-pointer"
                                            wire:click="expandFloor({{ $floor->id }})">
                                            <h5 class="text-md font-medium">Floor {{ $floor->floor_number }} (Level
                                                {{ $floor->level }})</h5>
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="text-xs text-gray-400">{{ $floor->is_active ? 'Active' : 'Inactive' }}</span>
                                                <button
                                                    wire:click.stop="openModal('floor', 'edit', {{ $floor->id }}, {{ $building->id }})"
                                                    class="text-blue-400 hover:text-blue-600 p-1 rounded-full hover:bg-blue-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.172-8.172z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button
                                                    wire:click.stop="openModal('floor', 'delete', {{ $floor->id }})"
                                                    class="text-red-400 hover:text-red-600 p-1 rounded-full hover:bg-red-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <svg
                                                    class="w-4 h-4 transition-transform duration-300 {{ $expandedFloorId === $floor->id ? 'rotate-90' : '' }}"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        @if ($expandedFloorId === $floor->id)
                                            <div class="p-3 border-t border-gray-100 bg-gray-100">
                                                <p class="text-xs text-gray-600 mb-3">{{ $floor->description }}</p>

                                                <h6 class="text-sm font-semibold mb-2">Rooms:</h6>
                                                <button
                                                    wire:click="openModal('room', 'create', null, {{ $floor->id }})"
                                                    class="inline-flex items-center px-3 py-1 bg-purple-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-600 active:bg-purple-700 focus:outline-none focus:border-purple-700 focus:ring focus:ring-purple-300 disabled:opacity-25 transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Add New Room
                                                </button>

                                                <div class="space-y-2 mt-4">
                                                    @forelse($floor->rooms->sortBy('number') as $room)
                                                        <div
                                                            class="bg-white rounded-md shadow-xs border border-gray-100 p-3 flex flex-col">
                                                            <div class="flex justify-between items-center mb-2">
                                                                <p class="text-sm font-medium">{{ $room->number }} -
                                                                    {{ $room->name }}</p>
                                                                <div class="flex items-center space-x-1">
                                                                    <span
                                                                        class="text-xs text-gray-400">{{ $room->is_active ? 'Active' : 'Inactive' }}</span>
                                                                    <button
                                                                        wire:click.stop="openModal('room', 'edit', {{ $room->id }}, {{ $floor->id }})"
                                                                        class="text-blue-400 hover:text-blue-600 p-1 rounded-full hover:bg-blue-100 transition">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.172-8.172z">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                    <button
                                                                        wire:click.stop="openModal('room', 'delete', {{ $room->id }})"
                                                                        class="text-red-400 hover:text-red-600 p-1 rounded-full hover:bg-red-100 transition">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <p class="text-xs text-gray-500 mb-2">{{ $room->description }}</p>

                                                            {{-- Responsible Persons for this Room --}}
                                                            <h6 class="text-xs font-semibold mb-1 text-gray-700">Assigned Responsible People:</h6>
                                                            <button wire:click.stop="openModal('assign-person-to-room', 'create', null, {{ $room->id }})"
                                                                class="inline-flex items-center px-2 py-1 bg-teal-500 border border-transparent rounded-lg font-semibold text-xxs text-white uppercase tracking-widest hover:bg-teal-600 active:bg-teal-700 focus:outline-none focus:border-teal-700 focus:ring focus:ring-teal-300 disabled:opacity-25 transition mb-2">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                    <path d="M12 4v16m8-8H4"></path>
                                                                </svg>
                                                                Assign Person
                                                            </button>
                                                            <div class="space-y-1">
                                                                @forelse($room->responsiblePeople as $person)
                                                                    <div class="flex justify-between items-center bg-gray-50 rounded-md px-2 py-1 border border-gray-100">
                                                                        <span class="text-xs text-gray-700">{{ $person->full_name }}</span>
                                                                        <button wire:click.stop="openModal('unassign-person-from-room', 'delete', null, {{ $room->id }}, {{ $person->id }})"
                                                                            class="text-red-400 hover:text-red-600 p-0.5 rounded-full hover:bg-red-100 transition">
                                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                @empty
                                                                    <p class="text-gray-500 text-xs italic">No responsible person assigned.</p>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p class="text-gray-500 text-sm italic">No rooms found for this
                                                            floor.</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-sm italic">No floors found for this building.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 text-center text-lg italic">No buildings found. Start by adding a new one!</p>
            @endforelse
        </div>
    </div>
</div>
