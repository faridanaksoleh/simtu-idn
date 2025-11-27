<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-wallet me-2"></i>Kelola Transaksi - Admin
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Tabs Navigation -->
            <div class="p-4 border-bottom">
                <ul class="nav nav-tabs" id="transaksiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold {{ $activeTab === 'semua' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'semua')"
                                type="button">
                            <i class="bi bi-list-ul me-2"></i>Semua Transaksi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold {{ $activeTab === 'persetujuan' ? 'active' : '' }}" 
                                wire:click="$set('activeTab', 'persetujuan')"
                                type="button">
                            <i class="bi bi-check-circle me-2"></i>Persetujuan
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="transaksiTabsContent">
                <div class="tab-pane fade {{ $activeTab === 'semua' ? 'show active' : '' }}" role="tabpanel">
                    @livewire('admin.semua-transaksi')
                </div>
                <div class="tab-pane fade {{ $activeTab === 'persetujuan' ? 'show active' : '' }}" role="tabpanel">
                    @livewire('admin.persetujuan-transaksi')
                </div>
            </div>
        </div>
    </div>
</div>