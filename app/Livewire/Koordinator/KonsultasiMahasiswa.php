<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class KonsultasiMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.koordinator.konsultasi-mahasiswa')
            ->layout('layouts.app');
    }
}
