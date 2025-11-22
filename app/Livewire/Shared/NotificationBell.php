<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    protected $listeners = ['refreshNotifications' => 'refresh'];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->unreadCount = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        $this->notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $this->refresh();
            
            // Hanya refresh, tidak redirect (biar user tetap di halaman saat ini)
            $this->dispatch('showInfo', ['message' => 'Notifikasi ditandai sudah dibaca']);
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

        $this->refresh();
        $this->dispatch('showSuccess', ['message' => 'Semua notifikasi ditandai sudah dibaca']);
    }

    public function goToNotificationsPage()
    {
        // Redirect ke halaman notifikasi
        return redirect()->route(Auth::user()->role . '.notifikasi');
    }

    public function render()
    {
        return view('livewire.shared.notification-bell');
    }
}