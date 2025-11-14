<div>
    <div class="pagetitle">
        <h1>Target Tabungan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Target Tabungan</li>
            </ol>
        </nav>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Total Tabungan <span>| Disetujui</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Rp{{ number_format($totalTabungan, 0, ',', '.') }}</h6>
                            <span class="text-success small pt-1 fw-bold">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Target Aktif</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $goals->where('status', 'active')->count() }}</h6>
                            <span class="text-primary small pt-1 fw-bold">Dalam Progres</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Target Tercapai</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $goals->where('status', 'completed')->count() }}</h6>
                            <span class="text-success small pt-1 fw-bold">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Input Target -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">
                <i class="bi bi-plus-circle me-2"></i>
                {{ $editMode ? 'Edit Target Tabungan' : 'Buat Target Tabungan Baru' }}
            </h5>

            <form wire:submit.prevent="saveGoal">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Target</label>
                            <input type="text" class="form-control" wire:model="goalName" 
                                   placeholder="Contoh: Tabungan Umrah, Dana Pendidikan">
                            @error('goalName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Target Jumlah</label>
                            <input type="number" class="form-control" wire:model="targetAmount" 
                                   placeholder="Contoh: 100000000">
                            @error('targetAmount') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Target Tanggal</label>
                            <input type="date" class="form-control" wire:model="deadline">
                            @error('deadline') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                @if($editMode)
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-check-lg me-1"></i>Update
                                    </button>
                                    <button type="button" class="btn btn-secondary" 
                                            wire:click="cancelEdit">
                                        <i class="bi bi-x-lg me-1"></i>Batal
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-plus-lg me-1"></i>Buat Target
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- List Target Tabungan -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Daftar Target Tabungan Saya</h5>
                <span class="badge bg-primary">{{ $goals->count() }} Target</span>
            </div>

            @forelse($goals as $goal)
                <div class="goal-item mb-4 p-4 border rounded shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <h6 class="text-primary mb-0 me-2">{{ $goal->goal_name }}</h6>
                                
                                <!-- Status Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm 
                                        @if($goal->status == 'completed') btn-success
                                        @elseif($goal->status == 'paused') btn-danger
                                        @else btn-primary @endif 
                                        dropdown-toggle py-1" 
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
                            
                            <div class="row text-muted">
                                <div class="col-md-4 mb-2">
                                    <i class="bi bi-currency-dollar me-1"></i>
                                    <strong>Target:</strong> Rp{{ number_format($goal->target_amount, 0, ',', '.') }}
                                </div>
                                <div class="col-md-4 mb-2">
                                    <i class="bi bi-calendar me-1"></i>
                                    <strong>Deadline:</strong> {{ $goal->deadline->format('d/m/Y') }}
                                </div>
                                <div class="col-md-4 mb-2">
                                    <i class="bi bi-clock me-1"></i>
                                    <strong>Sisa Waktu:</strong> 
                                    @if($goal->remaining_days > 0)
                                        {{ round($goal->remaining_days) }} hari
                                    @elseif($goal->remaining_days === 0)
                                        <span class="text-warning">Hari ini</span>
                                    @else
                                        <span class="text-danger">Terlambat {{ abs(round($goal->remaining_days)) }} hari</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="btn-group ms-3">
                            <button class="btn btn-sm btn-outline-warning" 
                                    wire:click="editGoal({{ $goal->id }})"
                                    title="Edit Target">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" 
                                    wire:click="deleteGoal({{ $goal->id }})"
                                    wire:confirm="Hapus target {{ $goal->goal_name }}?"
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

                    <div class="d-flex justify-content-between align-items-center text-sm">
                        <span class="text-muted">
                            <i class="bi bi-calculator me-1"></i>
                            Sisa: <strong>Rp{{ number_format($goal->remaining, 0, ',', '.') }}</strong>
                        </span>
                        
                        <!-- FIXED PERCENTAGE CALCULATION -->
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
            @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-bullseye display-4 d-block mb-3 text-primary"></i>
                    <h4 class="text-primary">Belum Ada Target Tabungan</h4>
                    <p class="mb-4">Mulai rencanakan masa depan Anda dengan membuat target tabungan pertama</p>
                    <button class="btn btn-primary btn-lg" wire:click="$set('editMode', false)">
                        <i class="bi bi-plus-circle me-2"></i>Buat Target Pertama
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</div>