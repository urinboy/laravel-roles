<?php

namespace App\Livewire\Characteristics;

use Livewire\Component;
use App\Models\Property;
use App\Models\EquipmentType;

class CharacteristicManage extends Component
{
    public $equipmentTypes;
    public $equipmentTypeId;
    public $name;
    public $editMode = false;
    public $editId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'equipmentTypeId' => 'required|exists:equipment_types,id',
    ];

    public function mount()
    {
        $this->equipmentTypes = EquipmentType::all();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $property = Property::find($this->editId);
            $property->update([
                'name' => $this->name,
                'equipment_type_id' => $this->equipmentTypeId,
            ]);
        } else {
            Property::create([
                'name' => $this->name,
                'equipment_type_id' => $this->equipmentTypeId,
            ]);
        }

        $this->resetInput();
        $this->emit('characteristicSaved');
    }

    public function edit($id)
    {
        $property = Property::find($id);
        $this->editId = $id;
        $this->name = $property->name;
        $this->equipmentTypeId = $property->equipment_type_id;
        $this->editMode = true;
    }

    public function delete($id)
    {
        Property::find($id)->delete();
        $this->emit('characteristicDeleted');
    }

    public function cancelEdit()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->equipmentTypeId = '';
        $this->editMode = false;
        $this->editId = null;
    }

    public function render()
    {
        $characteristics = Property::with('equipmentType')->get();
        return view('livewire.characteristics.characteristic-manage', [
            'characteristics' => $characteristics,
        ]);
    }
}