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
    public $showModal = false;
    public $modalType = 'create'; // create | edit | delete
    public $contractId;

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

        if ($this->modalType === 'create') {
            $rules['pdf_file'] = 'required|file|mimes:pdf|max:20480'; // max 20MB
        } else {
            $rules['pdf_file'] = 'nullable|file|mimes:pdf|max:20480';
        }

        return $rules;
    }

    public function mount()
    {
        $this->contracts = Contract::with('user')->latest()->get();
    }

    public function openModal($type, $id = null)
    {
        $this->modalType = $type;
        $this->contractId = $id;
        $this->resetErrorBag();

        if ($type === 'edit') {
            $contract = Contract::findOrFail($id);
            $this->number = $contract->number;
            $this->date = $contract->date->toDateString();
            $this->inventory_numbers = $contract->inventory_numbers ?? [];
            $this->pdf_path = $contract->pdf_path;
            $this->pdf_file = null;
            $this->description = $contract->description;
        } elseif ($type === 'delete') {
            $contract = Contract::findOrFail($id);
            $this->number = $contract->number;
        } else {
            $this->reset([
                'number',
                'date',
                'inventory_numbers',
                'inventory_number_input',
                'pdf_path',
                'pdf_file',
                'description',
                'contractId'
            ]);
            $this->inventory_numbers = [];
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'number',
            'date',
            'inventory_numbers',
            'inventory_number_input',
            'pdf_path',
            'pdf_file',
            'description',
            'contractId'
        ]);
        $this->resetErrorBag();
    }

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

    public function save()
    {
        // Yuborishdan oldin inputdagi qiymatni massivga qo‘shamiz
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

        // Fayl yuklash
        if ($this->pdf_file) {
            $pdfPath = $this->pdf_file->store('contracts', 'public');
            $data['pdf_path'] = $pdfPath;

            // Faqat yangi fayl yuklanganda eski faylni o‘chir
            if ($this->modalType === 'edit' && $this->pdf_path && $this->pdf_path !== $pdfPath) {
                Storage::disk('public')->delete($this->pdf_path);
            }
        } elseif ($this->modalType === 'edit') {
            $data['pdf_path'] = $this->pdf_path;
        }

        if ($this->modalType === 'edit') {
            $contract = Contract::findOrFail($this->contractId);
            $contract->update($data);
            session()->flash('success', __('Contract updated.'));
        } else {
            Contract::create($data);
            session()->flash('success', __('Contract created.'));
        }

        $this->contracts = Contract::with('user')->latest()->get();
        $this->closeModal();
    }

    public function delete()
    {
        $contract = Contract::findOrFail($this->contractId);
        if ($contract->pdf_path) {
            Storage::disk('public')->delete($contract->pdf_path);
        }
        $contract->delete();
        session()->flash('success', __('Contract deleted.'));
        $this->contracts = Contract::with('user')->latest()->get();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.contracts.contract-manage');
    }
}
