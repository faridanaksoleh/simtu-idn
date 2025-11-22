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

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function selectConsultation($consultationId)
    {
        $this->selectedConsultation = ConsultationNote::with(['student', 'coordinator'])
            ->where('id', $consultationId)
            ->firstOrFail();

        // Reset reply message ketika pilih konsultasi baru
        $this->reset('replyMessage');
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
                'coordinator_id' => Auth::id(), // Pastikan coordinator_id terisi
            ]);

            // Reset form
            $this->reset('replyMessage');
            
            session()->flash('success', 'Balasan berhasil dikirim!');
            
            // Refresh selected consultation data
            $this->selectConsultation($consultation->id);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengirim balasan: ' . $e->getMessage());
        }
    }

    public function markAsClosed($consultationId)
    {
        try {
            $consultation = ConsultationNote::findOrFail($consultationId);
            
            $consultation->update([
                'status' => 'closed',
            ]);

            session()->flash('success', 'Konsultasi ditandai sebagai selesai!');
            
            // Refresh jika yang ditutup adalah yang sedang dilihat
            if ($this->selectedConsultation && $this->selectedConsultation->id === $consultationId) {
                $this->selectConsultation($consultationId);
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menutup konsultasi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = ConsultationNote::with(['student', 'coordinator'])
            ->where(function($q) {
                // Koordinator hanya melihat konsultasi dari mahasiswa di kelasnya
                $q->whereHas('student', function($studentQuery) {
                    $studentQuery->where('class', Auth::user()->class);
                });
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
            'closed' => ConsultationNote::whereHas('student', function($q) {
                $q->where('class', Auth::user()->class);
            })->where('status', 'closed')->count(),
        ];

        return view('livewire.koordinator.konsultasi-mahasiswa', [
            'consultations' => $consultations,
            'stats' => $stats,
        ])->layout('layouts.app');
    }
}