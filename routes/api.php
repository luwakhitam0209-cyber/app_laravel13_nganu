<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ShippingController;


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/payment/create', [PaymentController::class, 'create']);
Route::get('/shipping/destinations', [ShippingController::class, 'destinations']);
Route::post('/shipping/cost', [ShippingController::class, 'cost']);