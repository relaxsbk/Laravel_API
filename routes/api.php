<?php

use App\Http\Controllers\api\v1\Booking\BookingController;
use App\Http\Controllers\api\v1\Resource\ResourceController;
use App\Http\Controllers\api\v1\User\AuthController;
use App\Http\Controllers\api\v1\User\RegisterController;
use App\Http\Controllers\api\v1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('resources', ResourceController::class)->middleware(['draftResource'])->only(['show']);

});

Route::controller(BookingController::class)->prefix('v1')->group(function () {
    //
});

//по окончанию вынести в файл
Route::controller(UserController::class)->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
});
