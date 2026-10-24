# Prediction service

Self-contained FastAPI service that predicts, for a given day's weather,
how many trips will run on each route and how much longer they'll take.

## Setup

```
pip install -r requirements.txt
```

Python 3.10+.

## Run

```
# Windows
./start.ps1

# Linux / Mac
./start.sh
```

Service listens on `http://localhost:8000`. Open `/docs` for a live
Swagger UI.

## Make a prediction

`POST /forecast` with one day's weather:

```json
{
  "date": "2026-03-15",
  "weather": {
    "era5_wind_kmh": 28.1,
    "era5_swh_m": 2.0,
    "era5_tp_mm": 0.5
  }
}
```

Returns one entry per known route:

```json
{
  "rows": [
    {
      "route_id": "R-001",
      "expected_trips": 0.4,
      "normal_trips": 3.1,
      "suppression_pct": 87.1,
      "per_trip_delta": 0.18
    }
  ]
}
```

- `expected_trips` — predicted trips on this route today
- `normal_trips` — this route's historical average
- `suppression_pct` — % reduction vs normal (higher = worse weather impact)
- `per_trip_delta` — predicted fractional change in trip duration (`0.18` = ~18% longer)
