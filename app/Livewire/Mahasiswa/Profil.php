<?php

namespace App\Livewire\Mahasiswa;

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
    public $nim;
    public $major;
    public $class;
    public $photo;
    public $current_photo;

    // Data untuk dropdown
    public $majors = [
        'TRPL' => 'Teknologi Rekayasa Perangkat Lunak',
        'TRMG' => 'Teknologi Rekayasa Multimedia & Grafis',
        'TRKJ' => 'Teknologi Rekayasa Komputer & Jaringan'
    ];

    // Hapus $classes dan $isClassDisabled dari public properties
    // Kita akan gunakan computed property

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->nim = $user->nim;
        $this->major = $user->major;
        $this->class = $user->class;
        $this->current_photo = $user->photo;
    }

    // Update opsi kelas ketika jurusan berubah
    public function updatedMajor($value)
    {
        $this->class = ''; // Reset kelas ketika ganti jurusan
        $this->dispatch('major-updated'); // Dispatch event untuk refresh
    }

    // Computed property untuk classes
    public function getClassesProperty()
    {
        $classes = [
            'TRPL' => ['A', 'B', 'C', 'D'],
            'TRMG' => ['A', 'B'],
            'TRKJ' => ['A', 'B', 'C', 'D']
        ];

        return $classes[$this->major] ?? [];
    }

    // Computed property untuk isClassDisabled
    public function getIsClassDisabledProperty()
    {
        return empty($this->classes);
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'nim' => 'required|string|max:20|unique:users,nim,' . Auth::id(),
            'major' => 'required|string|in:TRPL,TRMG,TRKJ',
            'class' => 'required|string',
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
            'nim' => $this->nim,
            'major' => $this->major,
            'class' => $this->class,
        ]);

        session()->flash('success', 'Profil berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.mahasiswa.profil')
            ->layout('layouts.app');
    }
}