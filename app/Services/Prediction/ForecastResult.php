<?php

namespace App\Services\Prediction;

class ForecastResult
{
    /**
     * @param  list<RouteForecast>  $rows
     */
    public function __construct(
        public readonly PredictionStatus $status,
        public readonly ?string $date = null,
        public readonly ?string $perTripTarget = null,
        public readonly ?string $countTarget = null,
        public readonly array $rows = [],
    ) {}

    public static function ok(array $payload): self
    {
        return new self(
            status: PredictionStatus::Ok,
            date: $payload['date'] ?? null,
            perTripTarget: $payload['per_trip_target'] ?? null,
            countTarget: $payload['count_target'] ?? null,
            rows: array_map(RouteForecast::fromArray(...), $payload['rows'] ?? []),
        );
    }

    public static function unavailable(): self
    {
        return new self(status: PredictionStatus::Unavailable);
    }
}
