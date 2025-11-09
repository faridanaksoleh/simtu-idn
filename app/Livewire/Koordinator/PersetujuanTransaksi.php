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

    public function approve($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->update([
            'status' => 'approved',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        session()->flash('success', 'Transaksi berhasil disetujui!');
    }

    public function reject($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->update([
            'status' => 'rejected', 
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        session()->flash('success', 'Transaksi berhasil ditolak!');
    }

    public function render()
    {
        $query = Transaction::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('category', function($categoryQuery) {
                    $categoryQuery->where('name', 'like', "%{$this->search}%");
                });
                
                $numericSearch = preg_replace('/[^0-9]/', '', $this->search);
                if (!empty($numericSearch)) {
                    $q->orWhereRaw('ABS(amount) LIKE ?', ["%{$numericSearch}%"]);
                }
            });
        }

        $transactions = $query->paginate(10);
        $pendingCount = Transaction::where('status', 'pending')->count();

        return view('livewire.koordinator.persetujuan-transaksi', compact('transactions', 'pendingCount'));
    }
}