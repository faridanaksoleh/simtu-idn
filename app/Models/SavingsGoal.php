<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal_name',
        'target_amount',
        'current_amount',
        'start_date',
        'deadline',
        'status',
    ];

    // ✅ TAMBAH INI: Cast tanggal ke Carbon
    protected $casts = [
        'deadline' => 'date',
        'start_date' => 'date',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}