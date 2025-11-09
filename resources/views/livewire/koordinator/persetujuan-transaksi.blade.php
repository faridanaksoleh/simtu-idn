<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <input type="text" class="form-control" placeholder="Cari transaksi pending..." 
                   wire:model.live="search" style="min-width: 300px;">
        </div>
        <div class="text-warning">
            <i class="bi bi-clock-history"></i> 
            {{ $pendingCount }} transaksi menunggu persetujuan
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>User</th>
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                                    Tidak ada transaksi yang menunggu persetujuan
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
                    dari {{ $transactions->total() }} transaksi pending
                </div>
                <div>
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>