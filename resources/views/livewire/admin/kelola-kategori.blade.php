<div>
    <div class="card border-0 shadow-sm">
        <!-- HEADER DENGAN BIRU TUA & FONT KECIL -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-tags me-2"></i>Kelola Kategori
            </h5>
            <button wire:click="resetInputFields" class="btn btn-light btn-sm d-flex align-items-center px-3 py-1" data-bs-toggle="modal" data-bs-target="#kategoriModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
            </button>
        </div>

        <div class="card-body p-0">
            <!-- Alert Messages -->
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center m-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div class="flex-grow-1">{{ session('message') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center py-3 border-bottom-0">No.</th>
                            <th class="py-3 border-bottom-0">Kategori</th>
                            <th width="12%" class="py-3 border-bottom-0">Tipe</th>
                            <th class="py-3 border-bottom-0">Deskripsi</th>
                            <th width="8%" class="text-center py-3 border-bottom-0">Status</th>
                            <th width="16%" class="text-center py-3 border-bottom-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $kategori)
                            <tr class="align-middle border-bottom">
                                <td class="text-center">
                                    <span class="text-muted fw-semibold">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="bi bi-tag text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $kategori->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 {{ $kategori->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                        <i class="bi {{ $kategori->type == 'income' ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle' }} me-1"></i>
                                        {{ $kategori->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $kategori->description ?: '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $kategori->is_active ? 'success' : 'danger' }}">
                                        {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $kategori->id }})" 
                                                class="btn btn-outline-primary d-flex align-items-center px-3" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#kategoriModal" 
                                                title="Edit Kategori">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>
                                        <button wire:click="confirmDelete({{ $kategori->id }})" 
                                                class="btn btn-outline-danger d-flex align-items-center px-3" 
                                                title="Hapus Kategori">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bi bi-tags display-4 text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">Belum ada data kategori</h5>
                                    <p class="text-muted mb-4">Klik tombol "Tambah Kategori" untuk menambahkan kategori pertama</p>
                                    <button wire:click="resetInputFields" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#kategoriModal">
                                        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Pertama
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light border-0 py-3">
                    <h5 class="modal-title text-dark fw-semibold" id="kategoriModalLabel">
                        <i class="bi {{ $isEdit ? 'bi-pencil-square text-warning' : 'bi-folder-plus text-primary' }} me-2"></i>
                        {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">
                                <i class="bi bi-tag me-1 text-primary"></i>Nama Kategori *
                            </label>
                            <input type="text" wire:model="name" class="form-control border @error('name') is-invalid @enderror" id="name" placeholder="Contoh: Transportasi, Makanan, Gaji">
                            @error('name')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold text-dark">
                                <i class="bi bi-arrow-left-right me-1 text-primary"></i>Tipe *
                            </label>
                            <select wire:model="type" class="form-select border @error('type') is-invalid @enderror" id="type">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">
                                <i class="bi bi-text-paragraph me-1 text-primary"></i>Deskripsi
                            </label>
                            <textarea wire:model="description" class="form-control border" id="description" rows="3" placeholder="Deskripsi kategori (opsional)"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-toggle-on me-1 text-primary"></i>Status
                            </label>
                            <div class="form-check form-switch">
                                <input wire:model="is_active" class="form-check-input" type="checkbox" id="is_active" {{ $is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    {{ $is_active ? 'Aktif' : 'Nonaktif' }}
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center px-3" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    @if($isEdit)
                        <button wire:click="update" class="btn btn-primary d-flex align-items-center px-3" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="update">
                                <i class="bi bi-check-circle me-1"></i>Update
                            </span>
                            <span wire:loading wire:target="update">
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                Memproses...
                            </span>
                        </button>
                    @else
                        <button wire:click="store" class="btn btn-success d-flex align-items-center px-3" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="store">
                                <i class="bi bi-save me-1"></i>Simpan
                            </span>
                            <span wire:loading wire:target="store">
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                Menyimpan...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Handler untuk close modal
Livewire.on('closeModal', () => {
    const modal = bootstrap.Modal.getInstance(document.getElementById('kategoriModal'));
    if (modal) {
        modal.hide();
    }
});
</script>