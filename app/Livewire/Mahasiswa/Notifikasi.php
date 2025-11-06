<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class Notifikasi extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.notifikasi')
            ->layout('layouts.app');
    }
}
