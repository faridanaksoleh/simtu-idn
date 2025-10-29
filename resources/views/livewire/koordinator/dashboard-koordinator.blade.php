<div>
  <div class="pagetitle">
    <h1>Dashboard Koordinator</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('koordinator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- ======= Kartu Statistik ======= -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <h5 class="card-title">Total Mahasiswa <span>| Bimbingan</span></h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                <i class="bi bi-people"></i>
              </div>
              <div class="ps-3">
                <h6>13</h6>
                <span class="text-success small pt-1 fw-bold">+3</span>
                <span class="text-muted small pt-2 ps-1">mahasiswa baru</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <h5 class="card-title">Total Saldo <span>| Tabungan</span></h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                <i class="bi bi-wallet2"></i>
              </div>
              <div class="ps-3">
                <h6>Rp 12.400.000</h6>
                <span class="text-success small pt-1 fw-bold">+8%</span>
                <span class="text-muted small pt-2 ps-1">dari bulan lalu</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="card info-card">
          <div class="card-body">
            <h5 class="card-title">Transaksi <span>| Bulan Ini</span></h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
                <i class="bi bi-cash-stack"></i>
              </div>
              <div class="ps-3">
                <h6>152</h6>
                <span class="text-success small pt-1 fw-bold">+12%</span>
                <span class="text-muted small pt-2 ps-1">aktivitas meningkat</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ======= Grafik Dummy ======= -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Perkembangan Tabungan</h5>
            <canvas id="chartTabungan" style="height: 300px;"></canvas>
          </div>
        </div>
      </div>

      <!-- ======= Tabel Ringkasan ======= -->
      <div class="col-lg-4">
        <div class="card recent-sales">
          <div class="card-body">
            <h5 class="card-title">Mahasiswa Terbaru</h5>
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Saldo</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Ahmad</td><td>TRPL 1</td><td>Rp 1.200.000</td></tr>
                <tr><td>Siti</td><td>TRPL 2</td><td>Rp 950.000</td></tr>
                <tr><td>Rizky</td><td>TRPL 1</td><td>Rp 1.400.000</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Chart.js Script -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('chartTabungan');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
          datasets: [{
            label: 'Total Tabungan (Rp)',
            data: [8000000, 8700000, 9000000, 9500000, 10800000, 12400000],
            borderColor: '#4154f1',
            fill: false,
            tension: 0.3
          }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
      });
    });
  </script>
</div>
