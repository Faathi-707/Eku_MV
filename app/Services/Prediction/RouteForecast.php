<?php

namespace App\Services\Prediction;

class RouteForecast
{
    public function __construct(
        public readonly string $routeId,
        public readonly bool $routeKnown,
        public readonly ?float $expectedTrips,
        public readonly ?float $normalTrips,
        public readonly ?float $suppressionPct,
        public readonly ?float $perTripDelta,
        public readonly ?float $perTripBaseline,
    ) {}

    public static function fromArray(array $row): self
    {
        return new self(
            routeId: (string) $row['route_id'],
            routeKnown: (bool) ($row['route_known'] ?? false),
            expectedTrips: isset($row['expected_trips']) ? (float) $row['expected_trips'] : null,
            normalTrips: isset($row['normal_trips']) ? (float) $row['normal_trips'] : null,
            suppressionPct: isset($row['suppression_pct']) ? (float) $row['suppression_pct'] : null,
            perTripDelta: isset($row['per_trip_delta']) ? (float) $row['per_trip_delta'] : null,
            perTripBaseline: isset($row['per_trip_baseline']) ? (float) $row['per_trip_baseline'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'route_id' => $this->routeId,
            'route_known' => $this->routeKnown,
            'expected_trips' => $this->expectedTrips,
            'normal_trips' => $this->normalTrips,
            'suppression_pct' => $this->suppressionPct,
            'per_trip_delta' => $this->perTripDelta,
            'per_trip_baseline' => $this->perTripBaseline,
        ];
    }
}
