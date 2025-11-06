<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class LaporanKeuangan extends Component
{
    public function render()
    {
        return view('livewire.admin.laporan-keuangan')
            ->layout('layouts.app');
    }
}
