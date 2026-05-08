<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword']);

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API'], 200);
});

Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});
