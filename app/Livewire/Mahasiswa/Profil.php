<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class Profil extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.profil')
            ->layout('layouts.app');
    }
}
