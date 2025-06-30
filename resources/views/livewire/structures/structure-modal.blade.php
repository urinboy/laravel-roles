<div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 flex items-center justify-center z-50"
    style="background: rgba(38, 50, 56, 0.12);" x-cloak>
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 animate-fade-in">
        <div class="px-7 pt-7 pb-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">
                    @if ($actionType === 'edit')
                        Edit {{ ucfirst($modalType) }}
                    @elseif($actionType === 'delete')
                        Delete {{ ucfirst($modalType) }}
                    @else
                        Add {{ ucfirst($modalType) }}
                    @endif
                </h3>
                <button @click="show = false" wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-900 text-2xl font-bold transition leading-none focus:outline-none">&times;</button>
            </div>
            <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}">
                @if ($actionType === 'delete')
                    <p class="mb-2 text-gray-800">Are you sure you want to delete this {{ $modalType }}?</p>
                    <p class="text-sm text-gray-600">This action cannot be undone.</p>
                @else
                    {{-- Building Form --}}
                    @if ($modalType === 'building')
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Building name <span class="text-red-600">*</span></label>
                            <input type="text" wire:model.lazy="building_name" placeholder="e.g., Main Campus"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                            @error('building_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Address</label>
                            <input type="text" wire:model.lazy="building_address" placeholder="e.g., 123 University Ave"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Description</label>
                            <textarea wire:model.lazy="building_description" placeholder="Optional description"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="building_is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
                    @endif

                    {{-- Floor Form --}}
                    @if ($modalType === 'floor')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Floor Number <span class="text-red-600">*</span></label>
                                <input type="number" wire:model.lazy="floor_number" placeholder="e.g., 1"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('floor_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Level <span class="text-red-600">*</span></label>
                                <input type="number" wire:model.lazy="floor_level" placeholder="e.g., 1"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('floor_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Description</label>
                            <textarea wire:model.lazy="floor_description" placeholder="e.g., Faculty of Engineering"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="floor_is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
                    @endif

                    {{-- Room Form --}}
                    @if ($modalType === 'room')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Room Number <span class="text-red-600">*</span></label>
                                <input type="number" wire:model.lazy="room_number" placeholder="e.g., 101"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('room_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800">Room Name <span class="text-red-600">*</span></label>
                                <input type="text" wire:model.lazy="room_name" placeholder="e.g., Dean's Office"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" />
                                @error('room_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Responsible Person</label>
                            <select wire:model="room_responsible_person_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                <option value="">Select a person</option>
                                @foreach($responsiblePeople as $person)
                                    <option value="{{ $person->id }}">{{ $person->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1 text-gray-800">Description</label>
                            <textarea wire:model.lazy="room_description" placeholder="Optional description"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 resize-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="room_is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
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
                            {{ $actionType === 'edit' ? 'Update' : 'Create' }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>