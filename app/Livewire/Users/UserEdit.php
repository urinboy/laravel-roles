<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public $user;
    public $name, $email, $password, $confirm_password;
    public $roles = [];
    public $allRoles = [];

    public function mount($id)
    {
        $this->user = User::with('roles')->findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->roles = $this->user->roles->pluck('name')->toArray();
        $this->allRoles = Role::all();
    }

    public function submit()
    {
        $this->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $this->user->id,
            "password" => "nullable|min:8|same:confirm_password",
            "roles" => "required|array|min:1",
            "roles.*" => "exists:roles,name",
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        if ($this->password) {
            $this->user->password = bcrypt($this->password);
        }
        $this->user->save();

        $this->user->syncRoles($this->roles);

        return to_route('users.index')->with("success", __("User updated successfully."));
    }

    public function render()
    {
        return view('livewire.users.user-edit');
    }
}
