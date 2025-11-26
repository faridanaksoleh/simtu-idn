<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-chat-dots me-2"></i>Konsultasi dengan Koordinator
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Form Konsultasi Baru -->
            <div class="p-4 border-bottom">
                <h6 class="fw-semibold text-dark mb-3">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>Ajukan Pertanyaan Baru
                </h6>
                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>Kirim pertanyaan kepada koordinator kelas Anda mengenai tabungan dan transaksi
                </p>
                
                <form wire:submit.prevent="sendConsultation">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-chat-text me-1 text-primary"></i>Subjek Pertanyaan *
                            </label>
                            <input type="text" class="form-control border @error('subject') is-invalid @enderror" 
                                   placeholder="Contoh: Masalah transfer tabungan, Konfirmasi transaksi" 
                                   wire:model="subject">
                            @error('subject')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-chat-left-text me-1 text-primary"></i>Pertanyaan Detail *
                            </label>
                            <textarea class="form-control border @error('message') is-invalid @enderror" rows="5" 
                                      placeholder="Tulis pertanyaan Anda secara detail..."
                                      wire:model="message"></textarea>
                            @error('message')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-end pt-3 border-top">
                                <button type="submit" class="btn btn-primary d-flex align-items-center px-4"
                                        wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="bi bi-send me-1"></i>Kirim Pertanyaan
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
            </div>

            <!-- Riwayat Konsultasi -->
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Konsultasi
                    </h6>
                    <span class="badge bg-primary">{{ $consultations->total() }} Konsultasi</span>
                </div>
                
                @if($consultations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="w-30">Subjek</th>
                                    <th class="w-15">Tanggal</th>
                                    <th class="w-15">Status</th>
                                    <th class="w-20">Koordinator</th>
                                    <th class="w-20">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consultations as $consultation)
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <strong class="text-dark">{{ $consultation->subject }}</strong>
                                                @if($editingId === $consultation->id)
                                                    <!-- Edit Form -->
                                                    <div class="mt-2 p-3 bg-light rounded">
                                                        <input type="text" class="form-control form-control-sm mb-2 border" 
                                                               wire:model="editSubject" placeholder="Subjek pertanyaan">
                                                        <textarea class="form-control form-control-sm mb-2 border" rows="3"
                                                                  wire:model="editMessage" placeholder="Detail pertanyaan"></textarea>
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-success btn-sm d-flex align-items-center" 
                                                                    wire:click="updateConsultation">
                                                                <i class="bi bi-check me-1"></i> Simpan
                                                            </button>
                                                            <button class="btn btn-secondary btn-sm d-flex align-items-center" 
                                                                    wire:click="cancelEdit">
                                                                <i class="bi bi-x me-1"></i> Batal
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <small class="text-muted">{{ Str::limit($consultation->message, 100) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ $consultation->created_at->format('d/m/Y') }}</span>
                                                <small class="text-muted">{{ $consultation->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($consultation->status === 'pending')
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock me-1"></i>Menunggu
                                                </span>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Sudah Dibalas
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($consultation->coordinator)
                                                <span class="fw-medium text-dark">{{ $consultation->coordinator->name }}</span>
                                            @else
                                                <span class="text-muted">Belum ditugaskan</span>
                                                @endif
                                        </td>
                                        <td>
                                            @if($consultation->status === 'pending')
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-warning d-flex align-items-center" 
                                                            wire:click="startEdit({{ $consultation->id }})"
                                                            title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger d-flex align-items-center" 
                                                            wire:click="confirmDelete({{ $consultation->id }})"
                                                            title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <!-- 🔥 PERBAIKAN: Button Lihat dengan style outline -->
                                                <button class="btn btn-outline-primary btn-sm d-flex align-items-center" 
                                                        wire:click="showDetail({{ $consultation->id }})"
                                                        title="Lihat Balasan">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination - VERSI SEDERHANA -->
                    @if($consultations->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="text-muted small">
                            Menampilkan {{ $consultations->firstItem() ?? 0 }} - {{ $consultations->lastItem() ?? 0 }} 
                            dari {{ $consultations->total() }} konsultasi
                        </div>
                        <div>
                            {{ $consultations->links() }}
                        </div>
                    </div>
                    @endif

                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat-dots display-6 d-block mb-3 text-primary"></i>
                        <h4 class="text-primary mb-3">Belum Ada Konsultasi</h4>
                        <p class="mb-4">Ajukan pertanyaan pertama Anda kepada koordinator</p>
                        <button class="btn btn-primary d-flex align-items-center mx-auto">
                            <i class="bi bi-plus-circle me-2"></i>Ajukan Pertanyaan Pertama
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Detail Konsultasi -->
    @if($showDetailModal && $selectedConsultation)
        <div class="modal-backdrop fade show" wire:click="closeDetail"></div>
        <div class="modal fade show d-block" tabindex="-1" wire:ignore>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- 🔥 PERBAIKAN: Header modal tanpa button tambahan -->
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold text-dark">
                            <i class="bi bi-chat-dots me-2 text-primary"></i>Detail Konsultasi
                        </h5>
                        <!-- Hanya button X di kanan atas -->
                        <button type="button" class="btn-close" wire:click="closeDetail" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body pt-0">
                        <!-- Info Konsultasi -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="text-primary mb-1">{{ $selectedConsultation->subject }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>
                                            Koordinator: {{ $selectedConsultation->coordinator->name ?? 'Belum ditugaskan' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $selectedConsultation->status === 'pending' ? 'warning' : 'success' }}">
                                        @if($selectedConsultation->status === 'pending')
                                            <i class="bi bi-clock me-1"></i>Menunggu
                                        @else
                                            <i class="bi bi-check-circle me-1"></i>Sudah Dibalas
                                        @endif
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <strong class="text-dark">Pertanyaan Anda:</strong>
                                    <p class="mb-0 mt-1">{{ $selectedConsultation->message }}</p>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    Dikirim: {{ $selectedConsultation->created_at->format('d F Y H:i') }}
                                </small>
                            </div>
                        </div>

                        <!-- Balasan Koordinator -->
                        @if($selectedConsultation->response)
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-success mb-3 d-flex align-items-center">
                                        <i class="bi bi-reply-fill me-2"></i>Balasan Koordinator
                                    </h6>
                                    <p class="mb-3">{{ $selectedConsultation->response }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        Dibalas: {{ $selectedConsultation->updated_at->format('d F Y H:i') }}
                                    </small>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning border-0 shadow-sm">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history me-2 fs-5"></i>
                                    <div>
                                        <strong class="d-block">Menunggu Balasan</strong>
                                        <small>Koordinator belum membalas konsultasi ini.</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- 🔥 PERBAIKAN: HAPUS SELURUH MODAL FOOTER -->
                    <!-- Tidak ada button tutup di footer -->
                </div>
            </div>
        </div>
    @endif
</div>