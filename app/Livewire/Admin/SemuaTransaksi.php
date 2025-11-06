<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SemuaTransaksi extends Component
{
    public function render()
    {
        return view('livewire.admin.semua-transaksi')
            ->layout('layouts.app');
    }
}
