<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/products', ProductController::class);
Route::resource('/orders', OrderController::class);
Route::patch('/orders/confirm/{id}', [OrderController::class, 'confirm']);
Route::patch('/orders/finalize/{id}', [OrderController::class, 'finalize']);
Route::patch('/orders/cancel/{id}', [OrderController::class, 'cancel']);