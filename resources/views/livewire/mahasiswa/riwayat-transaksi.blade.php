<div>
  <div class="d-flex gap-2 mb-3">
    <input type="text" class="form-control" placeholder="Cari kategori atau angka..." wire:model.live="search">
    <select class="form-select w-auto" wire:model.live="status">
      <option value="">Semua</option>
      <option value="pending">Pending</option>
      <option value="approved">Disetujui</option>
      <option value="rejected">Ditolak</option>
    </select>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Kategori</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Bukti</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($transactions as $trx)
        <tr>
          <td>{{ $trx->created_at->format('d/m/Y') }}</td>
          <td>{{ $trx->category->name ?? '-' }}</td>
          <td>
            @if($trx->amount < 0)
              <span class="text-danger">-Rp{{ number_format(abs($trx->amount), 0, ',', '.') }}</span>
            @else
              <span class="text-success">+Rp{{ number_format($trx->amount, 0, ',', '.') }}</span>
            @endif
          </td>
          <td>
            <span class="badge bg-{{ $trx->status == 'approved' ? 'success' : ($trx->status == 'rejected' ? 'danger' : 'warning') }}">
              {{ ucfirst($trx->status) }}
            </span>
          </td>
          <td>
            @if ($trx->payment_proof)
              <a href="{{ Storage::url($trx->payment_proof) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center text-muted py-4">
            Belum ada transaksi
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Simple Pagination dengan Info -->
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
  @else
  <div class="text-center text-muted small mt-3">
    Total {{ $transactions->total() }} transaksi
  </div>
  @endif
</div>