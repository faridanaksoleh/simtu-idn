<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Kelola User</h4>
            <button wire:click="resetInputFields" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah User
            </button>
        </div>

        <div class="card-body">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th width="12%">Role</th>
                            <th width="15%">Tanggal Dibuat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge 
                                        @if($user->role == 'Admin') bg-danger
                                        @elseif($user->role == 'Koordinator') bg-warning
                                        @else bg-info @endif">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#userModal" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button wire:click="delete({{ $user->id }})" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin mau menghapus user ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-people display-4 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada data user</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">
                        <i class="bi {{ $isEdit ? 'bi-pencil-square' : 'bi-person-plus' }} me-2"></i>
                        {{ $isEdit ? 'Edit User' : 'Tambah User' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Masukkan alamat email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="{{ $isEdit ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password' }}">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select wire:model="role" class="form-select @error('role') is-invalid @enderror" id="role">
                                <option value="">-- Pilih Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="Koordinator">Koordinator</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                Memproses...
                            </span>
                        </button>
                    @else
                        <button wire:click="store" class="btn btn-success" wire:loading.attr="disabled">
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