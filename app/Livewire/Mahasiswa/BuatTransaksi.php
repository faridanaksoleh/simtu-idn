<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class BuatTransaksi extends Component
{
    use WithFileUploads;

    public $amount, $category_id, $description, $bukti;
    public $transaction_type = 'income';

    protected $rules = [
        'amount' => 'required|numeric|min:1000',
        'category_id' => 'required|exists:categories,id',
        'transaction_type' => 'required|in:income,expense',
        'bukti' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        try {
            $path = $this->bukti ? $this->bukti->store('bukti-transaksi', 'public') : null;

            $finalAmount = $this->transaction_type === 'expense' 
                ? -$this->amount 
                : $this->amount;

            Transaction::create([
                'user_id' => Auth::id(),
                'category_id' => $this->category_id,
                'type' => $this->transaction_type,
                'amount' => $finalAmount,
                'description' => $this->description,
                'date' => now(),
                'payment_method' => 'transfer',
                'payment_proof' => $path,
                'status' => 'pending',
            ]);

            $this->reset();
            
            // 🔥 GUNAKAN SWEETALERT2 DARI LIVEWIRE DISPATCH
            $this->dispatch('showSuccess', [
                'message' => $this->transaction_type === 'income' 
                    ? 'Setoran berhasil disimpan! Menunggu persetujuan koordinator.' 
                    : 'Pengajuan penarikan berhasil! Menunggu persetujuan koordinator.'
            ]);
            
            $this->dispatch('transactionCreated');
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $categories = \App\Models\Category::where('type', $this->transaction_type)
            ->where('is_active', true)
            ->get();

        return view('livewire.mahasiswa.buat-transaksi', compact('categories'));
    }
}