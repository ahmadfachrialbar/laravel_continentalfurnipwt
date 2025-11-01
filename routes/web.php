<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('pages.home.index');
});

// Move all use statements to the top

// Regular user routes group
Route::middleware(['web', 'auth:web'])->group(function () {
    // Your existing authenticated user routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Home routes


Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');

// Cart routes


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Category routes

Route::get('/', [CategoryController::class, 'home'])->name('home');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');


// login and register routes

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Checkout routes

Route::middleware(['auth'])->group(function () {
    // Halaman utama checkout (form)
    Route::get('/checkout', [CheckoutController::class, 'index'])
    ->middleware('auth.redirect')
    ->name('checkout.index');

    // Proses simpan order + lanjut pembayaran
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Halaman sukses setelah checkout
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

    
});










