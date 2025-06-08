<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Часы 1',
            'description' => 'Описание часов 1',
            'price' => 1000,
            'image' => 'watch1.jpg',
            'type' => 'кварцевые',
            'brand' => 'Brand 1',
            'country' => 'Country 1',
            'article' => 'ART001',
        ]);

        Product::create([
            'name' => 'Часы 2',
            'description' => 'Описание часов 2',
            'price' => 2000,
            'image' => 'watch2.jpg',
            'type' => 'механические',
            'brand' => 'Brand 2',
            'country' => 'Country 2',
            'article' => 'ART002',
        ]);
    }
}