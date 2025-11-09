<div>
    <h4 class="mb-3 fw-bold">Transaksi</h4>

    <ul class="nav nav-tabs mb-3" id="transaksiTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'semua' ? 'active' : '' }}" 
                    wire:click="$set('activeTab', 'semua')"
                    type="button">
                <i class="bi bi-list-ul"></i> Semua Transaksi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'persetujuan' ? 'active' : '' }}" 
                    wire:click="$set('activeTab', 'persetujuan')"
                    type="button">
                <i class="bi bi-check-circle"></i> Persetujuan
                {{-- HAPUS BAGIAN BADGE INI --}}
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade {{ $activeTab === 'semua' ? 'show active' : '' }}" role="tabpanel">
            @livewire('admin.semua-transaksi')
        </div>
        <div class="tab-pane fade {{ $activeTab === 'persetujuan' ? 'show active' : '' }}" role="tabpanel">
            @livewire('admin.persetujuan-transaksi')
        </div>
    </div>
</div>