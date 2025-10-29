<div>
  <div class="pagetitle">
    <h1>Kelola User</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Kelola User</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <h5 class="card-title mb-0">Daftar Pengguna</h5>
          <button class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
          </button>
        </div>

        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Tanggal Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Ust. Ahmad</td>
              <td>ahmad@idn.ac.id</td>
              <td><span class="badge bg-primary">Admin</span></td>
              <td>2025-10-20</td>
              <td>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Koord. Rahman</td>
              <td>rahman@idn.ac.id</td>
              <td><span class="badge bg-warning text-dark">Koordinator</span></td>
              <td>2025-10-22</td>
              <td>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Mahasiswa Farid</td>
              <td>farid@idn.ac.id</td>
              <td><span class="badge bg-success">Mahasiswa</span></td>
              <td>2025-10-25</td>
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
