{{-- Wrap all content in a single root div --}}
<div class="relative">

    {{-- Modal container --}}
    <div x-data="{ show: @entangle('showModal') }" x-show="show" class="fixed inset-0 flex items-center justify-center z-50"
        style="background: rgba(38, 50, 56, 0.12);" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg w-full max-w-md mx-2 border border-gray-100 dark:border-gray-700 animate-fade-in">
            <div class="px-7 pt-7 pb-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        @if ($actionType === 'edit')
                            {{ __("Edit") }} {{ ucfirst(str_replace('-', ' ', $modalType)) }}
                        @elseif($actionType === 'delete')
                            {{ __("Delete") }} {{ ucfirst(str_replace('-', ' ', $modalType)) }}
                        @else
                            {{ __("Add") }} {{ ucfirst(str_replace('-', ' ', $modalType)) }}
                        @endif
                    </h3>
                    <button @click="show = false" wire:click="closeModal"
                        class="text-gray-400 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 text-2xl font-bold transition leading-none focus:outline-none">&times;</button>
                </div>
                <form wire:submit.prevent="{{ $actionType === 'delete' ? 'delete' : 'save' }}">
                    @if ($actionType === 'delete')
                        <p class="mb-2 text-gray-800 dark:text-gray-100">Are you sure you want to delete this
                            {{ str_replace('-', ' ', $modalType) }}?</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This action cannot be undone.</p>
                        @if ($modalType === 'unassign-person-from-room' && $assign_person_room_id && $assign_person_id)
                            @php
                                $room_name_display = App\Models\Room::find($assign_person_room_id)->name ?? 'N/A';
                                $person_name_display =
                                    App\Models\ResponsiblePerson::find($assign_person_id)->full_name ?? 'N/A';
                            @endphp
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                Unassign <strong>{{ $person_name_display }}</strong> from
                                <strong>{{ $room_name_display }}</strong>?
                            </p>
                        @endif
                    @else
                        {{-- Building Form --}}
                        @if ($modalType === 'building')
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Building name") }} <span
                                        class="text-red-600">*</span></label>
                                <input type="text" wire:model.lazy="building_name" placeholder="e.g., Main Campus"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                                @error('building_name')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Address") }}</label>
                                <input type="text" wire:model.lazy="building_address"
                                    placeholder="e.g., 123 University Ave"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Description") }}</label>
                                <textarea wire:model.lazy="building_description" placeholder="Optional description"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 resize-none bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="building_is_active"
                                        class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        @endif

                        {{-- Floor Form --}}
                        @if ($modalType === 'floor')
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Floor Number") }} <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" wire:model.lazy="floor_number" placeholder="e.g., 1"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                                    @error('floor_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Level") }} <span
                                            class="text-red-600">*</span></label>
                                    <input type="number" wire:model.lazy="floor_level" placeholder="e.g., 1"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                                    @error('floor_level')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Description") }}</label>
                                <textarea wire:model.lazy="floor_description" placeholder="e.g., Faculty of Engineering"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 resize-none bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="floor_is_active"
                                        class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ __("Active") }}</span>
                                </label>
                            </div>
                        @endif

                        {{-- Room Form --}}
                        @if ($modalType === 'room')
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Room Number") }} <span
                                            class="text-red-600">*</span></label>
                                    <input type="text" wire:model.lazy="number" placeholder="e.g., 101"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                                    @error('number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Room Name") }} <span
                                            class="text-red-600">*</span></label>
                                    <input type="text" wire:model.lazy="room_name" placeholder="e.g., Dean's Office"
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" />
                                    @error('room_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1 text-gray-800 dark:text-gray-200">{{ __("Description") }}</label>
                                <textarea wire:model.lazy="room_description" placeholder="Optional description"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 resize-none bg-white dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="room_is_active"
                                        class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        @endif

                    @endif

                    <div class="flex justify-end gap-2 mt-6 mb-2">
                        <button type="button" @click="show = false" wire:click="closeModal"
                            class="px-5 py-2 rounded-lg font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 transition">
                            {{ __("Cancel") }}
                        </button>
                        @if ($actionType === 'delete')
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition">
                                {{ __("Delete") }}
                            </button>
                        @else
                            <button type="submit"
                                class="px-5 py-2 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 transition">
                                {{ $actionType === 'edit' || $modalType === 'assign-person-to-room' ? 'Save' : 'Create' }}
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-flash />

    {{-- Main structure display area --}}
    <div>
        <div class="mb-6 w-full">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-2 mt-4 text-gray-900 dark:text-white">{{ __('Structure Management') }}</h2>
                    <p class="text-gray-500 dark:text-gray-300 mb-4">{{ __('Manage all your structure') }}</p>
                </div>
                @can('building.create')
                    <div class="mb-6 flex justify-end">
                        <button wire:click="openModal('building', 'create')"
                            title="{{ __('Add New Building') }}"
                            class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:text-white font-medium rounded hover:bg-blue-500 transition cursor-pointer">
                            <x-icons.plus />
                            {{ __("Add New") }}
                        </button>
                    </div>
                @endcan
            </div>
        
            <hr class="mb-4 border-gray-200 dark:border-gray-700" />
        </div>

        {{-- Buildings List --}}
        <div class="space-y-4">
            @forelse($buildings as $building)
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="p-4 flex justify-between items-center cursor-pointer"
                        wire:click="expandBuilding({{ $building->id }})">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-purple-600 dark:text-purple-300">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center font-semibold text-lg text-gray-900 dark:text-gray-100">{{ $building->name }} <x-status-icon :active="$building->is_active" /></div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    {{ $building->address }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @can('building.edit')
                                <button wire:click.stop="openModal('building', 'edit', {{ $building->id }})"
                                    class="text-blue-500 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-400 p-1 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                                    <x-icons.edit />
                                </button>
                            @endcan
                            @can('building.delete')
                                <button wire:click.stop="openModal('building', 'delete', {{ $building->id }})"
                                    class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition">
                                    <x-icons.delete />
                                </button>
                            @endcan
                            <svg class="w-5 h-5 transition-transform duration-300 {{ $expandedBuildingId === $building->id ? 'rotate-90' : '' }} text-gray-400 dark:text-gray-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>

                    @if ($expandedBuildingId === $building->id)
                        <div class="p-4 border-t border-purple-200 dark:border-purple-800 bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center justify-between mb-4">
                                <p class="flex items-center font-semibold text-sm text-gray-700 dark:text-gray-200 mb-4">{{ $building->description }}</p>
                                @can('floor.create')
                                    <button wire:click="openModal('floor', 'create', null, {{ $building->id }})"
                                    class="flex items-center px-4 py-2 bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200 text-sm font-medium rounded hover:bg-orange-200 dark:hover:bg-orange-700 transition cursor-pointer">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        {{ __("Add New Floor") }}
                                    </button>
                                @endcan

                            </div>

                            <div class="space-y-3 mt-4">
                                @forelse($building->floors->sortBy('floor_number') as $floor)
                                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                                        <div class="p-3 flex justify-between items-center cursor-pointer"
                                            wire:click="expandFloor({{ $floor->id }})">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900 flex items-center justify-center mr-2">
                                                    <svg class="h-4 w-4 text-orange-600 dark:text-orange-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                                    </svg>

                                                </div>
                                                <div>
                                                    <div class="flex items-center font-semibold text-sm text-gray-900 dark:text-gray-100"> {{ $floor->floor_number }} - {{ __("Floor") }}  <x-status-icon :active="$floor->is_active" /></div>
                                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $floor->description }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @can('floor.edit')
                                                    <button
                                                        wire:click.stop="openModal('floor', 'edit', {{ $floor->id }}, {{ $building->id }})"
                                                        class="text-blue-400 dark:text-blue-200 hover:text-blue-600 dark:hover:text-blue-400 p-1 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                                                        <x-icons.edit />
                                                    </button>
                                                @endcan
                                                @can('floor.delete')
                                                    <button
                                                        wire:click.stop="openModal('floor', 'delete', {{ $floor->id }})"
                                                        class="text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition">
                                                        <x-icons.delete />
                                                    </button>
                                                @endcan
                                                <svg class="w-4 h-4 transition-transform duration-300 {{ $expandedFloorId === $floor->id ? 'rotate-90' : '' }} text-gray-400 dark:text-gray-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        @if ($expandedFloorId === $floor->id)
                                            <div class="p-3 border-t border-orange-100 dark:border-orange-800 bg-gray-100 dark:bg-gray-800">
                                                <div class="flex items-center justify-between mb-4">
                                                    <span class="text-sm font-semibold mb-2 text-gray-700 dark:text-gray-200">Rooms:</span>
                                                    @can('room.create')
                                                        <button
                                                            wire:click="openModal('room', 'create', null, {{ $floor->id }})"
                                                            class="flex items-center text-sm px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 font-medium rounded hover:bg-blue-50 dark:hover:bg-blue-700 transition cursor-pointer">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                                stroke-width="2" viewBox="0 0 24 24">
                                                                <path d="M12 4v16m8-8H4"></path>
                                                            </svg>
                                                            {{ __("Add New Room") }}
                                                        </button>
                                                    @endcan
                                                </div>

                                                <div class="space-y-2 mt-4">
                                                    @forelse($floor->rooms->sortBy('number') as $room)
                                                        <div
                                                            class="bg-white dark:bg-gray-900 rounded-md shadow-xs border border-gray-100 dark:border-gray-700 p-3 flex flex-col">
                                                            <div class="flex justify-between items-center">
                                                                <div class="flex items-center">
                                                                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-2">
                                                                        <svg class="h-4 w-4 text-blue-600 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div class="flex items-center font-semibold text-sm text-gray-900 dark:text-gray-100"> {{ $room->number }} - {{ __("Room") }}  <x-status-icon :active="$room->is_active" /></div>
                                                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                                            {{ $room->name }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex items-center space-x-1">
                                                                    <button
                                                                        wire:click.stop="openModal('room', 'edit', {{ $room->id }}, {{ $floor->id }})"
                                                                        class="text-blue-400 dark:text-blue-200 hover:text-blue-600 dark:hover:text-blue-400 p-1 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                                                                        <x-icons.edit />
                                                                    </button>
                                                                    <button
                                                                        wire:click.stop="openModal('room', 'delete', {{ $room->id }})"
                                                                        class="text-red-400 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition">
                                                                        <x-icons.delete />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p class="text-gray-500 dark:text-gray-400 text-center text-sm italic">{{ __("No rooms found for this floor.") }}</p>
                                                    @endforelse
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 text-center text-sm italic">{{ __("No buildings found. Start by adding a new one!") }}</p>
                                @endforelse
                            </div>


                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center text-lg italic">{{ __("No buildings found. Start by adding a new one!") }}</p>
            @endforelse
        </div>
    </div>
</div>
