<div>
    <div class="card border-0 shadow-sm">
        <!-- HEADER DENGAN BIRU TUA & FONT KECIL -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-people me-2"></i>Kelola User
            </h5>
            <button wire:click="resetInputFields" class="btn btn-light btn-sm d-flex align-items-center px-3 py-1" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="bi bi-plus-circle me-1"></i>Tambah User
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
                            <th class="py-3 border-bottom-0">User</th>
                            <th class="py-3 border-bottom-0">Kontak</th>
                            <th width="10%" class="py-3 border-bottom-0">Role</th>
                            <th width="15%" class="py-3 border-bottom-0">Detail Akademik</th>
                            <th width="8%" class="text-center py-3 border-bottom-0">Status</th>
                            <th width="18%" class="text-center py-3 border-bottom-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr class="align-middle border-bottom">
                                <td class="text-center">
                                    <span class="text-muted fw-semibold">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        @if($user->phone)
                                            <i class="bi bi-telephone me-1"></i>{{ $user->phone }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <!-- ROLE BADGE ABU-ABU NETRAL -->
                                    <span class="badge rounded-pill px-3 py-2 bg-secondary text-white">
                                        <i class="bi 
                                            @if($user->role == 'admin') bi-shield-check
                                            @elseif($user->role == 'koordinator') bi-person-badge
                                            @else bi-person @endif me-1">
                                        </i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->role == 'mahasiswa')
                                        <div class="small">
                                            <div class="text-muted">
                                                <i class="bi bi-book me-1"></i>{{ $user->major ?? '-' }}
                                            </div>
                                            <div class="text-muted">
                                                <i class="bi bi-people me-1"></i>{{ $user->class ?? '-' }}
                                            </div>
                                            <div class="text-muted">
                                                <i class="bi bi-card-text me-1"></i>{{ $user->nim ?? '-' }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button wire:click="edit({{ $user->id }})" 
                                                class="btn btn-outline-primary d-flex align-items-center px-3" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#userModal" 
                                                title="Edit User">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>
                                        <!-- 🔥 GUNAKAN confirmDelete DENGAN SWEETALERT -->
                                        <button wire:click="confirmDelete({{ $user->id }})" 
                                                class="btn btn-outline-danger d-flex align-items-center px-3" 
                                                title="Hapus User">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State -->
            @if($users->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-people display-4 text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted mb-2">Belum ada data user</h5>
                    <p class="text-muted mb-4">Klik tombol "Tambah User" untuk menambahkan user pertama</p>
                    <button wire:click="resetInputFields" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#userModal">
                        <i class="bi bi-plus-circle me-2"></i>Tambah User Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light border-0 py-3">
                    <h5 class="modal-title text-dark fw-semibold" id="userModalLabel">
                        <i class="bi {{ $isEdit ? 'bi-pencil-square text-warning' : 'bi-person-plus text-primary' }} me-2"></i>
                        {{ $isEdit ? 'Edit User' : 'Tambah User Baru' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person me-1 text-primary"></i>Nama Lengkap *
                                    </label>
                                    <input type="text" wire:model="name" class="form-control border @error('name') is-invalid @enderror" id="name" placeholder="Masukkan nama lengkap">
                                    @error('name')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-envelope me-1 text-primary"></i>Email *
                                    </label>
                                    <input type="email" wire:model="email" class="form-control border @error('email') is-invalid @enderror" id="email" placeholder="Masukkan alamat email">
                                    @error('email')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-lock me-1 text-primary"></i>Password {{ $isEdit ? '' : '*' }}
                                    </label>
                                    <input type="password" wire:model="password" class="form-control border @error('password') is-invalid @enderror" id="password" placeholder="{{ $isEdit ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password' }}">
                                    @error('password')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person-badge me-1 text-primary"></i>Role *
                                    </label>
                                    <select wire:model="role" class="form-select border @error('role') is-invalid @enderror" id="role">
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin">Admin</option>
                                        <option value="koordinator">Koordinator</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-telephone me-1 text-primary"></i>Nomor Telepon
                                    </label>
                                    <input type="text" wire:model="phone" class="form-control border @error('phone') is-invalid @enderror" id="phone" placeholder="Masukkan nomor telepon">
                                    @error('phone')
                                        <div class="invalid-feedback d-flex align-items-center">
                                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            </div>
                        </div>

                        <!-- FIELD KHUSUS MAHASISWA -->
                        <div id="mahasiswaFields" style="display: {{ $role == 'mahasiswa' ? 'block' : 'none' }};">
                            <hr>
                            <h6 class="fw-semibold text-primary mb-3">
                                <i class="bi bi-mortarboard me-2"></i>Data Akademik Mahasiswa
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="nim" class="form-label fw-semibold text-dark">NIM *</label>
                                        <input type="text" wire:model="nim" class="form-control border @error('nim') is-invalid @enderror" id="nim" placeholder="Masukkan NIM">
                                        @error('nim')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="major" class="form-label fw-semibold text-dark">Jurusan *</label>
                                        <select wire:model="major" class="form-select border @error('major') is-invalid @enderror" id="major">
                                            <option value="">-- Pilih Jurusan --</option>
                                            <option value="TRPL">TRPL</option>
                                            <option value="TRMG">TRMG</option>
                                            <option value="TRKJ">TRKJ</option>
                                        </select>
                                        @error('major')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="class" class="form-label fw-semibold text-dark">Kelas *</label>
                                        <select wire:model="class" class="form-select border @error('class') is-invalid @enderror" id="class" 
                                                {{ empty($major) ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Kelas --</option>
                                            
                                            <!-- TRPL Classes -->
                                            @if($major == 'TRPL')
                                                <option value="TRPL-A">TRPL-A</option>
                                                <option value="TRPL-B">TRPL-B</option>
                                                <option value="TRPL-C">TRPL-C</option>
                                                <option value="TRPL-D">TRPL-D</option>
                                            
                                            <!-- TRMG Classes -->
                                            @elseif($major == 'TRMG')
                                                <option value="TRMG-A">TRMG-A</option>
                                                <option value="TRMG-B">TRMG-B</option>
                                            
                                            <!-- TRKJ Classes -->
                                            @elseif($major == 'TRKJ')
                                                <option value="TRKJ-A">TRKJ-A</option>
                                                <option value="TRKJ-B">TRKJ-B</option>
                                                <option value="TRKJ-C">TRKJ-C</option>
                                                <option value="TRKJ-D">TRKJ-D</option>
                                            @endif
                                        </select>
                                        @error('class')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                        
                                        <!-- Info Text -->
                                        @if(empty($major))
                                            <div class="form-text text-muted">Pilih jurusan terlebih dahulu</div>
                                        @endif
                                    </div>
                                </div>
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
// TOGGLE FIELD MAHASISWA BERDASARKAN ROLE
document.addEventListener('livewire:init', () => {
    Livewire.on('roleChanged', (role) => {
        const mahasiswaFields = document.getElementById('mahasiswaFields');
        if (role === 'mahasiswa') {
            mahasiswaFields.style.display = 'block';
        } else {
            mahasiswaFields.style.display = 'none';
        }
    });
    
    // 🔥 HANDLE CHANGE JURUSAN UNTUK UPDATE KELAS
    Livewire.on('majorChanged', (major) => {
        const classSelect = document.getElementById('class');
        if (major) {
            classSelect.disabled = false;
        } else {
            classSelect.disabled = true;
            classSelect.value = '';
        }
    });
});

// Listen untuk perubahan role di select
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            Livewire.dispatch('roleChanged', { role: this.value });
        });
    }
    
    // 🔥 LISTEN UNTUK PERUBAHAN JURUSAN
    const majorSelect = document.getElementById('major');
    if (majorSelect) {
        majorSelect.addEventListener('change', function() {
            Livewire.dispatch('majorChanged', { major: this.value });
        });
    }
});

// Handler untuk close modal
Livewire.on('closeModal', () => {
    const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
    if (modal) {
        modal.hide();
    }
});
</script>