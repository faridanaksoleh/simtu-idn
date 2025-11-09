<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class AdminTransaksi extends Component
{
    public $activeTab = 'semua'; // 'semua' atau 'persetujuan'

    protected $queryString = ['activeTab'];

    public function mount()
    {
        // Auto switch ke tab persetujuan jika ada transaksi pending
        if (request()->has('tab') && request('tab') === 'persetujuan') {
            $this->activeTab = 'persetujuan';
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-transaksi')
            ->layout('layouts.app');
    }
}