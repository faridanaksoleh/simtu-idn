<div>
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Assalamualaikum, {{ auth()->user()->name }}</h1>
    </div>

    <section class="section dashboard">
        <!-- Stats Cards -->
        <div class="row">
            <!-- Total Mahasiswa -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Mahasiswa</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalMahasiswa }}</h6>
                                <span class="text-muted small pt-2">Kelas {{ $kelasBimbingan }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Saldo -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Saldo</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h6>
                                <span class="text-success small pt-1 fw-bold">Tabungan Kelas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Bulan Ini -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi Bulan Ini</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $transaksiBulanIni }}</h6>
                                <span class="text-muted small pt-2">Transaksi Dilakukan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Activities - SAME HEIGHT -->
        <div class="row">
            <!-- Chart Section -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 bg-light py-3">
                        <h5 class="card-title mb-0 fw-semibold text-dark">
                            <i class="bi bi-graph-up me-2 text-primary"></i>
                            Grafik Progress Tabungan <span class="text-muted">| Kelas {{ $kelasBimbingan }} - 6 Bulan Terakhir</span>
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div id="reportsChartKoordinator" style="min-height: 300px; flex: 1;"></div>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Terbaru -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 bg-light py-3">
                        <h5 class="card-title mb-0 fw-semibold text-dark">
                            <i class="bi bi-people me-2 text-primary"></i>
                            Mahasiswa Terbaru
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="activity">
                            @forelse($mahasiswaTerbaru as $mahasiswa)
                                <div class="activity-item d-flex position-relative pb-3 mb-3">
                                    <div class="activite-label text-muted small" style="width: 80px; flex-shrink: 0;">
                                        {{ $mahasiswa->created_at->diffForHumans() }}
                                    </div>
                                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start' 
                                       style="position: absolute; left: 85px; top: 2px; font-size: 8px;"></i>
                                    <div class="activity-content" style="margin-left: 100px;">
                                        <div class="mb-1">
                                            <strong class="text-dark">{{ $mahasiswa->name }}</strong>
                                        </div>
                                        <div class="mb-1">
                                            <small class="text-muted">NIM: {{ $mahasiswa->nim }}</small>
                                        </div>
                                        <div>
                                            <span class="badge bg-success">
                                                Rp {{ number_format($mahasiswa->total_saldo ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-people display-4 text-muted opacity-50 d-block mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada mahasiswa di kelas ini</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
function initializeKoordinatorChart() {
    const chartElement = document.getElementById('reportsChartKoordinator');
    if (!chartElement) return;

    const chartData = @json($chartData);
    const categories = @json($chartCategories);

    // Fallback untuk data kosong
    if (chartData.length === 0 || categories.length === 0) {
        chartElement.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="bi bi-exclamation-triangle display-4 d-block mb-3"></i>
                <h5>Data chart tidak tersedia</h5>
                <p>Belum ada data tabungan untuk kelas ini.</p>
            </div>
        `;
        return;
    }

    try {
        if (window.koordinatorChart) {
            window.koordinatorChart.destroy();
        }
        
        const options = {
            series: [{
                name: "Tabungan Kelas {{ $kelasBimbingan }}",
                data: chartData
            }],
            chart: {
                type: 'area',
                height: '100%',
                parentHeightOffset: 0,
                zoom: { enabled: false },
                toolbar: { 
                    show: true,
                    tools: { download: true }
                }
            },
            colors: ['#4154f1'],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#4154f1']
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.8,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            markers: {
                size: 5,
                colors: ['#4154f1'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: { size: 7 }
            },
            xaxis: {
                categories: categories,
                labels: {
                    style: { 
                        colors: '#6c757d', 
                        fontSize: '12px',
                        fontFamily: 'Nunito, sans-serif'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'JT';
                        } else if (value >= 1000) {
                            return 'Rp ' + (value / 1000).toFixed(0) + 'RB';
                        }
                        return 'Rp ' + value.toLocaleString('id-ID');
                    },
                    style: { 
                        colors: '#6c757d', 
                        fontSize: '12px',
                        fontFamily: 'Nunito, sans-serif'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 3
            }
        };

        window.koordinatorChart = new ApexCharts(chartElement, options);
        window.koordinatorChart.render();
        
    } catch (error) {
        console.error('Error rendering koordinator chart:', error);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeKoordinatorChart();
});

document.addEventListener('livewire:load', function() {
    setTimeout(initializeKoordinatorChart, 100);
});

document.addEventListener('livewire:navigated', function() {
    setTimeout(initializeKoordinatorChart, 200);
});
</script>
@endpush