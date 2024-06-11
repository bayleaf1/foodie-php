<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SystemUserController;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login/system-user', [AuthController::class, 'login']);
Route::post('/auth/register/system-user', [AuthController::class, 'register']);

Route::resource('/system-user', SystemUserController::class)->middleware('auth:sanctum');
Route::get('/system-users/profile', [SystemUserController::class, 'getProfile'])->middleware('auth:sanctum');
Route::resource('/products', ProductController::class)->middleware('auth:sanctum');
Route::resource('/orders', OrderController::class)->middleware('auth:sanctum');
Route::patch('/orders/confirm/{id}', [OrderController::class, 'confirm']);
Route::patch('/orders/finalize/{id}', [OrderController::class, 'finalize']);
Route::patch('/orders/cancel/{id}', [OrderController::class, 'cancel']);

Route::post('/tokens/create', function (Request $request) {
    // $token = $request->user()->createToken($request->token_name);
    $t = SystemUser::create(["name" => "Ion"])->createToken("lala");
    return ['token' => $t->plainTextToken];
});
Route::get('/tokens', function (Request $request) {
    echo $request->user()->name;
    return [1];
})->middleware('auth:sanctum');