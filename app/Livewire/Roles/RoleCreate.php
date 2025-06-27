<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleCreate extends Component
{
    public $name;
    public $permissions = [];
    public $allPermissions;

    public function mount()
    {
        // Permission: role.create
        if (!auth()->user()?->can('role.create')) {
            abort(403, 'You do not have permission to create roles.');
        }
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
        // Permission: role.create
        if (!auth()->user()?->can('role.create')) {
            abort(403, 'You do not have permission to create roles.');
        }

        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $this->name]);
        if ($this->permissions) {
            $role->syncPermissions($this->permissions);
        }

        return to_route('roles.index')->with('success', __('Role created successfully.'));
    }

    public function render()
    {
        // Permission: role.create
        if (!auth()->user()?->can('role.create')) {
            abort(403, 'You do not have permission to create roles.');
        }
        return view('livewire.roles.role-create');
    }
}
