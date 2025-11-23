<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Services\NotificationService;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        // Notifikasi ke koordinator ketika ada transaksi baru
        NotificationService::notifyNewTransaction($transaction);
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        // Cek jika status berubah
        if ($transaction->isDirty('status')) {
            $oldStatus = $transaction->getOriginal('status');
            $newStatus = $transaction->status;

            // Notifikasi ke mahasiswa ketika transaksi approved
            if ($newStatus === 'approved' && $oldStatus !== 'approved') {
                NotificationService::notifyTransactionApproved($transaction);
            }

            // Notifikasi ke mahasiswa ketika transaksi rejected
            if ($newStatus === 'rejected' && $oldStatus !== 'rejected') {
                NotificationService::notifyTransactionRejected($transaction);
            }
        }
    }
}