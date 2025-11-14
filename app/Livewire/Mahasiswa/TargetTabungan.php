<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use App\Models\SavingsGoal;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TargetTabungan extends Component
{
    public $goalName;
    public $targetAmount;
    public $deadline;
    public $editMode = false;
    public $editingGoal = null;

    protected $rules = [
        'goalName' => 'required|string|max:100',
        'targetAmount' => 'required|numeric|min:100000',
        'deadline' => 'required|date|after:today'
    ];

    public function mount()
    {
        // Auto-calculate current progress dari transaksi approved
        $this->calculateProgress();
    }

    public function saveGoal()
    {
        $this->validate();

        if ($this->editMode && $this->editingGoal) {
            // Update existing goal
            $this->editingGoal->update([
                'goal_name' => $this->goalName,
                'target_amount' => $this->targetAmount,
                'deadline' => $this->deadline,
            ]);
            
            session()->flash('success', 'Target tabungan berhasil diupdate!');
        } else {
            // Create new goal
            SavingsGoal::create([
                'user_id' => Auth::id(),
                'goal_name' => $this->goalName,
                'target_amount' => $this->targetAmount,
                'current_amount' => 0, // Akan dihitung otomatis
                'deadline' => $this->deadline,
                'status' => 'active'
            ]);
            
            session()->flash('success', 'Target tabungan berhasil dibuat!');
        }

        $this->resetForm();
        $this->calculateProgress();
    }

    public function editGoal($goalId)
    {
        $goal = SavingsGoal::findOrFail($goalId);
        $this->editingGoal = $goal;
        $this->editMode = true;
        $this->goalName = $goal->goal_name;
        $this->targetAmount = $goal->target_amount;
        $this->deadline = $goal->deadline;
    }

    public function deleteGoal($goalId)
    {
        $goal = SavingsGoal::findOrFail($goalId);
        $goal->delete();
        
        session()->flash('success', 'Target tabungan berhasil dihapus!');
        $this->calculateProgress();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['goalName', 'targetAmount', 'deadline', 'editMode', 'editingGoal']);
    }

    private function calculateProgress()
    {
        // Hitung total tabungan dari transaksi approved
        $totalTabungan = Transaction::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('type', 'income')
            ->sum('amount');

        // Update current_amount di semua goals aktif
        SavingsGoal::where('user_id', Auth::id())
            ->where('status', 'active')
            ->update(['current_amount' => $totalTabungan]);

        // Auto update status goal
        $goals = SavingsGoal::where('user_id', Auth::id())->get();
        foreach ($goals as $goal) {
            $progress = ($goal->current_amount / $goal->target_amount) * 100;
            
            if ($progress >= 100) {
                $goal->update(['status' => 'completed']);
            } elseif ($goal->deadline && now()->gt($goal->deadline)) {
                $goal->update(['status' => 'paused']);
            }
        }
    }

    public function updateStatus($goalId, $status)
    {
        $goal = SavingsGoal::findOrFail($goalId);
        $goal->update(['status' => $status]);
        
        $this->calculateProgress();
    }

    // Tambah method ini di TargetTabungan.php
    public function getChartData()
    {
        // Ambil data transaksi approved per bulan
        $monthlyData = Transaction::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('type', 'income')
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartData = [];
        $categories = [];
        
        foreach ($monthlyData as $data) {
            $chartData[] = (float) $data->total;
            $categories[] = \Carbon\Carbon::create()->month($data->month)->format('M');
        }

        // Jika tidak ada data, beri sample data
        if (empty($chartData)) {
            $chartData = [0, 0, 0, 0, 0, 0];
            $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
        }

        return [
            'series' => $chartData,
            'categories' => $categories
        ];
    }

    public function render()
    {
        $goals = SavingsGoal::where('user_id', Auth::id())
            ->latest()
            ->get();

        $goals->each(function ($goal) {
            $goal->progress_percent = $goal->target_amount > 0 
                ? min(100, ($goal->current_amount / $goal->target_amount) * 100)
                : 0;
            $goal->remaining = max(0, $goal->target_amount - $goal->current_amount);
            $goal->remaining_days = $goal->deadline 
                ? max(0, now()->diffInDays($goal->deadline, false))
                : null;
        });

        $totalTabungan = Transaction::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('type', 'income')
            ->sum('amount');

        $chartData = $this->getChartData();

        return view('livewire.mahasiswa.target-tabungan', compact('goals', 'totalTabungan', 'chartData'))
            ->layout('layouts.app');
    }
}