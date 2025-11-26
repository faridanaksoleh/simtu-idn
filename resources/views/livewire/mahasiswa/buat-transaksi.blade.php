<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h6 class="fw-semibold text-dark mb-4">
                <i class="bi bi-plus-circle me-2 text-primary"></i>Form Transaksi Baru
            </h6>
            
            <form wire:submit.prevent="save" enctype="multipart/form-data">
                <!-- Pilihan Jenis Transaksi -->
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">
                        <i class="bi bi-arrow-left-right me-1 text-primary"></i>Jenis Transaksi *
                    </label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model.live="transaction_type" id="income" value="income">
                            <label class="form-check-label fw-medium" for="income">
                                <i class="bi bi-arrow-down-circle text-success me-1"></i>Setoran (Pemasukan)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" wire:model.live="transaction_type" id="expense" value="expense">
                            <label class="form-check-label fw-medium" for="expense">
                                <i class="bi bi-arrow-up-circle text-warning me-1"></i>Penarikan (Pengeluaran)
                            </label>
                        </div>
                    </div>
                    @error('transaction_type') 
                        <div class="text-danger small mt-1 d-flex align-items-center">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-cash-coin me-1 text-primary"></i>
                            @if($transaction_type == 'income')
                                Jumlah Setoran *
                            @else
                                Jumlah Penarikan *
                            @endif
                        </label>
                        <input type="number" class="form-control border @error('amount') is-invalid @enderror" 
                               wire:model="amount" placeholder="Contoh: 50000">
                        @error('amount') 
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-tags me-1 text-primary"></i>
                            @if($transaction_type == 'income')
                                Kategori Setoran *
                            @else
                                Tujuan Penarikan *
                            @endif
                        </label>
                        <select class="form-select border @error('category_id') is-invalid @enderror" wire:model="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') 
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-chat-text me-1 text-primary"></i>
                            @if($transaction_type == 'income')
                                Deskripsi Setoran
                            @else
                                Alasan Penarikan
                            @endif
                        </label>
                        <textarea class="form-control border" rows="3" wire:model="description" 
                            placeholder="@if($transaction_type == 'income') Contoh: Setoran bulan Januari @else Contoh: Untuk biaya semester @endif"></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-paperclip me-1 text-primary"></i>
                            @if($transaction_type == 'income')
                                Upload Bukti Pembayaran
                            @else
                                Upload Dokumen Pendukung
                            @endif
                        </label>
                        <input type="file" class="form-control border @error('bukti') is-invalid @enderror" wire:model="bukti">
                        <div class="form-text text-muted">
                            @if($transaction_type == 'income')
                                <i class="bi bi-info-circle me-1"></i>Bukti transfer, tunai, atau QRIS (Max: 2MB)
                            @else
                                <i class="bi bi-info-circle me-1"></i>Dokumen pendukung penarikan (Max: 2MB)
                            @endif
                        </div>
                        <div wire:loading wire:target="bukti" class="text-primary small mt-1">
                            <i class="bi bi-arrow-up-circle me-1"></i>Mengunggah...
                        </div>
                        @error('bukti') 
                            <div class="text-danger small mt-1 d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                      <div class="col-12">
                          <div class="d-flex justify-content-end pt-3 border-top">
                              <button type="submit" class="btn 
                                  @if($transaction_type == 'income') btn-primary @else btn-warning @endif 
                                  d-flex align-items-center px-3" 
                                  wire:loading.attr="disabled">
                                  <span wire:loading.remove>
                                      <i class="bi bi-check-circle me-1"></i>
                                      @if($transaction_type == 'income')
                                          Simpan Setoran
                                      @else
                                          Ajukan Penarikan
                                      @endif
                                  </span>
                                  <span wire:loading>
                                      <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                      @if($transaction_type == 'income')
                                          Menyimpan...
                                      @else
                                          Mengajukan...
                                      @endif
                                  </span>
                              </button>
                          </div>
                      </div>
                </div>
            </form>
        </div>
    </div>
</div>