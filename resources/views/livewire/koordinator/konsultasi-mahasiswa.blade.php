<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-chat-dots me-2"></i>Konsultasi Mahasiswa - Kelas {{ Auth::user()->class }}
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Summary Cards -->
            <div class="p-4 border-bottom">
                <div class="row g-3">
                    <div class="col-xl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Total</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-chat-dots"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $stats['total'] }}</h6>
                                        <span class="text-primary small pt-1 fw-bold">Konsultasi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Menunggu</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $stats['pending'] }}</h6>
                                        <span class="text-warning small pt-1 fw-bold">Perlu Balasan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Sudah Dibalas</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $stats['replied'] }}</h6>
                                        <span class="text-success small pt-1 fw-bold">Selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="p-4 border-bottom">
                <h6 class="fw-semibold text-dark mb-3">
                    <i class="bi bi-funnel me-2 text-primary"></i>Filter Konsultasi
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Cari Konsultasi</label>
                        <input type="text" class="form-control border" 
                               placeholder="Cari berdasarkan subjek, pesan, atau nama mahasiswa..." 
                               wire:model.live.500ms="search">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Status</label>
                        <select class="form-select border" wire:model.live="filterStatus">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Balasan</option>
                            <option value="replied">Sudah Dibalas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-dark">&nbsp;</label>
                        <div class="d-grid">
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                    wire:click="resetFilters">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-0">
                <!-- Daftar Konsultasi -->
                <div class="col-lg-6 border-end">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-semibold text-dark mb-0">
                                <i class="bi bi-list-ul me-2 text-primary"></i>Daftar Konsultasi
                            </h6>
                            <span class="badge bg-primary">{{ $consultations->total() }} Konsultasi</span>
                        </div>
                        
                        @if($consultations->count() > 0)
                            <div class="list-group">
                                @foreach($consultations as $consultation)
                                    <div class="list-group-item list-group-item-action border-0 rounded mb-2 cursor-pointer 
                                                {{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'bg-primary text-white' : 'bg-light' }}"
                                         wire:click="selectConsultation({{ $consultation->id }})"
                                         style="transition: all 0.3s ease;">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <h6 class="mb-1 {{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-white' : 'text-dark' }}">
                                                {{ $consultation->subject }}
                                            </h6>
                                            <small class="{{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-light' : 'text-muted' }}">
                                                {{ $consultation->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <p class="mb-2 {{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-light' : 'text-muted' }} small">
                                            {{ Str::limit($consultation->message, 80) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="{{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-light' : 'text-dark' }} fw-medium">
                                                {{ $consultation->student->name }}
                                            </small>
                                            <span class="badge bg-{{ $consultation->status === 'pending' ? 'warning' : 'success' }}">
                                                {{ $consultation->status === 'pending' ? 'Menunggu' : 'Dibalas' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- PAGINATION SAMA PERSIS DENGAN MAHASISWA -->
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
                            @else
                            <div class="text-center text-muted small mt-3 pt-3 border-top">
                                Total {{ $consultations->total() }} konsultasi
                            </div>
                            @endif

                        @else
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-chat-dots display-6 d-block mb-3 text-primary"></i>
                                <h4 class="text-primary mb-3">
                                    @if($search || $filterStatus !== 'all')
                                        Tidak Ditemukan
                                    @else
                                        Belum Ada Konsultasi
                                    @endif
                                </h4>
                                <p class="mb-4">
                                    @if($search || $filterStatus !== 'all')
                                        Coba ubah filter atau kata kunci pencarian
                                    @else
                                        Mahasiswa akan mengirim konsultasi melalui dashboard mereka
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detail Konsultasi & Balasan -->
                <div class="col-lg-6">
                    <div class="p-4">
                        @if($selectedConsultation)
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-semibold text-dark mb-0">
                                    <i class="bi bi-chat-text me-2 text-primary"></i>Detail Konsultasi
                                </h6>
                                <button class="btn btn-outline-secondary btn-sm d-flex align-items-center" 
                                        wire:click="closeDetail">
                                    <i class="bi bi-x me-1"></i>Tutup
                                </button>
                            </div>

                            <!-- Info Konsultasi -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="text-primary mb-1">{{ $selectedConsultation->subject }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i>
                                                Dari: {{ $selectedConsultation->student->name }} ({{ $selectedConsultation->student->class }})
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
                                        <strong class="text-dark">Pertanyaan Mahasiswa:</strong>
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
                                            <i class="bi bi-reply-fill me-2"></i>Balasan Anda
                                        </h6>
                                        <p class="mb-3">{{ $selectedConsultation->response }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            Dibalas: {{ $selectedConsultation->updated_at->format('d F Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            @endif

                            <!-- Form Balasan -->
                            @if($selectedConsultation->status === 'pending')
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="fw-semibold text-dark mb-3">
                                            <i class="bi bi-reply me-2 text-primary"></i>Balas Konsultasi
                                        </h6>
                                        <form wire:submit.prevent="sendReply">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Balasan *</label>
                                                <textarea class="form-control border @error('replyMessage') is-invalid @enderror" 
                                                          rows="4" 
                                                          placeholder="Tulis balasan Anda untuk mahasiswa..."
                                                          wire:model="replyMessage"></textarea>
                                                @error('replyMessage') 
                                                    <div class="invalid-feedback d-flex align-items-center">
                                                        <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center"
                                                        wire:loading.attr="disabled">
                                                    <span wire:loading.remove>
                                                        <i class="bi bi-send me-1"></i>Kirim Balasan
                                                    </span>
                                                    <span wire:loading>
                                                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                                        Mengirim...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif($selectedConsultation->status === 'replied')
                                <div class="alert alert-success border-0 shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle me-2 fs-5"></i>
                                        <div>
                                            <strong class="d-block">Sudah Dibalas</strong>
                                            <small>Mahasiswa dapat melihat jawaban kapan saja.</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-chat-text display-6 d-block mb-3 text-primary"></i>
                                <h4 class="text-primary mb-3">Pilih Konsultasi</h4>
                                <p class="mb-4">Klik pada salah satu konsultasi di sebelah kiri untuk melihat detail dan membalas</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>