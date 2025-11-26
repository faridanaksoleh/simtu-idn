<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PersetujuanTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    public $kelasBimbingan;

    // 🔥 TAMBAHKAN: Method untuk pagination
    public function paginationView()
    {
        return 'livewire::bootstrap';
    }

    public function updatingPage($page)
    {
        // Reset state jika perlu
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->kelasBimbingan = Auth::user()->class;
        
        if (!$this->kelasBimbingan) {
            $this->kelasBimbingan = 'TRPL-A';
            Auth::user()->update(['class' => $this->kelasBimbingan]);
        }
    }

    public function approve($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        
        if ($transaction->user->class !== $this->kelasBimbingan) {
            $this->dispatch('showError', [
                'message' => 'Anda tidak memiliki akses untuk menyetujui transaksi ini!'
            ]);
            return;
        }

        $transaction->update([
            'status' => 'approved',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        $this->dispatch('showSuccess', [
            'message' => 'Transaksi berhasil disetujui!'
        ]);
    }

    public function reject($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        
        if ($transaction->user->class !== $this->kelasBimbingan) {
            $this->dispatch('showError', [
                'message' => 'Anda tidak memiliki akses untuk menolak transaksi ini!'
            ]);
            return;
        }

        $transaction->update([
            'status' => 'rejected', 
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        $this->dispatch('showSuccess', [
            'message' => 'Transaksi berhasil ditolak!'
        ]);
    }

    public function render()
    {
        $user = Auth::user();
        
        $query = Transaction::with(['user', 'category'])
            ->where('status', 'pending')
            ->whereHas('user', function($q) use ($user) {
                $q->where('class', $user->class)
                  ->where('role', 'mahasiswa');
            })
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function($userQuery) {
                    $userQuery->where('name', 'like', "%{$this->search}%")
                             ->orWhere('email', 'like', "%{$this->search}%");
                })
                ->orWhereHas('category', function($categoryQuery) {
                    $categoryQuery->where('name', 'like', "%{$this->search}%");
                })
                ->orWhere('description', 'like', "%{$this->search}%");
                
                $numericSearch = preg_replace('/[^0-9]/', '', $this->search);
                if (!empty($numericSearch)) {
                    $q->orWhereRaw('ABS(amount) LIKE ?', ["%{$numericSearch}%"]);
                }
            });
        }

        $transactions = $query->paginate(10);
        
        $pendingCount = Transaction::where('status', 'pending')
            ->whereHas('user', function($q) use ($user) {
                $q->where('class', $user->class)
                  ->where('role', 'mahasiswa');
            })
            ->count();

        return view('livewire.koordinator.persetujuan-transaksi', compact('transactions', 'pendingCount'));
    }
}