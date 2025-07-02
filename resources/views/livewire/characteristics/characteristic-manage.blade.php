<div>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Характеристика бошқарув</h1>

        <!-- Форма -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label for="equipmentTypeId" class="block text-sm font-medium text-gray-700">Ускана тури</label>
                    <select wire:model="equipmentTypeId" id="equipmentTypeId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Танланг</option>
                        @foreach ($equipmentTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('equipmentTypeId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Номи</label>
                    <input wire:model="name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex space-x-2">
                    @if ($editMode)
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Сақлаш</button>
                        <button type="button" wire:click="cancelEdit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Бекор қилиш</button>
                    @else
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Қўшиш</button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Рўйхат -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Характеристикалар рўйхати</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Номи</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ускана тури</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Амаллар</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($characteristics as $characteristic)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $characteristic->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $characteristic->equipmentType->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="edit({{ $characteristic->id }})" class="text-indigo-600 hover:text-indigo-900 mr-2">Таҳрирлаш</button>
                                <button wire:click="delete({{ $characteristic->id }})" class="text-red-600 hover:text-red-900">Ўчириш</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>