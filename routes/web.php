<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home.index');
});
Route::get('/cart', function () {
    return view('pages.cart.index');
});

Route::get('/login', function () {
    return view('pages.auth.login');
});
Route::get('/register', function () {
    return view('pages.auth.register');
});

// Home routes
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');

// Cart routes
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Category routes
use App\Http\Controllers\CategoryController;

Route::get('/', [CategoryController::class, 'home'])->name('home');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');


// login and register routes
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

// Checkout routes
use App\Http\Controllers\CheckoutController;

Route::middleware(['auth'])->group(function () {
    // Halaman utama checkout (form)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // Proses simpan order + lanjut pembayaran
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Halaman sukses setelah checkout
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

    
});







