<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/products', ProductController::class);
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