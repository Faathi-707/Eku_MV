<?php

namespace App\Services\Prediction;

enum PredictionStatus: string
{
    case Ok = 'ok';
    case MissingFeatures = 'missing_features';
    case Unavailable = 'unavailable';
}
