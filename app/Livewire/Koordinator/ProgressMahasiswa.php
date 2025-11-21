<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProgressMahasiswa extends Component
{
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    public $userClass; // Kelas koordinator
    public $students = [];

    public function mount()
    {
        // Ambil kelas dari user yang login (koordinator)
        $this->userClass = Auth::user()->class;
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $query = User::where('role', 'mahasiswa')
            ->where('class', $this->userClass); // HANYA mahasiswa di kelas koordinator

        // Filter berdasarkan pencarian nama/email
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $this->students = $query->get()->map(function($student) {
            // Hitung total tabungan (income yang approved)
            $student->total_savings = $student->transactions()
                ->where('type', 'income')
                ->where('status', 'approved')
                ->sum('amount');

            // Hitung total transaksi
            $student->total_transactions = $student->transactions()
                ->where('status', 'approved')
                ->count();

            // Hitung transaksi bulan ini
            $student->monthly_transactions = $student->transactions()
                ->where('status', 'approved')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->count();

            // Tabungan bulan ini
            $student->monthly_savings = $student->transactions()
                ->where('type', 'income')
                ->where('status', 'approved')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('amount');

            // Progress persentase (contoh: target 1 juta)
            $target = 1000000; // Target tabungan
            $student->progress_percentage = $target > 0 ? min(100, ($student->total_savings / $target) * 100) : 0;

            return $student;
        });
    }

    public function updatedSearch()
    {
        $this->loadStudents();
    }

    public function sortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }

        $this->loadStudents();
    }

    // METHOD showDetail() DIHAPUS

    public function render()
    {
        return view('livewire.koordinator.progress-mahasiswa')
            ->layout('layouts.app');
    }
}