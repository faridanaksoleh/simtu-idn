<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN WARNA KONSISTEN (BIRU) -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-person-gear me-2"></i>Profil Koordinator
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Alert Messages -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center m-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row m-0">
                <!-- Sidebar - Profile Info -->
                <div class="col-lg-4 border-end p-4">
                    <!-- Profile Photo Section -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block mb-3">
                            @if($current_photo)
                                <img src="{{ Storage::url($current_photo) }}" alt="Profile" 
                                     class="rounded-circle shadow border border-4 border-white" 
                                     width="120" height="120" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-warning bg-gradient text-white d-flex align-items-center justify-content-center mx-auto shadow" 
                                     style="width: 120px; height: 120px;">
                                    <i class="bi bi-person-gear" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            @if($photo)
                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-3 border-white rounded-circle">
                                    <i class="bi bi-arrow-up-circle-fill text-white small"></i>
                                </span>
                            @endif
                        </div>

                        <h5 class="fw-bold text-dark mb-2">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-3">
                            <i class="bi bi-envelope me-1"></i>
                            {{ Auth::user()->email }}
                        </p>
                        <span class="badge bg-warning rounded-pill px-3 py-2 mb-3">
                            <i class="bi bi-gear me-1"></i>Koordinator
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

                    <!-- Account Info Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="card-title mb-0 fw-semibold text-dark">
                                <i class="bi bi-info-circle me-2"></i>Informasi Akun
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                <div class="bg-warning bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-gear text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Role</small>
                                    <strong class="text-dark">Koordinator</strong>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-calendar-check text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Bergabung</small>
                                    <strong class="text-dark">{{ Auth::user()->created_at->format('d M Y') }}</strong>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                    <i class="bi bi-check-circle text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Status</small>
                                    <strong class="text-dark">Aktif</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content - Edit Profile -->
                <div class="col-lg-8 p-4">
                    <!-- Edit Profile Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="card-title mb-0 fw-semibold text-dark">
                                <i class="bi bi-pencil-square me-2"></i>Edit Informasi Profil
                            </h6>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="updateProfile">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark">
                                            <i class="bi bi-person me-1 text-primary"></i>Nama Lengkap *
                                        </label>
                                        <input type="text" class="form-control border @error('name') is-invalid @enderror" 
                                               wire:model="name" placeholder="Masukkan nama lengkap">
                                        @error('name')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark">
                                            <i class="bi bi-envelope me-1 text-primary"></i>Email *
                                        </label>
                                        <input type="email" class="form-control border @error('email') is-invalid @enderror" 
                                               wire:model="email" placeholder="email@example.com">
                                        @error('email')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-dark">
                                            <i class="bi bi-telephone me-1 text-primary"></i>Nomor Telepon
                                        </label>
                                        <input type="text" class="form-control border @error('phone') is-invalid @enderror" 
                                               wire:model="phone" placeholder="081234567890">
                                        @error('phone')
                                            <div class="invalid-feedback d-flex align-items-center">
                                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-2 pt-4 mt-3 border-top">
                                    <button type="submit" class="btn btn-primary d-flex align-items-center px-4"
                                            wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                                        </span>
                                        <span wire:loading>
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Menyimpan...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Account Status Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <h6 class="card-title mb-0 fw-semibold text-dark">
                                <i class="bi bi-shield-check me-2"></i>Status Akun
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 d-inline-flex mb-2">
                                            <i class="bi bi-gear text-warning"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Role</h6>
                                        <span class="badge bg-warning rounded-pill">Koordinator</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex mb-2">
                                            <i class="bi bi-check-circle text-success"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Status</h6>
                                        <span class="badge bg-success rounded-pill">Aktif</span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-2 d-inline-flex mb-2">
                                            <i class="bi bi-calendar-check text-info"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Bergabung</h6>
                                        <div class="text-muted fw-medium small">{{ Auth::user()->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>