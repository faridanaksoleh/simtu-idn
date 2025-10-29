<div>
  <div class="pagetitle">
    <h1>Target Tabungan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Target Tabungan</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <h5 class="card-title mb-0">Daftar Target Tabungan</h5>
          <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Target
          </button>
        </div>

        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr class="text-center">
              <th style="width: 5%">#</th>
              <th>Nama Mahasiswa</th>
              <th>Nominal Target</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Status</th>
              <th style="width: 15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">1</td>
              <td>Farid Ahsan</td>
              <td>Rp10.000.000</td>
              <td>2025-01-01</td>
              <td>2025-06-30</td>
              <td><span class="badge bg-success">Berjalan</span></td>
              <td class="text-center">
                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td class="text-center">2</td>
              <td>Ahmad Rifqi</td>
              <td>Rp8.000.000</td>
              <td>2025-02-01</td>
              <td>2025-08-31</td>
              <td><span class="badge bg-secondary">Selesai</span></td>
              <td class="text-center">
                <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
