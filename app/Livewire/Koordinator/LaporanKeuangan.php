<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class LaporanKeuangan extends Component
{
    public function render()
    {
        return view('livewire.koordinator.laporan-keuangan')
            ->layout('layouts.app');
    }
}
