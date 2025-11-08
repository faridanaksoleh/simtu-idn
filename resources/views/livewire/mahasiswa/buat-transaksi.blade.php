<div>
  @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form wire:submit.prevent="save" enctype="multipart/form-data" class="card p-4 shadow-sm">
    
    <!-- Pilihan Jenis Transaksi -->
    <div class="mb-3">
      <label class="form-label">Jenis Transaksi</label>
      <div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" wire:model.live="transaction_type" id="income" value="income">
          <label class="form-check-label" for="income">
            Setoran (Pemasukan)
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" wire:model.live="transaction_type" id="expense" value="expense">
          <label class="form-check-label" for="expense">
            Penarikan (Pengeluaran)
          </label>
        </div>
      </div>
      @error('transaction_type') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">
        @if($transaction_type == 'income')
          Jumlah Setoran
        @else
          Jumlah Penarikan
        @endif
      </label>
      <input type="number" class="form-control" wire:model="amount" placeholder="contoh: 50000">
      @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">
        @if($transaction_type == 'income')
          Kategori Setoran
        @else
          Tujuan Penarikan
        @endif
      </label>
      <select class="form-select" wire:model="category_id">
        <option value="">-- Pilih Kategori --</option>
        @foreach ($categories as $cat)
          <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
      </select>
      @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">
        @if($transaction_type == 'income')
          Deskripsi Setoran
        @else
          Alasan Penarikan
        @endif
      </label>
      <textarea class="form-control" wire:model="description" 
        placeholder="@if($transaction_type == 'income') Contoh: Setoran bulan Januari @else Contoh: Untuk biaya semester @endif"></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">
        @if($transaction_type == 'income')
          Upload Bukti Pembayaran
        @else
          Upload Dokumen Pendukung
        @endif
      </label>
      <input type="file" class="form-control" wire:model="bukti">
      <div class="form-text">
        @if($transaction_type == 'income')
          Bukti transfer, tunai, atau QRIS
        @else
          Dokumen pendukung penarikan
        @endif
      </div>
      <div wire:loading wire:target="bukti" class="text-muted small">Mengunggah...</div>
      @error('bukti') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn 
      @if($transaction_type == 'income') btn-primary @else btn-warning @endif">
      @if($transaction_type == 'income')
        Simpan Setoran
      @else
        Ajukan Penarikan
      @endif
    </button>
  </form>
</div>