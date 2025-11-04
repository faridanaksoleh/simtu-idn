<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // ← tambahkan ini

class KelolaUser extends Component
{
    public $users, $name, $email, $password, $role, $user_id;
    public $isEdit = false;

    public function render()
    {
        $this->users = User::orderBy('created_at', 'desc')->get();
        return view('livewire.admin.kelola-user')
            ->layout('layouts.app');
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => bcrypt($this->password),
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required',
        ]);

        $user = User::findOrFail($this->user_id);

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if (!empty($this->password)) {
            $updateData['password'] = bcrypt($this->password);
        }

        $user->update($updateData);

        session()->flash('message', 'User berhasil diperbarui.');
        $this->resetInputFields();
    }


    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }
}
