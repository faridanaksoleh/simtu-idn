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
            $this->dispatch('showSuccess', ['message' => 'Notifikasi ditandai sudah dibaca']);
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

        $this->dispatch('showSuccess', ['message' => 'Semua notifikasi ditandai sudah dibaca']);
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