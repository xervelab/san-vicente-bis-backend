<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API'], 200);
});

Route::get('/status', function () {
    return response()->json(['status' => 'ok']);
});
