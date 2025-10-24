<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('category')->latest()->take(8)->get();
        return view('pages.home.index', compact('categories', 'products'));
    }
}
