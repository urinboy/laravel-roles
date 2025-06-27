<?php

namespace App\Livewire\Roles;

use Spatie\Permission\Models\Role;
use Livewire\Component;
use Livewire\Attributes\On;

class RoleIndex extends Component
{
    public $roles;

    public function mount()
    {
        // Permission: role.list
        if (!auth()->user()?->can('role.list')) {
            abort(403, 'You do not have permission to view roles.');
        }
        $this->roles = Role::all();
    }

    public function delete($id)
    {
        // Permission: role.delete
        if (!auth()->user()?->can('role.delete')) {
            abort(403, 'You do not have permission to delete roles.');
        }
        Role::findOrFail($id)->delete();
        $this->roles = Role::all();
        $this->dispatch('flash-success', message: __('Role deleted successfully.'));
    }

    #[On('role-created')]
    public function refreshRoles($url)
    {
        // Permission: role.list
        if (auth()->user()?->can('role.list')) {
            $this->roles = Role::all();
        }
        $this->dispatch('navigate', $url);
    }

    #[On('flash-success')]
    public function flashSuccess($message)
    {
        session()->flash('success', $message);
    }

    public function render()
    {
        // Permission: role.list
        if (!auth()->user()?->can('role.list')) {
            abort(403, 'You do not have permission to view roles.');
        }
        return view('livewire.roles.role-index');
    }
}
