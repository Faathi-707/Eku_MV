<?php

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('services.model.url', 'http://model.test');
    Cache::flush();
});

test('guests cannot call the predict endpoint', function () {
    $this->postJson(route('api.predict'), [
        'route_id' => 'A-B',
        'features' => ['era5_wind_kmh' => 1],
    ])->assertStatus(401);
});

test('authenticated users receive an ok response with headline delta', function () {
    Http::fake([
        'model.test/predict' => Http::response([
            'route_id' => 'A-B',
            'route_known' => true,
            'predictions' => ['tree_model' => 0.05, 'route_mean_baseline' => 0.1],
        ], 200),
    ]);

    $this->actingAs(User::factory()->create())
        ->postJson(route('api.predict'), [
            'route_id' => 'A-B',
            'features' => ['era5_wind_kmh' => 20],
        ])
        ->assertOk()
        ->assertJson([
            'status' => 'ok',
            'route_known' => true,
            'headline_delta_pct' => 10.0,
        ]);
});

test('missing features return 422 with the list of missing keys', function () {
    Http::fake([
        'model.test/predict' => Http::response([
            'detail' => ['missing' => ['era5_swh_m']],
        ], 422),
    ]);

    $this->actingAs(User::factory()->create())
        ->postJson(route('api.predict'), [
            'route_id' => 'A-B',
            'features' => ['era5_wind_kmh' => 20],
        ])
        ->assertStatus(422)
        ->assertJson([
            'status' => 'missing_features',
            'missing_features' => ['era5_swh_m'],
        ]);
});

test('service downtime surfaces as 503', function () {
    Http::fake([
        'model.test/predict' => Http::response([], 500),
    ]);

    $this->actingAs(User::factory()->create())
        ->postJson(route('api.predict'), [
            'route_id' => 'A-B',
            'features' => ['era5_wind_kmh' => 20],
        ])
        ->assertStatus(503)
        ->assertJson(['status' => 'unavailable']);
});

test('validation rejects non-numeric features', function () {
    $this->actingAs(User::factory()->create())
        ->postJson(route('api.predict'), [
            'route_id' => 'A-B',
            'features' => ['era5_wind_kmh' => 'windy'],
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('features.era5_wind_kmh');
});
