<li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="badge bg-primary badge-number">{{ $unreadCount }}</span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
            @if($unreadCount > 0)
                Anda memiliki {{ $unreadCount }} notifikasi baru
                <a href="#" wire:click.prevent="markAllAsRead" class="text-decoration-none ms-2">
                    <span class="badge bg-primary p-1">Tandai semua dibaca</span>
                </a>
            @else
                Tidak ada notifikasi baru
            @endif
        </li>
        
        <li><hr class="dropdown-divider"></li>

        @forelse($notifications as $notification)
            <li class="notification-item @if(!$notification->is_read) bg-light @endif" 
                style="cursor: pointer;"
                wire:click="markAsRead({{ $notification->id }})">
                
                @php
                    $icons = [
                        'success' => 'check-circle',
                        'warning' => 'exclamation-circle',
                        'danger' => 'x-circle', 
                        'info' => 'info-circle'
                    ];
                    $icon = $icons[$notification->type] ?? 'info-circle';
                @endphp
                
                <i class="bi bi-{{ $icon }} text-{{ $notification->type }}"></i>
                <div>
                    <h4>{{ $notification->title }}</h4>
                    <p>{{ $notification->message }}</p>
                    <p>{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </li>
            <li><hr class="dropdown-divider"></li>
        @empty
            <li class="text-center py-3 text-muted">
                <i class="bi bi-bell-slash h4"></i>
                <p class="mt-2 mb-0">Tidak ada notifikasi</p>
            </li>
        @endforelse

        <li class="dropdown-footer text-center">
            <a href="{{ route(auth()->user()->role . '.notifikasi') }}" 
               class="text-decoration-none fw-bold">
                Lihat semua notifikasi
            </a>
        </li>
    </ul>
</li>