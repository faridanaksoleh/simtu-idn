<div>
  <div class="pagetitle">
    <h1>Dashboard Koordinator</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('koordinator.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Dashboard - Kelas {{ $kelasBimbingan }}</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- Kartu Total Mahasiswa -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">Total Mahasiswa <span>| Kelas {{ $kelasBimbingan }}</span></h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
              </div>
              <div class="ps-3">
                <h6>{{ $totalMahasiswa }}</h6>
                <span class="text-success small pt-1 fw-bold">Aktif</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kartu Total Saldo -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card revenue-card">
          <div class="card-body">
            <h5 class="card-title">Total Saldo <span>| Tabungan Kelas</span></h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-wallet2"></i>
              </div>
              <div class="ps-3">
                <h6>Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h6>
                <span class="text-success small pt-1 fw-bold">Disetujui</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kartu Transaksi Bulan Ini -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card customers-card">
          <div class="card-body">
            <h5 class="card-title">Transaksi <span>| Bulan Ini</span></h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-cash-stack"></i>
              </div>
              <div class="ps-3">
                <h6>{{ $transaksiBulanIni }}</h6>
                <span class="text-warning small pt-1 fw-bold">Total transaksi</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Grafik Progress Tabungan Kelas -->
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Grafik Progress Tabungan <span>| Kelas {{ $kelasBimbingan }} - 6 Bulan Terakhir</span></h5>
            <div id="reportsChartKoordinator" style="min-height: 350px;"></div>
          </div>
        </div>
      </div>

      <!-- Tabel Mahasiswa Terbaru -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Mahasiswa Terbaru <span>| Kelas {{ $kelasBimbingan }}</span></h5>
            <div class="activity">
              @forelse($mahasiswaTerbaru as $mahasiswa)
                <div class="activity-item d-flex">
                  <div class="activite-label">{{ $mahasiswa->created_at->diffForHumans() }}</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    <b>{{ $mahasiswa->name }}</b>
                    <br>
                    <small class="text-muted">NIM: {{ $mahasiswa->nim }}</small>
                    <br>
                    <span class="badge bg-success">
                      Rp {{ number_format($mahasiswa->total_saldo ?? 0, 0, ',', '.') }}
                    </span>
                  </div>
                </div>
              @empty
                <div class="text-center text-muted py-3">
                  <i class="bi bi-people display-4 d-block mb-2"></i>
                  <p>Belum ada mahasiswa</p>
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
console.log('=== KOORDINATOR CHART DEBUG ===');

function initializeKoordinatorChart() {
    console.log('👨‍🏫 Initializing Koordinator Area Chart...');
    
    const chartElement = document.getElementById('reportsChartKoordinator');
    if (!chartElement) {
        console.error('❌ Chart element not found!');
        return false;
    }
    
    console.log('✅ Chart element found');
    
    // Data REAL dari Livewire
    const chartData = @json($chartData);
    const categories = @json($chartCategories);
    
    console.log('📊 KOORDINATOR Chart Data:', chartData);
    console.log('📅 KOORDINATOR Categories:', categories);
    
    // Cek jika data valid
    if (chartData.length === 0 || categories.length === 0) {
        console.error('❌ Chart data is empty!');
        chartElement.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="bi bi-exclamation-triangle display-4 d-block mb-3"></i>
                <h5>Data chart tidak tersedia</h5>
                <p>Belum ada data tabungan untuk kelas ini.</p>
            </div>
        `;
        return false;
    }

    try {
        // Hapus chart sebelumnya jika ada
        if (window.koordinatorChart) {
            window.koordinatorChart.destroy();
            console.log('♻️ Previous chart destroyed');
        }
        
        const options = {
            series: [{
                name: "Tabungan Kelas {{ $kelasBimbingan }}",
                data: chartData
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
            colors: ['#ff6b35'], // Warna orange untuk koordinator
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#ff6b35']
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            markers: {
                size: 5,
                colors: ['#ff6b35'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: { size: 7 }
            },
            xaxis: {
                categories: categories,
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
            }
        };

        console.log('🛠️ Koordinator chart options configured');
        
        window.koordinatorChart = new ApexCharts(chartElement, options);
        window.koordinatorChart.render();
        
        console.log('✅ Koordinator Area Chart rendered successfully!');
        
        return true;
        
    } catch (error) {
        console.error('❌ Error rendering koordinator chart:', error);
        return false;
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM Content Loaded - Koordinator');
    if (typeof ApexCharts !== 'undefined') {
        initializeKoordinatorChart();
    }
});

document.addEventListener('livewire:load', function() {
    console.log('⚡ Livewire Loaded - Koordinator');
    if (typeof ApexCharts !== 'undefined') {
        setTimeout(initializeKoordinatorChart, 100);
    }
});

document.addEventListener('livewire:navigated', function() {
    console.log('🔄 Livewire Navigated - Koordinator');
    setTimeout(() => {
        if (typeof ApexCharts !== 'undefined') {
            initializeKoordinatorChart();
        }
    }, 200);
});
</script>
@endpush