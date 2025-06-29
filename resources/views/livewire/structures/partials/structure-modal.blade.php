<div x-data="{ show: @entangle('showModal') }" x-show="show"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
     x-cloak>
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md border border-gray-200 mx-2">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                @if($actionType === 'edit')
                    Edit {{ ucfirst($modalType) }}
                @elseif($actionType === 'delete')
                    Delete {{ ucfirst($modalType) }}
                @else
                    Add {{ ucfirst($modalType) }}
                @endif
            </h3>
            <button @click="show = false" wire:click="closeModal"
                class="text-gray-400 hover:text-gray-900 text-2xl font-bold transition">&times;</button>
        </div>
        <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}">
            @if($actionType === 'delete')
                <p class="mb-2">Are you sure you want to delete this {{ $modalType }}?</p>
            @else
                @if($modalType === 'building')
                    <input type="text" wire:model.lazy="building_name" placeholder="Building name"
                        class="border p-2 w-full mb-3 rounded" />
                    <input type="text" wire:model.lazy="building_address" placeholder="Address"
                        class="border p-2 w-full mb-3 rounded" />
                    <textarea wire:model.lazy="building_description" placeholder="Description"
                        class="border p-2 w-full mb-3 rounded"></textarea>
                @elseif($modalType === 'floor')
                    <input type="number" wire:model.lazy="floor_number" placeholder="Floor number"
                        class="border p-2 w-full mb-3 rounded" />
                    <textarea wire:model.lazy="floor_description" placeholder="Description"
                        class="border p-2 w-full mb-3 rounded"></textarea>
                @elseif($modalType === 'room')
                    <input type="text" wire:model.lazy="room_name" placeholder="Room name"
                        class="border p-2 w-full mb-3 rounded" />
                    <textarea wire:model.lazy="room_description" placeholder="Description"
                        class="border p-2 w-full mb-3 rounded"></textarea>
                @endif
            @endif
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="show = false" wire:click="closeModal"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                @if($actionType === 'delete')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Delete
                    </button>
                @else
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        {{ $actionType === 'edit' ? 'Update' : 'Create' }}
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
