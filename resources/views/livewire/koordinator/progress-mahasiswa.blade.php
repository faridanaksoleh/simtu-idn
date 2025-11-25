<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-graph-up-arrow me-2"></i>Progress Mahasiswa - Kelas {{ $userClass }}
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Filter Section -->
            <div class="p-4 border-bottom">
                <h6 class="fw-semibold text-dark mb-3">
                    <i class="bi bi-search me-2 text-primary"></i>Cari Mahasiswa Kelas {{ $userClass }}
                </h6>
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control border" 
                               placeholder="Cari berdasarkan nama atau email mahasiswa..." 
                               wire:model.live="search">
                        <small class="text-muted mt-1 d-block">
                            <i class="bi bi-info-circle me-1"></i>Menampilkan mahasiswa dari kelas {{ $userClass }} saja
                        </small>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row m-0 p-4 border-bottom">
                <div class="col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-people text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Total Mahasiswa</h6>
                                    <h4 class="fw-bold text-primary mb-0">{{ count($students) }}</h4>
                                    <small class="text-muted">Mahasiswa aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-wallet2 text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Total Tabungan</h6>
                                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($students->sum('total_savings'), 0, ',', '.') }}</h4>
                                    <small class="text-muted">Tabungan terkumpul</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-arrow-left-right text-info fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Total Transaksi</h6>
                                    <h4 class="fw-bold text-info mb-0">{{ $students->sum('total_transactions') }}</h4>
                                    <small class="text-muted">Transaksi disetujui</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-calendar-month text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Tabungan Bulan Ini</h6>
                                    <h4 class="fw-bold text-warning mb-0">Rp {{ number_format($students->sum('monthly_savings'), 0, ',', '.') }}</h4>
                                    <small class="text-muted">Bulan {{ now()->format('M') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="p-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-list-ul me-2 text-primary"></i>Daftar Mahasiswa 
                        <span class="badge bg-primary ms-2">{{ count($students) }} orang</span>
                    </h6>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th wire:click="sortBy('name')" style="cursor: pointer;" class="w-25">
                                    <div class="d-flex align-items-center">
                                        Nama Mahasiswa
                                        @if($sortBy === 'name')
                                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="w-25">Email</th>
                                <th wire:click="sortBy('total_savings')" style="cursor: pointer;" class="w-20">
                                    <div class="d-flex align-items-center">
                                        Total Tabungan
                                        @if($sortBy === 'total_savings')
                                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @endif
                                    </div>
                                </th>
                                <th class="w-20">Progress Tabungan</th>
                                <th class="w-10">Total Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $student->name }}</strong>
                                            <small class="text-muted">Kelas: {{ $student->class }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $student->email }}</small>
                                    </td>
                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($student->total_savings, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <div class="progress mb-2" style="height: 20px;">
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
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-people display-6 d-block mb-2"></i>
                                        <span class="fw-medium">
                                            @if($search)
                                                Tidak ditemukan mahasiswa dengan kata kunci "{{ $search }}"
                                            @else
                                                Tidak ada data mahasiswa di kelas {{ $userClass }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Progress Distribution -->
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-pie-chart me-2 text-primary"></i>Distribusi Progress Tabungan - Kelas {{ $userClass }}
                    </h6>
                </div>
                
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
                                    <span class="fw-bold text-dark">{{ $label }}</span>
                                    <span class="text-muted">{{ $count }} mahasiswa</span>
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
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="fw-semibold text-dark mb-3 text-center">Statistik Kelas</h6>
                                <div class="text-center">
                                    <div class="mb-3 p-3 bg-light rounded">
                                        <small class="text-muted d-block">Rata-rata Tabungan</small>
                                        <div class="fw-bold text-success fs-5">Rp {{ number_format($students->avg('total_savings'), 0, ',', '.') }}</div>
                                    </div>
                                    <div class="mb-3 p-3 bg-light rounded">
                                        <small class="text-muted d-block">Rata-rata Progress</small>
                                        <div class="fw-bold text-primary fs-5">{{ number_format($students->avg('progress_percentage'), 1) }}%</div>
                                    </div>
                                    <div class="p-3 bg-light rounded">
                                        <small class="text-muted d-block">Top Saver</small>
                                        <div class="fw-bold text-dark">
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
    </div>
</div>