<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'amount',
        'description',
        'date',
        'status',
        'payment_method',
        'payment_proof',
        'verified_by',
        'verified_at',
        'rejection_note',
    ];

    // 🔗 Relasi ke User (pembuat transaksi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 🔗 Relasi ke Verifikator (admin atau koordinator)
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
