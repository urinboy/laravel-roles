<div>
    <x-modal wire:model="showFloorModal">
        <form wire:submit.prevent="saveFloor" class="space-y-4">
            <h3 class="text-lg font-bold mb-2">
                {{ $editingFloorId ? 'Qavatni tahrirlash' : 'Yangi qavat' }}
            </h3>
            <div>
                <label class="block mb-1">Qavat raqami</label>
                <input type="number" class="w-full px-3 py-2 border rounded" wire:model.defer="floor_number" required>
                @error('floor_number') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block mb-1">Darajasi (level)</label>
                <input type="number" class="w-full px-3 py-2 border rounded" wire:model.defer="floor_level">
            </div>
            <div>
                <label class="block mb-1">Izoh</label>
                <textarea class="w-full px-3 py-2 border rounded" wire:model.defer="floor_description"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:model.defer="floor_is_active" id="floor_is_active">
                <label for="floor_is_active">Aktiv</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" wire:click="closeFloorModal" class="px-4 py-2 rounded border">Bekor qilish</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white shadow hover:bg-green-700">
                    Saqlash
                </button>
            </div>
        </form>
    </x-modal>
</div>
