<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@idn.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Koordinator Keuangan',
            'email' => 'koordinator@idn.ac.id',
            'password' => Hash::make('koor123'),
            'role' => 'koordinator',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@idn.ac.id',
            'password' => Hash::make('mhs123'),
            'role' => 'mahasiswa',
            'nim' => '221101001',
            'major' => 'TRPL',
            'class' => 'A',
            'is_active' => true,
        ]);
    }
}
