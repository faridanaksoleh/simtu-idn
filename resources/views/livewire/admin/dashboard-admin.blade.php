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
                                <h6>{{ $totalMahasiswa }}</h6>
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
                                <h6>Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h6>
                                <span class="text-success small pt-1 fw-bold">0%</span>
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
                                <h6>{{ $totalTransaksi }}</h6>
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
                                <h6>{{ $targetTercapai }}%</h6>
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
                            @foreach ($aktivitasTerbaru as $item)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $item->created_at->diffForHumans() }}</div>
                                    <i class='bi bi-circle-fill activity-badge 
                                        {{ $item->type === 'income' ? 'text-success' : 'text-danger' }} align-self-start'></i>
                                    <div class="activity-content">
                                        Mahasiswa <b>{{ $item->user->name }}</b>
                                        {{ $item->type === 'income' ? 'menabung' : 'melakukan pengeluaran' }}
                                        Rp {{ number_format($item->amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- End Activity -->
        </div>
    </section>
</div>

@push('scripts')
<script>

// Debug info
console.log('Script loaded');
console.log('ApexCharts available:', typeof ApexCharts !== 'undefined');
console.log('Chart element exists:', document.getElementById('reportsChart') !== null);

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    setTimeout(initializeChart, 100);
});

document.addEventListener('livewire:load', function() {
    console.log('Livewire loaded');
    initializeChart();
});

document.addEventListener('livewire:navigated', function() {
    console.log('Livewire navigated');
    setTimeout(initializeChart, 200);
});

function initializeChart() {
    console.log('Initializing chart...');
    
    const chartElement = document.getElementById('reportsChart');
    
    if (!chartElement) {
        console.log('Chart element not found, retrying...');
        setTimeout(initializeChart, 500);
        return;
    }
    
    if (typeof ApexCharts === 'undefined') {
        console.log('ApexCharts not loaded, retrying...');
        setTimeout(initializeChart, 500);
        return;
    }
    
document.addEventListener('livewire:load', function() {
    initializeChart();
});

document.addEventListener('livewire:navigated', function() {
    // Delay sedikit untuk memastikan DOM sudah sepenuhnya ter-render
    setTimeout(initializeChart, 100);
});

function initializeChart() {
    const chartElement = document.getElementById('reportsChart');
    
    if (!chartElement) {
        console.error('Chart element not found!');
        return;
    }
    
    // Cek jika ApexCharts tersedia
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts is not loaded!');
        // Coba load ulang setelah delay
        setTimeout(initializeChart, 500);
        return;
    }
    
    // Hapus chart sebelumnya jika ada
    if (window.reportsChart) {
        window.reportsChart.destroy();
    }
    
    const options = {
        series: [{
            name: 'Total Tabungan',
            data: [3100000, 4200000, 3500000, 5000000, 4900000, 6000000]
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#4154f1'],
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return 'Rp ' + value.toLocaleString('id-ID');
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return 'Rp ' + value.toLocaleString('id-ID');
                }
            }
        }
    };

    window.reportsChart = new ApexCharts(chartElement, options);
    window.reportsChart.render();
    console.log('Chart rendered successfully');
}

// Fallback jika DOM sudah loaded tapi Livewire belum trigger
if (document.readyState === 'complete') {
    setTimeout(initializeChart, 1000);
}
</script>
@endpush
