<?php

namespace App\Livewire\Buildings;

use App\Models\Building;
use Livewire\Component;

class BuildingEdit extends Component
{
    public $building, $name, $description, $address, $is_active;

    public function mount($id)
    {
        // Permission: building.edit
        if (!auth()->user()?->can('building.edit')) {
            abort(403, 'You do not have permission to edit buildings.');
        }

        $this->building = Building::findOrFail($id);
        $this->name = $this->building->name;
        $this->description = $this->building->description;
        $this->address = $this->building->address;
        $this->is_active = $this->building->is_active;
    }

    public function render()
    {
        // Permission: building.edit
        if (!auth()->user()?->can('building.edit')) {
            abort(403, 'You do not have permission to edit buildings.');
        }
        return view('livewire.buildings.building-edit');
    }

    public function submit()
    {
        // Permission: building.edit
        if (!auth()->user()?->can('building.edit')) {
            abort(403, 'You do not have permission to edit buildings.');
        }

        $this->validate([
            "name" => "required|string|max:255|unique:buildings,name," . $this->building->id,
            "description" => "nullable|string",
            "address" => "nullable|string|max:255",
            "is_active" => "boolean",
        ]);

        $this->building->update([
            "name" => $this->name,
            "description" => $this->description,
            "address" => $this->address,
            "is_active" => $this->is_active,
        ]);

        return to_route('buildings.index')->with("success", __("Building updated successfully."));
    }
}
