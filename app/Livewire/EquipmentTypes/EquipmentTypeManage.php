<?php

namespace App\Livewire\EquipmentTypes;

use Livewire\Component;
use App\Models\EquipmentType;

class EquipmentTypeManage extends Component
{
    public $equipmentTypes;

    // Modal controls
    public $showModal = false;
    public $modalType = 'create'; // create|edit|delete
    public $equipmentTypeId;

    // Form fields
    public $name;
    public $icon;
    public $color;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255|unique:equipment_types,name',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:32',
        ];

        if ($this->modalType === 'edit') {
            $rules['name'] = 'required|string|max:255|unique:equipment_types,name,' . $this->equipmentTypeId;
        }

        return $rules;
    }

    public function mount()
    {
        $this->loadEquipmentTypes();
    }

    public function loadEquipmentTypes()
    {
        $this->equipmentTypes = EquipmentType::orderBy('name')->get();
    }

    public function openModal($type, $id = null)
    {
        $this->modalType = $type;
        $this->equipmentTypeId = $id;
        $this->resetErrorBag();

        if ($type === 'edit' && $id) {
            $eq = EquipmentType::findOrFail($id);
            $this->name  = $eq->name;
            $this->icon  = $eq->icon;
            $this->color = $eq->color;
        } elseif ($type === 'delete' && $id) {
            $eq = EquipmentType::findOrFail($id);
            $this->name = $eq->name;
        } else {
            $this->reset(['name', 'icon', 'color', 'equipmentTypeId']);
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'icon', 'color', 'equipmentTypeId']);
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        if ($this->modalType === 'edit') {
            $eq = EquipmentType::findOrFail($this->equipmentTypeId);
            $eq->update([
                'name'  => $this->name,
                'icon'  => $this->icon,
                'color' => $this->color,
            ]);
            session()->flash('success', __('Equipment type updated.'));
        } else {
            EquipmentType::create([
                'name'  => $this->name,
                'icon'  => $this->icon,
                'color' => $this->color,
            ]);
            session()->flash('success', __('Equipment type created.'));
        }

        $this->loadEquipmentTypes();
        $this->closeModal();
    }

    public function delete()
    {
        $eq = EquipmentType::findOrFail($this->equipmentTypeId);
        $eq->delete();
        session()->flash('success', __('Equipment type deleted.'));
        $this->loadEquipmentTypes();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.equipment-types.equipment-type-manage');
    }
}
