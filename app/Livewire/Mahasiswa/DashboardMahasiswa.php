<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class DashboardMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.dashboard-mahasiswa')
            ->layout('layouts.app');
    }
}
