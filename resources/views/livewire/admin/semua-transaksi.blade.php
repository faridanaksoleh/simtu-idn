<div>
    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark mb-3 mt-3">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Semua Transaksi
            </h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-dark">Cari Transaksi</label>
                    <input type="text" class="form-control border" 
                           placeholder="Cari kategori atau jumlah..." 
                           wire:model.live.500ms="search">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">Status</label>
                    <select class="form-select border" wire:model.live="status">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-dark">Mahasiswa</label>
                    <select class="form-select border" wire:model.live="userFilter">
                        <option value="">Semua Mahasiswa</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-dark">&nbsp;</label>
                    <div class="d-grid">
                        <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                wire:click="resetFilters">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 bg-light">
            <h6 class="fw-semibold text-dark mb-0">
                <i class="bi bi-list-ul me-2 text-primary"></i>Semua Transaksi Sistem
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Mahasiswa</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th class="pe-4">Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $trx->created_at->format('d/m/Y') }}</span>
                                        <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <strong class="text-dark">{{ $trx->user->name }}</strong>
                                        <small class="text-muted">{{ $trx->user->class }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-dark">{{ $trx->category->name }}</span>
                                </td>
                                <td>
                                    <span class="{{ $trx->amount < 0 ? 'text-danger' : 'text-success' }} fw-bold">
                                        @if($trx->amount < 0)
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            -Rp{{ number_format(abs($trx->amount), 0, ',', '.') }}
                                        @else
                                            <i class="bi bi-arrow-down-circle me-1"></i>
                                            +Rp{{ number_format($trx->amount, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $trx->status == 'approved' ? 'success' : ($trx->status == 'rejected' ? 'danger' : 'warning') }}">
                                        @if($trx->status === 'pending')
                                            <i class="bi bi-clock me-1"></i>Pending
                                        @elseif($trx->status === 'approved')
                                            <i class="bi bi-check-circle me-1"></i>Disetujui
                                        @else
                                            <i class="bi bi-x-circle me-1"></i>Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td class="pe-4">
                                    @if ($trx->payment_proof)
                                        <a href="{{ Storage::url($trx->payment_proof) }}" target="_blank" 
                                           class="btn btn-outline-primary btn-sm d-inline-flex align-items-center px-2 py-1">
                                            <i class="bi bi-eye me-1" style="font-size: 0.8rem;"></i>
                                            <span style="font-size: 0.8rem;">Lihat</span>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-receipt display-6 d-block mb-3 text-primary"></i>
                                    <h5 class="text-primary mb-3">Belum Ada Transaksi</h5>
                                    <p class="text-muted">Transaksi dari mahasiswa akan muncul di sini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔥 PERBAIKAN PAGINATION KONSISTEN -->
            @if($transactions->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} 
                    dari {{ $transactions->total() }} transaksi
                </div>
                <div>
                    {{ $transactions->links() }}
                </div>
            </div>
            @elseif($transactions->total() > 0)
            <div class="text-center text-muted small p-4 border-top">
                Total {{ $transactions->total() }} transaksi
            </div>
            @endif
        </div>
    </div>
</div>