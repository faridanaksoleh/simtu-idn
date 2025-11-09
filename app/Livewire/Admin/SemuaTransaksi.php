<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class SemuaTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $userFilter = '';

    public function render()
    {
        $query = Transaction::with(['user', 'category'])
            ->latest();

        // Search: HANYA kategori dan amount
        if ($this->search) {
            $query->where(function($q) {
                // CARI KATEGORI
                $q->whereHas('category', function($categoryQuery) {
                    $categoryQuery->where('name', 'like', "%{$this->search}%");
                });
                
                // CARI JUMLAH (partial number match)
                $numericSearch = preg_replace('/[^0-9]/', '', $this->search);
                if (!empty($numericSearch)) {
                    $q->orWhereRaw('ABS(amount) LIKE ?', ["%{$numericSearch}%"]);
                }
            });
        }

        // Filter by status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Filter by user
        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        $transactions = $query->paginate(10);
        $users = \App\Models\User::where('role', 'mahasiswa')->get();

        return view('livewire.admin.semua-transaksi', compact('transactions', 'users'));
    }
}