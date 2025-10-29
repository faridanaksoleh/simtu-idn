<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class KategoriTabungan extends Component
{
    public function render()
    {
        return view('livewire.admin.kategori-tabungan')
            ->layout('layouts.app');
    }
}
