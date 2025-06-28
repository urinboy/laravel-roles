<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserManage extends Component
{
    public $users;
    public $roles;
    public $showModal = false;
    public $modalType = 'create'; // create | edit | delete
    public $userId;
    public $name;
    public $email;
    public $first_name;
    public $last_name;
    public $phone;
    public $role;
    public $password;
    public $confirm_password;

    public function mount()
    {
        $this->checkPermission('user.list');
        $this->users = User::with('roles')->get();
        $this->roles = Role::all();
    }

    public function openModal($type, $id = null)
    {
        $this->modalType = $type;
        $this->userId = $id;
        $this->resetErrorBag();

        if ($type === 'edit') {
            $this->checkPermission('user.edit');
            $user = User::with('roles')->findOrFail($id);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->phone = $user->phone;
            $this->role = $user->roles->first()?->name;
            $this->password = "";
            $this->confirm_password = "";
        } elseif ($type === 'delete') {
            $this->checkPermission('user.delete');
            $user = User::findOrFail($id);
            $this->name = $user->name;
            $this->email = $user->email;
        } else {
            $this->checkPermission('user.create');
            $this->reset(['name', 'email', 'first_name', 'last_name', 'phone', 'role', 'password', 'confirm_password', 'userId']);
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'first_name', 'last_name', 'phone', 'role', 'password', 'confirm_password', 'userId', 'modalType']);
    }

    public function save()
    {
        if ($this->modalType === 'edit') {
            $this->checkPermission('user.edit');
            $this->validate([
                'name' => 'required|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:32',
                'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
                'role' => 'required|exists:roles,name',
                'password' => 'nullable|min:8|same:confirm_password',
            ]);
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'email' => $this->email,
                ...( $this->password ? ['password' => bcrypt($this->password)] : [] ),
            ]);
            $user->syncRoles([$this->role]);
            session()->flash('success', __('User updated.'));
        } else {
            $this->checkPermission('user.create');
            $this->validate([
                'name' => 'required|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:32',
                'email' => 'required|email|max:255|unique:users,email',
                'role' => 'required|exists:roles,name',
                'password' => 'required|min:8|same:confirm_password',
            ]);
            $user = User::create([
                'name' => $this->name,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->assignRole($this->role);
            session()->flash('success', __('User created.'));
        }

        $this->users = User::with('roles')->get();
        $this->closeModal();
    }

    public function delete()
    {
        $this->checkPermission('user.delete');
        User::findOrFail($this->userId)->delete();
        session()->flash('success', __('User deleted.'));
        $this->users = User::with('roles')->get();
        $this->closeModal();
    }

    protected function checkPermission($ability)
    {
        if (!auth()->user()?->can($ability)) {
            abort(403, 'You do not have permission.');
        }
    }

    public function render()
    {
        $this->checkPermission('user.list');
        return view('livewire.users.user-manage');
    }
}
