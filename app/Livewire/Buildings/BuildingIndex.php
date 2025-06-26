<?php

namespace App\Livewire\Buildings;

use App\Models\Building;
use Livewire\Component;

class BuildingIndex extends Component
{
    public $buildings;

    public function mount()
    {
        $this->buildings = Building::all();
    }
    public function render()
    {
        return view('livewire.buildings.building-index');
    }
}
