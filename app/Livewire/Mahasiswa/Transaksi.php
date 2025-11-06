<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class Transaksi extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.transaksi')
            ->layout('layouts.app');
    }
}
