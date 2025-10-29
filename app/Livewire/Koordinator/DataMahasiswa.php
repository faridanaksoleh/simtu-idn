<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class DataMahasiswa extends Component
{
    public function render()
    {
        return view('livewire.koordinator.data-mahasiswa')
            ->layout('layouts.app');
    }
}
