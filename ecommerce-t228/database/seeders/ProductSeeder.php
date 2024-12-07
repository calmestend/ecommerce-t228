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
        Product::create([
            'name' => 'producto 1',
            'description' => 'descripcion 1',
            'thumbnail' => '1.webp',
            'cost' => 100,
            'price' => 120,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'producto 2',
            'description' => 'description 2',
            'thumbnail' => '2.webp',
            'cost' => 100,
            'price' => 120,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'producto 3',
            'description' => 'descripcion 3',
            'thumbnail' => '3.webp',
            'cost' => 100,
            'price' => 120,
            'category_id' => 1
        ]);
    }
}
