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
        // Faqat 'user.list' ruxsati bo'lganlar uchun userlarni yuklash
        if (auth()->user()?->can('user.list')) {
            $this->users = User::with('roles')->get();
        } else {
            abort(403, 'You do not have permission to view users.');
        }
    }

    public function delete($id)
    {
        // Faqat 'user.delete' ruxsati bo'lganlar foydalanuvchini o'chira oladi
        if (!auth()->user()?->can('user.delete')) {
            abort(403, 'You do not have permission to delete users.');
        }
        User::findOrFail($id)->delete();
        $this->users = User::with('roles')->get();
        $this->dispatch('flash-success', message: __('User deleted successfully.'));
    }

    #[On('user-created')]
    public function refreshUsers($url)
    {
        if (auth()->user()?->can('user.list')) {
            $this->users = User::with('roles')->get();
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
        // Faqat 'user.list' ruxsati bo'lganlar uchun view qaytariladi
        if (!auth()->user()?->can('user.list')) {
            abort(403, 'You do not have permission to view users.');
        }
        return view('livewire.users.user-index');
    }
}
