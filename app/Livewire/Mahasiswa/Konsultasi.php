<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use App\Models\ConsultationNote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Konsultasi extends Component
{
    use WithPagination;

    public $subject = '';
    public $message = '';
    
    public $editingId = null;
    public $editSubject = '';
    public $editMessage = '';
    public $showDetailModal = false;
    public $selectedConsultation = null;
    public $deleteId = null;

    protected $rules = [
        'subject' => 'required|min:5|max:200',
        'message' => 'required|min:10',
    ];

    protected $listeners = ['deleteConfirmed'];

    // 🔥 HAPUS $queryString - INI YANG MENYEBABKAN ERROR
    // protected $queryString = [
    //     'page' => ['except' => 1]
    // ];

    public function sendConsultation()
    {
        $this->validate();

        try {
            $user = Auth::user();
            
            $coordinator = User::where('role', 'koordinator')
                ->where('class', $user->class)
                ->first();

            $consultation = ConsultationNote::create([
                'student_id' => $user->id,
                'coordinator_id' => $coordinator?->id,
                'subject' => $this->subject,
                'message' => $this->message,
                'status' => 'pending',
            ]);

            \App\Services\NotificationService::notifyNewConsultation($consultation);

            $this->reset(['subject', 'message']);
            
            // 🔥 RESET KE HALAMAN 1 SETELAH TAMBAH DATA BARU
            $this->resetPage();
            
            $this->dispatch('showSuccess', [
                'message' => 'Pertanyaan berhasil dikirim!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal mengirim pertanyaan: ' . $e->getMessage()
            ]);
        }
    }

    public function startEdit($consultationId)
    {
        $consultation = ConsultationNote::findOrFail($consultationId);
        
        if ($consultation->student_id !== Auth::id()) {
            $this->dispatch('showError', [
                'message' => 'Anda tidak memiliki akses!'
            ]);
            return;
        }

        if ($consultation->status !== 'pending') {
            $this->dispatch('showWarning', [
                'message' => 'Konsultasi sudah dibalas, tidak dapat diubah!'
            ]);
            return;
        }

        $this->editingId = $consultationId;
        $this->editSubject = $consultation->subject;
        $this->editMessage = $consultation->message;
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'editSubject', 'editMessage']);
    }

    public function updateConsultation()
    {
        $this->validate([
            'editSubject' => 'required|min:5|max:200',
            'editMessage' => 'required|min:10',
        ]);

        try {
            $consultation = ConsultationNote::findOrFail($this->editingId);
            
            if ($consultation->student_id !== Auth::id() || $consultation->status !== 'pending') {
                $this->dispatch('showError', [
                    'message' => 'Tidak dapat mengubah konsultasi!'
                ]);
                return;
            }

            $consultation->update([
                'subject' => $this->editSubject,
                'message' => $this->editMessage,
            ]);

            $this->cancelEdit();
            $this->dispatch('showSuccess', [
                'message' => 'Konsultasi berhasil diperbarui!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal memperbarui konsultasi: ' . $e->getMessage()
            ]);
        }
    }

    public function confirmDelete($consultationId)
    {
        $this->deleteId = $consultationId;
        
        $this->dispatch('showDeleteConfirmation', [
            'title' => 'Hapus Konsultasi?',
            'text' => "Anda tidak dapat mengembalikan konsultasi ini!",
            'confirmText' => 'Ya, Hapus!',
            'cancelText' => 'Batal',
            'id' => $consultationId
        ]);
    }

    public function deleteConfirmed()
    {
        if (!$this->deleteId) {
            $this->dispatch('showError', [
                'message' => 'ID konsultasi tidak valid!'
            ]);
            return;
        }
        
        try {
            $consultation = ConsultationNote::findOrFail($this->deleteId);
            
            if ($consultation->student_id !== Auth::id() || $consultation->status !== 'pending') {
                $this->dispatch('showError', [
                    'message' => 'Tidak dapat menghapus konsultasi!'
                ]);
                return;
            }

            $consultation->delete();
            
            // 🔥 RESET KE HALAMAN 1 JIKA HALAMAN SEKARANG KOSONG SETELAH DELETE
            $currentPage = $this->getPage();
            $consultations = ConsultationNote::where('student_id', Auth::id())->paginate(10, ['*'], 'page', $currentPage);
            
            if ($consultations->count() === 0 && $currentPage > 1) {
                $this->resetPage();
            }
            
            $this->dispatch('showSuccess', [
                'message' => 'Konsultasi berhasil dihapus!'
            ]);
            
            $this->deleteId = null;
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal menghapus konsultasi: ' . $e->getMessage()
            ]);
            $this->deleteId = null;
        }
    }

    public function showDetail($consultationId)
    {
        try {
            $this->selectedConsultation = ConsultationNote::with(['coordinator', 'student'])
                ->where('id', $consultationId)
                ->where('student_id', Auth::id())
                ->firstOrFail();

            $this->showDetailModal = true;
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal memuat detail konsultasi: ' . $e->getMessage()
            ]);
        }
    }

    public function closeDetail()
    {
        $this->reset(['showDetailModal', 'selectedConsultation']);
    }

    // 🔥 TAMBAHKAN METHOD UNTUK MENGATASI PAGINATION
    public function paginationView()
    {
        return 'livewire::bootstrap'; // atau 'pagination::bootstrap-5'
    }

    // 🔥 METHOD UNTUK HANDLE PAGE CHANGE
    public function updatingPage($page)
    {
        // Reset modal ketika pindah page
        $this->reset(['showDetailModal', 'selectedConsultation', 'editingId']);
    }

    public function render()
    {
        $consultations = ConsultationNote::with('coordinator')
            ->where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.mahasiswa.konsultasi', [
            'consultations' => $consultations,
        ])->layout('layouts.app');
    }
}