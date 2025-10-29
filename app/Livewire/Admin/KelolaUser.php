<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class KelolaUser extends Component
{
    public function render()
    {
        return view('livewire.admin.kelola-user')
            ->layout('layouts.app');
    }
}
