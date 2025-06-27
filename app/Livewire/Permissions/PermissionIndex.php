<?php

namespace App\Livewire\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    public $permissions;
    public $showModal = false;
    public $modalType = 'create'; // create | edit | delete
    public $permissionId;
    public $name;

    public function mount()
    {
        $this->checkPermission('permission.view');
        $this->permissions = Permission::all();
    }

    public function openModal($type, $id = null)
    {
        $this->modalType = $type;
        $this->permissionId = $id;
        $this->resetErrorBag();

        if ($type === 'edit') {
            $this->checkPermission('permission.edit');
            $perm = Permission::findOrFail($id);
            $this->name = $perm->name;
        } elseif ($type === 'delete') {
            $this->checkPermission('permission.delete');
            $perm = Permission::findOrFail($id);
            $this->name = $perm->name;
        } else {
            $this->checkPermission('permission.create');
            $this->name = '';
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'permissionId', 'modalType']);
    }

    public function save()
    {
        if ($this->modalType === 'edit') {
            $this->checkPermission('permission.edit');
            $this->validate([
                'name' => 'required|string|max:255|unique:permissions,name,' . $this->permissionId,
            ]);
            $perm = Permission::findOrFail($this->permissionId);
            $perm->update(['name' => $this->name]);
            session()->flash('success', __('Permission updated.'));
        } else {
            $this->checkPermission('permission.create');
            $this->validate([
                'name' => 'required|string|max:255|unique:permissions,name',
            ]);
            Permission::create(['name' => $this->name]);
            session()->flash('success', __('Permission created.'));
        }

        $this->permissions = Permission::all();
        $this->closeModal();
    }

    public function delete()
    {
        $this->checkPermission('permission.delete');
        Permission::findOrFail($this->permissionId)->delete();
        session()->flash('success', __('Permission deleted.'));
        $this->permissions = Permission::all();
        $this->closeModal();
    }

    // Custom permission check to avoid signature conflict with Livewire\Component::authorize
    protected function checkPermission($ability)
    {
        if (!auth()->user()?->can($ability)) {
            abort(403, 'You do not have permission.');
        }
    }

    public function render()
    {
        $this->checkPermission('permission.view');
        return view('livewire.permissions.permission-index');
    }
}
