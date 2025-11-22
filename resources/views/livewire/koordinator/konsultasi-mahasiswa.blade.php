<div>
    <div class="pagetitle">
        <h1>Konsultasi Mahasiswa - Kelas {{ Auth::user()->class }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('koordinator.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Konsultasi Mahasiswa</li>
            </ol>
        </nav>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
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

        <div class="col-xl-3 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-clock-history text-warning"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $stats['pending'] }}</h6>
                            <span class="text-warning small pt-1 fw-bold">Perlu Balasan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Dibalas</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle text-success"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $stats['replied'] }}</h6>
                            <span class="text-success small pt-1 fw-bold">Sudah Dibalas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-archive text-secondary"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $stats['closed'] }}</h6>
                            <span class="text-secondary small pt-1 fw-bold">Ditutup</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Filter Konsultasi</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cari</label>
                    <input type="text" class="form-control" placeholder="Cari berdasarkan subjek, pesan, atau nama mahasiswa..." 
                           wire:model.live="search">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model.live="filterStatus">
                        <option value="all">Semua Status</option>
                        <option value="pending">Menunggu Balasan</option>
                        <option value="replied">Sudah Dibalas</option>
                        <option value="closed">Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button class="btn btn-outline-secondary" wire:click="$set('search', '')">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Daftar Konsultasi -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Konsultasi</h5>
                    
                    @if($consultations->count() > 0)
                        <div class="list-group">
                            @foreach($consultations as $consultation)
                                <a href="javascript:void(0)" 
                                   class="list-group-item list-group-item-action {{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'active' : '' }}"
                                   wire:click="selectConsultation({{ $consultation->id }})">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 {{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-white' : '' }}">
                                            {{ $consultation->subject }}
                                        </h6>
                                        <small class="{{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-light' : 'text-muted' }}">
                                            {{ $consultation->created_at->format('d/m') }}
                                        </small>
                                    </div>
                                    <p class="mb-1 {{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-light' : 'text-muted' }}">
                                        {{ Str::limit($consultation->message, 100) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="{{ $selectedConsultation && $selectedConsultation->id === $consultation->id ? 'text-light' : 'text-muted' }}">
                                            {{ $consultation->student->name }}
                                        </small>
                                        <span class="badge bg-{{ $consultation->status === 'pending' ? 'warning' : ($consultation->status === 'replied' ? 'success' : 'secondary') }}">
                                            {{ $consultation->status === 'pending' ? 'Menunggu' : ($consultation->status === 'replied' ? 'Dibalas' : 'Selesai') }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $consultations->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-chat-dots display-1 text-muted"></i>
                            <h5 class="text-muted mt-3">
                                @if($search || $filterStatus !== 'all')
                                    Tidak ditemukan konsultasi
                                @else
                                    Belum ada konsultasi
                                @endif
                            </h5>
                            <p class="text-muted">
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
        </div>

        <!-- Detail Konsultasi & Balasan -->
        <div class="col-lg-6">
            @if($selectedConsultation)
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Detail Konsultasi</h5>
                            <button class="btn btn-sm btn-outline-secondary" wire:click="closeDetail">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>

                        <!-- Info Konsultasi -->
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">{{ $selectedConsultation->subject }}</h6>
                                    <small class="text-muted">
                                        Dari: {{ $selectedConsultation->student->name }} ({{ $selectedConsultation->student->class }})
                                    </small>
                                </div>
                                <span class="badge bg-{{ $selectedConsultation->status === 'pending' ? 'warning' : ($selectedConsultation->status === 'replied' ? 'success' : 'secondary') }}">
                                    {{ $selectedConsultation->status === 'pending' ? 'Menunggu Balasan' : ($selectedConsultation->status === 'replied' ? 'Sudah Dibalas' : 'Selesai') }}
                                </span>
                            </div>
                            <p class="mb-2">{{ $selectedConsultation->message }}</p>
                            <small class="text-muted">
                                Dikirim: {{ $selectedConsultation->created_at->format('d F Y H:i') }}
                            </small>
                        </div>

                        <!-- Balasan Koordinator -->
                        @if($selectedConsultation->response)
                            <div class="border rounded p-3 mb-3 bg-light">
                                <h6 class="text-success mb-2">
                                    <i class="bi bi-reply-fill me-1"></i>Balasan Anda
                                </h6>
                                <p class="mb-2">{{ $selectedConsultation->response }}</p>
                                <small class="text-muted">
                                    Dibalas: {{ $selectedConsultation->updated_at->format('d F Y H:i') }}
                                </small>
                            </div>
                        @endif

                        <!-- Form Balasan -->
                        @if($selectedConsultation->status === 'pending')
                            <div class="border rounded p-3">
                                <h6 class="mb-3">Balas Konsultasi</h6>
                                <form wire:submit.prevent="sendReply">
                                    <div class="mb-3">
                                        <label class="form-label">Balasan *</label>
                                        <textarea class="form-control" rows="4" 
                                                  placeholder="Tulis balasan Anda untuk mahasiswa..."
                                                  wire:model="replyMessage"></textarea>
                                        @error('replyMessage') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-send me-1"></i>Kirim Balasan
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" 
                                                wire:click="markAsClosed({{ $selectedConsultation->id }})">
                                            <i class="bi bi-archive me-1"></i>Tandai Selesai
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif($selectedConsultation->status === 'replied')
                            <div class="text-center">
                                <button type="button" class="btn btn-outline-secondary" 
                                        wire:click="markAsClosed({{ $selectedConsultation->id }})">
                                    <i class="bi bi-archive me-1"></i>Tandai sebagai Selesai
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-chat-text display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Pilih Konsultasi</h5>
                        <p class="text-muted">Klik pada salah satu konsultasi di sebelah kiri untuk melihat detail dan membalas</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>