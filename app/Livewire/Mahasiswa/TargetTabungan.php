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
    public $deleteId = null; // Tambahkan property untuk menyimpan ID yang akan dihapus

    protected $rules = [
        'goalName' => 'required|string|max:100',
        'targetAmount' => 'required|numeric|min:100000',
        'deadline' => 'required|date|after:today'
    ];

    // Tambahkan listener untuk event delete confirmation
    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->calculateProgress();
    }

    public function saveGoal()
    {
        $this->validate();

        try {
            if ($this->editMode && $this->editingGoal) {
                $this->editingGoal->update([
                    'goal_name' => $this->goalName,
                    'target_amount' => $this->targetAmount,
                    'deadline' => $this->deadline,
                ]);
                
                $this->dispatch('showSuccess', [
                    'message' => 'Target tabungan berhasil diupdate!'
                ]);
            } else {
                SavingsGoal::create([
                    'user_id' => Auth::id(),
                    'goal_name' => $this->goalName,
                    'target_amount' => $this->targetAmount,
                    'current_amount' => 0,
                    'deadline' => $this->deadline,
                    'status' => 'active'
                ]);
                
                $this->dispatch('showSuccess', [
                    'message' => 'Target tabungan berhasil dibuat!'
                ]);
            }

            $this->resetForm();
            $this->calculateProgress();

        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal menyimpan target: ' . $e->getMessage()
            ]);
        }
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
        
        // Simpan ID yang akan dihapus
        $this->deleteId = $goalId;
        
        // Dispatch event untuk SweetAlert confirmation
        $this->dispatch('showDeleteConfirmation', [
            'title' => 'Hapus Target Tabungan?',
            'text' => "Target '" . $goal->goal_name . "' akan dihapus permanen!",
            'confirmText' => 'Ya, Hapus!',
            'cancelText' => 'Batal',
            'id' => $goalId
        ]);
    }

    // Method yang dipanggil ketika delete dikonfirmasi - TANPA PARAMETER
    public function deleteConfirmed()
    {
        if (!$this->deleteId) {
            $this->dispatch('showError', [
                'message' => 'ID target tidak valid!'
            ]);
            return;
        }
        
        try {
            $goal = SavingsGoal::findOrFail($this->deleteId);
            $goalName = $goal->goal_name;
            $goal->delete();
            
            $this->dispatch('showSuccess', [
                'message' => 'Target "'.$goalName.'" berhasil dihapus!'
            ]);
            
            $this->calculateProgress();
            
            // Reset deleteId setelah berhasil dihapus
            $this->deleteId = null;

        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal menghapus target: ' . $e->getMessage()
            ]);
            $this->deleteId = null;
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function updateStatus($goalId, $status)
    {
        try {
            $goal = SavingsGoal::findOrFail($goalId);
            $goal->update(['status' => $status]);
            
            $statusText = $status == 'active' ? 'diaktifkan' : ($status == 'completed' ? 'diselesaikan' : 'ditunda');
            
            $this->dispatch('showSuccess', [
                'message' => 'Target "'.$goal->goal_name.'" berhasil '.$statusText.'!'
            ]);
            
            $this->calculateProgress();

        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ]);
        }
    }

    private function resetForm()
    {
        $this->reset(['goalName', 'targetAmount', 'deadline', 'editMode', 'editingGoal']);
    }

    private function calculateProgress()
    {
        $totalTabungan = Transaction::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('type', 'income')
            ->sum('amount');

        SavingsGoal::where('user_id', Auth::id())
            ->where('status', 'active')
            ->update(['current_amount' => $totalTabungan]);

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

    public function getChartData()
    {
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