<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-broadcast me-2"></i>Broadcast Notifikasi
            </h5>
        </div>

        <div class="card-body p-4">
            <!-- Description -->
            <p class="text-muted mb-4">
                <i class="bi bi-info-circle me-1"></i>Kirim notifikasi ke semua mahasiswa atau semua pengguna sistem
            </p>

            <form wire:submit.prevent="broadcast">
                <div class="row g-4">
                    <!-- Target Selection -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-bullseye me-1 text-primary"></i>Target *
                        </label>
                        <select class="form-control border @error('target') is-invalid @enderror" wire:model="target">
                            <option value="students">Semua Mahasiswa</option>
                            <option value="all">Semua Pengguna</option>
                        </select>
                        @error('target')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Notification Type -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-tag me-1 text-primary"></i>Tipe Notifikasi *
                        </label>
                        <select class="form-control border @error('type') is-invalid @enderror" wire:model="type">
                            <option value="info">
                                <i class="bi bi-info-circle me-1 text-info"></i>Info
                            </option>
                            <option value="success">
                                <i class="bi bi-check-circle me-1 text-success"></i>Success
                            </option>
                            <option value="warning">
                                <i class="bi bi-exclamation-triangle me-1 text-warning"></i>Warning
                            </option>
                            <option value="danger">
                                <i class="bi bi-x-circle me-1 text-danger"></i>Danger
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Title Input -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-chat-square-text me-1 text-primary"></i>Judul *
                        </label>
                        <input type="text" class="form-control border @error('title') is-invalid @enderror" 
                               placeholder="Contoh: Informasi Penting, Pengumuman, dll." 
                               wire:model="title">
                        @error('title')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Message Textarea -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-chat-left-text me-1 text-primary"></i>Pesan *
                        </label>
                        <textarea class="form-control border @error('message') is-invalid @enderror" 
                                  rows="5"
                                  placeholder="Tulis pesan notifikasi yang ingin disampaikan..."
                                  wire:model="message"></textarea>
                        @error('message')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Action Button -->
                    <div class="col-12">
                        <div class="d-flex justify-content-end pt-3 border-top">
                            <button type="submit" class="btn btn-primary d-flex align-items-center px-4"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="bi bi-send me-1"></i>Kirim Broadcast
                                </span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                    Mengirim...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Info Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="card-title mb-0 fw-semibold text-dark">
                        <i class="bi bi-info-circle me-2"></i>Informasi Broadcast
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 d-inline-flex mb-2">
                                    <i class="bi bi-people text-primary"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Target Mahasiswa</h6>
                                <small class="text-muted">Notifikasi akan dikirim ke semua mahasiswa terdaftar</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 d-inline-flex mb-2">
                                    <i class="bi bi-person-check text-success"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Target Semua</h6>
                                <small class="text-muted">Notifikasi akan dikirim ke semua pengguna sistem</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 d-inline-flex mb-2">
                                    <i class="bi bi-bell text-warning"></i>
                                </div>
                                <h6 class="fw-semibold mb-1">Real-time</h6>
                                <small class="text-muted">Notifikasi akan muncul langsung di dashboard penerima</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>