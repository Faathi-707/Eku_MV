<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Report Marine Disruption</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

        /* Glassmorphism card container */
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }

        /* Form inputs & textareas styling */
        .form-input-box {
            background-color: #0b284f !important;
            border: 1px solid rgba(30, 75, 135, 0.6) !important;
            color: #ffffff !important;
            transition: all 0.2s ease;
        }

        .form-input-box:focus {
            border-color: #38bdf8 !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        }

        /* Map box & tools styling */
        .map-canvas-bg {
            background: radial-gradient(circle at center, #0b3464 0%, #061830 100%);
            position: relative;
            overflow: hidden;
        }

        .map-tool-btn {
            background: rgba(11, 40, 79, 0.85);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #94a3b8;
            transition: all 0.2s ease;
        }

        .map-tool-btn:hover, .map-tool-btn.active {
            background: #00d2ff;
            color: #071930;
            border-color: #00d2ff;
        }

        #area-map { background: #061830; border-radius: 1rem; }
        #area-map .leaflet-control-scale-line {
            background: rgba(7, 25, 48, 0.75);
            border-color: #94a3b8;
            color: #cbd5e1;
            font-size: 10px;
        }
        #area-map .leaflet-control-attribution {
            background: rgba(7, 25, 48, 0.7);
            color: #64748b;
            font-size: 9px;
        }
        #area-map .leaflet-control-attribution a { color: #94a3b8; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@2.17.0/dist/leaflet-geoman.css">
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('Both.navbar')

    <!-- Main Content Container -->
    <main class="max-w-4xl mx-auto w-full px-4 py-8 flex-grow space-y-6">

        <!-- Page Header Section -->
        <div class="flex items-start gap-4">
            <div class="p-3 bg-cyan-500/20 text-cyan-400 rounded-2xl border border-cyan-500/30 mt-1">
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white">Report Marine Disruption</h1>
                <p class="text-sm text-slate-400 mt-0.5">Provide details about the disruption so we can notify mariners and update routes.</p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="glass-card rounded-2xl p-6 md:p-8 shadow-2xl space-y-6">
            
            <!-- Section Header -->
            <div class="flex items-center gap-3 border-b border-blue-900/50 pb-4">
                <i class="fa-solid fa-file-lines text-cyan-400 text-lg"></i>
                <div>
                    <h2 class="font-bold text-base text-white">Disruption Details</h2>
                    <p class="text-xs text-slate-400">Complete all required fields before publishing.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-xl border border-red-500/40 bg-red-500/10 text-red-300 text-xs p-4">
                    <p class="font-semibold mb-1">Please fix the following:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Body -->
            <form action="{{ $report ? route('report.update', $report) : route('report.store') }}" method="POST" class="space-y-6">
                @csrf
                @if ($report)
                    @method('PUT')
                @endif

                <!-- Category Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Category <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <select name="category" required class="w-full form-input-box rounded-xl px-4 py-3 text-xs md:text-sm appearance-none cursor-pointer">
                            <option value="" disabled @selected(! old('category', $report?->category?->value)) class="bg-[#0b284f]">Select disruption category</option>
                            <option value="tss" @selected(old('category', $report?->category?->value) === 'tss') class="bg-[#0b284f]">Traffic Separation Schemes (TSS)</option>
                            <option value="eez" @selected(old('category', $report?->category?->value) === 'eez') class="bg-[#0b284f]">Exclusive Economic Zone (EEZ)</option>
                            <option value="anchorages" @selected(old('category', $report?->category?->value) === 'anchorages') class="bg-[#0b284f]">Negligent Anchorages and Infrastructure Accidents</option>
                            <option value="regulatory" @selected(old('category', $report?->category?->value) === 'regulatory') class="bg-[#0b284f]">Overloading and Safety Regulatory Halts</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-xs text-slate-400 pointer-events-none"></i>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5 leading-relaxed">
                        Traffic Separation Schemes (TSS); Exclusive Economic Zone (EEZ); Negligent Anchorages and Infrastructure Accidents; Overloading and Safety Regulatory Halts.
                    </p>
                </div>

                <!-- Cause Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Cause <span class="text-red-400">*</span>
                    </label>
                    <textarea name="cause" rows="3" required placeholder="Describe what happened and the source of the report..." class="w-full form-input-box rounded-xl p-4 text-xs md:text-sm resize-none">{{ old('cause', $report?->cause) }}</textarea>
                </div>

                <!-- Expected Clearance Period Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Expected clearance period <span class="text-red-400">*</span>
                        </label>
                        <span class="block text-[11px] text-slate-400 mb-1">Estimated duration</span>
                        <div class="relative">
                            <select name="clearance_period" required class="w-full form-input-box rounded-xl px-4 py-3 text-xs md:text-sm appearance-none cursor-pointer">
                                <option value="" disabled @selected(! old('clearance_period', $report?->clearance_period)) class="bg-[#0b284f]">Select duration</option>
                                <option value="24h" @selected(old('clearance_period', $report?->clearance_period) === '24h') class="bg-[#0b284f]">Under 24 hours</option>
                                <option value="48h" @selected(old('clearance_period', $report?->clearance_period) === '48h') class="bg-[#0b284f]">1–2 days</option>
                                <option value="week" @selected(old('clearance_period', $report?->clearance_period) === 'week') class="bg-[#0b284f]">3–7 days</option>
                                <option value="extended" @selected(old('clearance_period', $report?->clearance_period) === 'extended') class="bg-[#0b284f]">Indefinite / Extended</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-xs text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5 opacity-0 hidden md:block">Clear by</label>
                        <span class="block text-[11px] text-slate-400 mb-1 md:mt-5">Expected clear by</span>
                        <div class="relative flex items-center">
                            <input type="datetime-local" name="clear_by" value="{{ old('clear_by', $report?->clear_by?->format('Y-m-d\TH:i')) }}" class="w-full form-input-box rounded-xl px-4 py-2.5 text-xs md:text-sm text-slate-200 cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- Alternative Routes Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Alternative routes <span class="text-red-400">*</span>
                    </label>
                    <textarea name="alternative_routes" rows="3" placeholder="List safe alternative routes or waypoints vessels should follow..." class="w-full form-input-box rounded-xl p-4 text-xs md:text-sm resize-none">{{ old('alternative_routes', $report?->alternative_routes) }}</textarea>
                </div>

                <!-- Other Information Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Other information <span class="text-slate-500 font-normal">(Optional)</span>
                    </label>
                    <textarea name="other_info" rows="3" placeholder="Additional instructions, affected vessels, coordinates, or contact details..." class="w-full form-input-box rounded-xl p-4 text-xs md:text-sm resize-none">{{ old('other_info', $report?->other_info) }}</textarea>
                </div>

                <!-- Affected area label -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">
                        Affected area <span class="text-slate-500 font-normal">(Optional)</span>
                    </label>
                    <input type="text" name="affected_area" value="{{ old('affected_area', $report?->affected_area) }}" placeholder="e.g. Central Atolls, Malé – Thulusdhoo" class="w-full form-input-box rounded-xl px-4 py-3 text-xs md:text-sm">
                </div>

                <!-- Mark Affected Area on Map Box -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-cyan-400"></i> Mark affected area on map <span class="text-red-400">*</span>
                    </label>
                    
                    @php $markedArea = old('geojson', $report?->geojson); @endphp
                    <input type="hidden" name="geojson" id="geojson-input" value="{{ is_array($markedArea) ? json_encode($markedArea) : $markedArea }}">

                    <div class="map-canvas-bg rounded-2xl border border-blue-900/60 h-80 md:h-96 relative">
                        <div id="area-map" class="absolute inset-0"></div>

                        <!-- Map Toolbar (Left) -->
                        <div class="absolute left-4 top-4 flex flex-col gap-2 z-[1000]">
                            <button type="button" data-map-tool="select" title="Select: move around the map" class="map-tool-btn active w-9 h-9 rounded-xl flex items-center justify-center shadow"><i class="fa-solid fa-arrow-pointer text-xs"></i></button>
                            <button type="button" data-map-tool="circle" title="Circle an area" class="map-tool-btn w-9 h-9 rounded-xl flex items-center justify-center shadow"><i class="fa-regular fa-circle text-xs"></i></button>
                            <button type="button" data-map-tool="polygon" title="Draw a boundary" class="map-tool-btn w-9 h-9 rounded-xl flex items-center justify-center shadow"><i class="fa-solid fa-draw-polygon text-xs"></i></button>
                            <button type="button" data-map-tool="edit" title="Edit the marked area" class="map-tool-btn w-9 h-9 rounded-xl flex items-center justify-center shadow"><i class="fa-solid fa-pen text-xs"></i></button>
                            <button type="button" data-map-action="clear" title="Delete the marked area" class="map-tool-btn w-9 h-9 rounded-xl flex items-center justify-center shadow hover:text-red-400"><i class="fa-solid fa-trash-can text-xs"></i></button>
                        </div>

                        <!-- Map Controls (Top Right & Bottom Right) -->
                        <div class="absolute right-4 top-4 z-[1000]">
                            <button type="button" data-map-action="layers" title="Switch to satellite view" class="map-tool-btn w-9 h-9 rounded-xl flex items-center justify-center shadow"><i class="fa-solid fa-map text-xs"></i></button>
                        </div>

                        <div class="absolute right-4 bottom-16 flex flex-col gap-1 z-[1000]">
                            <button type="button" data-map-action="zoom-in" title="Zoom in" class="map-tool-btn w-9 h-8 rounded-t-xl flex items-center justify-center shadow"><i class="fa-solid fa-plus text-xs"></i></button>
                            <button type="button" data-map-action="zoom-out" title="Zoom out" class="map-tool-btn w-9 h-8 rounded-b-xl flex items-center justify-center shadow"><i class="fa-solid fa-minus text-xs"></i></button>
                        </div>

                        <div class="absolute right-4 bottom-4 z-[1000]">
                            <button type="button" data-map-action="clear" class="bg-[#0b284f]/90 hover:bg-blue-900/80 border border-blue-900 text-slate-200 text-xs px-3 py-2 rounded-xl flex items-center gap-2 shadow">
                                <i class="fa-solid fa-rotate-left text-cyan-400"></i> Clear selection
                            </button>
                        </div>

                        <!-- Drawing hint -->
                        <div id="map-hint" class="absolute left-1/2 -translate-x-1/2 top-4 z-[1000] bg-[#071930]/90 border border-cyan-500/40 text-cyan-200 text-[11px] px-3 py-1.5 rounded-full shadow pointer-events-none" hidden></div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-2">Required to publish. Use the circle or boundary tool to mark the disrupted zone.</p>
                </div>

                <!-- Verification Checkbox -->
                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" name="verified" value="1" id="verifyCheck" class="w-4 h-4 rounded bg-[#0b284f] border-blue-900 text-cyan-500 focus:ring-cyan-500 cursor-pointer">
                    <label for="verifyCheck" class="text-xs text-slate-300 font-medium cursor-pointer">
                        I confirm this report has been verified by my agency. (Required to publish.)
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-blue-900/50">
                    <button type="submit" name="intent" value="draft" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-transparent hover:bg-blue-900/30 text-slate-300 border border-blue-900/60 font-semibold text-xs transition duration-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk text-cyan-400"></i> Save draft
                    </button>

                    <button type="submit" name="intent" value="publish" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs transition duration-200 shadow-lg shadow-cyan-500/20 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Publish to Notifications
                    </button>
                </div>

            </form>

        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@2.17.0/dist/leaflet-geoman.js"></script>
    <script>
        (() => {
            const areaStyle = { color: '#ef4444', weight: 2, dashArray: '6 4', fillColor: '#ef4444', fillOpacity: 0.2 };
            const geojsonInput = document.getElementById('geojson-input');
            const hint = document.getElementById('map-hint');

            const map = L.map('area-map', { zoomControl: false, attributionControl: true }).setView([3.2, 73.22], 7);

            const baseLayers = {
                dark: L.tileLayer(@json('https://basemaps.cartocdn.com/rastertiles/'.config('services.carto.style').'/{z}/{x}/{y}.png?key='.config('services.carto.key')), {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                }),
                satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri',
                }),
            };
            let activeBase = 'dark';
            baseLayers.dark.addTo(map);

            L.control.scale({ position: 'bottomleft', imperial: false }).addTo(map);
            map.pm.setGlobalOptions({ pathOptions: areaStyle, templineStyle: areaStyle, hintlineStyle: { color: '#ef4444', dashArray: '4 4' } });

            let areaLayer = null;

            /**
             * Circles are not part of the GeoJSON spec, so they are stored as a Point with a radius in metres.
             */
            const toGeojson = (layer) => {
                if (layer instanceof L.Circle) {
                    const center = layer.getLatLng();

                    return {
                        type: 'Feature',
                        geometry: { type: 'Point', coordinates: [center.lng, center.lat] },
                        properties: { shape: 'circle', radius: Math.round(layer.getRadius()) },
                    };
                }

                return { ...layer.toGeoJSON(), properties: { shape: 'polygon' } };
            };

            const fromGeojson = (feature) => {
                if (feature.properties?.shape === 'circle') {
                    const [lng, lat] = feature.geometry.coordinates;

                    return L.circle([lat, lng], { ...areaStyle, radius: feature.properties.radius });
                }

                return L.polygon(feature.geometry.coordinates[0].map(([lng, lat]) => [lat, lng]), areaStyle);
            };

            const saveArea = () => {
                geojsonInput.value = areaLayer ? JSON.stringify(toGeojson(areaLayer)) : '';
            };

            const setArea = (layer) => {
                if (areaLayer && areaLayer !== layer) {
                    map.removeLayer(areaLayer);
                }
                areaLayer = layer;
                layer.on('pm:edit', saveArea);
                saveArea();
            };

            const showHint = (text) => {
                hint.textContent = text ?? '';
                hint.hidden = ! text;
            };

            const toolButtons = document.querySelectorAll('[data-map-tool]');
            const activateTool = (tool) => {
                map.pm.disableDraw();
                map.pm.disableGlobalEditMode();
                toolButtons.forEach((button) => button.classList.toggle('active', button.dataset.mapTool === tool));

                if (tool === 'circle') {
                    map.pm.enableDraw('Circle');
                    showHint('Click the centre of the zone, then click again to set its size.');
                } else if (tool === 'polygon') {
                    map.pm.enableDraw('Polygon');
                    showHint('Click to add points. Click the first point to close the boundary.');
                } else if (tool === 'edit') {
                    if (! areaLayer) {
                        showHint('Draw an area first, then use the pen to adjust it.');
                        setTimeout(() => activateTool('select'), 2000);

                        return;
                    }
                    map.pm.enableGlobalEditMode();
                    showHint('Drag the handles to adjust the area. Choose Select when done.');
                } else {
                    showHint(null);
                }
            };

            map.on('pm:create', ({ layer }) => {
                setArea(layer);
                activateTool('select');
            });

            toolButtons.forEach((button) => button.addEventListener('click', () => activateTool(button.dataset.mapTool)));

            document.querySelectorAll('[data-map-action]').forEach((button) => button.addEventListener('click', () => {
                const action = button.dataset.mapAction;

                if (action === 'clear') {
                    if (areaLayer) {
                        map.removeLayer(areaLayer);
                        areaLayer = null;
                        saveArea();
                    }
                    activateTool('select');
                } else if (action === 'zoom-in') {
                    map.zoomIn();
                } else if (action === 'zoom-out') {
                    map.zoomOut();
                } else if (action === 'layers') {
                    map.removeLayer(baseLayers[activeBase]);
                    activeBase = activeBase === 'dark' ? 'satellite' : 'dark';
                    baseLayers[activeBase].addTo(map);
                    button.title = activeBase === 'dark' ? 'Switch to satellite view' : 'Switch to street map';
                }
            }));

            if (geojsonInput.value) {
                try {
                    const layer = fromGeojson(JSON.parse(geojsonInput.value)).addTo(map);
                    setArea(layer);
                    map.fitBounds(layer.getBounds(), { padding: [40, 40], maxZoom: 12 });
                } catch {
                    geojsonInput.value = '';
                }
            }
        })();
    </script>

</body>
</html>