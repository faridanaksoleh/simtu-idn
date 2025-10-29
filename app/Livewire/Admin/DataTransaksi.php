<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class DataTransaksi extends Component
{
    public function render()
    {
        return view('livewire.admin.data-transaksi')
            ->layout('layouts.app');
    }
}
