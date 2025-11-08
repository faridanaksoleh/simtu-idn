<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // ===== INCOME (Pemasukan) =====
            [
                'name' => 'Setoran Tunai',
                'type' => 'income',
                'description' => 'Setoran uang tunai langsung',
                'is_active' => true,
            ],
            [
                'name' => 'Transfer Bank', 
                'type' => 'income',
                'description' => 'Transfer melalui bank',
                'is_active' => true,
            ],
            [
                'name' => 'Setoran Bulanan',
                'type' => 'income',
                'description' => 'Setoran rutin bulanan',
                'is_active' => true,
            ],
            [
                'name' => 'Setoran Awal',
                'type' => 'income',
                'description' => 'Setoran pertama/awal',
                'is_active' => true,
            ],

            // ===== EXPENSE (Pengeluaran) =====
            [
                'name' => 'Penarikan Tunai',
                'type' => 'expense',
                'description' => 'Penarikan uang tunai',
                'is_active' => true,
            ],
            [
                'name' => 'Dana Umrah',
                'type' => 'expense',
                'description' => 'Pengambilan untuk umrah',
                'is_active' => true,
            ],
            [
                'name' => 'Dana Pendidikan',
                'type' => 'expense',
                'description' => 'Pengambilan untuk pendidikan',
                'is_active' => true,
            ],
            [
                'name' => 'Dana Darurat',
                'type' => 'expense',
                'description' => 'Pengambilan untuk keperluan darurat',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Kategori income dan expense berhasil ditambahkan!');
    }
}