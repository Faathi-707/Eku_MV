<?php

use App\Services\Prediction\PredictionService;
use App\Services\Prediction\PredictionStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('services.model.url', 'http://model.test');
    config()->set('services.model.timeout', 5);
    Cache::flush();
});

test('predict returns ok result and caches response', function () {
    Http::fake([
        'model.test/predict' => Http::response([
            'route_id' => 'P0001-P0007',
            'target' => 'trip_delta_duration',
            'route_known' => true,
            'predictions' => ['tree_model' => 0.08, 'route_mean_baseline' => 0.12],
            'features_used' => [],
            'missing_features' => [],
        ], 200),
    ]);

    $service = app(PredictionService::class);
    $features = ['era5_wind_kmh' => 22.5];

    $first = $service->predict('P0001-P0007', $features);
    $second = $service->predict('P0001-P0007', $features);

    expect($first->status)->toBe(PredictionStatus::Ok)
        ->and($first->routeKnown)->toBeTrue()
        ->and($first->headlineDeltaPct())->toBe(12.0)
        ->and($second->headlineDeltaPct())->toBe(12.0);

    Http::assertSentCount(1);
});

test('predict returns missing_features result on 422', function () {
    Http::fake([
        'model.test/predict' => Http::response([
            'detail' => [
                'error' => 'missing_features',
                'missing' => ['era5_swh_m', 'day_of_week'],
                'expected' => ['era5_wind_kmh', 'era5_swh_m', 'day_of_week'],
            ],
        ], 422),
    ]);

    $result = app(PredictionService::class)->predict('P0001-P0007', ['era5_wind_kmh' => 1]);

    expect($result->status)->toBe(PredictionStatus::MissingFeatures)
        ->and($result->missingFeatures)->toBe(['era5_swh_m', 'day_of_week']);
});

test('predict returns unavailable on 500', function () {
    Http::fake([
        'model.test/predict' => Http::response(['error' => 'boom'], 500),
    ]);

    $result = app(PredictionService::class)->predict('P0001-P0007', ['era5_wind_kmh' => 1]);

    expect($result->status)->toBe(PredictionStatus::Unavailable);
});
