<?php

use App\Http\Controllers\api\v1\Booking\BookingController;
use App\Http\Controllers\api\v1\Resource\ResourceController;

use Illuminate\Support\Facades\Route;

require __DIR__ . '/groups/user.group.php';

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('resources', ResourceController::class)->middleware(['draftResource'])->only(['show']);
});

Route::controller(BookingController::class)->prefix('v1')->group(function () {
    //
});
