<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\ConsultationNote;

class NotificationService
{
    public static function create($userId, $title, $message, $type = 'info', $relatedConsultationId = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_consultation_id' => $relatedConsultationId
        ]);
    }

    // Notifikasi ketika mahasiswa buat konsultasi baru (untuk koordinator)
    public static function notifyNewConsultation($consultation)
    {
        try {
            // Pastikan consultation ada dan punya student
            if (!$consultation || !$consultation->student) {
                \Log::error('Consultation or student not found', ['consultation_id' => $consultation->id ?? 'null']);
                return;
            }

            // Cari koordinator berdasarkan kelas mahasiswa
            $coordinator = User::where('role', 'koordinator')
                ->where('class', $consultation->student->class)
                ->first();

            if ($coordinator) {
                self::create(
                    $coordinator->id,
                    'Konsultasi Baru',
                    "Mahasiswa {$consultation->student->name} mengajukan konsultasi: \"{$consultation->subject}\"",
                    'info',
                    $consultation->id
                );
                
                \Log::info('Notification sent to coordinator', [
                    'coordinator_id' => $coordinator->id,
                    'consultation_id' => $consultation->id
                ]);
            } else {
                \Log::warning('No coordinator found for class', ['class' => $consultation->student->class]);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending notification to coordinator: ' . $e->getMessage());
        }
    }

    // Notifikasi ketika koordinator membalas konsultasi (untuk mahasiswa)
    public static function notifyConsultationReply($consultation)
    {
        try {
            self::create(
                $consultation->student_id,
                'Konsultasi Dibalas',
                "Koordinator telah membalas konsultasi Anda: \"{$consultation->subject}\"",
                'success',
                $consultation->id
            );
            
            \Log::info('Notification sent to student', [
                'student_id' => $consultation->student_id,
                'consultation_id' => $consultation->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Error sending notification to student: ' . $e->getMessage());
        }
    }

    // Notifikasi ketika transaksi approved
    public static function notifyTransactionApproved($transaction)
    {
        self::create(
            $transaction->user_id,
            'Transaksi Disetujui',
            "Transaksi Rp " . number_format($transaction->amount, 0, ',', '.') . " telah disetujui koordinator",
            'success',
            null
        );
    }

    // Notifikasi ketika transaksi rejected  
    public static function notifyTransactionRejected($transaction)
    {
        self::create(
            $transaction->user_id,
            'Transaksi Ditolak',
            "Transaksi Rp " . number_format($transaction->amount, 0, ',', '.') . " ditolak koordinator. Alasan: {$transaction->rejection_reason}",
            'danger',
            null
        );
    }
}