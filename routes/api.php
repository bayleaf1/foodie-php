<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SystemUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login/system-user', [AuthController::class, 'login']);
Route::post('/auth/register/system-user', [AuthController::class, 'register']);

// Route::resource('/system-user', SystemUserController::class)->middleware('auth:sanctum');
Route::get('/system-users/me', [SystemUserController::class, 'me'])->middleware('auth:sanctum');
Route::get('/system-users/profile/{id}', [SystemUserController::class, 'profile'])->middleware('auth:sanctum');
Route::patch('/system-users/profile/{id}', [SystemUserController::class, 'update'])->middleware('auth:sanctum');
Route::get('/system-users/table', [SystemUserController::class, 'table'])->middleware('auth:sanctum');

Route::post('/products/cart', [ProductController::class, 'cart']);
Route::get('/products/showcase/{id}', [ProductController::class, 'showcase']);
Route::get('/products/table', [ProductController::class, 'table'])->middleware('auth:sanctum');
Route::get('/products/menu', [ProductController::class, 'menu']);
Route::get('/products/message', [ProductController::class, 'sendMessage']);
Route::resource('/products', ProductController::class)->middleware('auth:sanctum');

Route::patch('/orders/confirm/{id}', [OrderController::class, 'confirm'])->middleware('auth:sanctum');
Route::patch('/orders/finalize/{id}', [OrderController::class, 'finalize'])->middleware('auth:sanctum');
;
Route::patch('/orders/cancel/{id}', [OrderController::class, 'cancel'])->middleware('auth:sanctum');
Route::get('/orders/table', [OrderController::class, 'table'])->middleware('auth:sanctum');
Route::resource('/orders', OrderController::class)->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders/guest', [OrderController::class, 'ordersForGuest']);

Route::resource('/resources', ResourceController::class);//->middleware('auth:sanctum');
