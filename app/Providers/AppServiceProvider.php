<?php

namespace App\Providers;

use App\Http\Resources\Resource\MiniResourceResource;
use App\Http\Resources\Resource\ResourceResource;
use App\Models\Booking;
use App\Observers\BookingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Booking::observe(BookingObserver::class);
        MiniResourceResource::withoutWrapping();
        ResourceResource::withoutWrapping();
    }
}
