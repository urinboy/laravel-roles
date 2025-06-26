<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleShow extends Component
{
    public $role;
    public $permissions = [];

    public function mount($id)
    {
        $this->role = Role::findOrFail($id);
        $this->permissions = $this->role->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        return view('livewire.roles.role-show');
    }
}
