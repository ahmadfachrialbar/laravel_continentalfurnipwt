<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

// PAYMENT CALLBACK
Route::post('/midtrans-callback', [CheckoutController::class, 'callback']);
