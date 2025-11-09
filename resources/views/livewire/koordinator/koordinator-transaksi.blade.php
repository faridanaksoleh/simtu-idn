<div>
    <h4 class="mb-3 fw-bold">Transaksi</h4>

    <ul class="nav nav-tabs mb-3" id="transaksiTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'persetujuan' ? 'active' : '' }}" 
                    wire:click="$set('activeTab', 'persetujuan')"
                    type="button">
                <i class="bi bi-check-circle"></i> Persetujuan
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'riwayat' ? 'active' : '' }}" 
                    wire:click="$set('activeTab', 'riwayat')"
                    type="button">
                <i class="bi bi-list-ul"></i> Riwayat
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade {{ $activeTab === 'persetujuan' ? 'show active' : '' }}" role="tabpanel">
            @livewire('koordinator.persetujuan-transaksi')
        </div>
        <div class="tab-pane fade {{ $activeTab === 'riwayat' ? 'show active' : '' }}" role="tabpanel">
            @livewire('koordinator.riwayat-transaksi')
        </div>
    </div>
</div>

<script>
// Maintain tab state ketika ada URL parameters
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Jika ada parameter page, search, status, userFilter → tetap di tab riwayat
    const hasRiwayatParams = urlParams.get('page') || urlParams.get('search') || 
                            urlParams.get('status') || urlParams.get('userFilter');
    
    if (hasRiwayatParams) {
        const riwayatTab = new bootstrap.Tab(document.getElementById('riwayat-tab'));
        riwayatTab.show();
    }
    
    // Jika ada parameter tab di URL
    if (urlParams.get('tab') === 'riwayat') {
        const riwayatTab = new bootstrap.Tab(document.getElementById('riwayat-tab'));
        riwayatTab.show();
    }
});

// Update URL ketika ganti tab (optional)
document.addEventListener('livewire:load', function() {
    Livewire.on('tab-changed', (tab) => {
        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url);
    });
});
</script>