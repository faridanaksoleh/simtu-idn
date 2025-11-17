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
                <h6>Rp {{ number_format($totalTabungan, 0, ',', '.') }}</h6>
                <span class="text-success small pt-1 fw-bold">Disetujui</span>
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
                <h6>{{ $transaksiAktif }} Transaksi</h6>
                <span class="text-warning small pt-1 fw-bold">Menunggu verifikasi</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Kartu Target Tabungan -->
      <div class="col-lg-4 col-md-6">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">Progress Target</h5>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-bullseye"></i>
              </div>
              <div class="ps-3 w-100">
                <h6 class="mb-1">{{ $targetName }}</h6>
                <div class="progress mt-2" style="height: 8px;">
                  <div class="progress-bar bg-success" role="progressbar" 
                       style="width: {{ $progressTarget }}%;" 
                       aria-valuenow="{{ $progressTarget }}"></div>
                </div>
                <span class="text-muted small">{{ $progressTarget }}% tercapai</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Grafik Progress Tabungan -->
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Grafik Progress Tabungan <span>| 6 Bulan Terakhir</span></h5>
            <div id="reportsChartMahasiswa" style="min-height: 350px;"></div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Aktivitas Terbaru</h5>
            <div class="activity">
              @php
                $recentTransactions = \App\Models\Transaction::where('user_id', auth()->id())
                  ->latest()
                  ->take(5)
                  ->get();
              @endphp
              
              @forelse($recentTransactions as $transaction)
                <div class="activity-item d-flex">
                  <div class="activite-label">{{ $transaction->created_at->diffForHumans() }}</div>
                  <i class='bi bi-circle-fill activity-badge 
                    {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }} align-self-start'></i>
                  <div class="activity-content">
                    {{ $transaction->type === 'income' ? 'Tabungan' : 'Pengeluaran' }}
                    <br>
                    <small class="text-muted">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</small>
                    <br>
                    <span class="badge bg-{{ $transaction->status === 'approved' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                      {{ $transaction->status }}
                    </span>
                  </div>
                </div>
              @empty
                <div class="text-center text-muted py-3">
                  <i class="bi bi-clock-history display-4 d-block mb-2"></i>
                  <p>Belum ada transaksi</p>
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
console.log('=== MAHASISWA CHART DEBUG ===');

function initializeMahasiswaChart() {
    console.log('🎓 Initializing Mahasiswa Area Chart...');
    
    const chartElement = document.getElementById('reportsChartMahasiswa');
    if (!chartElement) {
        console.error('❌ Chart element not found!');
        return false;
    }
    
    console.log('✅ Chart element found');
    
    // Data REAL dari Livewire
    const chartData = @json($chartData);
    const categories = @json($chartCategories);
    
    console.log('📊 MAHASISWA Chart Data:', chartData);
    console.log('📅 MAHASISWA Categories:', categories);
    
    // Cek jika data valid
    if (chartData.length === 0 || categories.length === 0) {
        console.error('❌ Chart data is empty!');
        chartElement.innerHTML = `
            <div class="text-center text-muted py-5">
                <i class="bi bi-exclamation-triangle display-4 d-block mb-3"></i>
                <h5>Data chart tidak tersedia</h5>
                <p>Belum ada data tabungan untuk ditampilkan.</p>
            </div>
        `;
        return false;
    }

    try {
        // Hapus chart sebelumnya jika ada
        if (window.mahasiswaChart) {
            window.mahasiswaChart.destroy();
            console.log('♻️ Previous chart destroyed');
        }
        
        const options = {
            series: [{
                name: "Tabungan Saya",
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
            colors: ['#2ecc71'], // Warna hijau untuk mahasiswa
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#2ecc71']
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
                colors: ['#2ecc71'],
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

        console.log('🛠️ Mahasiswa chart options configured');
        
        window.mahasiswaChart = new ApexCharts(chartElement, options);
        window.mahasiswaChart.render();
        
        console.log('✅ Mahasiswa Area Chart rendered successfully!');
        
        return true;
        
    } catch (error) {
        console.error('❌ Error rendering mahasiswa chart:', error);
        return false;
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM Content Loaded - Mahasiswa');
    if (typeof ApexCharts !== 'undefined') {
        initializeMahasiswaChart();
    }
});

document.addEventListener('livewire:load', function() {
    console.log('⚡ Livewire Loaded - Mahasiswa');
    if (typeof ApexCharts !== 'undefined') {
        setTimeout(initializeMahasiswaChart, 100);
    }
});

document.addEventListener('livewire:navigated', function() {
    console.log('🔄 Livewire Navigated - Mahasiswa');
    setTimeout(() => {
        if (typeof ApexCharts !== 'undefined') {
            initializeMahasiswaChart();
        }
    }, 200);
});
</script>
@endpush