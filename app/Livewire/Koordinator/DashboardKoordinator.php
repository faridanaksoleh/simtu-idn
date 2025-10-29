<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class DashboardKoordinator extends Component
{
    public function render()
    {
        return view('livewire.koordinator.dashboard-koordinator')
            ->layout('layouts.app');
    }
}
