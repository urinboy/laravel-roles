<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public $name, $email, $password, $confirm_password;
    public $role = null; // endi faqat bitta rol
    public $allRoles = [];

    public function mount()
    {
        // Permission: user.create
        if (!auth()->user()?->can('user.create')) {
            abort(403, 'You do not have permission to create users.');
        }
        $this->allRoles = Role::all();
    }

    public function render()
    {
        // Permission: user.create
        if (!auth()->user()?->can('user.create')) {
            abort(403, 'You do not have permission to create users.');
        }
        return view('livewire.users.user-create');
    }

    public function submit()
    {
        // Permission: user.create
        if (!auth()->user()?->can('user.create')) {
            abort(403, 'You do not have permission to create users.');
        }

        $this->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|min:8|same:confirm_password",
            "role" => "required|exists:roles,name",
        ]);

        $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => bcrypt($this->password),
        ]);

        $user->assignRole($this->role);

        return to_route('users.index')->with("success", __("User created successfully."));
    }
}
