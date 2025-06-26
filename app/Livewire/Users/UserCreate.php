<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public $name, $email, $password, $confirm_password;
    public $roles = []; // array bo'lishi kerak
    public $allRoles = [];

    public function mount()
    {
        $this->allRoles = Role::all();
    }

    public function render()
    {
        return view('livewire.users.user-create');
    }

    public function submit()
    {
        $this->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|min:8|same:confirm_password",
            "roles" => "required|array|min:1",
            "roles.*" => "exists:roles,name",
        ]);

        $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => bcrypt($this->password),
        ]);

        $user->syncRoles($this->roles);

        return to_route('users.index')->with("success", __("User created successfully."));
    }
}
