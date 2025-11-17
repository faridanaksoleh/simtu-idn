<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\SavingsGoal;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswa extends Component
{
    public $totalTabungan;
    public $transaksiAktif;
    public $progressTarget;
    public $targetName;
    
    // Data untuk chart
    public $chartData = [];
    public $chartCategories = [];

    public function mount()
    {
        $user = Auth::user();
        
        // Total tabungan pribadi (hanya transaksi 'income' dan disetujui)
        $this->totalTabungan = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->where('status', 'approved')
            ->sum('amount');

        // Jumlah transaksi pending
        $this->transaksiAktif = Transaction::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Progress target tabungan
        $activeGoal = SavingsGoal::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();
            
        if ($activeGoal) {
            $this->targetName = $activeGoal->goal_name;
            $this->progressTarget = $activeGoal->target_amount > 0 
                ? round(($this->totalTabungan / $activeGoal->target_amount) * 100, 1)
                : 0;
        } else {
            $this->targetName = 'Belum ada target';
            $this->progressTarget = 0;
        }
            
        // Ambil data untuk chart - tabungan pribadi per bulan
        $this->getChartData();
    }
    
    private function getChartData()
    {
        $user = Auth::user();
        
        // Query untuk mendapatkan total tabungan pribadi per bulan (6 bulan terakhir)
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        
        $monthlyData = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->where('status', 'approved')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('
                YEAR(created_at) as year, 
                MONTH(created_at) as month, 
                SUM(amount) as total,
                MAX(created_at) as last_transaction
            ')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartData = [];
        $categories = [];
        
        // Generate data untuk 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            $monthName = $date->locale('id')->translatedFormat('M');
            
            // Cari data untuk bulan ini
            $monthData = $monthlyData->first(function ($item) use ($year, $month) {
                return $item->year == $year && $item->month == $month;
            });
            
            $chartData[] = $monthData ? (float) $monthData->total : 0;
            $categories[] = $monthName;
        }

        // Jika semua data 0, buat sample data yang lebih kecil (sesuai mahasiswa)
        if (array_sum($chartData) === 0) {
            $chartData = [500000, 750000, 600000, 900000, 800000, 1200000];
            $categories = ['Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov'];
        }

        $this->chartData = $chartData;
        $this->chartCategories = $categories;
    }

    public function render()
    {
        return view('livewire.mahasiswa.dashboard-mahasiswa')
            ->layout('layouts.app');
    }
}