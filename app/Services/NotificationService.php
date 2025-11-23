<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Transaction;

class NotificationService
{
    public static function create($userId, $title, $message, $type = 'info', $relatedTransactionId = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_transaction_id' => $relatedTransactionId
        ]);
    }

    // Notifikasi ketika transaksi baru dibuat (untuk koordinator)
    public static function notifyNewTransaction($transaction)
    {
        $coordinator = User::where('role', 'koordinator')
            ->where('class', $transaction->user->class)
            ->first();

        if ($coordinator) {
            self::create(
                $coordinator->id,
                'Transaksi Baru Menunggu Approval',
                "Mahasiswa {$transaction->user->name} membuat transaksi {$transaction->type}: Rp " . number_format(abs($transaction->amount), 0, ',', '.'),
                'info',
                $transaction->id
            );
        }
    }

    // Notifikasi ketika transaksi approved (untuk mahasiswa)
    public static function notifyTransactionApproved($transaction)
    {
        self::create(
            $transaction->user_id,
            'Transaksi Disetujui',
            "Transaksi {$transaction->type} sebesar Rp " . number_format(abs($transaction->amount), 0, ',', '.') . " telah disetujui koordinator.",
            'success',
            $transaction->id
        );
    }

    // Notifikasi ketika transaksi rejected (untuk mahasiswa)
    public static function notifyTransactionRejected($transaction)
    {
        $reason = $transaction->rejection_reason ? " Alasan: {$transaction->rejection_reason}" : '';
        
        self::create(
            $transaction->user_id,
            'Transaksi Ditolak',
            "Transaksi {$transaction->type} sebesar Rp " . number_format(abs($transaction->amount), 0, ',', '.') . " ditolak koordinator.{$reason}",
            'danger',
            $transaction->id
        );
    }

    // Notifikasi ketika mahasiswa buat konsultasi baru (untuk koordinator)
    public static function notifyNewConsultation($consultation)
    {
        $coordinator = User::where('role', 'koordinator')
            ->where('class', $consultation->student->class)
            ->first();

        if ($coordinator) {
            self::create(
                $coordinator->id,
                'Konsultasi Baru',
                "Mahasiswa {$consultation->student->name} mengajukan konsultasi: \"{$consultation->subject}\"",
                'info',
                null, // no transaction
                $consultation->id // related_consultation_id
            );
        }
    }

    // Notifikasi ketika koordinator balas konsultasi (untuk mahasiswa)  
    public static function notifyConsultationReply($consultation)
    {
        self::create(
            $consultation->student_id,
            'Konsultasi Dibalas',
            "Koordinator telah membalas konsultasi Anda: \"{$consultation->subject}\"",
            'success',
            null, // no transaction
            $consultation->id // related_consultation_id
        );
    }

    // Broadcast notifikasi ke semua mahasiswa (admin)
    public static function broadcastToStudents($title, $message, $type = 'info')
    {
        $students = User::where('role', 'mahasiswa')->get();
        
        foreach ($students as $student) {
            self::create(
                $student->id,
                $title,
                $message,
                $type
            );
        }
    }

    // Broadcast notifikasi ke semua user (admin)
    public static function broadcastToAll($title, $message, $type = 'info')
    {
        $users = User::all();
        
        foreach ($users as $user) {
            self::create(
                $user->id,
                $title,
                $message,
                $type
            );
        }
    }
}