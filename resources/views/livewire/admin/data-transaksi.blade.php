<div>
  <div class="pagetitle">
    <h1>Data Transaksi</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Transaksi</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <h5 class="card-title mb-0">Riwayat Transaksi Mahasiswa</h5>
          <button class="btn btn-success btn-sm">
            <i class="bi bi-download me-1"></i> Export Laporan
          </button>
        </div>

        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Mahasiswa</th>
              <th>Kategori Tabungan</th>
              <th>Jumlah</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Ahmad Zaky</td>
              <td>Tabungan Umrah</td>
              <td>Rp 500.000</td>
              <td>2025-10-18</td>
              <td><span class="badge bg-success">Terkonfirmasi</span></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Nur Aisyah</td>
              <td>Tabungan Qurban</td>
              <td>Rp 300.000</td>
              <td>2025-10-20</td>
              <td><span class="badge bg-warning text-dark">Pending</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
