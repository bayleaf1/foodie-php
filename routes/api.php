<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SystemUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/login', '/admin/login')->name('login');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login/system-user', [AuthController::class, 'login']);
Route::post('/auth/register/system-user', [AuthController::class, 'register']);

// Route::resource('/system-user', SystemUserController::class)->middleware('auth:sanctum');
Route::get('/system-users/me', [SystemUserController::class, 'me'])->middleware('auth:sanctum');
Route::get('/system-users/profile/{id}', [SystemUserController::class, 'profile'])->middleware('auth:sanctum');
Route::patch('/system-users/profile/{id}', [SystemUserController::class, 'update'])->middleware('auth:sanctum');
Route::post('/system-users/table', [SystemUserController::class, 'table'])->middleware('auth:sanctum');

Route::post('/products/cart', [ProductController::class, 'cart']);
Route::get('/products/showcase/{id}', [ProductController::class, 'showcase']);
Route::post('/products/table', [ProductController::class, 'table'])->middleware('auth:sanctum');
Route::get('/products/menu', [ProductController::class, 'menu']);
Route::get('/products/message', [ProductController::class, 'sendMessage']);
Route::resource('/products', ProductController::class)->middleware('auth:sanctum');
Route::post('/invoices/table', [InvoiceController::class, 'table'])->middleware('auth:sanctum');
Route::get('/invoices/show-for-guest/{public_id}', [InvoiceController::class, 'showForGuest']);
Route::resource('/invoices', InvoiceController::class)->middleware('auth:sanctum');

Route::patch('/orders/confirm/{id}', [OrderController::class, 'confirm'])->middleware('auth:sanctum');
Route::patch('/orders/finalize/{id}', [OrderController::class, 'finalize'])->middleware('auth:sanctum');
;
Route::patch('/orders/cancel/{id}', [OrderController::class, 'cancel'])->middleware('auth:sanctum');
Route::post('/orders/table', [OrderController::class, 'table'])->middleware('auth:sanctum');
Route::resource('/orders', OrderController::class)->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders/guest', [OrderController::class, 'ordersForGuest']);
Route::post('/orders/test', [OrderController::class, 'test']);

Route::resource('/resources', ResourceController::class);//->middleware('auth:sanctum');
