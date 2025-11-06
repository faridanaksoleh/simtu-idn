<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class RiwayatTransaksi extends Component
{
    public function render()
    {
        return view('livewire.koordinator.riwayat-transaksi')
            ->layout('layouts.app');
    }
}
