<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class TransaksiMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.transaksi-mahasiswa')
            ->layout('layouts.app');
    }
}
