<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::insert([
            [
                'name' => 'Oli Mesin',
                'stock' => 20,
                'capital' => 40000, // Harga Beli
                'sell' => 20000,   // Keuntungan (Harga Jual - Harga Beli)
            ],
            [
                'name' => 'Filter Udara',
                'stock' => 15,
                'capital' => 20000,
                'sell' => 15000,
            ],
            [
                'name' => 'Aki',
                'stock' => 10,
                'capital' => 250000,
                'sell' => 100000,
            ],
            [
                'name' => 'Ban Luar',
                'stock' => 8,
                'capital' => 400000,
                'sell' => 150000,
            ],
            [
                'name' => 'Ban Dalam',
                'stock' => 12,
                'capital' => 60000,
                'sell' => 30000,
            ],
            [
                'name' => 'Lampu Depan',
                'stock' => 5,
                'capital' => 50000,
                'sell' => 25000,
            ],
            [
                'name' => 'Kampas Rem',
                'stock' => 25,
                'capital' => 30000,
                'sell' => 20000,
            ],
            [
                'name' => 'Busi',
                'stock' => 30,
                'capital' => 15000,
                'sell' => 15000,
            ],
            [
                'name' => 'Shockbreaker',
                'stock' => 4,
                'capital' => 180000,
                'sell' => 70000,
            ],
            [
                'name' => 'Rantai',
                'stock' => 10,
                'capital' => 45000,
                'sell' => 25000,
            ],
        ]);

    }
}
