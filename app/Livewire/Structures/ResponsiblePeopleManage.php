<?php

namespace App\Livewire\Structures;

use App\Models\ResponsiblePerson;
use Livewire\Component;

class ResponsiblePeopleManage extends Component
{
    public $responsiblePeople;

    // Modal controls
    public $showModal = false;
    public $actionType = 'create'; // create|edit|delete

    // Form fields for Responsible Person
    public $responsible_person_id;
    public $responsible_person_full_name;
    public $responsible_person_phone;
    public $responsible_person_passport_pdf_path;
    public $responsible_person_is_active = true;

    protected $listeners = ['refreshResponsiblePeople' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->responsiblePeople = ResponsiblePerson::orderBy('full_name')->get();
    }

    public function render()
    {
        return view('livewire.structures.responsible-people-manage');
    }

    public function openModal($actionType = 'create', $id = null)
    {
        $this->resetErrorBag();
        $this->resetAllFields();

        $this->actionType = $actionType;
        $this->responsible_person_id = $id;

        if ($actionType === 'edit' && $id) {
            $rp = ResponsiblePerson::findOrFail($id);
            $this->responsible_person_full_name = $rp->full_name;
            $this->responsible_person_phone = $rp->phone;
            $this->responsible_person_passport_pdf_path = $rp->passport_pdf_path;
            $this->responsible_person_is_active = $rp->is_active;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetAllFields();
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'responsible_person_full_name' => 'required|string|max:255',
            'responsible_person_phone' => 'nullable|string|max:255',
            'responsible_person_passport_pdf_path' => 'nullable|string|max:255',
            'responsible_person_is_active' => 'required|boolean',
        ]);

        ResponsiblePerson::updateOrCreate(['id' => $this->responsible_person_id], [
            'full_name' => $this->responsible_person_full_name,
            'phone' => $this->responsible_person_phone,
            'passport_pdf_path' => $this->responsible_person_passport_pdf_path,
            'is_active' => $this->responsible_person_is_active,
        ]);

        session()->flash('success', $this->actionType === 'create'
            ? __('Responsible person created.')
            : __('Responsible person updated.')
        );

        $this->closeModal();
        $this->loadData();
        $this->dispatch('refreshStructures');
    }

    public function delete()
    {
        if ($this->actionType !== 'delete' || !$this->responsible_person_id) {
            return;
        }

        ResponsiblePerson::findOrFail($this->responsible_person_id)->delete();
        session()->flash('success', __('Responsible person deleted.'));

        $this->closeModal();
        $this->loadData();
        $this->dispatch('refreshStructures');
    }

    private function resetAllFields()
    {
        $this->responsible_person_id = null;
        $this->responsible_person_full_name = '';
        $this->responsible_person_phone = '';
        $this->responsible_person_passport_pdf_path = '';
        $this->responsible_person_is_active = true;
    }
}
