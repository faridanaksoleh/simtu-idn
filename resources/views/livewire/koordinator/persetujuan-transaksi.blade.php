<div>
    <!-- Filter dan Info Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <h6 class="fw-semibold text-dark mb-3">
                        <i class="bi bi-funnel me-2 text-primary"></i>Filter Transaksi Pending
                    </h6>
                    <input type="text" class="form-control border" 
                           placeholder="Cari berdasarkan nama, email, kategori, atau jumlah..." 
                           wire:model.live.500ms="search">
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end gap-3">
                        <!-- Card Menunggu Persetujuan -->
                        <div class="card border-0 bg-warning text-dark" style="min-width: 160px;">
                            <div class="card-body py-2 px-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history fs-5 me-2"></i>
                                    <div>
                                        <div class="fw-bold fs-6">{{ $pendingCount }}</div>
                                        <div class="small">Menunggu</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Kelas Bimbingan -->
                        <div class="card border-0 bg-primary text-white" style="min-width: 140px;">
                            <div class="card-body py-2 px-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-building fs-5 me-2"></i>
                                    <div>
                                        <div class="fw-bold fs-6">{{ Auth::user()->class }}</div>
                                        <div class="small">Kelas</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 bg-light">
            <h6 class="fw-semibold text-dark mb-0">
                <i class="bi bi-list-check me-2 text-primary"></i>Daftar Persetujuan Transaksi
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Mahasiswa</th>
                            <th>Kelas</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Bukti</th>
                            <th class="pe-4">Aksi</th>
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
                                        <small class="text-muted">{{ $trx->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $trx->user->class }}</span>
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
                                    <span class="text-muted">{{ $trx->description ?? '-' }}</span>
                                </td>
                                <td>
                                    @if ($trx->payment_proof)
                                        <a href="{{ asset('storage/' . $trx->payment_proof) }}" target="_blank" 
                                           class="btn btn-outline-primary btn-sm d-inline-flex align-items-center px-2 py-1">
                                            <i class="bi bi-eye me-1" style="font-size: 0.8rem;"></i>
                                            <span style="font-size: 0.8rem;">Lihat</span>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-2">
                                        <!-- 🔥 PERBAIKAN: Ganti wire:click ke confirmApprove dan HAPUS wire:confirm -->
                                        <button class="btn btn-outline-success btn-sm d-flex align-items-center px-3" 
                                                wire:click="confirmApprove({{ $trx->id }})"
                                                title="Approve"
                                                onmouseover="this.classList.add('btn-success', 'text-white'); this.classList.remove('btn-outline-success')"
                                                onmouseout="this.classList.remove('btn-success', 'text-white'); this.classList.add('btn-outline-success')">
                                            <i class="bi bi-check-lg me-1"></i>Approve
                                        </button>
                                        
                                        <!-- 🔥 PERBAIKAN: Ganti wire:click ke confirmReject dan HAPUS wire:confirm -->
                                        <button class="btn btn-outline-danger btn-sm d-flex align-items-center px-3" 
                                                wire:click="confirmReject({{ $trx->id }})"
                                                title="Reject"
                                                onmouseover="this.classList.add('btn-danger', 'text-white'); this.classList.remove('btn-outline-danger')"
                                                onmouseout="this.classList.remove('btn-danger', 'text-white'); this.classList.add('btn-outline-danger')">
                                            <i class="bi bi-x-lg me-1"></i>Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-check-circle display-6 d-block mb-3 text-primary"></i>
                                    <h5 class="text-primary mb-3">Tidak Ada Transaksi Pending</h5>
                                    <p class="text-muted">Semua transaksi dari kelas {{ Auth::user()->class }} sudah diproses</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                <div class="text-muted small">
                    Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} 
                    dari {{ $transactions->total() }} transaksi pending
                </div>
                <div>
                    {{ $transactions->links() }}
                </div>
            </div>
            @elseif($transactions->total() > 0)
            <div class="text-center text-muted small p-4 border-top">
                Total {{ $transactions->total() }} transaksi pending
            </div>
            @endif
        </div>
    </div>
</div>