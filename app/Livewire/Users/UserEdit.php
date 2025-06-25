<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserEdit extends Component
{
    public $user, $name, $email, $password, $confirm_password;
    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function render()
    {
        return view('livewire.users.user-edit');
    }

    public function submit()
    {
        $this->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $this->user->id,
            "password" => "nullable|min:8|same:confirm_password",
        ]);

        $this->user->update([
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password ? bcrypt($this->password) : $this->user->password,
        ]);

        return to_route('users.index')->with("success", __("User updated successfully."));
    }


}
