<?php

namespace App\Livewire\Buildings;

use App\Models\Building;
use Livewire\Component;
use Livewire\Attributes\On;

class BuildingIndex extends Component
{
    public $buildings;

    public function mount()
    {
        // Permission: building.list
        if (!auth()->user()?->can('building.list')) {
            abort(403, 'You do not have permission to view buildings.');
        }
        $this->buildings = Building::all();
    }

    public function delete($id)
    {
        // Permission: building.delete
        if (!auth()->user()?->can('building.delete')) {
            abort(403, 'You do not have permission to delete buildings.');
        }
        Building::findOrFail($id)->delete();
        $this->buildings = Building::all();
        $this->dispatch('flash-success', message: __('Building deleted successfully.'));
    }

    #[On('building-created')]
    public function refreshBuildings($url)
    {
        // Permission: building.list
        if (!auth()->user()?->can('building.list')) {
            abort(403, 'You do not have permission to view buildings.');
        }
        $this->buildings = Building::all();
        $this->dispatch('navigate', $url);
    }

    #[On('flash-success')]
    public function flashSuccess($message)
    {
        session()->flash('success', $message);
    }

    public function render()
    {
        // Permission: building.list
        if (!auth()->user()?->can('building.list')) {
            abort(403, 'You do not have permission to view buildings.');
        }
        return view('livewire.buildings.building-index');
    }
}
