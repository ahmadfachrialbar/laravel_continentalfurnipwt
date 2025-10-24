<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('category')->latest()->paginate(12);

        // Tidak ada kategori aktif
        $categoryActive = null;

        return view('pages.products.index', compact('products', 'categories', 'categoryActive'));
    }

    // Menampilkan produk berdasarkan kategori
    public function byCategory($slug)
    {
        $categoryActive = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        $products = Product::where('category_id', $categoryActive->id)
            ->with('category')
            ->latest()
            ->paginate(12);

        // Pastikan dikirim ke view yang sama
        return view('pages.products.index', compact('products', 'categories', 'categoryActive'));
    }

    // Halaman detail produk
    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('pages.products.detailProduct', compact('product', 'relatedProducts'));
    }

    // tampilan di home
    public function home()
    {
        $products = Product::with('category')->latest()->take(8)->get();
        return view('pages.home.index', compact('products'));
    }
}
