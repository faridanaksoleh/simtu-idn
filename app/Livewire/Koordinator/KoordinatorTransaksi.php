<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;

class KoordinatorTransaksi extends Component
{
    public $activeTab = 'persetujuan';

    protected $queryString = [
        'activeTab' => ['except' => 'persetujuan']
    ];

    public function mount()
    {
        // Auto switch berdasarkan URL parameter
        if (request()->has('tab')) {
            $this->activeTab = request('tab');
        }
        
        // Juga cek jika ada parameter pagination/search di riwayat
        if (request()->has('page') || request()->has('search') || request()->has('status') || request()->has('userFilter')) {
            $this->activeTab = 'riwayat';
        }
    }

    public function render()
    {
        return view('livewire.koordinator.koordinator-transaksi')
            ->layout('layouts.app');
    }
}