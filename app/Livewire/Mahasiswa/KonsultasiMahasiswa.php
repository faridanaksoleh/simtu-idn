<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class KonsultasiMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.konsultasi-mahasiswa')
            ->layout('layouts.app');
    }
}
