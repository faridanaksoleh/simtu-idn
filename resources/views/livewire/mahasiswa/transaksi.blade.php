<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-wallet me-2"></i>Transaksi Tabungan
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Tabs Navigation -->
            <div class="p-4 border-bottom">
                <ul class="nav nav-tabs" id="transaksiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="buat-tab" data-bs-toggle="tab" data-bs-target="#buat" type="button" role="tab">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab">
                            <i class="bi bi-clock-history me-2"></i>Riwayat Transaksi
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="transaksiTabsContent">
                <div class="tab-pane fade show active" id="buat" role="tabpanel">
                    @livewire('mahasiswa.buat-transaksi')
                </div>
                <div class="tab-pane fade" id="riwayat" role="tabpanel">
                    @livewire('mahasiswa.riwayat-transaksi')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('page') || urlParams.get('search') || urlParams.get('status')) {
        const riwayatTab = new bootstrap.Tab(document.getElementById('riwayat-tab'));
        riwayatTab.show();
    }
});
</script>