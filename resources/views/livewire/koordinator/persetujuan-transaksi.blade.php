<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <input type="text" class="form-control" placeholder="Cari transaksi pending..." 
                   wire:model.live="search" style="min-width: 300px;">
        </div>
        <div class="text-end">
            <div class="text-warning mb-1">
                <i class="bi bi-clock-history"></i> 
                {{ $pendingCount }} transaksi menunggu persetujuan
            </div>
            <div class="text-info small">
                <i class="bi bi-building"></i> 
                Kelas Bimbingan: <strong>{{ Auth::user()->class }}</strong>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tambah info di tabel header -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-check me-2"></i>
                Persetujuan Transaksi - Kelas {{ Auth::user()->class }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Kelas</th> <!-- Tambah kolom kelas -->
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr>
                                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <strong>{{ $trx->user->name }}</strong>
                                    <br><small class="text-muted">{{ $trx->user->email }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $trx->user->class }}</span>
                                </td>
                                <td>{{ $trx->category->name }}</td>
                                <td>
                                    <span class="{{ $trx->amount < 0 ? 'text-danger' : 'text-success' }} fw-bold">
                                        {{ $trx->amount < 0 ? '-' : '+' }}Rp{{ number_format(abs($trx->amount), 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>{{ $trx->description ?? '-' }}</td>
                                <td>
                                    @if ($trx->payment_proof)
                                        <a href="{{ asset('storage/' . $trx->payment_proof) }}" target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-success" 
                                                wire:click="approve({{ $trx->id }})"
                                                wire:confirm="Setujui transaksi ini?"
                                                title="Approve">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                        <button class="btn btn-danger" 
                                                wire:click="reject({{ $trx->id }})"
                                                wire:confirm="Tolak transaksi ini?"
                                                title="Reject">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                                    Tidak ada transaksi yang menunggu persetujuan di kelas {{ Auth::user()->class }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} 
                    dari {{ $transactions->total() }} transaksi pending di kelas {{ Auth::user()->class }}
                </div>
                <div>
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>