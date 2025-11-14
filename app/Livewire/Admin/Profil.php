<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profil extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $photo;
    public $current_photo;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->current_photo = $user->photo;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        
        // Handle photo upload
        if ($this->photo) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $this->photo->store('profile-photos', 'public');
            $user->photo = $photoPath;
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('success', 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.admin.profil')
            ->layout('layouts.app');
    }
}