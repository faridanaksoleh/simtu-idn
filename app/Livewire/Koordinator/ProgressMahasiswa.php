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
    
    public $userClass;
    public $students = [];

    public function mount()
    {
        $this->userClass = Auth::user()->class;
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $query = User::where('role', 'mahasiswa')
            ->where('class', $this->userClass);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $this->students = $query->get()->map(function($student) {
            $student->total_savings = $student->transactions()
                ->where('type', 'income')
                ->where('status', 'approved')
                ->sum('amount');

            $student->total_transactions = $student->transactions()
                ->where('status', 'approved')
                ->count();

            $student->monthly_transactions = $student->transactions()
                ->where('status', 'approved')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->count();

            $student->monthly_savings = $student->transactions()
                ->where('type', 'income')
                ->where('status', 'approved')
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('amount');

            $target = 1000000;
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

    public function render()
    {
        return view('livewire.koordinator.progress-mahasiswa')
            ->layout('layouts.app');
    }
}