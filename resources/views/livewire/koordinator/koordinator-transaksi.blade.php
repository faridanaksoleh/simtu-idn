<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-wallet me-2"></i>Kelola Transaksi - Kelas {{ Auth::user()->class }}
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Tabs Navigation -->
            <div class="p-4 border-bottom">
                <ul class="nav nav-tabs" id="transaksiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold {{ $activeTab === 'persetujuan' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'persetujuan')"
                                type="button">
                            <i class="bi bi-check-circle me-2"></i>Persetujuan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold {{ $activeTab === 'riwayat' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'riwayat')"
                                type="button">
                            <i class="bi bi-clock-history me-2"></i>Riwayat
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="transaksiTabsContent">
                <div class="tab-pane fade {{ $activeTab === 'persetujuan' ? 'show active' : '' }}" role="tabpanel">
                    @livewire('koordinator.persetujuan-transaksi')
                </div>
                <div class="tab-pane fade {{ $activeTab === 'riwayat' ? 'show active' : '' }}" role="tabpanel">
                    @livewire('koordinator.riwayat-transaksi')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    const hasRiwayatParams = urlParams.get('page') || urlParams.get('search') || 
                            urlParams.get('status') || urlParams.get('userFilter');
    
    if (hasRiwayatParams) {
        const riwayatTab = new bootstrap.Tab(document.getElementById('riwayat-tab'));
        riwayatTab.show();
    }
    
    if (urlParams.get('tab') === 'riwayat') {
        const riwayatTab = new bootstrap.Tab(document.getElementById('riwayat-tab'));
        riwayatTab.show();
    }
});
</script>