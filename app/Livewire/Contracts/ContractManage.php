<?php

namespace App\Livewire\Contracts;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Contract;
use Illuminate\Support\Facades\Storage;

class ContractManage extends Component
{
    use WithFileUploads;

    public $contracts;

    // Modal controls
    public $showModal = false;
    public $modalType = 'contract'; // always 'contract' for this component
    public $actionType = 'create'; // create|edit|delete

    // Selected ID
    public $contractId;

    // Form fields
    public $number;
    public $date;
    public $inventory_numbers = [];
    public $inventory_number_input = '';
    public $pdf_path;
    public $pdf_file; // For Livewire file upload
    public $description;

    protected function rules()
    {
        $rules = [
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'inventory_numbers' => 'required|array|min:1',
            'inventory_numbers.*' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];

        if ($this->actionType === 'create') {
            $rules['pdf_file'] = 'required|file|mimes:pdf|max:20480'; // max 20MB
        } else {
            $rules['pdf_file'] = 'nullable|file|mimes:pdf|max:20480';
        }

        return $rules;
    }

    public function mount()
    {
        $this->loadContracts();
    }

    public function loadContracts()
    {
        $this->contracts = Contract::with('user')->latest()->get();
    }

    public function render()
    {
        return view('livewire.contracts.contract-manage');
    }

    // --- Modal handlers ---
    public function openModal($actionType = 'create', $id = null)
    {
        $this->resetErrorBag();
        $this->resetAllFields();
        $this->modalType = 'contract';
        $this->actionType = $actionType;
        $this->contractId = $id;

        if ($actionType === 'edit' && $id) {
            $contract = Contract::findOrFail($id);
            $this->number = $contract->number;
            $this->date = $contract->date->toDateString();
            $this->inventory_numbers = $contract->inventory_numbers ?? [];
            $this->pdf_path = $contract->pdf_path;
            $this->pdf_file = null;
            $this->description = $contract->description;
        } elseif ($actionType === 'delete' && $id) {
            $contract = Contract::findOrFail($id);
            $this->number = $contract->number;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetAllFields();
        $this->resetErrorBag();
    }

    // --- Form helpers ---
    public function addInventoryNumber()
    {
        $val = trim($this->inventory_number_input);
        if ($val && !in_array($val, $this->inventory_numbers)) {
            $this->inventory_numbers[] = $val;
        }
        $this->inventory_number_input = '';
    }

    public function removeInventoryNumber($value)
    {
        $this->inventory_numbers = array_values(array_filter(
            $this->inventory_numbers,
            fn($item) => $item !== $value
        ));
    }

    // --- CRUD actions ---
    public function save()
    {
        // Add the input value to the array before validation
        if ($this->inventory_number_input) {
            $this->addInventoryNumber();
        }

        $this->validate();

        $data = [
            'number' => $this->number,
            'date' => $this->date,
            'inventory_numbers' => $this->inventory_numbers,
            'description' => $this->description,
            'user_id' => auth()->id(),
        ];

        // File upload
        if ($this->pdf_file) {
            $pdfPath = $this->pdf_file->store('contracts', 'public');
            $data['pdf_path'] = $pdfPath;

            // Remove old file if necessary
            if ($this->actionType === 'edit' && $this->pdf_path && $this->pdf_path !== $pdfPath) {
                Storage::disk('public')->delete($this->pdf_path);
            }
        } elseif ($this->actionType === 'edit') {
            $data['pdf_path'] = $this->pdf_path;
        }

        if ($this->actionType === 'edit') {
            $contract = Contract::findOrFail($this->contractId);
            $contract->update($data);
            session()->flash('success', __('Contract updated.'));
        } else {
            Contract::create($data);
            session()->flash('success', __('Contract created.'));
        }

        $this->loadContracts();
        $this->closeModal();
    }

    public function delete()
    {
        if ($this->actionType !== 'delete') return;

        $contract = Contract::findOrFail($this->contractId);
        if ($contract->pdf_path) {
            Storage::disk('public')->delete($contract->pdf_path);
        }
        $contract->delete();
        session()->flash('success', __('Contract deleted.'));
        $this->loadContracts();
        $this->closeModal();
    }

    // --- Helpers ---
    private function resetAllFields()
    {
        $this->contractId = null;
        $this->number = '';
        $this->date = '';
        $this->inventory_numbers = [];
        $this->inventory_number_input = '';
        $this->pdf_path = null;
        $this->pdf_file = null;
        $this->description = '';
    }
}
