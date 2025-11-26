<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $listeners = ['transactionCreated' => '$refresh'];

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

    public function updatingStatus()
    {
        $this->resetPage();
    }

    // 🔥 PERBAIKAN: Tambah method resetFilters
    public function resetFilters()
    {
        $this->reset(['search', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Transaction::where('user_id', Auth::id())
            ->with('category')
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

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $transactions = $query->paginate(10);

        return view('livewire.mahasiswa.riwayat-transaksi', compact('transactions'));
    }
}