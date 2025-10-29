<div>
  <div class="pagetitle">
    <h1>Kategori Tabungan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kategori Tabungan</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <h5 class="card-title mb-0">Daftar Kategori</h5>
          <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
          </button>
        </div>

        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
              <th>Tanggal Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Tabungan Umrah</td>
              <td>Program tabungan untuk keberangkatan umrah.</td>
              <td>2025-10-10</td>
              <td>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Tabungan Qurban</td>
              <td>Program tabungan hewan qurban tahunan.</td>
              <td>2025-10-12</td>
              <td>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
