<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
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
            $this->loadNotifications();
            
            // 🔥 FIX: Redirect admin ke dashboard, lainnya ke notifikasi
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route($role . '.notifikasi');
        }
    }

    // 🔥 TAMBAHKAN method untuk "Lihat semua notifikasi"
    public function goToNotificationsPage()
    {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route($role . '.notifikasi');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.shared.notification-bell');
    }
}