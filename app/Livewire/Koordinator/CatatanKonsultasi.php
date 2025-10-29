<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class CatatanKonsultasi extends Component
{
    public function render()
    {
        return view('livewire.koordinator.catatan-konsultasi')
            ->layout('layouts.app');
    }
}
