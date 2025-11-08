<div>
  <h4 class="mb-3 fw-bold">Transaksi</h4>

  <ul class="nav nav-tabs mb-3" id="transaksiTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="buat-tab" data-bs-toggle="tab" data-bs-target="#buat" type="button" role="tab">
        Tambah Transaksi
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab">
        Riwayat Transaksi
      </button>
    </li>
  </ul>

  <div class="tab-content" id="transaksiTabsContent">
    <div class="tab-pane fade show active" id="buat" role="tabpanel">
      @livewire('mahasiswa.buat-transaksi')
    </div>
    <div class="tab-pane fade" id="riwayat" role="tabpanel">
      @livewire('mahasiswa.riwayat-transaksi')
    </div>
  </div>
</div>

<script>
// Simple tab persistence - hanya jika ada parameter URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('page') || urlParams.get('search') || urlParams.get('status')) {
        const riwayatTab = new bootstrap.Tab(document.getElementById('riwayat-tab'));
        riwayatTab.show();
    }
});
</script>