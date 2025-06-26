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
        $this->buildings = Building::all();
    }

    public function delete($id)
    {
        Building::findOrFail($id)->delete();
        $this->buildings = Building::all();
        $this->dispatch('flash-success', message: __('Building deleted successfully.'));
    }

    #[On('building-created')]
    public function refreshBuildings($url)
    {
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
        return view('livewire.buildings.building-index');
    }
}
