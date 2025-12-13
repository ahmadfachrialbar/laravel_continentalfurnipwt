<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kursi',
                'description' => 'Produk Kursi berbagai model',
            ],
            [
                'name' => 'Meja',
                'description' => 'Produk Meja',
            ],
            [
                'name' => 'Lemari',
                'description' => 'Berbagai Lemari',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
