<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public $user;
    public $name, $email, $password, $confirm_password;
    public $role = null; // faqat bitta rol
    public $allRoles = [];

    public function mount($id)
    {
        // Permission: user.edit
        if (!auth()->user()?->can('user.edit')) {
            abort(403, 'You do not have permission to edit users.');
        }

        $this->user = User::with('roles')->findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->roles->pluck('name')->first(); // faqat birinchi rol
        $this->allRoles = Role::all();
    }

    public function submit()
    {
        // Permission: user.edit
        if (!auth()->user()?->can('user.edit')) {
            abort(403, 'You do not have permission to edit users.');
        }

        $this->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $this->user->id,
            "password" => "nullable|min:8|same:confirm_password",
            "role" => "required|exists:roles,name",
        ]);

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        if ($this->password) {
            $this->user->password = bcrypt($this->password);
        }
        $this->user->save();

        $this->user->syncRoles([$this->role]);

        return to_route('users.index')->with("success", __("User updated successfully."));
    }

    public function render()
    {
        // Permission: user.edit
        if (!auth()->user()?->can('user.edit')) {
            abort(403, 'You do not have permission to edit users.');
        }
        return view('livewire.users.user-edit');
    }
}
