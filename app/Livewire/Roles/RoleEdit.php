<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleEdit extends Component
{
    public $role;
    public $name;
    public $permissions = [];
    public $allPermissions;

    public function mount($id)
    {
        // Permission: role.edit
        if (!auth()->user()?->can('role.edit')) {
            abort(403, 'You do not have permission to edit roles.');
        }

        $this->role = Role::findOrFail($id);
        $this->name = $this->role->name;
        $this->permissions = $this->role->permissions->pluck('name')->toArray();
        $this->allPermissions = Permission::all();
    }

    public function checkAllPermissions($model)
    {
        $order = ['list', 'view', 'create', 'edit', 'delete'];
        $modelPermissions = [];
        foreach ($order as $action) {
            $perm = $model.'.'.$action;
            if ($this->allPermissions->pluck('name')->contains($perm)) {
                $modelPermissions[] = $perm;
            }
        }
        $this->permissions = array_values(array_unique(array_merge($this->permissions ?: [], $modelPermissions)));
    }

    public function uncheckAllPermissions($model)
    {
        $order = ['list', 'view', 'create', 'edit', 'delete'];
        $modelPermissions = [];
        foreach ($order as $action) {
            $perm = $model.'.'.$action;
            if ($this->allPermissions->pluck('name')->contains($perm)) {
                $modelPermissions[] = $perm;
            }
        }
        $this->permissions = array_values(array_diff($this->permissions ?: [], $modelPermissions));
    }

    public function submit()
    {
        // Permission: role.edit
        if (!auth()->user()?->can('role.edit')) {
            abort(403, 'You do not have permission to edit roles.');
        }

        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
            'permissions' => 'array',
        ]);

        $this->role->update(['name' => $this->name]);
        $this->role->syncPermissions($this->permissions);

        return to_route('roles.index')->with('success', __('Role updated successfully.'));
    }

    public function render()
    {
        // Permission: role.edit
        if (!auth()->user()?->can('role.edit')) {
            abort(403, 'You do not have permission to edit roles.');
        }
        return view('livewire.roles.role-edit');
    }
}
