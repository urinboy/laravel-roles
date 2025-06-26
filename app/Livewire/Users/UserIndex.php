<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class UserIndex extends Component
{
    public $users;

    public function mount()
    {
        // Rollarni eager load qilamiz
        $this->users = User::with('roles')->get();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        $this->users = User::with('roles')->get();
        $this->dispatch('flash-success', message: __('User deleted successfully.'));
    }

    #[On('user-created')]
    public function refreshUsers($url)
    {
        $this->users = User::with('roles')->get();
        $this->dispatch('navigate', $url);
    }

    #[On('flash-success')]
    public function flashSuccess($message)
    {
        session()->flash('success', $message);
    }

    public function render()
    {
        return view('livewire.users.user-index');
    }
}
