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

test('forecast returns ok result with parsed route rows and caches', function () {
    Http::fake([
        'model.test/forecast' => Http::response([
            'date' => '2026-03-15',
            'per_trip_target' => 'trip_delta_duration',
            'count_target' => 'trip_count',
            'rows' => [[
                'route_id' => 'R-001',
                'route_known' => true,
                'expected_trips' => 0.4,
                'normal_trips' => 3.1,
                'suppression_pct' => 87.1,
                'per_trip_delta' => 0.18,
                'per_trip_baseline' => 0.1,
            ]],
        ], 200),
    ]);

    $service = app(PredictionService::class);
    $weather = ['era5_wind_kmh' => 28.1, 'era5_swh_m' => 2.0, 'era5_tp_mm' => 0.5];

    $first = $service->forecast('2026-03-15', $weather, ['R-001']);
    $second = $service->forecast('2026-03-15', $weather, ['R-001']);

    expect($first->status)->toBe(PredictionStatus::Ok)
        ->and($first->rows)->toHaveCount(1)
        ->and($first->rows[0]->routeId)->toBe('R-001')
        ->and($first->rows[0]->suppressionPct)->toBe(87.1)
        ->and($first->rows[0]->perTripDelta)->toBe(0.18)
        ->and($second->rows[0]->routeId)->toBe('R-001');

    Http::assertSentCount(1);
});

test('forecast returns unavailable when service is down', function () {
    Http::fake([
        'model.test/forecast' => Http::response([], 500),
    ]);

    $result = app(PredictionService::class)->forecast('2026-03-15', ['era5_wind_kmh' => 1]);

    expect($result->status)->toBe(PredictionStatus::Unavailable)
        ->and($result->rows)->toBe([]);
});

test('forecast sends routes filter when provided', function () {
    Http::fake(['model.test/forecast' => Http::response(['rows' => []], 200)]);

    app(PredictionService::class)->forecast('2026-03-15', ['era5_wind_kmh' => 1], ['A-B', 'C-D']);

    Http::assertSent(fn ($req) => $req->url() === 'http://model.test/forecast'
        && $req['routes'] === ['A-B', 'C-D']);
});
