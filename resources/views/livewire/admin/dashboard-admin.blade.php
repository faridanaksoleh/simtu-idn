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
            <!-- Card Statistik (sama seperti sebelumnya) -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Mahasiswa</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalMahasiswa }}</h6>
                                <span class="text-muted small pt-2">Mahasiswa aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Tabungan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h6>
                                <span class="text-success small pt-1 fw-bold">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Transaksi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalTransaksi }}</h6>
                                <span class="text-muted small pt-2">Total transaksi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Progress Target</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $targetTercapai }}%</h6>
                                <span class="text-muted small pt-2">Target tercapai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Progress Tabungan <span>| 6 Bulan Terakhir</span></h5>
                        <div id="reportsChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Aktivitas Terbaru</h5>
                        <div class="activity">
                            @foreach ($aktivitasTerbaru as $item)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $item->created_at->diffForHumans() }}</div>
                                    <i class='bi bi-circle-fill activity-badge 
                                        {{ $item->type === 'income' ? 'text-success' : 'text-danger' }} align-self-start'></i>
                                    <div class="activity-content">
                                        @if($item->user)
                                            <b>{{ $item->user->name }}</b>
                                        @else
                                            <b>User tidak ditemukan</b>
                                        @endif
                                        {{ $item->type === 'income' ? 'menabung' : 'melakukan pengeluaran' }}
                                        <br>
                                        <small class="text-muted">Rp {{ number_format($item->amount, 0, ',', '.') }}</small>
                                        <br>
                                        <span class="badge bg-{{ $item->status === 'approved' ? 'success' : ($item->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
console.log('=== CHART DEBUG INFO ===');

function initializeAreaChart() {
    console.log('🚀 Initializing Area Chart with REAL data...');
    
    const chartElement = document.getElementById('reportsChart');
    if (!chartElement) {
        console.error('❌ Chart element not found!');
        return false;
    }
    
    console.log('✅ Chart element found');
    
    // Data REAL dari Livewire
    const chartData = @json($chartData);
    const categories = @json($chartCategories);
    
    console.log('📊 REAL Chart Data:', chartData);
    console.log('📅 REAL Categories:', categories);
    console.log('📏 Data length:', chartData.length);
    
    // Cek jika data valid
    if (chartData.length === 0 || categories.length === 0) {
        console.error('❌ Chart data is empty!');
        chartElement.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="bi bi-exclamation-triangle display-4 d-block mb-3"></i>
                <h5>Data chart tidak tersedia</h5>
                <p>Tidak ada data transaksi untuk ditampilkan.</p>
            </div>
        `;
        return false;
    }

    try {
        // Hapus chart sebelumnya jika ada
        if (window.adminAreaChart) {
            window.adminAreaChart.destroy();
            console.log('♻️ Previous chart destroyed');
        }
        
        const options = {
            series: [{
                name: "Total Tabungan",
                data: chartData // PAKAI DATA REAL
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: { enabled: false },
                toolbar: { 
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
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
                categories: categories, // PAKAI CATEGORIES REAL
                labels: {
                    style: { colors: '#6c757d', fontSize: '12px' }
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
                    style: { colors: '#6c757d', fontSize: '12px' }
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
            },
            noData: {
                text: "Loading data...",
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: "#6c757d",
                    fontSize: "14px",
                    fontFamily: "Nunito, sans-serif"
                }
            }
        };

        console.log('🛠️ Chart options configured with REAL data');
        
        window.adminAreaChart = new ApexCharts(chartElement, options);
        window.adminAreaChart.render();
        
        console.log('✅ Area Chart rendered successfully with REAL data!');
        
        return true;
        
    } catch (error) {
        console.error('❌ Error rendering area chart:', error);
        return false;
    }
}

// Initialize dengan data real
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM Content Loaded - Using REAL data');
    if (typeof ApexCharts !== 'undefined') {
        initializeAreaChart();
    } else {
        console.error('❌ ApexCharts not loaded');
    }
});

// Handle Livewire
document.addEventListener('livewire:load', function() {
    console.log('⚡ Livewire Loaded - Using REAL data');
    if (typeof ApexCharts !== 'undefined') {
        setTimeout(initializeAreaChart, 100);
    }
});

document.addEventListener('livewire:navigated', function() {
    console.log('🔄 Livewire Navigated - Refreshing with REAL data');
    setTimeout(() => {
        if (typeof ApexCharts !== 'undefined') {
            initializeAreaChart();
        }
    }, 200);
});
</script>
@endpush