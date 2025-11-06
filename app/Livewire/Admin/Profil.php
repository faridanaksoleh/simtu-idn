<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Profil extends Component
{
    public function render()
    {
        return view('livewire.admin.profil')
            ->layout('layouts.app');
    }
}
