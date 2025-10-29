<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class TargetTabungan extends Component
{
    public function render()
    {
        return view('livewire.admin.target-tabungan')
            ->layout('layouts.app');
    }
}
