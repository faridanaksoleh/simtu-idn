<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;
use App\Models\SavingsGoal;

class DashboardAdmin extends Component
{
    public $totalMahasiswa;
    public $totalTabungan;
    public $totalTransaksi;
    public $targetTercapai;
    public $aktivitasTerbaru;

    public function mount()
    {
        // Hitung jumlah mahasiswa
        $this->totalMahasiswa = User::where('role', 'mahasiswa')->count();

        // Total nominal tabungan (hanya transaksi 'income' dan disetujui)
        $this->totalTabungan = Transaction::where('type', 'income')
            ->where('status', 'approved')
            ->sum('amount');

        // Total transaksi
        $this->totalTransaksi = Transaction::count();

        // Target tabungan (optional)
        $totalTarget = SavingsGoal::sum('target_amount');
        $this->targetTercapai = $totalTarget > 0
            ? round(($this->totalTabungan / $totalTarget) * 100, 2)
            : 0;

        // Ambil 5 aktivitas terbaru
        $this->aktivitasTerbaru = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-admin')
            ->layout('layouts.app');
    }
}

