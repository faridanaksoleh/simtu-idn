<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class TargetTabungan extends Component
{
    public function render()
    {
        return view('livewire.mahasiswa.target-tabungan')
            ->layout('layouts.app');
    }
}
