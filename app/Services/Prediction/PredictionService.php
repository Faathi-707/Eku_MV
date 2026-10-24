<?php

namespace App\Services\Prediction;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PredictionService
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly int $timeout,
    ) {}

    /**
     * Fetch the service schema. Cached for 10 minutes.
     *
     * @return array<string, mixed>|null null when the service is unreachable
     */
    public function health(): ?array
    {
        return Cache::remember('model_service:health', now()->addMinutes(10), function () {
            try {
                return $this->client()->get('/health')->throw()->json();
            } catch (ConnectionException|RequestException $e) {
                Log::warning('Model service /health failed', ['message' => $e->getMessage()]);

                return null;
            }
        });
    }

    /**
     * @param  array<string, float|int>  $features
     */
    public function predict(string $routeId, array $features): PredictionResult
    {
        $key = 'route_pred:'.$routeId.':'.md5(json_encode($features));

        return Cache::remember($key, now()->addMinutes(30), fn () => $this->call($routeId, $features));
    }

    private function call(string $routeId, array $features): PredictionResult
    {
        try {
            $response = $this->client()->post('/predict', [
                'route_id' => $routeId,
                'features' => $features,
            ]);

            if ($response->status() === 422) {
                $detail = $response->json('detail', []);

                return PredictionResult::missingFeatures($detail['missing'] ?? []);
            }

            return PredictionResult::ok($response->throw()->json());
        } catch (ConnectionException|RequestException $e) {
            Log::warning('Model service /predict failed', [
                'route_id' => $routeId,
                'message' => $e->getMessage(),
            ]);

            return PredictionResult::unavailable();
        }
    }

    /**
     * @param  array<string, float|int>  $weather
     * @param  list<string>|null  $routes
     */
    public function forecast(string $date, array $weather, ?array $routes = null): ForecastResult
    {
        try {
            $body = ['date' => $date, 'weather' => $weather];
            if ($routes !== null) {
                $body['routes'] = $routes;
            }

            Log::info('Model service /forecast request', ['body' => $body]);
            $response = $this->client()->post('/forecast', $body);
            Log::info('Model service /forecast response', [
                'status' => $response->status(),
                'body' => mb_substr($response->body(), 0, 500),
            ]);

            return ForecastResult::ok($response->throw()->json());
        } catch (ConnectionException|RequestException $e) {
            Log::warning('Model service /forecast failed', [
                'date' => $date,
                'message' => $e->getMessage(),
            ]);

            return ForecastResult::unavailable();
        }
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->timeout($this->timeout)
            ->retry(2, 200, throw: false)
            ->acceptJson();
    }
}
