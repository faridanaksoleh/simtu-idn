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

    public function mount()
    {
        // Ambil kelas yang dikelola koordinator
        $this->kelasBimbingan = Auth::user()->class;
        
        // Fallback jika koordinator belum punya kelas
        if (!$this->kelasBimbingan) {
            $this->kelasBimbingan = 'TRPL-A'; // Default fallback
            Auth::user()->update(['class' => $this->kelasBimbingan]);
        }
    }

    public function approve($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        
        // Validasi: pastikan transaksi ini dari mahasiswa di kelas bimbingan
        if ($transaction->user->class !== $this->kelasBimbingan) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menyetujui transaksi ini!');
            return;
        }

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
        
        // Validasi: pastikan transaksi ini dari mahasiswa di kelas bimbingan
        if ($transaction->user->class !== $this->kelasBimbingan) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menolak transaksi ini!');
            return;
        }

        $transaction->update([
            'status' => 'rejected', 
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        session()->flash('success', 'Transaksi berhasil ditolak!');
    }

    public function render()
    {
        $user = Auth::user();
        
        // Query hanya transaksi dari mahasiswa di kelas bimbingan koordinator
        $query = Transaction::with(['user', 'category'])
            ->where('status', 'pending')
            ->whereHas('user', function($q) use ($user) {
                $q->where('class', $user->class)
                  ->where('role', 'mahasiswa');
            })
            ->latest();

        // Search functionality
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
                
                // Search by amount (numeric only)
                $numericSearch = preg_replace('/[^0-9]/', '', $this->search);
                if (!empty($numericSearch)) {
                    $q->orWhereRaw('ABS(amount) LIKE ?', ["%{$numericSearch}%"]);
                }
            });
        }

        $transactions = $query->paginate(10);
        
        // Count hanya transaksi dari kelas bimbingan
        $pendingCount = Transaction::where('status', 'pending')
            ->whereHas('user', function($q) use ($user) {
                $q->where('class', $user->class)
                  ->where('role', 'mahasiswa');
            })
            ->count();

        return view('livewire.koordinator.persetujuan-transaksi', compact('transactions', 'pendingCount'));
    }
}