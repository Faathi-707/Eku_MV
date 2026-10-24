<?php

namespace App\Services\Prediction;

class PredictionResult
{
    /**
     * @param  array<string, float>|null  $predictions  ['tree_model' => float, 'route_mean_baseline' => float]
     * @param  list<string>  $missingFeatures
     */
    public function __construct(
        public readonly PredictionStatus $status,
        public readonly ?string $routeId = null,
        public readonly ?bool $routeKnown = null,
        public readonly ?array $predictions = null,
        public readonly array $missingFeatures = [],
    ) {}

    public static function ok(array $payload): self
    {
        return new self(
            status: PredictionStatus::Ok,
            routeId: $payload['route_id'] ?? null,
            routeKnown: $payload['route_known'] ?? null,
            predictions: $payload['predictions'] ?? null,
        );
    }

    public static function missingFeatures(array $missing): self
    {
        return new self(
            status: PredictionStatus::MissingFeatures,
            missingFeatures: $missing,
        );
    }

    public static function unavailable(): self
    {
        return new self(status: PredictionStatus::Unavailable);
    }

    public function headlineDeltaPct(): ?float
    {
        $baseline = $this->predictions['route_mean_baseline'] ?? null;

        return $baseline === null ? null : $baseline * 100;
    }
}
