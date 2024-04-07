<?php

use Illuminate\Support\Facades\Route;



Route::post('captcha', [\Zealov\Controllers\Api\AuthController::class, 'captcha']);
Route::post('login', [\Zealov\Controllers\Api\AuthController::class, 'login']);
Route::post('refresh', [\Zealov\Controllers\Api\AuthController::class, 'refresh']);
Route::middleware('auth:admin')->group(function () {
    Route::post('me', [\Zealov\Controllers\Api\AuthController::class, 'getUserInfo']);
    Route::post('logout', [\Zealov\Controllers\Api\AuthController::class, 'logout']);
});

