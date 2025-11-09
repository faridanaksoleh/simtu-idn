<div>
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <input type="text" class="form-control" placeholder="Cari kategori atau jumlah" 
                wire:model.live="search" style="min-width: 300px;">
        
        <select class="form-select w-auto" wire:model.live="status" style="min-width: 150px;">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Disetujui</option>
            <option value="rejected">Ditolak</option>
        </select>

        <select class="form-select w-auto" wire:model.live="userFilter" style="min-width: 180px;">
            <option value="">Semua User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

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
                            <th>Status</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            <tr>
                                <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $trx->user->name }}</td>
                                <td>{{ $trx->category->name }}</td>
                                <td>
                                    <span class="{{ $trx->amount < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $trx->amount < 0 ? '-' : '+' }}Rp{{ number_format(abs($trx->amount), 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $trx->status == 'approved' ? 'success' : ($trx->status == 'rejected' ? 'danger' : 'warning') }}">
                                        @if($trx->status === 'pending')
                                            pending
                                        @elseif($trx->status === 'approved')
                                            approved
                                        @else
                                            rejected
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if ($trx->payment_proof)
                                        <a href="{{ Storage::url($trx->payment_proof) }}" target="_blank" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-receipt fs-1 d-block mb-2"></i>
                                    Belum ada transaksi
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
                    dari {{ $transactions->total() }} transaksi
                </div>
                <div>
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>