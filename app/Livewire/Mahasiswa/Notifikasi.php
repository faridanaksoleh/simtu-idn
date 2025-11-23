<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Notifikasi extends Component
{
    use WithPagination;

    public function markAsRead($notificationId)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            // Tidak ada dispatch
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        // Tidak ada dispatch
    }

    public function render()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.mahasiswa.notifikasi', [
            'notifications' => $notifications
        ])->layout('layouts.app');
    }
}