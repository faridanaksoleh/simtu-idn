<div>
   <li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="badge bg-danger badge-number">{{ $unreadCount }}</span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
            <span>Anda memiliki {{ $unreadCount }} notifikasi baru</span>
            @if($unreadCount > 0)
                <a href="#" wire:click.prevent="markAllAsRead" class="text-decoration-none ms-2">
                    <span class="badge bg-primary p-1">Tandai semua dibaca</span>
                </a>
            @endif
        </li>
        
        <li><hr class="dropdown-divider"></li>

        @forelse($notifications as $notification)
            <li class="notification-item @if(!$notification->is_read) bg-light @endif" 
                wire:click="markAsRead({{ $notification->id }})"
                style="cursor: pointer;">
                
                @php
                    $icons = [
                        'success' => 'check-circle',
                        'warning' => 'exclamation-circle',
                        'danger' => 'x-circle',
                        'info' => 'info-circle'
                    ];
                    $colors = [
                        'success' => 'success',
                        'warning' => 'warning', 
                        'danger' => 'danger',
                        'info' => 'primary'
                    ];
                    $icon = $icons[$notification->type] ?? 'info-circle';
                    $color = $colors[$notification->type] ?? 'primary';
                @endphp
                
                <i class="bi bi-{{ $icon }} text-{{ $color }}"></i>
                <div>
                    <h6 class="mb-1">{{ $notification->title }}</h6>
                    <p class="mb-1 small">{{ Str::limit($notification->message, 50) }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
        @empty
            <li class="text-center py-3 text-muted">
                <i class="bi bi-bell-slash h4"></i>
                <p class="mt-2 mb-0 small">Tidak ada notifikasi</p>
            </li>
        @endforelse

            <li class="dropdown-footer text-center">
                <a href="{{ route(auth()->user()->role . '.notifikasi') }}" 
                class="text-decoration-none fw-bold"
                wire:click.prevent="goToNotificationsPage">
                    Lihat semua notifikasi
                </a>
            </li>
        </ul>
    </li>
</div>
