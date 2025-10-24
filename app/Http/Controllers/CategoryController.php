<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan kategori & produk di homepage
    public function home()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->latest()->take(8)->get();

        return view('pages.home.index', compact('categories', 'products'));
    }

    // Ketika kategori diklik di homepage, arahkan ke halaman produk sesuai kategori
    public function show($slug)
    {
        return redirect()->route('products.byCategory', ['slug' => $slug]);
    }
}
