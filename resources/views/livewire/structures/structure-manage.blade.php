<div class="w-full mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">{{ __("University Structure") }}</h1>
        <div class="text-gray-500 mb-4">{{ __("Manage buildings, floors, faculties and rooms") }}</div>
        <div class="flex justify-end">
            <button
                class="flex items-center px-4 py-2 bg-blue-50 text-blue-700 font-medium rounded hover:bg-blue-100 transition"
                wire:click="openModal('building', 'create')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4"></path>
                </svg>
                {{  __("Add building") }}
            </button>
        </div>
    </div>
    <div>
        @foreach ($buildings as $building)
            <div class="border border-gray-200 rounded-lg bg-white mb-6 shadow-sm">
                <!-- Building Header -->
                <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-3" wire:click="expandBuilding({{ $building->id }})">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor"
                                 class="h-5 w-5 text-gray-500 transition-transform duration-200 {{ $expandedBuildingId === $building->id ? 'rotate-180' : '' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                            </svg>
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-purple-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="font-semibold text-lg text-gray-900">{{ $building->name }}</div>
                            <div class="text-sm text-gray-500">{{ $building->address }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                wire:click.stop="openModal('building','edit',{{ $building->id }})" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                wire:click.stop="openModal('building','delete',{{ $building->id }})" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Expanded Building Content -->
                @if ($expandedBuildingId === $building->id)
                    <div class="pb-4">
                        <div class="border-t border-gray-100 pt-4">
                            <div class="px-4 mb-4">
                                <div class="border-b border-gray-200">
                                    <nav class="-mb-px flex space-x-8">
                                        <button class="py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" disabled>
                                            {{ __("Floors & Rooms") }}
                                        </button>
                                    </nav>
                                </div>
                            </div>
                            <div class="px-4">
                                <div class="space-y-2">
                                    @foreach ($building->floors as $floor)
                                        <div class="border border-gray-200 rounded-lg bg-white">
                                            <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                                                <div class="flex items-center space-x-3" wire:click="expandFloor({{ $floor->id }})">
                                                    <div class="flex items-center space-x-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                             stroke-width="1.5" stroke="currentColor"
                                                             class="h-5 w-5 text-gray-500 {{ $expandedFloorId === $floor->id ? 'rotate-180' : '' }}">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                                        </svg>
                                                        <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                 stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-orange-600">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">{{ $floor->floor_number }} - {{ __("floor") }}</div>
                                                        <div class="text-sm text-gray-500">{{ $floor->description }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <button class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                                            wire:click.stop="openModal('floor','edit',{{ $floor->id }},{{ $building->id }})" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                             stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                                        </svg>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                                            wire:click.stop="openModal('floor','delete',{{ $floor->id }},{{ $building->id }})" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                             stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            {{-- Rooms (add your own collapse logic if needed) --}}
                                            @if($expandedFloorId === $floor->id)
                                                <div class="px-4 py-2 space-y-2">
                                                @foreach($floor->rooms as $room)
                                                    <div class="border border-gray-200 rounded-lg bg-white">
                                                        <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="flex items-center space-x-2">
                                                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                             stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-blue-600">
                                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                                  d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="font-medium text-gray-900">{{ $room->number }} - {{ $room->name }}</div>
                                                                    <div class="text-sm text-gray-500">{{ $room->description }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center space-x-2">
                                                                <button class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                                                        wire:click.stop="openModal('room','edit',{{ $room->id }},{{ $floor->id }})" title="Edit">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                         stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                                                    </svg>
                                                                </button>
                                                                <button class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                                                        wire:click.stop="openModal('room','delete',{{ $room->id }},{{ $floor->id }})" title="Delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                         stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                                <button class="flex items-center space-x-2 px-4 m-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors"
                                                        wire:click.stop="openModal('room','create',null,{{ $floor->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                         stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M12 4.5v15m7.5-7.5h-15"/>
                                                    </svg>
                                                    <span>Add room</span>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                    <button class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-orange-600 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors"
                                            wire:click.stop="openModal('floor','create',null,{{ $building->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        <span>Add floor</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    @include('livewire.structures.partials.structure-modal')
</div>
