<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PersetujuanTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    
    // 🔥 PERBAIKAN: Gunakan pola yang sama seperti KelolaUser & KelolaKategori
    public $approveTransactionId = null;
    public $rejectTransactionId = null;

    // 🔥 PERBAIKAN: Listener untuk delete confirmation (seperti komponen lain)
    protected $listeners = [
        'approveConfirmed' => 'performApprove',
        'rejectConfirmed' => 'performReject'
    ];

    public function paginationView()
    {
        return 'livewire::bootstrap';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // 🔥 PERBAIKAN: Method untuk konfirmasi approve - SIMPAN ID SAJA
    public function confirmApprove($transactionId)
    {
        $this->approveTransactionId = $transactionId;
        $transaction = Transaction::find($transactionId);
        
        $this->dispatch('showApproveConfirmation', [
            'transactionId' => $transactionId,
            'userName' => $transaction->user->name ?? 'User',
            'amount' => $transaction->amount ?? 0
        ]);
    }

    // 🔥 PERBAIKAN: Method untuk konfirmasi reject - SIMPAN ID SAJA
    public function confirmReject($transactionId)
    {
        $this->rejectTransactionId = $transactionId;
        $transaction = Transaction::find($transactionId);
        
        $this->dispatch('showRejectConfirmation', [
            'transactionId' => $transactionId,
            'userName' => $transaction->user->name ?? 'User',
            'amount' => $transaction->amount ?? 0
        ]);
    }

    // 🔥 PERBAIKAN: Method yang dipanggil setelah konfirmasi approve - TANPA PARAMETER
    public function performApprove()
    {
        if ($this->approveTransactionId) {
            $transaction = Transaction::findOrFail($this->approveTransactionId);
            $transaction->update([
                'status' => 'approved',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            $this->dispatch('showSuccess', [
                'message' => 'Transaksi berhasil disetujui!'
            ]);
            
            $this->approveTransactionId = null;
        }
    }

    // 🔥 PERBAIKAN: Method yang dipanggil setelah konfirmasi reject - TANPA PARAMETER
    public function performReject()
    {
        if ($this->rejectTransactionId) {
            $transaction = Transaction::findOrFail($this->rejectTransactionId);
            $transaction->update([
                'status' => 'rejected', 
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            $this->dispatch('showSuccess', [
                'message' => 'Transaksi berhasil ditolak!'
            ]);
            
            $this->rejectTransactionId = null;
        }
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

        return view('livewire.admin.persetujuan-transaksi', compact('transactions', 'pendingCount'));
    }
}