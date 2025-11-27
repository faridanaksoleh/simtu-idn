<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-bell me-2"></i>Notifikasi
            </h5>
            @if($notifications->where('is_read', false)->count() > 0)
                <button wire:click="markAllAsRead" class="btn btn-light btn-sm d-flex align-items-center px-3">
                    <i class="bi bi-check-all me-1"></i>Tandai Semua Dibaca
                </button>
            @endif
        </div>

        <div class="card-body p-0">
            <!-- Daftar Notifikasi -->
            <div class="p-4">
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
                            
                            <i class="bi bi-{{ $icon }} text-{{ $color }} me-3 mt-1 fs-5"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-semibold text-dark">{{ $notification->title }}</h6>
                                    @if(!$notification->is_read)
                                        <span class="badge bg-primary ms-2">Baru</span>
                                    @endif
                                </div>
                                <p class="mb-2 text-muted">{{ $notification->message }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash display-4 text-muted opacity-50 d-block mb-3"></i>
                        <h5 class="text-muted mb-2">Tidak Ada Notifikasi</h5>
                        <p class="text-muted">Semua notifikasi akan muncul di sini</p>
                    </div>
                @endforelse

                <!-- Pagination - KONSISTEN DENGAN KOMPONEN LAIN -->
                @if($notifications->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="text-muted small">
                        Menampilkan {{ $notifications->firstItem() ?? 0 }} - {{ $notifications->lastItem() ?? 0 }} 
                        dari {{ $notifications->total() }} notifikasi
                    </div>
                    <div>
                        {{ $notifications->links() }}
                    </div>
                </div>
                @elseif($notifications->total() > 0)
                <div class="text-center text-muted small mt-3 pt-3 border-top">
                    Total {{ $notifications->total() }} notifikasi
                </div>
                @endif
            </div>
        </div>
    </div>
</div>