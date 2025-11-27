<?php

namespace App\Livewire\Koordinator;

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
    }

    // 🔥 PERBAIKAN: Tambahkan method untuk pagination
    public function paginationView()
    {
        return 'livewire::bootstrap';
    }

    // 🔥 PERBAIKAN: Reset page ketika melakukan aksi
    public function updatingPage($page)
    {
        // Reset state jika perlu
    }

    public function render()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.koordinator.notifikasi', [
            'notifications' => $notifications
        ])->layout('layouts.app');
    }
}