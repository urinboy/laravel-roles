<?php

namespace App\Livewire\Buildings;

use App\Models\Building;
use Livewire\Component;

class BuildingShow extends Component
{
    public $building;

    public function mount($id)
    {
        $this->building = Building::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.buildings.building-show');
    }
}
