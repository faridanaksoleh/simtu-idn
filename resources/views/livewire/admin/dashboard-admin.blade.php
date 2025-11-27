<div>
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Assalamualaikum, {{ auth()->user()->name }}</h1>
    </div>

    <section class="section dashboard">
        <!-- Stats Cards -->
        <div class="row">
            <!-- Total Mahasiswa -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Mahasiswa</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalMahasiswa }}</h6>
                                <span class="text-muted small pt-2">Mahasiswa Terdaftar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Tabungan -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Tabungan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h6>
                                <span class="text-success small pt-1 fw-bold">Saldo Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalTransaksi }}</h6>
                                <span class="text-muted small pt-2">Transaksi Dilakukan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Target -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Progress Target</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $targetTercapai }}%</h6>
                                <span class="text-muted small pt-2">Target Tercapai</span>
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
                            Grafik Progress Tabungan <span class="text-muted">| 6 Bulan Terakhir</span>
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div id="reportsChart" style="min-height: 300px; flex: 1;"></div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 bg-light py-3">
                        <h5 class="card-title mb-0 fw-semibold text-dark">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            Aktivitas Terbaru
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="activity">
                            @forelse ($aktivitasTerbaru as $item)
                                <div class="activity-item d-flex position-relative pb-3 mb-3">
                                    <div class="activite-label text-muted small" style="width: 80px; flex-shrink: 0;">
                                        {{ $item->created_at->diffForHumans() }}
                                    </div>
                                    <i class='bi bi-circle-fill activity-badge 
                                        {{ $item->type === 'income' ? 'text-success' : 'text-danger' }} 
                                        align-self-start' 
                                        style="position: absolute; left: 85px; top: 2px; font-size: 8px;"></i>
                                    <div class="activity-content" style="margin-left: 100px;">
                                        <div class="mb-1">
                                            @if($item->user)
                                                <strong class="text-dark">{{ $item->user->name }}</strong>
                                            @else
                                                <strong class="text-muted">User tidak ditemukan</strong>
                                            @endif
                                            {{ $item->type === 'income' ? 'menabung' : 'melakukan penarikan' }}
                                        </div>
                                        <div class="mb-1">
                                            <span class="fw-semibold {{ $item->type === 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $item->type === 'income' ? '+' : '-' }}Rp {{ number_format(abs($item->amount), 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="badge bg-{{ $item->status === 'approved' ? 'success' : ($item->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                            @if($item->description)
                                                <small class="text-muted d-block mt-1">{{ Str::limit($item->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox display-4 text-muted opacity-50 d-block mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada aktivitas transaksi</p>
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
document.addEventListener('DOMContentLoaded', function() {
    initializeAreaChart();
});

function initializeAreaChart() {
    const chartElement = document.getElementById('reportsChart');
    if (!chartElement) return;

    const chartData = @json($chartData);
    const categories = @json($chartCategories);

    // Fallback untuk data kosong
    if (chartData.length === 0 || categories.length === 0) {
        chartElement.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="bi bi-exclamation-triangle display-4 d-block mb-3"></i>
                <h5>Data chart tidak tersedia</h5>
                <p>Tidak ada data transaksi untuk ditampilkan.</p>
            </div>
        `;
        return;
    }

    try {
        if (window.adminAreaChart) {
            window.adminAreaChart.destroy();
        }
        
        const options = {
            series: [{
                name: "Total Tabungan",
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

        window.adminAreaChart = new ApexCharts(chartElement, options);
        window.adminAreaChart.render();
        
    } catch (error) {
        console.error('Error rendering chart:', error);
    }
}

// Handle Livewire events
document.addEventListener('livewire:load', function() {
    setTimeout(initializeAreaChart, 100);
});

document.addEventListener('livewire:navigated', function() {
    setTimeout(initializeAreaChart, 200);
});
</script>
@endpush