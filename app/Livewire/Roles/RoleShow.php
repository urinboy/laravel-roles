<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleShow extends Component
{
    public $role;
    public $permissions = [];

    public function mount($id)
    {
        // Permission: role.view
        if (!auth()->user()?->can('role.view')) {
            abort(403, 'You do not have permission to view roles.');
        }

        $this->role = Role::findOrFail($id);
        $this->permissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        // Permission: role.view
        if (!auth()->user()?->can('role.view')) {
            abort(403, 'You do not have permission to view roles.');
        }

        return view('livewire.roles.role-show');
    }
}
