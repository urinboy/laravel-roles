<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserShow extends Component
{
    public $user;

    public function mount($id)
    {
        // Permission: user.view
        if (!auth()->user()?->can('user.view')) {
            abort(403, 'You do not have permission to view users.');
        }

        $this->user = User::with('roles')->findOrFail($id);
    }

    public function render()
    {
        // Permission: user.view (optional, agar har safar tekshirmoqchi bo‘lsangiz)
        if (!auth()->user()?->can('user.view')) {
            abort(403, 'You do not have permission to view users.');
        }

        return view('livewire.users.user-show');
    }
}
