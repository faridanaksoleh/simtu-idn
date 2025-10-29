<div>
  <div class="pagetitle">
      <h1>Riwayat Transaksi</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Riwayat Transaksi</li>
          </ol>
      </nav>
  </div>

  <section class="section">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title">Daftar Transaksi</h5>
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Tanggal</th>
                          <th>Jenis</th>
                          <th>Nominal</th>
                          <th>Keterangan</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>1</td>
                          <td>25 Okt 2025</td>
                          <td><span class="badge bg-success">Setoran</span></td>
                          <td>Rp 200.000</td>
                          <td>Tabungan bulan Oktober</td>
                      </tr>
                      <tr>
                          <td>2</td>
                          <td>18 Sep 2025</td>
                          <td><span class="badge bg-danger">Penarikan</span></td>
                          <td>Rp 100.000</td>
                          <td>Biaya keperluan pribadi</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </section>
</div>
