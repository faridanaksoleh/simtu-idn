<div>
  <div class="pagetitle">
    <h1>Dashboard Mahasiswa</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Selamat datang, {{ auth()->user()->name }} 👋</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- Kartu Total Tabungan -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card revenue-card">
          <div class="card-body">
            <h5 class="card-title">Total Tabungan</h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-wallet2"></i>
              </div>
              <div class="ps-3">
                <h6>Rp 12.500.000</h6>
                <span class="text-success small pt-1 fw-bold">+8%</span> <span class="text-muted small pt-2 ps-1">dari bulan lalu</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kartu Transaksi Aktif -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card customers-card">
          <div class="card-body">
            <h5 class="card-title">Transaksi Aktif</h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-repeat"></i>
              </div>
              <div class="ps-3">
                <h6>3 Transaksi</h6>
                <span class="text-warning small pt-1 fw-bold">Menunggu verifikasi</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kartu Target Umrah -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">Progress Target Umrah</h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-bullseye"></i>
              </div>
              <div class="ps-3 w-100">
                <div class="progress" style="height: 8px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60"></div>
                </div>
                <span class="text-muted small">60% tercapai</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Grafik (placeholder dulu) -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Grafik Tabungan</h5>
        <p class="text-muted">Fitur ini akan menampilkan grafik perkembangan tabungan kamu 📊</p>
      </div>
    </div>

  </section>
</div>
