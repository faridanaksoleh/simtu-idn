{{-- resources/views/livewire/admin/dashboard-admin.blade.php --}}
<div>
    <div class="pagetitle">
        <h1>Dashboard Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Card Statistik -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Mahasiswa</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>120</h6>
                                <span class="text-muted small pt-2">Mahasiswa aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Card -->

            <!-- Total Tabungan -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Tabungan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp 87.500.000</h6>
                                <span class="text-success small pt-1 fw-bold">+12%</span>
                                <span class="text-muted small pt-2 ps-1">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Card -->

            <!-- Total Transaksi -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="ps-3">
                                <h6>248</h6>
                                <span class="text-muted small pt-2">Total transaksi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Card -->

            <!-- Target Tabungan -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Target Tercapai</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="ps-3">
                                <h6>73%</h6>
                                <span class="text-muted small pt-2">Dari total target</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Card -->

        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Tabungan <span>| Bulanan</span></h5>
                        <div id="reportsChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Aktivitas Terbaru</h5>
                        <div class="activity">
                            <div class="activity-item d-flex">
                                <div class="activite-label">10 min</div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                                    Mahasiswa <a href="#" class="fw-bold text-dark">Farid</a> menabung Rp 200.000
                                </div>
                            </div>
                            <div class="activity-item d-flex">
                                <div class="activite-label">1 hr</div>
                                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                <div class="activity-content">
                                    Admin menambahkan kategori <a href="#" class="fw-bold text-dark">Umrah 2026</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Activity -->
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener("livewire:navigated", renderChart);
    document.addEventListener("DOMContentLoaded", renderChart);

    function renderChart() {
        if (typeof ApexCharts !== 'undefined') {
            new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                    name: 'Total Tabungan',
                    data: [3100000, 4200000, 3500000, 5000000, 4900000, 6000000]
                }],
                chart: { height: 300, type: 'area', toolbar: { show: false } },
                colors: ['#4154f1'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'] },
                tooltip: { y: { formatter: val => `Rp ${val.toLocaleString()}` } }
            }).render();
        }
    }
</script>
@endpush
