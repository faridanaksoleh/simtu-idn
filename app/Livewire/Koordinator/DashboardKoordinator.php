<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardKoordinator extends Component
{
    public $totalMahasiswa;
    public $totalSaldo;
    public $transaksiBulanIni;
    public $mahasiswaTerbaru;
    
    // Data untuk chart per kelas
    public $chartData = [];
    public $chartCategories = [];
    public $kelasBimbingan;

    public function mount()
    {
        $user = Auth::user();
        
        // Ambil kelas yang dikelola koordinator (asumsi ada field 'class' di user)
        $this->kelasBimbingan = $user->class ?? 'TRPL-A'; // Fallback jika tidak ada
        
        // Hitung jumlah mahasiswa di kelas bimbingan
        $this->totalMahasiswa = User::where('role', 'mahasiswa')
            ->where('class', $this->kelasBimbingan)
            ->count();

        // Total saldo tabungan mahasiswa di kelas bimbingan
        $this->totalSaldo = Transaction::where('type', 'income')
            ->where('status', 'approved')
            ->whereHas('user', function($query) {
                $query->where('class', $this->kelasBimbingan)
                      ->where('role', 'mahasiswa');
            })
            ->sum('amount');

        // Transaksi bulan ini di kelas bimbingan
        $this->transaksiBulanIni = Transaction::whereHas('user', function($query) {
                $query->where('class', $this->kelasBimbingan)
                      ->where('role', 'mahasiswa');
            })
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Mahasiswa terbaru di kelas bimbingan
        $this->mahasiswaTerbaru = User::where('role', 'mahasiswa')
            ->where('class', $this->kelasBimbingan)
            ->withSum(['transactions as total_saldo' => function($query) {
                $query->where('type', 'income')
                      ->where('status', 'approved');
            }], 'amount')
            ->latest()
            ->take(5)
            ->get();
            
        // Ambil data untuk chart - perbandingan kelas
        $this->getChartData();
    }
    
    private function getChartData()
    {
        $user = Auth::user();
        $kelasKoordinator = $user->class ?? 'TRPL-A';
        
        // Query untuk mendapatkan total tabungan per bulan untuk kelas bimbingan
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        
        $monthlyData = Transaction::where('type', 'income')
            ->where('status', 'approved')
            ->whereHas('user', function($query) use ($kelasKoordinator) {
                $query->where('class', $kelasKoordinator)
                      ->where('role', 'mahasiswa');
            })
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

        // Jika semua data 0, buat sample data
        if (array_sum($chartData) === 0) {
            $chartData = [1200000, 1500000, 1300000, 1800000, 1600000, 2000000];
            $categories = ['Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov'];
        }

        $this->chartData = $chartData;
        $this->chartCategories = $categories;
    }

    public function render()
    {
        return view('livewire.koordinator.dashboard-koordinator')
            ->layout('layouts.app');
    }
}