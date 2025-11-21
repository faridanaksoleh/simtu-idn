<div>
    <div class="pagetitle">
        <h1>Progress Mahasiswa - Kelas {{ $userClass }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('koordinator.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Progress Mahasiswa</li>
            </ol>
        </nav>
    </div>

    <!-- Filter Section -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Filter Progress Mahasiswa - Kelas {{ $userClass }}</h5>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Cari Mahasiswa</label>
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama atau email..." 
                           wire:model.live="search">
                    <small class="text-muted">Menampilkan mahasiswa dari kelas {{ $userClass }} saja</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mt-4">
        <div class="col-lg-3">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Total Mahasiswa</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ count($students) }}</h6>
                            <span class="text-primary small pt-1 fw-bold">Mahasiswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Total Tabungan</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2 text-success"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Rp {{ number_format($students->sum('total_savings'), 0, ',', '.') }}</h6>
                            <span class="text-success small pt-1 fw-bold">Tabungan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-left-right text-info"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $students->sum('total_transactions') }}</h6>
                            <span class="text-info small pt-1 fw-bold">Transaksi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Tabungan Bulan Ini</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar-month text-warning"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Rp {{ number_format($students->sum('monthly_savings'), 0, ',', '.') }}</h6>
                            <span class="text-warning small pt-1 fw-bold">Bulan {{ now()->format('M') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Daftar Mahasiswa Kelas {{ $userClass }} ({{ count($students) }} orang)</h5>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('name')" style="cursor: pointer;" class="w-25">
                                Nama Mahasiswa
                                @if($sortBy === 'name')
                                    <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </th>
                            <th class="w-25">Email</th>
                            <th wire:click="sortBy('total_savings')" style="cursor: pointer;" class="w-20">
                                Total Tabungan
                                @if($sortBy === 'total_savings')
                                    <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </th>
                            <th class="w-20">Progress Tabungan</th>
                            <th class="w-10">Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>
                                    <strong>{{ $student->name }}</strong>
                                    <br>
                                    <small class="text-muted">Kelas: {{ $student->class }}</small>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($student->total_savings, 0, ',', '.') }}
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar 
                                            @if($student->progress_percentage >= 75) bg-success
                                            @elseif($student->progress_percentage >= 50) bg-info
                                            @elseif($student->progress_percentage >= 25) bg-warning
                                            @else bg-danger
                                            @endif" 
                                            role="progressbar" 
                                            style="width: {{ $student->progress_percentage }}%"
                                            aria-valuenow="{{ $student->progress_percentage }}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                            {{ number_format($student->progress_percentage, 1) }}%
                                        </div>
                                    </div>
                                    <small class="text-muted">Target: Rp 1.000.000</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $student->total_transactions }}</span>
                                    <br>
                                    <small class="text-muted">
                                        {{ $student->monthly_transactions }} transaksi bulan ini
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4"> <!-- COLSPAN DIUBAH DARI 6 JADI 5 -->
                                    <i class="bi bi-people display-4 d-block mb-2"></i>
                                    @if($search)
                                        Tidak ditemukan mahasiswa dengan kata kunci "{{ $search }}"
                                    @else
                                        Tidak ada data mahasiswa di kelas {{ $userClass }}
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Progress Distribution -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Distribusi Progress Tabungan - Kelas {{ $userClass }}</h5>
            <div class="row">
                <div class="col-md-8">
                    @php
                        $categories = [
                            'Sangat Baik (>75%)' => $students->where('progress_percentage', '>', 75)->count(),
                            'Baik (50-75%)' => $students->whereBetween('progress_percentage', [50, 75])->count(),
                            'Cukup (25-50%)' => $students->whereBetween('progress_percentage', [25, 50])->count(),
                            'Perlu Perhatian (<25%)' => $students->where('progress_percentage', '<', 25)->count()
                        ];
                    @endphp
                    
                    @foreach($categories as $label => $count)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold">{{ $label }}</span>
                                <span>{{ $count }} mahasiswa</span>
                            </div>
                            <div class="progress" style="height: 12px;">
                                <div class="progress-bar 
                                    @if($label === 'Sangat Baik (>75%)') bg-success
                                    @elseif($label === 'Baik (50-75%)') bg-info
                                    @elseif($label === 'Cukup (25-50%)') bg-warning
                                    @else bg-danger
                                    @endif" 
                                    style="width: {{ count($students) > 0 ? ($count / count($students)) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <h6>Statistik Kelas</h6>
                        <div class="border rounded p-3">
                            <div class="mb-2">
                                <small class="text-muted">Rata-rata Tabungan</small>
                                <div class="fw-bold text-success">Rp {{ number_format($students->avg('total_savings'), 0, ',', '.') }}</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Rata-rata Progress</small>
                                <div class="fw-bold text-primary">{{ number_format($students->avg('progress_percentage'), 1) }}%</div>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Top Saver</small>
                                <div class="fw-bold">
                                    @if($students->count() > 0)
                                        {{ $students->sortByDesc('total_savings')->first()->name }} 
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>