<div>
    <x-modal wire:model="showResponsiblePersonModal">
        <form wire:submit.prevent="saveResponsiblePerson" class="space-y-4">
            <h3 class="text-lg font-bold mb-2">
                {{ $editingResponsiblePersonId ? "Mas'ulni tahrirlash" : "Yangi mas'ul" }}
            </h3>
            <div>
                <label class="block mb-1">To'liq ism</label>
                <input type="text" class="w-full px-3 py-2 border rounded" wire:model.defer="person_full_name" required>
                @error('person_full_name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block mb-1">Telefon</label>
                <input type="text" class="w-full px-3 py-2 border rounded" wire:model.defer="person_phone">
            </div>
            <div>
                <label class="block mb-1">Passport PDF</label>
                <input type="file" wire:model="person_passport_pdf_path" class="w-full px-3 py-2 border rounded">
                @if($person_passport_pdf_path && is_string($person_passport_pdf_path))
                    <a href="{{ asset('storage/' . $person_passport_pdf_path) }}" target="_blank" class="text-blue-500 underline">Yuklab olish</a>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:model.defer="person_is_active" id="person_is_active">
                <label for="person_is_active">Aktiv</label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" wire:click="closeResponsiblePersonModal" class="px-4 py-2 rounded border">Bekor qilish</button>
                <button type="submit" class="px-4 py-2 rounded bg-purple-600 text-white shadow hover:bg-purple-700">
                    Saqlash
                </button>
            </div>
        </form>
    </x-modal>
</div>
