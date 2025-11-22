<div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Notifikasi Admin</h4>
                @if($notifications->where('is_read', false)->count() > 0)
                    <button wire:click="markAllAsRead" class="btn btn-primary btn-sm">
                        <i class="bi bi-check-all me-1"></i>Tandai Semua Dibaca
                    </button>
                @endif
            </div>

            <div class="list-group">
                @forelse($notifications as $notification)
                    <div class="list-group-item list-group-item-action @if(!$notification->is_read) list-group-item-light @endif"
                         wire:click="markAsRead({{ $notification->id }})"
                         style="cursor: pointer;">
                        
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                @php
                                    $icons = [
                                        'success' => 'check-circle-fill text-success',
                                        'warning' => 'exclamation-circle-fill text-warning',
                                        'danger' => 'x-circle-fill text-danger', 
                                        'info' => 'info-circle-fill text-info'
                                    ];
                                    $iconClass = $icons[$notification->type] ?? 'info-circle-fill text-info';
                                @endphp
                                
                                <i class="bi bi-{{ $iconClass }} me-2"></i>
                                {{ $notification->title }}
                            </h5>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        
                        <p class="mb-1">{{ $notification->message }}</p>
                        
                        @if(!$notification->is_read)
                            <span class="badge bg-primary float-end">Baru</span>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Tidak ada notifikasi</h5>
                        <p class="text-muted">Notifikasi akan muncul di sini ketika ada aktivitas baru</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>