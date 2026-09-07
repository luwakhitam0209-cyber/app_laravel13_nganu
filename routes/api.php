<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ShippingController;


// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


// PRODUCTS
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);


// PAYMENT
Route::post('/payment/create', [PaymentController::class, 'create']);


// SHIPPING
Route::get('/shipping/destinations', [ShippingController::class, 'destinations']);
Route::post('/shipping/cost', [ShippingController::class, 'cost']);