<div>
    <!-- Main Card Container -->
    <div class="card border-0 shadow-sm">
        <!-- HEADER UTAMA DENGAN BIRU TUA KONSISTEN -->
        <div class="card-header border-0 d-flex justify-content-between align-items-center py-3" style="background-color: #1D4ED8;">
            <h5 class="mb-0 text-white fw-semibold fs-6">
                <i class="bi bi-bullseye me-2"></i>Target Tabungan
            </h5>
        </div>

        <div class="card-body p-0">
            <!-- Stats Cards -->
            <div class="row m-0 p-4 border-bottom">
                <div class="col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-wallet2 text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Total Tabungan</h6>
                                    <h4 class="fw-bold text-success mb-0">Rp{{ number_format($totalTabungan, 0, ',', '.') }}</h4>
                                    <small class="text-muted">Tabungan disetujui</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-bullseye text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Target Aktif</h6>
                                    <h4 class="fw-bold text-primary mb-0">{{ $goals->where('status', 'active')->count() }}</h4>
                                    <small class="text-muted">Dalam progres</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="card-title text-muted mb-1">Target Tercapai</h6>
                                    <h4 class="fw-bold text-success mb-0">{{ $goals->where('status', 'completed')->count() }}</h4>
                                    <small class="text-muted">Selesai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Input Target -->
            <div class="p-4 border-bottom">
                <h6 class="fw-semibold text-dark mb-3">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>
                    {{ $editMode ? 'Edit Target Tabungan' : 'Buat Target Tabungan Baru' }}
                </h6>

                <form wire:submit.prevent="saveGoal">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-tag me-1 text-primary"></i>Nama Target
                            </label>
                            <input type="text" class="form-control border @error('goalName') is-invalid @enderror" 
                                   wire:model="goalName" 
                                   placeholder="Contoh: Tabungan Umrah, Dana Pendidikan">
                            @error('goalName')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-currency-dollar me-1 text-primary"></i>Target Jumlah
                            </label>
                            <input type="number" class="form-control border @error('targetAmount') is-invalid @enderror" 
                                   wire:model="targetAmount" 
                                   placeholder="Contoh: 100000000">
                            @error('targetAmount')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-calendar me-1 text-primary"></i>Target Tanggal
                            </label>
                            <input type="date" class="form-control border @error('deadline') is-invalid @enderror" 
                                   wire:model="deadline">
                            @error('deadline')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                @if($editMode)
                                    <button type="submit" class="btn btn-warning d-flex align-items-center justify-content-center"
                                            wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            <i class="bi bi-check-lg me-1"></i>Update
                                        </span>
                                        <span wire:loading>
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Updating...
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-secondary d-flex align-items-center justify-content-center" 
                                            wire:click="cancelEdit">
                                        <i class="bi bi-x-lg me-1"></i>Batal
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center"
                                            wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            <i class="bi bi-plus-lg me-1"></i>Buat Target
                                        </span>
                                        <span wire:loading>
                                            <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                            Creating...
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- List Target Tabungan -->
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-semibold text-dark mb-0">
                        <i class="bi bi-list-ul me-2 text-primary"></i>Daftar Target Tabungan Saya
                    </h6>
                    <span class="badge bg-primary">{{ $goals->count() }} Target</span>
                </div>

                @forelse($goals as $goal)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="text-primary mb-0 me-2">{{ $goal->goal_name }}</h6>
                                        
                                        <!-- Status Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm 
                                                @if($goal->status == 'completed') btn-success
                                                @elseif($goal->status == 'paused') btn-warning
                                                @else btn-primary @endif 
                                                dropdown-toggle py-1 d-flex align-items-center" 
                                                    type="button" data-bs-toggle="dropdown">
                                                @if($goal->status == 'completed')
                                                    <i class="bi bi-check-circle me-1"></i>Tercapai
                                                @elseif($goal->status == 'paused')
                                                    <i class="bi bi-pause-circle me-1"></i>Ditunda
                                                @else
                                                    <i class="bi bi-play-circle me-1"></i>Aktif
                                                @endif
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       wire:click="updateStatus({{ $goal->id }}, 'active')">
                                                        <i class="bi bi-play-circle text-primary me-2"></i>
                                                        Aktif
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       wire:click="updateStatus({{ $goal->id }}, 'completed')">
                                                        <i class="bi bi-check-circle text-success me-2"></i>
                                                        Tercapai
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       wire:click="updateStatus({{ $goal->id }}, 'paused')">
                                                        <i class="bi bi-pause-circle text-warning me-2"></i>
                                                        Ditunda
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-currency-dollar me-2"></i>
                                                <div>
                                                    <small class="d-block">Target</small>
                                                    <strong class="text-dark">Rp{{ number_format($goal->target_amount, 0, ',', '.') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-calendar me-2"></i>
                                                <div>
                                                    <small class="d-block">Deadline</small>
                                                    <strong class="text-dark">{{ $goal->deadline->format('d/m/Y') }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-clock me-2"></i>
                                                <div>
                                                    <small class="d-block">Sisa Waktu</small>
                                                    <strong class="@if($goal->remaining_days > 0) text-success @elseif($goal->remaining_days === 0) text-warning @else text-danger @endif">
                                                        @if($goal->remaining_days > 0)
                                                            {{ round($goal->remaining_days) }} hari
                                                        @elseif($goal->remaining_days === 0)
                                                            Hari ini
                                                        @else
                                                            Terlambat {{ abs(round($goal->remaining_days)) }} hari
                                                        @endif
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group ms-3">
                                    <button class="btn btn-sm btn-outline-warning d-flex align-items-center" 
                                            wire:click="editGoal({{ $goal->id }})"
                                            title="Edit Target">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger d-flex align-items-center" 
                                            wire:click="deleteGoal({{ $goal->id }})"
                                            title="Hapus Target">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        Progress: <strong>{{ number_format($goal->progress_percent, 1) }}%</strong>
                                    </small>
                                    <small class="text-muted">
                                        <strong>Rp{{ number_format($goal->current_amount, 0, ',', '.') }}</strong> 
                                        dari 
                                        <strong>Rp{{ number_format($goal->target_amount, 0, ',', '.') }}</strong>
                                    </small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar 
                                        @if($goal->progress_percent >= 100) bg-success
                                        @elseif($goal->remaining_days < 30 && $goal->remaining_days > 0) bg-warning
                                        @elseif($goal->remaining_days < 0) bg-danger
                                        @else bg-primary @endif"
                                        role="progressbar" 
                                        style="width: {{ $goal->progress_percent }}%"
                                        aria-valuenow="{{ $goal->progress_percent }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="bi bi-calculator me-1"></i>
                                    Sisa: <strong>Rp{{ number_format($goal->remaining, 0, ',', '.') }}</strong>
                                </span>
                                
                                @if($goal->progress_percent > 0 && $goal->progress_percent < 100)
                                    @php
                                        $remainingPercent = 100 - $goal->progress_percent;
                                    @endphp
                                    <span class="text-info">
                                        <i class="bi bi-arrow-up-right me-1"></i>
                                        {{ number_format($remainingPercent, 1) }}% menuju target
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-bullseye display-6 d-block mb-3 text-primary"></i>
                        <h4 class="text-primary mb-3">Belum Ada Target Tabungan</h4>
                        <p class="mb-4">Mulai rencanakan masa depan Anda dengan membuat target tabungan pertama</p>
                        <button class="btn btn-primary btn-lg d-flex align-items-center mx-auto" 
                                wire:click="$set('editMode', false)">
                            <i class="bi bi-plus-circle me-2"></i>Buat Target Pertama
                        </button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>