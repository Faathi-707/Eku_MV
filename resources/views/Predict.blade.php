<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maldives Eku_mv - Plan Your Sea Journey</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS File via Vite -->
    @vite(['resources/css/predict.css'])
    
    <style>
        body {
            background-color: #071930;
            color: #ffffff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }
        .metric-box {
            background: rgba(15, 45, 85, 0.5);
            border: 1px solid rgba(30, 75, 135, 0.4);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('navbar')

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto w-full px-4 py-6 flex-grow space-y-6">

        <!-- Top Search & Plan Form Bar -->
        <section class="glass-card rounded-2xl p-6 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-3">
                        <i class="fa-solid fa-compass text-cyan-400"></i> Plan your sea journey
                    </h1>
                    <p class="text-sm text-slate-400 mt-1">Check marine conditions, potential disruptions and safer travel options.</p>
                </div>
            </div>

            <form id="journeyForm" onsubmit="handleAnalysis(event)" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                
                <!-- From -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-slate-400 mb-1">From</label>
                    <div class="flex items-center bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-white">
                        <i class="fa-solid fa-location-dot text-cyan-400 mr-2.5"></i>
                        <select id="from" class="bg-transparent w-full text-sm font-medium focus:outline-none cursor-pointer">
                            <option value="Male" selected class="bg-[#0b284f]">Malé</option>
                            <option value="Hulhumale" class="bg-[#0b284f]">Hulhumalé</option>
                            <option value="Maafushi" class="bg-[#0b284f]">Maafushi</option>
                        </select>
                    </div>
                </div>

                <!-- To -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-slate-400 mb-1">To</label>
                    <div class="flex items-center bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-white">
                        <i class="fa-solid fa-location-dot text-cyan-400 mr-2.5"></i>
                        <select id="to" class="bg-transparent w-full text-sm font-medium focus:outline-none cursor-pointer">
                            <option value="Thulusdhoo" selected class="bg-[#0b284f]">Thulusdhoo</option>
                            <option value="Maafushi" class="bg-[#0b284f]">Maafushi</option>
                            <option value="Rasdhoo" class="bg-[#0b284f]">Rasdhoo</option>
                        </select>
                    </div>
                </div>

                <!-- Departure Date -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Departure date</label>
                    <div class="flex items-center bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-white">
                        <i class="fa-regular fa-calendar text-cyan-400 mr-2.5"></i>
                        <input type="date" id="departureDate" value="2025-06-20" class="bg-transparent w-full text-sm font-medium focus:outline-none cursor-pointer">
                    </div>
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">End date</label>
                    <div class="flex items-center bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-white">
                        <i class="fa-regular fa-calendar text-cyan-400 mr-2.5"></i>
                        <input type="date" id="endDate" value="2025-06-22" class="bg-transparent w-full text-sm font-medium focus:outline-none cursor-pointer">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end h-full pt-5 md:pt-0">
                    <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-sm py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-cyan-500/20">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Analyse sea conditions
                    </button>
                </div>

            </form>
        </section>

        <!-- Main Dashboard Split Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- LEFT COLUMN: Marine Conditions & Sea Alerts -->
            <div class="space-y-6">
                
                <!-- Current Marine Conditions Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-water text-cyan-400 text-lg"></i>
                            <h2 class="font-bold text-lg text-white">Current Marine Conditions</h2>
                        </div>
                        <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-semibold px-2.5 py-1 rounded-full flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Live Data
                        </span>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <!-- Wind Speed -->
                        <div class="metric-box p-3.5 rounded-xl">
                            <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-1.5">
                                <i class="fa-solid fa-wind text-cyan-400"></i> Wind Speed
                            </div>
                            <div class="text-lg font-bold text-white">22 km/h</div>
                            <div class="text-xs text-slate-400 font-medium">SE</div>
                        </div>

                        <!-- Wave Height -->
                        <div class="metric-box p-3.5 rounded-xl">
                            <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-1.5">
                                <i class="fa-solid fa-water text-cyan-400"></i> Wave Height
                            </div>
                            <div class="text-lg font-bold text-white">1.8 m</div>
                            <div class="text-xs text-slate-400 font-medium">Moderate</div>
                        </div>

                        <!-- Rain -->
                        <div class="metric-box p-3.5 rounded-xl">
                            <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-1.5">
                                <i class="fa-solid fa-cloud-rain text-cyan-400"></i> Rain
                            </div>
                            <div class="text-lg font-bold text-white">Light</div>
                            <div class="text-xs text-slate-400 font-medium">Possible showers</div>
                        </div>

                        <!-- Sea Temperature -->
                        <div class="metric-box p-3.5 rounded-xl">
                            <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-1.5">
                                <i class="fa-solid fa-temperature-three-quarters text-cyan-400"></i> Sea Temperature
                            </div>
                            <div class="text-lg font-bold text-white">29°C</div>
                        </div>

                        <!-- Visibility -->
                        <div class="metric-box p-3.5 rounded-xl">
                            <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-1.5">
                                <i class="fa-solid fa-eye text-cyan-400"></i> Visibility
                            </div>
                            <div class="text-lg font-bold text-white">Good</div>
                            <div class="text-xs text-slate-400 font-medium">> 10 km</div>
                        </div>

                        <!-- Tide -->
                        <div class="metric-box p-3.5 rounded-xl">
                            <div class="flex items-center gap-1.5 text-slate-400 text-xs mb-1.5">
                                <i class="fa-solid fa-water text-cyan-400"></i> Tide (next high)
                            </div>
                            <div class="text-lg font-bold text-white">14:32</div>
                            <div class="text-xs text-slate-400 font-medium">1.2 m</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-blue-900/40">
                        <span>Weather data updated: 2025-06-20 08:45</span>
                        <span>Source: Met Office (demo)</span>
                    </div>
                </section>

                <!-- Sea Alerts Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-bell text-cyan-400 text-lg"></i>
                            <h2 class="font-bold text-lg text-white">Sea Alerts</h2>
                        </div>
                        <span class="text-xs text-cyan-400 font-semibold cursor-pointer hover:underline">Latest</span>
                    </div>

                    <div class="space-y-3">
                        <!-- Alert 1 -->
                        <div class="bg-red-950/40 border border-red-500/40 rounded-xl p-3.5 flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-red-500/20 rounded-lg text-red-400 mt-0.5">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-red-200">High waves expected</h4>
                                    <p class="text-xs text-red-300/80 mt-0.5">Wave height may reach 2.5–3.0 m on June 21.</p>
                                </div>
                            </div>
                            <span class="text-xs text-red-300 font-medium whitespace-nowrap ml-2">Jun 21, 06:00</span>
                        </div>

                        <!-- Alert 2 -->
                        <div class="bg-amber-950/40 border border-amber-500/40 rounded-xl p-3.5 flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-amber-500/20 rounded-lg text-amber-400 mt-0.5">
                                    <i class="fa-solid fa-wind"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-amber-200">Strong winds</h4>
                                    <p class="text-xs text-amber-300/80 mt-0.5">Wind speed may exceed 20 km/h in the southern atolls.</p>
                                </div>
                            </div>
                            <span class="text-xs text-amber-300 font-medium whitespace-nowrap ml-2">Jun 21, 09:00</span>
                        </div>

                        <!-- Alert 3 -->
                        <div class="bg-blue-950/40 border border-blue-500/40 rounded-xl p-3.5 flex items-start justify-between">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg text-cyan-400 mt-0.5">
                                    <i class="fa-solid fa-cloud-showers-heavy"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-blue-200">Possible rain</h4>
                                    <p class="text-xs text-blue-300/80 mt-0.5">Light to moderate showers expected in the afternoon.</p>
                                </div>
                            </div>
                            <span class="text-xs text-blue-300 font-medium whitespace-nowrap ml-2">Jun 21, 12:00</span>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN: AI Prediction & Route Recommendations -->
            <div class="space-y-6">

                <!-- AI Prediction Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-wand-magic-sparkles text-cyan-400 text-lg"></i>
                            <div>
                                <h2 class="font-bold text-lg text-white">AI Prediction</h2>
                                <p class="text-xs text-slate-400">Based on weather patterns and sea conditions</p>
                            </div>
                        </div>
                        <span class="bg-blue-950 text-cyan-400 border border-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Next 3 days</span>
                    </div>

                    <!-- Warning Banner -->
                    <div class="bg-amber-500/10 border border-amber-500/40 rounded-xl p-4 flex items-start justify-between mb-5">
                        <div class="flex items-start gap-3">
                            <div class="text-amber-400 text-xl mt-0.5">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-amber-300 text-sm">Travel with caution</h3>
                                <p class="text-xs text-amber-200/80 mt-1 leading-relaxed">Rough seas and stronger winds are expected on June 21. Consider an alternative route or delay if possible.</p>
                            </div>
                        </div>
                        <button class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 whitespace-nowrap mt-1">
                            View details <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Expected Conditions 3-day strip -->
                    <div>
                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Expected Conditions</h4>
                        <div class="grid grid-cols-3 gap-3">
                            <!-- Day 1 -->
                            <div class="metric-box p-3 rounded-xl border-l-2 border-emerald-400">
                                <div class="text-xs font-bold text-white mb-1">Jun 20 <span class="text-[10px] text-slate-400 font-normal">(Today)</span></div>
                                <div class="flex items-center gap-1.5 text-xs text-emerald-400 font-medium mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Favourable
                                </div>
                                <div class="text-[11px] text-slate-300 space-y-0.5">
                                    <div>Wind 15 km/h</div>
                                    <div>Waves 1.0 m</div>
                                </div>
                            </div>

                            <!-- Day 2 -->
                            <div class="metric-box p-3 rounded-xl border-l-2 border-amber-400 bg-amber-950/10">
                                <div class="text-xs font-bold text-white mb-1">Jun 21 <span class="text-[10px] text-slate-400 font-normal">(Tomorrow)</span></div>
                                <div class="flex items-center gap-1.5 text-xs text-amber-400 font-medium mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Caution
                                </div>
                                <div class="text-[11px] text-slate-300 space-y-0.5">
                                    <div>Wind 22 km/h</div>
                                    <div>Waves 2.5 m</div>
                                </div>
                            </div>

                            <!-- Day 3 -->
                            <div class="metric-box p-3 rounded-xl border-l-2 border-emerald-400">
                                <div class="text-xs font-bold text-white mb-1">Jun 22</div>
                                <div class="flex items-center gap-1.5 text-xs text-emerald-400 font-medium mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Favourable
                                </div>
                                <div class="text-[11px] text-slate-300 space-y-0.5">
                                    <div>Wind 14 km/h</div>
                                    <div>Waves 1.2 m</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Route Recommendations Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-route text-cyan-400 text-lg"></i>
                            <h2 class="font-bold text-lg text-white">Route Recommendations</h2>
                        </div>
                        <a href="#" class="text-xs text-cyan-400 font-semibold hover:underline">Compared routes <i class="fa-solid fa-angle-right text-[10px]"></i></a>
                    </div>

                    <div class="space-y-3">
                        <!-- Main Route (Recommended) -->
                        <div class="metric-box rounded-xl p-3.5 flex items-center justify-between border-cyan-500/50 bg-[#0d2f5a]">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-cyan-500/20 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-water"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-white">Main Route</h4>
                                        <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold px-2 py-0.5 rounded">Recommended</span>
                                    </div>
                                    <div class="text-xs text-slate-300 mt-1 flex items-center gap-3">
                                        <span>Distance: <strong>77 km</strong></span>
                                        <span>Est. time: <strong>3 h 10 min</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check"></i> Safe
                                </span>
                                <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                            </div>
                        </div>

                        <!-- Alternative Route 1 -->
                        <div class="metric-box rounded-xl p-3.5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-blue-500/20 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-route"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white">Alternative Route 1</h4>
                                    <div class="text-xs text-slate-300 mt-1 flex items-center gap-3">
                                        <span>Distance: <strong>92 km</strong></span>
                                        <span>Est. time: <strong>3 h 50 min</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Caution
                                </span>
                                <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                            </div>
                        </div>

                        <!-- Alternative Route 2 -->
                        <div class="metric-box rounded-xl p-3.5 flex items-center justify-between opacity-80">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-slate-700 text-slate-400 rounded-lg">
                                    <i class="fa-solid fa-route"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-300">Alternative Route 2</h4>
                                    <div class="text-xs text-slate-400 mt-1 flex items-center gap-3">
                                        <span>Distance: <strong>108 km</strong></span>
                                        <span>Est. time: <strong>4 h 30 min</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="bg-slate-700/50 text-slate-300 border border-slate-600 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <i class="fa-solid fa-ban"></i> Not recommended
                                </span>
                                <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

    <!-- Prediction result banner (hidden until a prediction is returned) -->
    <div id="predictionBanner" class="hidden fixed bottom-6 right-6 max-w-sm glass-card rounded-2xl p-4 shadow-2xl text-sm text-slate-100 border border-cyan-500/40"></div>

    <!-- Interactive JS Hook -->
    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

        async function handleAnalysis(event) {
            event.preventDefault();
            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;
            const depDate = document.getElementById('departureDate').value;
            const banner = document.getElementById('predictionBanner');

            banner.classList.remove('hidden');
            banner.innerHTML = `<div class="flex items-center gap-2"><i class="fa-solid fa-spinner fa-spin text-cyan-400"></i> Analysing ${from} → ${to}…</div>`;

            // TODO: replace these placeholder weather features with values from a real weather feed.
            const features = {
                era5_wind_kmh: 22.5,
                era5_swh_m: 1.4,
                era5_tp_mm: 0.3,
                median_path_length_km: 12.0,
                day_of_week: new Date(depDate).getDay(),
            };

            try {
                const res = await fetch("{{ route('api.predict') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                    },
                    body: JSON.stringify({ route_id: `${from}-${to}`, features }),
                });
                const data = await res.json();

                if (data.status === 'ok') {
                    const pct = data.headline_delta_pct;
                    const sign = pct >= 0 ? '+' : '';
                    const warn = data.route_known ? '' : '<div class="text-amber-300 text-xs mt-1"><i class="fa-solid fa-triangle-exclamation"></i> Limited data for this route — estimate only.</div>';
                    banner.innerHTML = `
                        <div class="font-bold text-white">${from} → ${to}</div>
                        <div class="text-2xl font-bold text-cyan-300 mt-1">${sign}${pct.toFixed(1)}% vs usual</div>
                        <div class="text-xs text-slate-400 mt-1">Headline uses route-mean baseline (model: ${(data.predictions.tree_model * 100).toFixed(1)}%).</div>
                        ${warn}`;
                } else if (data.status === 'missing_features') {
                    banner.innerHTML = `<div class="text-amber-300">Missing weather inputs: ${(data.missing_features || []).join(', ')}</div>`;
                } else {
                    banner.innerHTML = `<div class="text-rose-300">Weather prediction unavailable right now.</div>`;
                }
            } catch (e) {
                banner.innerHTML = `<div class="text-rose-300">Could not reach prediction service.</div>`;
            }
        }
    </script>
</body>
</html>