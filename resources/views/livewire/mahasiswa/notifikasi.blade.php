<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Notifikasi</h5>
            @if($notifications->where('is_read', false)->count() > 0)
                <button wire:click="markAllAsRead" class="btn btn-sm btn-primary">
                    Tandai Semua Dibaca
                </button>
            @endif
        </div>
        <div class="card-body">
            @forelse($notifications as $notification)
                <div class="border-bottom pb-3 mb-3 @if(!$notification->is_read) bg-light rounded p-3 @endif"
                     wire:click="markAsRead({{ $notification->id }})"
                     style="cursor: pointer;">
                    
                    <div class="d-flex align-items-start">
                        @php
                            $icons = [
                                'success' => 'check-circle',
                                'warning' => 'exclamation-circle', 
                                'danger' => 'x-circle',
                                'info' => 'info-circle'
                            ];
                            $icon = $icons[$notification->type] ?? 'info-circle';
                            $color = $notification->type ?? 'info';
                        @endphp
                        
                        <i class="bi bi-{{ $icon }} text-{{ $color }} me-3 mt-1"></i>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $notification->title }}</h6>
                            <p class="mb-1 text-muted">{{ $notification->message }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        @if(!$notification->is_read)
                            <span class="badge bg-primary ms-2">Baru</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-bell-slash display-4 text-muted"></i>
                    <p class="mt-3 text-muted">Tidak ada notifikasi</p>
                </div>
            @endforelse

            <!-- 🔥 FIX: Pagination yang benar -->
            @if($notifications->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $notifications->firstItem() ?? 0 }} - {{ $notifications->lastItem() ?? 0 }} 
                    dari {{ $notifications->total() }} notifikasi
                </div>
                <div>
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @else
            <div class="text-center text-muted small mt-3">
                Total {{ $notifications->total() }} notifikasi
            </div>
            @endif
        </div>
    </div>
</div>