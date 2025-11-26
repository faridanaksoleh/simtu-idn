<div>
    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h6 class="fw-semibold text-dark mb-4">
                <i class="bi bi-funnel me-2 text-primary"></i>Filter Riwayat
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-dark">Cari Transaksi</label>
                    <input type="text" class="form-control border" 
                           placeholder="Cari berdasarkan kategori atau jumlah..." 
                           wire:model.live.500ms="search">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-dark">Status</label>
                    <select class="form-select border" wire:model.live="status">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>  
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-dark">&nbsp;</label>
                    <div class="d-grid">
                        <!-- 🔥 PERBAIKAN: Reset filter dengan method -->
                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
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
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="w-20 ps-4">Tanggal</th> <!-- 🔥 TAMBAH PADDING -->
                            <th class="w-25">Kategori</th>
                            <th class="w-20">Jumlah</th>
                            <th class="w-15">Status</th>
                            <th class="w-20 pe-4">Bukti</th> <!-- 🔥 TAMBAH PADDING -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr>
                                <td class="ps-4"> <!-- 🔥 TAMBAH PADDING -->
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium">{{ $trx->created_at->format('d/m/Y') }}</span>
                                        <small class="text-muted">{{ $trx->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-dark">{{ $trx->category->name ?? '-' }}</span>
                                </td>
                                <td>
                                    @if($trx->amount < 0)
                                        <span class="text-danger fw-bold">
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            -Rp{{ number_format(abs($trx->amount), 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-success fw-bold">
                                            <i class="bi bi-arrow-down-circle me-1"></i>
                                            +Rp{{ number_format($trx->amount, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $trx->status == 'approved' ? 'success' : ($trx->status == 'rejected' ? 'danger' : 'warning') }}">
                                        @if($trx->status == 'approved')
                                            <i class="bi bi-check-circle me-1"></i>Disetujui
                                        @elseif($trx->status == 'rejected')
                                            <i class="bi bi-x-circle me-1"></i>Ditolak
                                        @else
                                            <i class="bi bi-clock me-1"></i>Pending
                                        @endif
                                    </span>
                                </td>
                                <td class="pe-4"> <!-- 🔥 TAMBAH PADDING -->
                                    @if ($trx->payment_proof)
                                        <!-- 🔥 PERBAIKAN: Button Lihat lebih kecil -->
                                        <a href="{{ Storage::url($trx->payment_proof) }}" target="_blank" 
                                           class="btn btn-outline-primary btn-sm d-inline-flex align-items-center px-2 py-1"> <!-- 🔥 TAMBAH py-1 -->
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
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-wallet display-6 d-block mb-3 text-primary"></i>
                                    <h5 class="text-primary mb-3">Belum Ada Transaksi</h5>
                                    <p class="text-muted">Transaksi yang Anda buat akan muncul di sini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
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