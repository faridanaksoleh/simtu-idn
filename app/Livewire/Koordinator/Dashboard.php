<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.koordinator.dashboard')
            ->layout('layouts.app');
    }
}
