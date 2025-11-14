<div>
    <div class="pagetitle">
        <h1 class="fw-bold text-primary">Profil Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active text-dark fw-semibold">Profil</li>
            </ol>
        </nav>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <span class="fw-medium">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-4">
                    <div class="position-relative d-inline-block mb-3">
                        @if($current_photo)
                            <img src="{{ Storage::url($current_photo) }}" alt="Profile" 
                                 class="rounded-circle shadow border border-4 border-white" 
                                 width="140" height="140" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center mx-auto shadow" 
                                 style="width: 140px; height: 140px;">
                                <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
                            </div>
                        @endif
                        @if($photo)
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-3 border-white rounded-circle">
                                <i class="bi bi-arrow-up-circle-fill text-white small"></i>
                            </span>
                        @endif
                    </div>

                    <h4 class="fw-bold text-dark mb-2">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-3">
                        <i class="bi bi-envelope me-1"></i>
                        {{ Auth::user()->email }}
                    </p>
                    <span class="badge bg-danger bg-gradient px-3 py-2 mb-3">
                        <i class="bi bi-shield-check me-1"></i>Administrator
                    </span>

                    <div class="mt-3">
                        <label class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-camera me-2"></i>Ganti Foto
                            <input type="file" class="d-none" wire:model="photo" accept="image/*">
                        </label>
                        @error('photo') 
                            <small class="text-danger d-block mt-2">{{ $message }}</small> 
                        @enderror
                        @if($photo)
                            <small class="text-success d-block mt-2">
                                <i class="bi bi-check-circle me-1"></i>Foto baru dipilih
                            </small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-semibold text-white">
                        <i class="bi bi-info-circle me-2"></i>Informasi Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-person-badge text-primary fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Role</small>
                            <strong class="text-dark">Administrator</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-calendar-check text-primary fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Bergabung</small>
                            <strong class="text-dark">{{ Auth::user()->created_at->format('d M Y') }}</strong>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center p-3 bg-light rounded">
                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-clock text-primary fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Terakhir Login</small>
                            <strong class="text-dark">
                                {{ Auth::user()->last_login ? Auth::user()->last_login->diffForHumans() : 'Belum ada' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="bi bi-pencil-square me-2"></i>Edit Informasi Profil
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="updateProfile">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" wire:model="name" 
                                           placeholder="Masukkan nama lengkap">
                                </div>
                                @error('name') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" wire:model="email" 
                                           placeholder="email@example.com">
                                </div>
                                @error('email') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-phone text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" wire:model="phone" 
                                           placeholder="081234567890">
                                </div>
                                @error('phone') <small class="text-danger mt-1">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 pt-4 mt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                                </span>
                                <span wire:loading>
                                    <i class="bi bi-arrow-repeat spinner me-1"></i>Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Spacer saja, tanpa card tambahan -->
            <div class="mt-4"></div>
        </div>
    </div>
</div>