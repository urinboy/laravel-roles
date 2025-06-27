<?php

namespace App\Livewire\Buildings;

use App\Models\Building;
use Livewire\Component;

class BuildingShow extends Component
{
    public $building;

    public function mount($id)
    {
        // Permission: building.view
        if (!auth()->user()?->can('building.view')) {
            abort(403, 'You do not have permission to view buildings.');
        }
        $this->building = Building::findOrFail($id);
    }

    public function render()
    {
        // Permission: building.view
        if (!auth()->user()?->can('building.view')) {
            abort(403, 'You do not have permission to view buildings.');
        }
        return view('livewire.buildings.building-show');
    }
}
