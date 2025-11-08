<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;

class Transaksi extends Component
{
    public $activeTab = 'buat';

    // Maintain state di URL
    protected $queryString = ['activeTab'];

    public function mount()
    {
        // Jika ada data di riwayat, auto switch ke tab riwayat
        if (request()->has('page') || request()->has('search') || request()->has('status')) {
            $this->activeTab = 'riwayat';
        }
    }

    public function render()
    {
        return view('livewire.mahasiswa.transaksi')
            ->layout('layouts.app');
    }
}