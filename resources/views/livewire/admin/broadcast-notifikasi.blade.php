<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Broadcast Notifikasi</h4>
            <p class="text-muted">Kirim notifikasi ke semua mahasiswa atau semua pengguna</p>

            <form wire:submit.prevent="broadcast">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Target *</label>
                        <select class="form-select" wire:model="target">
                            <option value="students">Semua Mahasiswa</option>
                            <option value="all">Semua Pengguna</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Tipe Notifikasi *</label>
                        <select class="form-select" wire:model="type">
                            <option value="info">Info</option>
                            <option value="success">Success</option>
                            <option value="warning">Warning</option>
                            <option value="danger">Danger</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Judul *</label>
                        <input type="text" class="form-control" placeholder="Contoh: Informasi Penting" 
                               wire:model="title">
                        @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pesan *</label>
                        <textarea class="form-control" rows="4" 
                                  placeholder="Tulis pesan notifikasi..."
                                  wire:model="message"></textarea>
                        @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i>Kirim Broadcast
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>