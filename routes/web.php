<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;


// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// AUTH ROUTES
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// PRODUCT
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');

// CART
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// CATEGORY
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-orders', [ProfileController::class, 'myOrders'])->name('profile.orders');
});


// CHECKOUT
Route::middleware(['auth'])->group(function () {

    // halaman form checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // proses store
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // review
    Route::get('/order/{id}/review', [CheckoutController::class, 'review'])->name('order.review');

    // success
    Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])
    ->name('checkout.success');

    // detail order
    Route::get('/checkout/{id}/detail', [CheckoutController::class, 'detail'])->name('order.detail');


   
});

// AJAX RAJAONGKIR
Route::get('/provinces', [RajaOngkirController::class, 'getProvinces']);
Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
Route::get('/districts/{cityId}', [RajaOngkirController::class, 'getDistricts']);
Route::post('/check-ongkir', [RajaOngkirController::class, 'checkOngkir']);



