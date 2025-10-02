<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
{
    $this->configureRateLimiting();

    $this->routes(function () {
        require base_path('routes/web.php');
    });
}

protected function configureRateLimiting()
{
    RateLimiter::for('review', function ($request) {
        return Limit::perMinute(3)->by($request->user()->id);
    });

    RateLimiter::for('checkout', function ($request) {
        return Limit::perMinute(5)->by($request->user()->id);
    });
}
}
