<?php

namespace App\Providers;

use App\Services\Prediction\PredictionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PredictionService::class, fn ($app) => new PredictionService(
            baseUrl: $app['config']->get('services.model.url'),
            timeout: $app['config']->get('services.model.timeout'),
        ));
    }

    public function boot(): void
    {
        //
    }
}
