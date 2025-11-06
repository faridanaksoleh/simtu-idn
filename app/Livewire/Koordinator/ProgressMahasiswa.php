<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class ProgressMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.koordinator.progress-mahasiswa')
            ->layout('layouts.app');
    }
}
