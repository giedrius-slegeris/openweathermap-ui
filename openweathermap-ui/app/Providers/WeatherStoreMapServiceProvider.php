<?php

namespace App\Providers;

use App\Services\WeatherStoreMapService;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class WeatherStoreMapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(WeatherStoreMapService::class, function ($app) {
            return new WeatherStoreMapService($app->make(LoggerInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
