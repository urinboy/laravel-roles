<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandManage extends Component
{
    use WithFileUploads;

    public $brands;

    // Modal controls
    public $showModal = false;
    public $actionType = 'create'; // create|edit|delete

    // Form fields for Brand
    public $brand_id;
    public $name;
    public $description;
    public $logo;
    public $logo_path;
    public $is_active = true;

    protected $listeners = ['refreshBrands' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->brands = Brand::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.brands.brand-manage');
    }

    public function openModal($actionType = 'create', $id = null)
    {
        $this->resetErrorBag();
        $this->resetAllFields();

        $this->actionType = $actionType;
        $this->brand_id = $id;

        if (($actionType === 'edit' || $actionType === 'delete') && $id) {
            $brand = Brand::findOrFail($id);
            $this->name = $brand->name;
            $this->description = $brand->description;
            $this->logo_path = $brand->logo;
            $this->is_active = $brand->is_active;
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
            'name' => 'required|string|max:255|unique:brands,name,' . $this->brand_id,
            'description' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // Fayl yuklash
        $logoPath = $this->logo_path;
        if ($this->logo) {
            $logoPath = $this->logo->store('brands', 'public');
        }

        Brand::updateOrCreate(['id' => $this->brand_id], [
            'name' => $this->name,
            'description' => $this->description,
            'logo' => $logoPath,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', $this->actionType === 'create'
            ? __('Brand created.')
            : __('Brand updated.')
        );

        $this->closeModal();
        $this->loadData();
        $this->dispatch('refreshBrands');
    }

    public function delete()
    {
        if ($this->actionType !== 'delete' || !$this->brand_id) {
            return;
        }

        Brand::findOrFail($this->brand_id)->delete();
        session()->flash('success', __('Brand deleted.'));

        $this->closeModal();
        $this->loadData();
        $this->dispatch('refreshBrands');
    }

    private function resetAllFields()
    {
        $this->brand_id = null;
        $this->name = '';
        $this->description = '';
        $this->logo = null;
        $this->logo_path = '';
        $this->is_active = true;
    }
}
