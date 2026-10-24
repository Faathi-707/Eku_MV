"""
Standalone FastAPI prediction service.

Self-contained — depends only on the two joblib artifacts sitting next to
this file (model.joblib and count_model.joblib). No training-pipeline code
required. Drop this whole folder into your Laravel project and run:

    pip install -r requirements.txt
    uvicorn app:app --host 0.0.0.0 --port 8000

Endpoints:
    GET  /health                 — artifact metadata
    POST /predict                — one row  → per-trip prediction
    POST /predict/batch          — many rows (vectorised)
    POST /forecast               — one day's weather → forecast per route
"""

from __future__ import annotations

import os
from pathlib import Path
from typing import Any

import joblib
import pandas as pd
from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, Field


HERE = Path(__file__).resolve().parent
MODEL_PATH = Path(os.getenv("MODEL_ARTIFACT_PATH", HERE / "model.joblib"))
COUNT_PATH = Path(os.getenv("COUNT_MODEL_ARTIFACT_PATH",
                             HERE / "count_model.joblib"))


# -------- load artifacts once at startup --------------------------------

if not MODEL_PATH.exists():
    raise RuntimeError(
        f"Per-trip model artifact not found at {MODEL_PATH}. "
        "Place model.joblib next to app.py or set MODEL_ARTIFACT_PATH."
    )
ARTIFACT: dict[str, Any] = joblib.load(MODEL_PATH)
MODEL = ARTIFACT["model"]
FEATURES: list[str] = ARTIFACT["features"]
TARGET: str = ARTIFACT["target"]
ROUTE_MEANS: dict[str, float] = ARTIFACT["route_means"]
OVERALL_MEAN: float = ARTIFACT["overall_mean"]

COUNT_ARTIFACT: dict[str, Any] | None = None
if COUNT_PATH.exists():
    COUNT_ARTIFACT = joblib.load(COUNT_PATH)


# -------- schemas -------------------------------------------------------

class PredictRequest(BaseModel):
    route_id: str = Field(..., description="Route identifier")
    features: dict[str, float] = Field(
        ..., description="Feature name → numeric value (see /health)"
    )


class PredictResponse(BaseModel):
    route_id: str
    target: str
    route_known: bool
    predictions: dict[str, float]
    features_used: list[str]
    missing_features: list[str]


class BatchRequest(BaseModel):
    rows: list[PredictRequest]


class BatchResponse(BaseModel):
    target: str
    rows: list[PredictResponse]


class ForecastRequest(BaseModel):
    date: str = Field(..., description="ISO date, e.g. '2026-03-15'")
    weather: dict[str, float] = Field(
        ..., description="Daily weather (era5_wind_kmh, era5_swh_m, era5_tp_mm, ...)"
    )
    routes: list[str] | None = Field(
        default=None, description="Restrict output to these route_ids"
    )


class RouteForecast(BaseModel):
    route_id: str
    route_known: bool
    expected_trips: float | None
    normal_trips: float | None
    suppression_pct: float | None
    per_trip_delta: float | None
    per_trip_baseline: float | None


class ForecastResponse(BaseModel):
    date: str
    per_trip_target: str
    count_target: str | None
    rows: list[RouteForecast]


# -------- app -----------------------------------------------------------

app = FastAPI(
    title="Maldives route-change prediction service",
    version="1.0.0",
)

# Set CORS_ORIGINS="https://yoursite.com,https://staging.yoursite.com" in
# production. "*" is fine for local dev / demos.
_origins = os.getenv("CORS_ORIGINS", "*")
app.add_middleware(
    CORSMiddleware,
    allow_origins=[o.strip() for o in _origins.split(",")],
    allow_methods=["GET", "POST"],
    allow_headers=["*"],
)


@app.get("/health")
def health() -> dict[str, Any]:
    body: dict[str, Any] = {
        "status": "ok",
        "per_trip_model": {
            "mode": ARTIFACT.get("mode"),
            "target": TARGET,
            "features": FEATURES,
            "n_known_routes": len(ROUTE_MEANS),
            "trained_at": ARTIFACT.get("trained_at"),
            "n_rows_trained": ARTIFACT.get("n_rows"),
        },
    }
    if COUNT_ARTIFACT is not None:
        body["count_model"] = {
            "target":         COUNT_ARTIFACT["target"],
            "features":       COUNT_ARTIFACT["features"],
            "n_known_routes": len(COUNT_ARTIFACT["route_means"]),
            "trained_at":     COUNT_ARTIFACT.get("trained_at"),
            "n_rows_trained": COUNT_ARTIFACT.get("n_rows"),
        }
    else:
        body["count_model"] = None
    return body


def _predict_one(req: PredictRequest) -> PredictResponse:
    missing = [f for f in FEATURES if f not in req.features]
    if missing:
        raise HTTPException(
            status_code=422,
            detail={"error": "missing_features", "missing": missing,
                    "expected": FEATURES},
        )
    row = pd.DataFrame([[req.features[f] for f in FEATURES]], columns=FEATURES)
    tree_pred = float(MODEL.predict(row)[0])
    baseline = float(ROUTE_MEANS.get(req.route_id, OVERALL_MEAN))
    return PredictResponse(
        route_id=req.route_id,
        target=TARGET,
        route_known=req.route_id in ROUTE_MEANS,
        predictions={
            "tree_model": tree_pred,
            "route_mean_baseline": baseline,
        },
        features_used=FEATURES,
        missing_features=[],
    )


@app.post("/predict", response_model=PredictResponse)
def predict(req: PredictRequest) -> PredictResponse:
    return _predict_one(req)


@app.post("/predict/batch", response_model=BatchResponse)
def predict_batch(req: BatchRequest) -> BatchResponse:
    if not req.rows:
        raise HTTPException(status_code=422, detail="rows must be non-empty")
    for r in req.rows:
        miss = [f for f in FEATURES if f not in r.features]
        if miss:
            raise HTTPException(
                status_code=422,
                detail={"error": "missing_features",
                        "route_id": r.route_id, "missing": miss,
                        "expected": FEATURES},
            )
    X = pd.DataFrame(
        [[r.features[f] for f in FEATURES] for r in req.rows],
        columns=FEATURES,
    )
    tree_preds = MODEL.predict(X).astype(float)
    out = []
    for r, tp in zip(req.rows, tree_preds):
        out.append(PredictResponse(
            route_id=r.route_id,
            target=TARGET,
            route_known=r.route_id in ROUTE_MEANS,
            predictions={
                "tree_model": float(tp),
                "route_mean_baseline": float(
                    ROUTE_MEANS.get(r.route_id, OVERALL_MEAN)
                ),
            },
            features_used=FEATURES,
            missing_features=[],
        ))
    return BatchResponse(target=TARGET, rows=out)


def _row_for_features(wanted: list[str],
                      weather: dict[str, float],
                      route_meta: dict[str, float],
                      dow: int, month: int) -> list[float]:
    row = []
    for f in wanted:
        if f in weather:
            row.append(float(weather[f]))
        elif f == "day_of_week":
            row.append(float(dow))
        elif f == "month":
            row.append(float(month))
        elif f in route_meta:
            row.append(float(route_meta[f]))
        else:
            row.append(float("nan"))
    return row


@app.post("/forecast", response_model=ForecastResponse)
def forecast(req: ForecastRequest) -> ForecastResponse:
    try:
        d = pd.Timestamp(req.date)
    except (TypeError, ValueError):
        raise HTTPException(status_code=422, detail="date must be ISO-formatted")
    dow = int(d.dayofweek)
    month = int(d.month)

    route_ids = req.routes if req.routes else sorted(ROUTE_MEANS.keys())

    count_meta: dict[str, dict[str, float]] = {}
    if COUNT_ARTIFACT is not None:
        count_meta = COUNT_ARTIFACT.get("route_metadata", {})

    per_trip_X_rows = [
        _row_for_features(FEATURES, req.weather,
                           count_meta.get(rid, {}), dow, month)
        for rid in route_ids
    ]
    X_trip = pd.DataFrame(per_trip_X_rows, columns=FEATURES)
    per_trip_pred = MODEL.predict(
        X_trip.fillna(X_trip.mean(numeric_only=True))
    ).astype(float)

    if COUNT_ARTIFACT is not None:
        count_features = COUNT_ARTIFACT["features"]
        count_route_means = COUNT_ARTIFACT["route_means"]
        count_overall = COUNT_ARTIFACT["overall_mean"]
        X_count = pd.DataFrame(
            [_row_for_features(count_features, req.weather,
                               count_meta.get(rid, {}), dow, month)
             for rid in route_ids],
            columns=count_features,
        )
        count_pred = COUNT_ARTIFACT["model"].predict(
            X_count.fillna(X_count.mean(numeric_only=True))
        ).astype(float)
    else:
        count_route_means = {}
        count_overall = None
        count_pred = [None] * len(route_ids)

    rows: list[RouteForecast] = []
    for i, rid in enumerate(route_ids):
        expected = float(count_pred[i]) if COUNT_ARTIFACT is not None else None
        normal = count_route_means.get(rid, count_overall) if COUNT_ARTIFACT else None
        suppression = None
        if expected is not None and normal and normal > 0:
            suppression = max(0.0, min(100.0, 100.0 * (1 - expected / normal)))
        rows.append(RouteForecast(
            route_id=rid,
            route_known=rid in ROUTE_MEANS,
            expected_trips=expected,
            normal_trips=float(normal) if normal is not None else None,
            suppression_pct=suppression,
            per_trip_delta=float(per_trip_pred[i]),
            per_trip_baseline=float(ROUTE_MEANS.get(rid, OVERALL_MEAN)),
        ))

    return ForecastResponse(
        date=req.date,
        per_trip_target=TARGET,
        count_target=(COUNT_ARTIFACT["target"] if COUNT_ARTIFACT else None),
        rows=rows,
    )
