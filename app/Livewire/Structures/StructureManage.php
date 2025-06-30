<?php

namespace App\Livewire\Structures;

use App\Models\ResponsiblePerson;
use Livewire\Component;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;

class StructureManage extends Component
{
    public $buildings;
    public $responsiblePeople;
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
    public $building_name, $building_address, $building_description, $building_is_active = true, $building_id;
    public $floor_number, $floor_description, $floor_level, $floor_is_active = true, $floor_id;
    public $room_number, $room_name, $room_description, $room_is_active = true, $room_responsible_person_id, $room_id;

    protected $listeners = ['refreshStructures' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->buildings = Building::with(['floors.rooms.responsiblePerson'])->orderBy('name')->get();
        $this->responsiblePeople = ResponsiblePerson::where('is_active', true)->orderBy('full_name')->get();
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
        $this->resetAllFields();
        $this->modalType = $modalType;
        $this->actionType = $actionType;

        if ($modalType === 'building') {
            if ($actionType === 'edit' && $id) {
                $b = Building::findOrFail($id);
                $this->building_id = $b->id;
                $this->building_name = $b->name;
                $this->building_address = $b->address;
                $this->building_description = $b->description;
                $this->building_is_active = $b->is_active;
            }
        } elseif ($modalType === 'floor') {
            $this->selectedBuildingId = $parentId; // building id
            if ($actionType === 'edit' && $id) {
                $f = Floor::findOrFail($id);
                $this->floor_id = $f->id;
                $this->floor_number = $f->floor_number;
                $this->floor_level = $f->level;
                $this->floor_description = $f->description;
                $this->floor_is_active = $f->is_active;
            }
        } elseif ($modalType === 'room') {
            $this->selectedFloorId = $parentId; // floor id
            if ($actionType === 'edit' && $id) {
                $r = Room::findOrFail($id);
                $this->room_id = $r->id;
                $this->room_number = $r->number;
                $this->room_name = $r->name;
                $this->room_description = $r->description;
                $this->room_is_active = $r->is_active;
                $this->room_responsible_person_id = $r->responsible_person_id;
            }
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetAllFields();
    }

    // --- CRUD actions ---
    public function save()
    {
        if ($this->modalType === 'building') {
            $this->validate([
                'building_name' => 'required|string|max:255',
                'building_address' => 'nullable|string|max:255',
                'building_description' => 'nullable|string',
                'building_is_active' => 'required|boolean',
            ]);
            Building::updateOrCreate(['id' => $this->building_id], [
                'name' => $this->building_name,
                'address' => $this->building_address,
                'description' => $this->building_description,
                'is_active' => $this->building_is_active,
            ]);
        } elseif ($this->modalType === 'floor') {
            $this->validate([
                'selectedBuildingId' => 'required|exists:buildings,id',
                'floor_number' => 'required|integer',
                'floor_level' => 'required|integer',
                'floor_description' => 'nullable|string',
                'floor_is_active' => 'required|boolean',
            ]);
            Floor::updateOrCreate(['id' => $this->floor_id], [
                'building_id' => $this->selectedBuildingId,
                'floor_number' => $this->floor_number,
                'level' => $this->floor_level,
                'description' => $this->floor_description,
                'is_active' => $this->floor_is_active,
            ]);
        } elseif ($this->modalType === 'room') {
            $this->validate([
                'selectedFloorId' => 'required|exists:floors,id',
                'room_number' => 'required|integer',
                'room_name' => 'required|string|max:255',
                'room_description' => 'nullable|string',
                'room_is_active' => 'required|boolean',
                'room_responsible_person_id' => 'nullable|exists:responsible_people,id',
            ]);
            Room::updateOrCreate(['id' => $this->room_id], [
                'floor_id' => $this->selectedFloorId,
                'number' => $this->room_number,
                'name' => $this->room_name,
                'description' => $this->room_description,
                'is_active' => $this->room_is_active,
                'responsible_person_id' => $this->room_responsible_person_id,
            ]);
        }
        $this->closeModal();
        $this->loadData();
    }

    public function delete()
    {
        if ($this->actionType !== 'delete') return;

        if ($this->modalType === 'building') {
            Building::findOrFail($this->building_id)->delete();
        } elseif ($this->modalType === 'floor') {
            Floor::findOrFail($this->floor_id)->delete();
        } elseif ($this->modalType === 'room') {
            Room::findOrFail($this->room_id)->delete();
        }
        $this->closeModal();
        $this->loadData();
    }

    // --- Helpers ---
    private function resetAllFields()
    {
        $this->building_id = null;
        $this->building_name = '';
        $this->building_address = '';
        $this->building_description = '';
        $this->building_is_active = true;

        $this->floor_id = null;
        $this->floor_number = '';
        $this->floor_level = '';
        $this->floor_description = '';
        $this->floor_is_active = true;

        $this->room_id = null;
        $this->room_number = '';
        $this->room_name = '';
        $this->room_description = '';
        $this->room_is_active = true;
        $this->room_responsible_person_id = null;

        $this->selectedBuildingId = null;
        $this->selectedFloorId = null;
        $this->selectedRoomId = null;
    }
}