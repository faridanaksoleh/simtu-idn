<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Kelola Kategori</h4>
            <button wire:click="resetInputFields" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#kategoriModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
                            <th width="15%">Tipe</th>
                            <th>Deskripsi</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $kategori)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $kategori->name }}</td>
                                <td>
                                    <span class="badge {{ $kategori->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $kategori->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td>{{ $kategori->description ?: '-' }}</td>
                                <td>
                                    <span class="badge {{ $kategori->is_active ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button wire:click="edit({{ $kategori->id }})" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#kategoriModal" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button 
                                            wire:confirm="Yakin mau menghapus kategori ini?" 
                                            wire:click="delete({{ $kategori->id }})" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-folder-x display-5 text-muted"></i>
                                    <p class="text-muted mt-3">Belum ada kategori</p>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriModalLabel">
                        <i class="bi {{ $isEdit ? 'bi-pencil-square' : 'bi-folder-plus' }} me-2"></i>
                        {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Transportasi">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe</label>
                            <select wire:model="type" class="form-select @error('type') is-invalid @enderror">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea wire:model="description" class="form-control" placeholder="Opsional..."></textarea>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActive">
                            <label class="form-check-label" for="isActive">Aktifkan kategori ini</label>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    @if($isEdit)
                        <button wire:click="update" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="update">
                                <i class="bi bi-check-circle me-1"></i>Update
                            </span>
                            <span wire:loading wire:target="update">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Memproses...
                            </span>
                        </button>
                    @else
                        <button wire:click="store" class="btn btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="store">
                                <i class="bi bi-save me-1"></i>Simpan
                            </span>
                            <span wire:loading wire:target="store">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                Menyimpan...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
`
