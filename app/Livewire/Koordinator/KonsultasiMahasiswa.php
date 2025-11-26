<?php

namespace App\Livewire\Koordinator;

use Livewire\Component;
use App\Models\ConsultationNote;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class KonsultasiMahasiswa extends Component
{
    use WithPagination;

    public $selectedConsultation = null;
    public $replyMessage = '';
    public $filterStatus = 'all';
    public $search = '';

    protected $rules = [
        'replyMessage' => 'required|min:10',
    ];

    protected $listeners = ['refresh' => '$refresh'];

    // 🔥 SAMA PERSIS DENGAN MAHASISWA
    public function paginationView()
    {
        return 'livewire::bootstrap';
    }

    public function updatingPage($page)
    {
        $this->reset(['selectedConsultation', 'replyMessage']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->reset(['selectedConsultation', 'replyMessage']);
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
        $this->reset(['selectedConsultation', 'replyMessage']);
    }

    // 🔥 METHOD resetFilters YANG BENAR
    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus', 'selectedConsultation', 'replyMessage']);
        $this->resetPage();
    }

    public function selectConsultation($consultationId)
    {
        try {
            $this->selectedConsultation = ConsultationNote::with(['student', 'coordinator'])
                ->where('id', $consultationId)
                ->firstOrFail();

            $this->reset('replyMessage');
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal memuat konsultasi: ' . $e->getMessage()
            ]);
        }
    }

    public function closeDetail()
    {
        $this->reset(['selectedConsultation', 'replyMessage']);
    }

    public function sendReply()
    {
        $this->validate();

        try {
            $consultation = ConsultationNote::findOrFail($this->selectedConsultation->id);
            
            $consultation->update([
                'response' => $this->replyMessage,
                'status' => 'replied',
                'coordinator_id' => Auth::id(),
            ]);

            // 🔥 KIRIM NOTIFIKASI KE MAHASISWA
            \App\Services\NotificationService::notifyConsultationReply($consultation);

            $this->reset('replyMessage');
            
            $this->dispatch('showSuccess', [
                'message' => 'Balasan berhasil dikirim!'
            ]);
            
            // Refresh selected consultation
            $this->selectConsultation($consultation->id);
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal mengirim balasan: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $query = ConsultationNote::with(['student', 'coordinator'])
            ->whereHas('student', function($studentQuery) {
                $studentQuery->where('class', Auth::user()->class);
            });

        // Filter berdasarkan status
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Filter berdasarkan pencarian
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%')
                  ->orWhereHas('student', function($studentQuery) {
                      $studentQuery->where('name', 'like', '%' . $this->search . '%')
                                 ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $consultations = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistik untuk cards
        $stats = [
            'total' => ConsultationNote::whereHas('student', function($q) {
                $q->where('class', Auth::user()->class);
            })->count(),
            'pending' => ConsultationNote::whereHas('student', function($q) {
                $q->where('class', Auth::user()->class);
            })->where('status', 'pending')->count(),
            'replied' => ConsultationNote::whereHas('student', function($q) {
                $q->where('class', Auth::user()->class);
            })->where('status', 'replied')->count(),
        ];

        return view('livewire.koordinator.konsultasi-mahasiswa', [
            'consultations' => $consultations,
            'stats' => $stats,
        ])->layout('layouts.app');
    }
}