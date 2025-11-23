<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelolaUser extends Component
{
    public $users, $name, $email, $password, $role, $user_id;
    public $nim, $major, $class, $phone, $is_active;
    public $isEdit = false;

    // 🔥 TAMBAHKAN PROPERTY UNTUK STORE DELETE ID
    public $deleteUserId = null;

    // 🔥 LISTENER YANG BENAR
    protected $listeners = ['deleteConfirmed' => 'performDelete'];

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
        $this->nim = '';
        $this->major = '';
        $this->class = '';
        $this->phone = '';
        $this->is_active = true;
        $this->isEdit = false;
        $this->user_id = null;
        $this->deleteUserId = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'nim' => 'required_if:role,mahasiswa|unique:users,nim',
            'major' => 'required_if:role,mahasiswa',
            'class' => 'required_if:role,mahasiswa',
            'phone' => 'nullable|string|max:15',
        ]);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'nim' => $this->nim,
            'major' => $this->major,
            'class' => $this->class,
            'phone' => $this->phone,
            'is_active' => $this->is_active ?? true,
            'password' => bcrypt($this->password),
        ];

        User::create($userData);

        $this->dispatch('showSuccess', [
            'message' => 'User berhasil ditambahkan.'
        ]);

        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->nim = $user->nim;
        $this->major = $user->major;
        $this->class = $user->class;
        $this->phone = $user->phone;
        $this->is_active = $user->is_active;
        $this->isEdit = true;
    }

    public function update()
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'role' => 'required',
            'phone' => 'nullable|string|max:15',
        ];

        if ($this->role == 'mahasiswa') {
            $validationRules['nim'] = 'required|unique:users,nim,' . $this->user_id;
            $validationRules['major'] = 'required';
            $validationRules['class'] = 'required';
        } else {
            $this->nim = null;
            $this->major = null;
            $this->class = null;
        }

        $this->validate($validationRules);

        $user = User::findOrFail($this->user_id);

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'nim' => $this->nim,
            'major' => $this->major,
            'class' => $this->class,
            'phone' => $this->phone,
            'is_active' => $this->is_active ?? true,
        ];

        if (!empty($this->password)) {
            $updateData['password'] = bcrypt($this->password);
        }

        $user->update($updateData);

        $this->dispatch('showSuccess', [
            'message' => 'User berhasil diperbarui.'
        ]);

        $this->resetInputFields();
        $this->dispatch('closeModal');
    }

    // 🔥 TAMBAHKAN METHOD UNTUK RESET KELAS SAAT JURUSAN BERUBAH
    public function updatedMajor($value)
    {
        // Reset kelas ketika jurusan berubah
        $this->class = '';
        
        // Dispatch event untuk JavaScript
        $this->dispatch('majorChanged', major: $value);
    }

    // 🔥 METHOD UNTUK TRIGGER SWEETALERT - SIMPAN ID NYA
    public function confirmDelete($id)
    {
        $this->deleteUserId = $id;
        $user = User::findOrFail($id);
        
        $this->dispatch('showDeleteConfirmation', [
            'title' => 'Hapus User?',
            'text' => "Yakin ingin menghapus user {$user->name}?",
            'confirmText' => 'Ya, Hapus!',
            'cancelText' => 'Batal',
            'id' => $id
        ]);
    }

    // 🔥 METHOD YANG DIPANGGIL SETELAH KONFIRMASI - TANPA PARAMETER
    public function performDelete()
    {
        if ($this->deleteUserId) {
            $user = User::findOrFail($this->deleteUserId);
            $userName = $user->name;
            $user->delete();
            
            $this->dispatch('showSuccess', [
                'message' => "User {$userName} berhasil dihapus."
            ]);
            
            $this->deleteUserId = null;
        }
    }

    // 🔥 FALLBACK METHOD JIKA PERLU
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();
        
        $this->dispatch('showSuccess', [
            'message' => "User {$userName} berhasil dihapus."
        ]);
    }
}