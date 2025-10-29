<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.dashboard')
            ->layout('layouts.app');
    }
}
