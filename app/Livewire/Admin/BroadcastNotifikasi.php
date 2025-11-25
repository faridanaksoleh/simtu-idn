<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\NotificationService;

class BroadcastNotifikasi extends Component
{
    public $title = '';
    public $message = '';
    public $target = 'students'; // students, all
    public $type = 'info';

    protected $rules = [
        'title' => 'required|min:5|max:200',
        'message' => 'required|min:10',
        'target' => 'required|in:students,all',
        'type' => 'required|in:info,success,warning,danger',
    ];

    public function broadcast()
    {
        $this->validate();

        try {
            if ($this->target === 'students') {
                NotificationService::broadcastToStudents($this->title, $this->message, $this->type);
                $targetText = 'semua mahasiswa';
            } else {
                NotificationService::broadcastToAll($this->title, $this->message, $this->type);
                $targetText = 'semua pengguna';
            }

            $this->reset(['title', 'message']);
            
            $this->dispatch('showSuccess', [
                'message' => "Notifikasi berhasil dikirim ke {$targetText}!"
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('showError', [
                'message' => 'Gagal mengirim notifikasi: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.broadcast-notifikasi')
            ->layout('layouts.app');
    }
}