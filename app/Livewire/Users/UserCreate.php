<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|same:confirm_password',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        // Emit an event to notify UserIndex and trigger navigation
        $this->dispatch('user-created', route('users.index'));
        $this->dispatch('flash-success', message: __('User created successfully.'));

        // Reset form fields
        $this->reset(['name', 'email', 'password', 'confirm_password']);
    }

    #[On('navigate')]
    public function navigateTo($url)
    {
        $this->redirect($url, navigate: true);
    }
}