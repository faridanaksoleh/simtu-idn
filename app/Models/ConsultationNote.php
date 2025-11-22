<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'coordinator_id',
        'subject',
        'message',
        'response',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan student (mahasiswa)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship dengan coordinator
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    // Scope untuk konsultasi yang pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope untuk konsultasi yang sudah dibalas
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    // Scope untuk konsultasi milik mahasiswa tertentu
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    // Scope untuk konsultasi milik koordinator tertentu
    public function scopeByCoordinator($query, $coordinatorId)
    {
        return $query->where('coordinator_id', $coordinatorId);
    }
}