<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserCreate extends Component
{
    public $name, $email, $password, $confirm_password;
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
        ]);

        User::create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => bcrypt($this->password),
        ]);
        return to_route('users.index')->with("success", __("User created successfully."));
    }
}