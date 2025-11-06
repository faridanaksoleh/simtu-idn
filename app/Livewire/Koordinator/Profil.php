<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class Profil extends Component
{
    public function render()
    {
        return view('livewire.koordinator.profil')
            ->layout('layouts.app');
    }
}
