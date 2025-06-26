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
        $this->roles = Role::all();
    }

    public function delete($id)
    {
        Role::findOrFail($id)->delete();
        $this->roles = Role::all();
        $this->dispatch('flash-success', message: __('Role deleted successfully.'));
    }

    #[On('role-created')]
    public function refreshRoles($url)
    {
        $this->roles = Role::all();
        $this->dispatch('navigate', $url);
    }

    #[On('flash-success')]
    public function flashSuccess($message)
    {
        session()->flash('success', $message);
    }

    public function render()
    {
        return view('livewire.roles.role-index');
    }
}
