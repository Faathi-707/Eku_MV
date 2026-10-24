$port = if ($env:PORT) { $env:PORT } else { "8000" }
py -3.11 -m uvicorn app:app --host 0.0.0.0 --port $port
