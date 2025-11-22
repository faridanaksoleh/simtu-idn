<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nim',
        'password',
        'role',
        'major',      // TAMBAH INI
        'class',      // TAMBAH INI  
        'phone',      // TAMBAH INI
        'photo',      // TAMBAH INI
        'is_active',  // TAMBAH INI (jika ada di migration)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // TAMBAH INI jika ada field is_active
            'last_login' => 'datetime', // TAMBAH INI jika ada field last_login
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function verifiedTransactions()
    {
        return $this->hasMany(Transaction::class, 'verified_by');
    }

    // TAMBAHKAN RELATIONSHIP UNTUK KONSULTASI
    public function sentConsultations()
    {
        return $this->hasMany(ConsultationNote::class, 'student_id');
    }

    public function receivedConsultations()
    {
        return $this->hasMany(ConsultationNote::class, 'coordinator_id');
    }

    // Helper method untuk mengecek apakah user adalah koordinator
    public function isCoordinator()
    {
        return $this->role === 'koordinator';
    }

    // Helper method untuk mengecek apakah user adalah mahasiswa
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}