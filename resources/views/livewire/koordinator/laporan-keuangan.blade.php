<div>
    <div class="pagetitle">
        <h1>Laporan Keuangan Kelas {{ $userClass }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('koordinator.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Keuangan</li>
            </ol>
            
            <!-- Flash Messages -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </nav>
    </div>

    <!-- Filter Section -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Filter Laporan Kelas {{ $userClass }}</h5>
            <form wire:submit.prevent="generateReport">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" wire:model.live="startDate">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" wire:model.live="endDate">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tipe Transaksi</label>
                        <select class="form-select" wire:model.live="reportType">
                            <option value="all">Semua</option>
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-1"></i>Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Total Pemasukan</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-down-circle text-success"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Rp {{ number_format($totalIncome, 0, ',', '.') }}</h6>
                            <span class="text-success small pt-1 fw-bold">Pemasukan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Total Pengeluaran</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-up-circle text-danger"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Rp {{ number_format($totalExpense, 0, ',', '.') }}</h6>
                            <span class="text-danger small pt-1 fw-bold">Pengeluaran</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Saldo Bersih</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2 {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }}"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Rp {{ number_format($netBalance, 0, ',', '.') }}</h6>
                            <span class="{{ $netBalance >= 0 ? 'text-success' : 'text-danger' }} small pt-1 fw-bold">
                                {{ $netBalance >= 0 ? 'Surplus' : 'Defisit' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Export Laporan Kelas {{ $userClass }}</h5>
                        <div class="btn-group">
                            <button class="btn btn-success" wire:click="exportPDF">
                                <i class="bi bi-file-pdf me-1"></i>Export PDF
                            </button>
                            <button class="btn btn-primary" wire:click="exportExcel">
                                <i class="bi bi-file-spreadsheet me-1"></i>Export Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Detail Transaksi ({{ count($transactions) }} records)</h5>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Mahasiswa</th>
                            <th>Tipe</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <strong>{{ $transaction->user->name }}</strong>
                                    <br><small class="text-muted">{{ $transaction->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->category->name }}</td>
                                <td class="{{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $transaction->amount >= 0 ? '+' : '-' }}Rp{{ number_format(abs($transaction->amount), 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $transaction->status === 'approved' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>{{ $transaction->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                    Tidak ada transaksi pada periode yang dipilih
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Student Statistics -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Statistik Mahasiswa Kelas {{ $userClass }}</h5>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Total Transaksi</th>
                            <th>Total Tabungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($studentStats as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->total_transactions }}</td>
                                <td class="text-success fw-bold">
                                    Rp {{ number_format($student->total_savings, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-people display-4 d-block mb-2"></i>
                                    Tidak ada data mahasiswa pada periode yang dipilih
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>