<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Prediction\PredictionService;
use App\Services\Prediction\PredictionStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function __construct(private readonly PredictionService $service) {}

    public function predict(Request $request): JsonResponse
    {
        $data = $request->validate([
            'route_id' => ['required', 'string', 'max:64'],
            'features' => ['required', 'array'],
            'features.*' => ['numeric'],
        ]);

        $result = $this->service->predict($data['route_id'], $data['features']);

        return response()->json([
            'status' => $result->status->value,
            'route_id' => $result->routeId,
            'route_known' => $result->routeKnown,
            'predictions' => $result->predictions,
            'headline_delta_pct' => $result->headlineDeltaPct(),
            'missing_features' => $result->missingFeatures,
        ], match ($result->status) {
            PredictionStatus::Ok => 200,
            PredictionStatus::MissingFeatures => 422,
            PredictionStatus::Unavailable => 503,
        });
    }

    public function forecast(Request $request): JsonResponse
    {
        $data = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
            'weather' => ['required', 'array'],
            'weather.*' => ['numeric'],
            'routes' => ['nullable', 'array'],
            'routes.*' => ['string', 'max:64'],
        ]);

        $result = $this->service->forecast(
            $data['date'],
            $data['weather'],
            $data['routes'] ?? null,
        );

        return response()->json([
            'status' => $result->status->value,
            'date' => $result->date,
            'per_trip_target' => $result->perTripTarget,
            'count_target' => $result->countTarget,
            'rows' => array_map(fn ($row) => $row->toArray(), $result->rows),
        ], $result->status === PredictionStatus::Ok ? 200 : 503);
    }
}
