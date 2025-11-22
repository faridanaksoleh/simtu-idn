<div>
    <!-- Satu root div utama -->
    <div>
        <div class="pagetitle">
            <h1>Konsultasi dengan Koordinator</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Konsultasi</li>
                </ol>
            </nav>
        </div>

        <!-- Form Konsultasi Baru -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ajukan Pertanyaan Baru</h5>
                <p class="text-muted">Kirim pertanyaan kepada koordinator kelas Anda mengenai tabungan dan transaksi</p>
                
                <form wire:submit.prevent="sendConsultation">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Subjek Pertanyaan *</label>
                            <input type="text" class="form-control" placeholder="Contoh: Masalah transfer tabungan" 
                                   wire:model="subject">
                            @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Pertanyaan Detail *</label>
                            <textarea class="form-control" rows="5" 
                                      placeholder="Tulis pertanyaan Anda secara detail..."
                                      wire:model="message"></textarea>
                            @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Kirim Pertanyaan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Riwayat Konsultasi -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Riwayat Konsultasi</h5>
                
                @if($consultations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Subjek</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Koordinator</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consultations as $consultation)
                                    <tr>
                                        <td>
                                            <strong>{{ $consultation->subject }}</strong>
                                            @if($editingId === $consultation->id)
                                                <!-- Edit Form -->
                                                <div class="mt-2 p-3 bg-light rounded">
                                                    <input type="text" class="form-control form-control-sm mb-2" 
                                                           wire:model="editSubject">
                                                    <textarea class="form-control form-control-sm mb-2" rows="3"
                                                              wire:model="editMessage"></textarea>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-success btn-sm" 
                                                                wire:click="updateConsultation">
                                                            <i class="bi bi-check"></i> Simpan
                                                        </button>
                                                        <button class="btn btn-secondary btn-sm" 
                                                                wire:click="cancelEdit">
                                                            <i class="bi bi-x"></i> Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <br>
                                                <small class="text-muted">{{ Str::limit($consultation->message, 100) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $consultation->created_at->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">{{ $consultation->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($consultation->status === 'pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($consultation->status === 'replied')
                                                <span class="badge bg-success">Dibalas</span>
                                            @else
                                                <span class="badge bg-secondary">Ditutup</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($consultation->coordinator)
                                                {{ $consultation->coordinator->name }}
                                            @else
                                                <span class="text-muted">Belum ditugaskan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($consultation->status === 'pending')
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" 
                                                            wire:click="startEdit({{ $consultation->id }})"
                                                            title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger" 
                                                            wire:click="confirmDelete({{ $consultation->id }})"
                                                            title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @elseif($consultation->status === 'replied')
                                                <button class="btn btn-sm btn-outline-info" 
                                                        wire:click="showDetail({{ $consultation->id }})"
                                                        title="Lihat Balasan">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </button>
                                            @else
                                                <!-- Status closed - tidak ada action -->
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $consultations->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-chat-dots display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">Belum ada konsultasi</h5>
                        <p class="text-muted">Ajukan pertanyaan pertama Anda kepada koordinator</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Detail Konsultasi -->
        @if($showDetailModal && $selectedConsultation)
            <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5)" wire:click="closeDetail">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" wire:click.stop>
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Konsultasi</h5>
                            <button type="button" class="btn-close" wire:click="closeDetail"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Info Konsultasi -->
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $selectedConsultation->subject }}</h6>
                                        <small class="text-muted">
                                            Koordinator: {{ $selectedConsultation->coordinator->name ?? 'Belum ditugaskan' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success">Dibalas</span>
                                </div>
                                <p class="mb-2"><strong>Pertanyaan Anda:</strong><br>{{ $selectedConsultation->message }}</p>
                                <small class="text-muted">
                                    Dikirim: {{ $selectedConsultation->created_at->format('d F Y H:i') }}
                                </small>
                            </div>

                            <!-- Balasan Koordinator -->
                            @if($selectedConsultation->response)
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-success mb-2">
                                        <i class="bi bi-reply-fill me-1"></i>Balasan Koordinator
                                    </h6>
                                    <p class="mb-2">{{ $selectedConsultation->response }}</p>
                                    <small class="text-muted">
                                        Dibalas: {{ $selectedConsultation->updated_at->format('d F Y H:i') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeDetail">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>