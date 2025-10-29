<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class TabunganMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.tabungan-mahasiswa')
            ->layout('layouts.app');
    }
}
