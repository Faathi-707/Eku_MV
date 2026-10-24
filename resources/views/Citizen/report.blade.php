<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Disruption Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if ($report->geojson)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    @endif
    <style>
        :root {
            --panel: #082242;
            --line: #0d3b73;
            --ink: #ffffff;
            --muted: #94a3b8;
            --chip: #0d3b73;
            --focus: #38bdf8;
            --f-display: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        body {
            background-color: #071930 !important;
            color: var(--ink);
            font-family: var(--f-display);
        }
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }
        .detail-box {
            background: rgba(12, 38, 72, 0.6);
            border: 1px solid rgba(30, 64, 115, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('Both.navbar')
    @php
        $clearancePeriods = [
            '24h' => 'Under 24 hours',
            '48h' => '1–2 days',
            'week' => '3–7 days',
            'extended' => 'Indefinite / Extended',
        ];
    @endphp
    <main class="max-w-4xl mx-auto w-full px-4 py-6 flex-grow space-y-6">
        <a href="{{ route('notifications') }}" class="inline-flex items-center gap-2 text-sm text-cyan-400 hover:underline">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to notifications
        </a>

        <article class="glass-card rounded-2xl p-6 md:p-8 border-l-4 border-l-red-500 space-y-6">
            <header class="flex items-start gap-4">
                <div class="p-3 bg-red-500/20 text-red-400 rounded-xl">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-red-400 uppercase tracking-wider">Disruption Report</span>
                    <h1 class="text-xl md:text-2xl font-bold text-white">{{ $report->category->label() }}</h1>
                    <p class="text-xs text-slate-400">Published {{ $report->published_at?->format('M j, Y - H:i') }}</p>
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="detail-box rounded-xl p-4">
                    <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Affected Area</h2>
                    <p class="text-sm text-white">{{ $report->affected_area ?: 'Not specified' }}</p>
                </div>
                <div class="detail-box rounded-xl p-4">
                    <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Expected Clearance</h2>
                    <p class="text-sm text-white">{{ $clearancePeriods[$report->clearance_period] ?? $report->clearance_period }}</p>
                    @if ($report->clear_by)
                        <p class="text-xs text-slate-400 mt-1">Clear by {{ $report->clear_by->format('M j, Y - H:i') }}</p>
                    @endif
                </div>
            </div>

            @if ($report->geojson)
                <section class="detail-box rounded-xl p-4">
                    <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Affected Area on Map</h2>
                    <div id="report-map" class="h-72 rounded-xl overflow-hidden"></div>
                </section>
            @endif

            <section class="detail-box rounded-xl p-4">
                <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cause</h2>
                <p class="text-sm text-white whitespace-pre-line">{{ $report->cause }}</p>
            </section>

            <section class="detail-box rounded-xl p-4">
                <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Alternative Routes</h2>
                <p class="text-sm text-white whitespace-pre-line">{{ $report->alternative_routes ?: 'None provided' }}</p>
            </section>

            @if ($report->other_info)
                <section class="detail-box rounded-xl p-4">
                    <h2 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Additional Information</h2>
                    <p class="text-sm text-white whitespace-pre-line">{{ $report->other_info }}</p>
                </section>
            @endif
        </article>
    </main>
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>
    @if ($report->geojson)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
        <script>
            (() => {
                const area = @json($report->geojson);
                const areaStyle = { color: '#ef4444', weight: 2, dashArray: '6 4', fillColor: '#ef4444', fillOpacity: 0.2 };
                const map = L.map('report-map', { scrollWheelZoom: false });

                L.tileLayer(@json('https://basemaps.cartocdn.com/rastertiles/'.config('services.carto.style').'/{z}/{x}/{y}.png?key='.config('services.carto.key')), {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                }).addTo(map);
                L.control.scale({ imperial: false }).addTo(map);

                const layer = area.properties?.shape === 'circle'
                    ? L.circle([area.geometry.coordinates[1], area.geometry.coordinates[0]], { ...areaStyle, radius: area.properties.radius })
                    : L.polygon(area.geometry.coordinates[0].map(([lng, lat]) => [lat, lng]), areaStyle);

                layer.addTo(map);
                map.fitBounds(layer.getBounds(), { padding: [30, 30], maxZoom: 12 });
            })();
        </script>
    @endif
</body>
</html>
