<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">University Structure</h1>
        <div class="text-gray-500 mb-4">Manage buildings, floors, faculties and rooms</div>
        <div class="flex justify-end">
            <button
                class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded hover:bg-blue-100 transition"
                wire:click="openModal('building', 'create')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                Add building
            </button>
        </div>
    </div>
    <div>
        @foreach($buildings as $building)
            <div class="mb-5 rounded-xl border bg-gray-50">
                {{-- Building Header --}}
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-xl border">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 cursor-pointer min-w-0"
                             wire:click="expandBuilding({{ $building->id }})">
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 {{ $expandedBuildingId === $building->id ? 'rotate-90' : '' }}"
                                 viewBox="0 0 20 20" fill="none">
                                <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="2"></path>
                            </svg>
                            <span class="font-semibold text-lg truncate text-black">{{ $building->name }}</span>
                        </div>
                        @if($building->address)
                            <div class="flex items-center gap-1 mt-1 ml-7 text-xs text-gray-500">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/>
                                </svg>
                                <span class="truncate">{{ $building->address }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-2 items-start pt-1">
                        <button class="p-2 text-blue-500 hover:text-blue-600"
                                wire:click.stop="openModal('building','edit',{{ $building->id }})" title="Edit building">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-red-500 hover:text-red-600"
                                wire:click.stop="openModal('building','delete',{{ $building->id }})" title="Delete building">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                            </svg>
                        </button>
                    </div>
                </div>
                {{-- Expanded Building Content --}}
                @if($expandedBuildingId === $building->id)
                    <div class="bg-white rounded-b-xl border-t">
                        {{-- Tabs --}}
                        <div class="flex border-b">
                            <button class="px-4 py-2 -mb-px text-blue-600 border-b-2 border-blue-600 font-semibold bg-white focus:outline-none"
                                disabled>
                                Floors & Rooms
                            </button>
                        </div>
                        {{-- Floors --}}
                        <div class="px-6 pt-4 pb-2">
                            @foreach($building->floors as $floor)
                                <div class="mb-3">
                                    <div class="flex items-center gap-2 cursor-pointer"
                                         wire:click="expandFloor({{ $floor->id }})">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-100 text-orange-500 rounded-lg mr-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M3 21v-7a2 2 0 012-2h2a2 2 0 012 2v7M7 21V9a2 2 0 012-2h2a2 2 0 012 2v12M17 21v-5a2 2 0 012-2h2a2 2 0 012 2v5"/>
                                            </svg>
                                        </span>
                                        <span class="font-semibold text-base text-gray-800">Floor {{ $floor->floor_number }}</span>
                                        @if($floor->description)
                                            <span class="ml-2 text-xs text-gray-400">{{ $floor->description }}</span>
                                        @endif
                                    </div>
                                    {{-- Rooms --}}
                                    <div class="{{ $expandedFloorId === $floor->id ? 'block' : 'hidden' }}">
                                        @foreach($floor->rooms as $room)
                                            <div class="flex items-center bg-blue-50 rounded-lg px-4 py-2 mb-2 mt-2 shadow-sm">
                                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-500 rounded-lg mr-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M3 21v-7a2 2 0 012-2h2a2 2 0 012 2v7M7 21V9a2 2 0 012-2h2a2 2 0 012 2v12M17 21v-5a2 2 0 012-2h2a2 2 0 012 2v5"/>
                                                    </svg>
                                                </span>
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-semibold text-gray-800 truncate">{{ $room->name }}</div>
                                                    @if($room->description)
                                                        <div class="text-xs text-gray-500 truncate">{{ $room->description }}</div>
                                                    @endif
                                                </div>
                                                <button class="p-2 text-blue-500 hover:text-blue-600"
                                                        wire:click.stop="openModal('room','edit',{{ $room->id }},{{ $floor->id }})">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                         stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                                    </svg>
                                                </button>
                                                <button class="p-2 text-red-500 hover:text-red-600"
                                                        wire:click.stop="openModal('room','delete',{{ $room->id }},{{ $floor->id }})">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                         stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                        <button class="flex items-center text-sm text-blue-600 px-2 py-1 hover:bg-blue-50 rounded mt-2"
                                                wire:click.stop="openModal('room','create',null,{{ $floor->id }})">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                 stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add room
                                        </button>
                                    </div>
                                    <div class="ml-1 flex gap-2 mt-2">
                                        <button class="p-1 text-blue-500 hover:text-blue-600"
                                                wire:click.stop="openModal('floor','edit',{{ $floor->id }},{{ $building->id }})">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                 viewBox="0 0 24 24">
                                                <path d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.5 19.5H3v-4.5l13.862-13.513z"/>
                                            </svg>
                                        </button>
                                        <button class="p-1 text-red-500 hover:text-red-600"
                                                wire:click.stop="openModal('floor','delete',{{ $floor->id }},{{ $building->id }})">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                 viewBox="0 0 24 24">
                                                <path d="M6 18A2 2 0 008 20h8a2 2 0 002-2V7H6v11zM5 7h14M10 11v6m4-6v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <button class="flex items-center text-sm text-blue-600 px-2 py-1 hover:bg-blue-50 rounded mt-2"
                                    wire:click.stop="openModal('floor','create',null,{{ $building->id }})">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add floor
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    @include('livewire.structures.partials.structure-modal')
</div>
