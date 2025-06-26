<?php

namespace App\Livewire\Buildings;

use App\Models\Building;
use Livewire\Component;

class BuildingCreate extends Component
{
    public $name, $description, $address, $is_active = true;

    public function render()
    {
        return view('livewire.buildings.building-create');
    }

    public function submit()
    {
        $this->validate([
            "name" => "required|string|max:255|unique:buildings,name",
            "description" => "nullable|string",
            "address" => "nullable|string|max:255",
            "is_active" => "boolean",
        ]);

        Building::create([
            "name" => $this->name,
            "description" => $this->description,
            "address" => $this->address,
            "is_active" => $this->is_active,
        ]);

        return to_route('buildings.index')->with("success", __("Building created successfully."));
    }
}
