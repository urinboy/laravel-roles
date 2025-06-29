<div>
    <x-modal wire:model="showBuildingModal">
        <form wire:submit.prevent="saveBuilding" class="space-y-4">
            <h3 class="text-lg font-bold mb-2">
                {{ $editingBuildingId ? 'Bino tahrirlash' : 'Yangi bino' }}
            </h3>
            <div>
                <label class="block mb-1">Nomi</label>
                <input type="text" class="w-full px-3 py-2 border rounded" wire:model.defer="building_name" required>
                @error('building_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block mb-1">Manzil</label>
                <input type="text" class="w-full px-3 py-2 border rounded" wire:model.defer="building_address">
            </div>
            <div>
                <label class="block mb-1">Izoh</label>
                <textarea class="w-full px-3 py-2 border rounded" wire:model.defer="building_description"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:model.defer="building_is_active" id="building_is_active">
                <label for="building_is_active">Aktiv</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" wire:click="closeBuildingModal" class="px-4 py-2 rounded border">Bekor qilish</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white shadow hover:bg-blue-700">
                    Saqlash
                </button>
            </div>
        </form>
    </x-modal>
</div>
