<?php

namespace App\Livewire\Structures;

use Livewire\Component;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Support\Collection;

class StructureManage extends Component
{
    public $buildings;
    public $expandedBuildingId = null;
    public $expandedFloorId = null;

    // Modal controls
    public $showModal = false;
    public $modalType = 'building'; // building|floor|room
    public $actionType = 'create'; // create|edit|delete

    // Selected IDs
    public $selectedBuildingId;
    public $selectedFloorId;
    public $selectedRoomId;

    // Form fields
    public $building_name;
    public $building_address;
    public $building_description;
    public $building_id;

    public $floor_number;
    public $floor_description;
    public $floor_id;

    public $room_name;
    public $room_description;
    public $room_id;

    protected $listeners = ['refreshStructures' => 'loadBuildings'];

    public function mount()
    {
        $this->loadBuildings();
    }

    public function loadBuildings()
    {
        $this->buildings = Building::with(['floors.rooms'])->orderBy('id')->get();
    }

    public function render()
    {
        return view('livewire.structures.structure-manage');
    }

    // --- UI actions ---
    public function expandBuilding($id)
    {
        $this->expandedBuildingId = $this->expandedBuildingId === $id ? null : $id;
        $this->expandedFloorId = null;
    }

    public function expandFloor($id)
    {
        $this->expandedFloorId = $this->expandedFloorId === $id ? null : $id;
    }

    // --- Modal handlers ---
    public function openModal($modalType, $actionType = 'create', $id = null, $parentId = null)
    {
        $this->resetErrorBag();
        $this->modalType = $modalType;
        $this->actionType = $actionType;

        if ($modalType === 'building') {
            if ($actionType === 'edit' && $id) {
                $b = Building::findOrFail($id);
                $this->building_id = $b->id;
                $this->building_name = $b->name;
                $this->building_address = $b->address;
                $this->building_description = $b->description;
            } else {
                $this->resetBuildingFields();
            }
        } elseif ($modalType === 'floor') {
            if ($actionType === 'edit' && $id) {
                $f = Floor::findOrFail($id);
                $this->floor_id = $f->id;
                $this->floor_number = $f->floor_number;
                $this->floor_description = $f->description;
                $this->selectedBuildingId = $f->building_id;
            } else {
                $this->resetFloorFields();
                $this->selectedBuildingId = $parentId; // building id
            }
        } elseif ($modalType === 'room') {
            if ($actionType === 'edit' && $id) {
                $r = Room::findOrFail($id);
                $this->room_id = $r->id;
                $this->room_name = $r->name;
                $this->room_description = $r->description;
                $this->selectedFloorId = $r->floor_id;
            } else {
                $this->resetRoomFields();
                $this->selectedFloorId = $parentId; // floor id
            }
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetBuildingFields();
        $this->resetFloorFields();
        $this->resetRoomFields();
    }

    // --- CRUD actions ---
    public function save()
    {
        if ($this->modalType === 'building') {
            $this->validate([
                'building_name' => 'required|string|max:255',
                'building_address' => 'nullable|string|max:255',
                'building_description' => 'nullable|string|max:255',
            ]);
            if ($this->actionType === 'edit') {
                $b = Building::findOrFail($this->building_id);
                $b->update([
                    'name' => $this->building_name,
                    'address' => $this->building_address,
                    'description' => $this->building_description,
                ]);
            } else {
                Building::create([
                    'name' => $this->building_name,
                    'address' => $this->building_address,
                    'description' => $this->building_description,
                ]);
            }
        } elseif ($this->modalType === 'floor') {
            $this->validate([
                'floor_number' => 'required|integer',
                'floor_description' => 'nullable|string|max:255',
                'selectedBuildingId' => 'required|exists:buildings,id',
            ]);
            if ($this->actionType === 'edit') {
                $f = Floor::findOrFail($this->floor_id);
                $f->update([
                    'building_id' => $this->selectedBuildingId,
                    'floor_number' => $this->floor_number,
                    'description' => $this->floor_description,
                ]);
            } else {
                Floor::create([
                    'building_id' => $this->selectedBuildingId,
                    'floor_number' => $this->floor_number,
                    'description' => $this->floor_description,
                ]);
            }
        } elseif ($this->modalType === 'room') {
            $this->validate([
                'room_name' => 'required|string|max:255',
                'room_description' => 'nullable|string|max:255',
                'selectedFloorId' => 'required|exists:floors,id',
            ]);
            if ($this->actionType === 'edit') {
                $r = Room::findOrFail($this->room_id);
                $r->update([
                    'floor_id' => $this->selectedFloorId,
                    'name' => $this->room_name,
                    'description' => $this->room_description,
                ]);
            } else {
                Room::create([
                    'floor_id' => $this->selectedFloorId,
                    'name' => $this->room_name,
                    'description' => $this->room_description,
                ]);
            }
        }
        $this->closeModal();
        $this->loadBuildings();
    }

    public function delete()
    {
        if ($this->modalType === 'building') {
            Building::findOrFail($this->building_id)->delete();
        } elseif ($this->modalType === 'floor') {
            Floor::findOrFail($this->floor_id)->delete();
        } elseif ($this->modalType === 'room') {
            Room::findOrFail($this->room_id)->delete();
        }
        $this->closeModal();
        $this->loadBuildings();
    }

    // --- Helpers ---
    private function resetBuildingFields()
    {
        $this->building_id = null;
        $this->building_name = '';
        $this->building_address = '';
        $this->building_description = '';
    }

    private function resetFloorFields()
    {
        $this->floor_id = null;
        $this->floor_number = '';
        $this->floor_description = '';
    }

    private function resetRoomFields()
    {
        $this->room_id = null;
        $this->room_name = '';
        $this->room_description = '';
    }
}
