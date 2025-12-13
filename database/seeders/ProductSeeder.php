<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kursi = Category::where('slug', 'kursi')->first();
        $meja = Category::where('slug', 'meja')->first();
        $lemari = Category::where('slug', 'lemari')->first();
        $tempatTidur = Category::where('slug', 'tempat-tidur')->first();

        $products = [
            [
                'category_id' => $kursi->id,
                'name' => 'Kursi Kayu Minimalis',
                'description' => 'Kursi kayu jati desain minimalis, cocok untuk ruang tamu.',
                'price' => 450000,
                'weight' => 8000,
                'stock' => 15,
                'image' => 'assetseeder/kursi-kayu-minimalis.jpeg',
            ],
            [
                'category_id' => $meja->id,
                'name' => 'Meja Makan 4 Kursi',
                'description' => 'Set meja makan kayu solid lengkap dengan 4 kursi.',
                'price' => 2500000,
                'weight' => 25000,
                'stock' => 8,
                'image' => 'assetseeder/meja-makan-4-kursi.jpeg',
            ],
            [
                'category_id' => $lemari->id,
                'name' => 'Lemari Pakaian 2 Pintu',
                'description' => 'Lemari pakaian kayu dengan kapasitas besar.',
                'price' => 1800000,
                'weight' => 30000,
                'stock' => 6,
                'image' => 'assetseeder/lemari-2-pintu.jpeg',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'weight' => $product['weight'],
                'stock' => $product['stock'],
                'image' => $product['image'],
            ]);
        }
    }
}
