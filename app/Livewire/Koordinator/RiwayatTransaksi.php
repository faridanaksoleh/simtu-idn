<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class RiwayatTransaksi extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $userFilter = '';

    public function render()
    {
        $query = Transaction::with(['user', 'category'])
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

        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }

        $transactions = $query->paginate(10);
        $users = \App\Models\User::where('role', 'mahasiswa')->get();

        return view('livewire.koordinator.riwayat-transaksi', compact('transactions', 'users'));
    }
}