<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-graph-up me-2"></i>Laporan Keuangan Kelas {{ $userClass }}
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Filter Section -->
            <div class="p-4 border-bottom">
                <h6 class="fw-semibold text-dark mb-3">
                    <i class="bi bi-funnel me-2 text-primary"></i>Filter Laporan Kelas {{ $userClass }}
                </h6>
                <form wire:submit.prevent="generateReport">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Tanggal Mulai</label>
                            <input type="date" class="form-control border" wire:model.live="startDate">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">Tanggal Akhir</label>
                            <input type="date" class="form-control border" wire:model.live="endDate">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-dark">Tipe Transaksi</label>
                            <select class="form-control border" wire:model.live="reportType">
                                <option value="all">Semua</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-filter me-1"></i>Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="row m-0 p-4 border-bottom">
                <div class="col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-arrow-down-circle text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Total Pemasukan</h6>
                                    <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
                                    <small class="text-muted">Pemasukan disetujui</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-arrow-up-circle text-danger fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Total Pengeluaran</h6>
                                    <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h4>
                                    <small class="text-muted">Pengeluaran disetujui</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="{{ $netBalance >= 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-wallet2 {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }} fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Saldo Bersih</h6>
                                    <h4 class="fw-bold {{ $netBalance >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                                        Rp {{ number_format($netBalance, 0, ',', '.') }}
                                    </h4>
                                    <small class="text-muted">{{ $netBalance >= 0 ? 'Surplus' : 'Defisit' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Buttons -->
            <div class="p-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-download me-2 text-primary"></i>Export Laporan Kelas {{ $userClass }}
                    </h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success d-flex align-items-center px-3" wire:click="exportPDF"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="bi bi-file-pdf me-2"></i>Export PDF
                            </span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Generating...
                            </span>
                        </button>
                        <button class="btn btn-primary d-flex align-items-center px-3" wire:click="exportExcel"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="bi bi-file-spreadsheet me-2"></i>Export Excel
                            </span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Generating...
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="p-4 border-bottom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-list-ul me-2 text-primary"></i>Detail Transaksi 
                        <span class="badge bg-primary ms-2">{{ count($transactions) }} records</span>
                    </h6>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Mahasiswa</th>
                                <th>Tipe</th>
                                <th>Kategori</th>
                                <th class="text-end">Jumlah</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="fw-medium">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong class="text-dark">{{ $transaction->user->name }}</strong>
                                            <small class="text-muted">{{ $transaction->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $transaction->category->name }}</span>
                                    </td>
                                    <td class="text-end {{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                        {{ $transaction->amount >= 0 ? '+' : '-' }}Rp{{ number_format(abs($transaction->amount), 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->status === 'approved' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $transaction->description ?? '-' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                        <span class="fw-medium">Tidak ada transaksi pada periode yang dipilih</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Student Statistics -->
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-people me-2 text-primary"></i>Statistik Mahasiswa Kelas {{ $userClass }}
                    </h6>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th class="text-center">Total Transaksi</th>
                                <th class="text-end">Total Tabungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studentStats as $student)
                                <tr>
                                    <td class="fw-medium">{{ $student->name }}</td>
                                    <td>
                                        <small class="text-muted">{{ $student->email }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-dark">{{ $student->total_transactions }}</span>
                                    </td>
                                    <td class="text-end text-success fw-bold">
                                        Rp {{ number_format($student->total_savings, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-people display-6 d-block mb-2"></i>
                                        <span class="fw-medium">Tidak ada data mahasiswa pada periode yang dipilih</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>