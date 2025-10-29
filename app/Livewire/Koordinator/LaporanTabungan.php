<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class LaporanTabungan extends Component
{
    public function render()
    {
        return view('livewire.koordinator.laporan-tabungan')
            ->layout('layouts.app');
    }
}
