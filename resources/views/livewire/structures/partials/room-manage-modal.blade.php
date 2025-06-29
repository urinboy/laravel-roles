<div>
    <x-modal wire:model="showRoomModal">
        <form wire:submit.prevent="saveRoom" class="space-y-4">
            <h3 class="text-lg font-bold mb-2">
                {{ $editingRoomId ? 'Xonani tahrirlash' : 'Yangi xona' }}
            </h3>
            <div>
                <label class="block mb-1">Nomi</label>
                <input type="text" class="w-full px-3 py-2 border rounded" wire:model.defer="room_name" required>
                @error('room_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block mb-1">Izoh</label>
                <textarea class="w-full px-3 py-2 border rounded" wire:model.defer="room_description"></textarea>
            </div>
            <div>
                <label class="block mb-1">Mas'ul shaxs</label>
                <select class="w-full px-3 py-2 border rounded" wire:model.defer="room_responsible_person_id">
                    <option value="">Tanlang</option>
                    @foreach($responsiblePeople as $person)
                        <option value="{{ $person->id }}">{{ $person->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:model.defer="room_is_active" id="room_is_active">
                <label for="room_is_active">Aktiv</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" wire:click="closeRoomModal" class="px-4 py-2 rounded border">Bekor qilish</button>
                <button type="submit" class="px-4 py-2 rounded bg-yellow-600 text-white shadow hover:bg-yellow-700">
                    Saqlash
                </button>
            </div>
        </form>
    </x-modal>
</div>
