<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\User\AuthController;
use App\Http\Controllers\api\v1\User\RegisterController;
use App\Http\Controllers\api\v1\User\UserController;


Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('/login', 'login')->name('login');
});

Route::controller(RegisterController::class)->prefix('v1')->group(function () {
    Route::post('/register', 'register')->name('register');
});

Route::controller(UserController::class)->prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::delete('/logout', 'logout')->name('logout');
    Route::delete('/logoutAll', 'logoutAll')->name('logoutAll');
});

