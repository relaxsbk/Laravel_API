<?php

use App\Models\Booking;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/notification', function () {

    $booking = Booking::find(24);

    $bookingData = [
        'user' => $booking->user->name,
        'resource' => $booking->resource->name,
    ];
    return (new \App\Mail\BookingCanceledMail($bookingData));
});
