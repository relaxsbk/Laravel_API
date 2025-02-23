<?php

use App\Http\Controllers\api\v1\Booking\BookingController;
use App\Http\Controllers\api\v1\Resource\ResourceController;

use Illuminate\Support\Facades\Route;

require __DIR__ . '/groups/user.group.php';

Route::group(['prefix' => 'v1'], function () {
      Route::apiResource('resources', ResourceController::class);
      Route::get('/resources/{resource}/bookings', [ResourceController::class, 'showWithBookings'])->name('resources.bookings');

      Route::apiResource('bookings', BookingController::class)->only(['store', 'destroy']);

});


