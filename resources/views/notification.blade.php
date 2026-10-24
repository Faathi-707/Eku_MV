<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Notifications</title>
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

        /* Glassmorphism containers matching the design */
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }

        /* Individual Notification Row Styling */
        .notification-item {
            background: rgba(12, 38, 72, 0.6);
            border: 1px solid rgba(30, 64, 115, 0.5);
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            border-color: rgba(56, 189, 248, 0.4);
            background: rgba(15, 45, 85, 0.8);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('navbar')

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto w-full px-4 py-6 flex-grow space-y-6">

        <!-- Page Header & Filter Pills -->
        <header class="space-y-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-3">
                    <i class="fa-solid fa-bell text-cyan-400"></i> Notifications
                </h1>
                <p class="text-sm text-slate-400 mt-1">Stay updated with the latest weather alerts, travel advisories and system updates for your sea journey.</p>
            </div>

            <!-- Category Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 pt-2">
                <button class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold text-xs px-5 py-2 rounded-full transition shadow">All</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">Weather Alerts</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">Travel Advisories</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">Route Updates</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">System Updates</button>
            </div>
        </header>

        <!-- Dashboard Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            <!-- LEFT COLUMN: Notifications List -->
            <div class="lg:col-span-2 space-y-4">

                <!-- Notification 1 -->
                <div class="notification-item rounded-2xl p-5 border-l-4 border-l-red-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="p-2.5 bg-red-500/20 text-red-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-red-400 uppercase tracking-wider">Weather Alert</span>
                                <span class="text-xs text-slate-400">• Jun 20, 2025 &nbsp; 14:32</span>
                            </div>
                            <h2 class="text-base font-bold text-white">High waves expected in central atolls</h2>
                            <p class="text-xs text-slate-300">Wave height may reach 2.5 – 3.0 m from 21 Jun, 06:00 to 21 Jun, 18:00.<br>Boats are advised to avoid non-essential travel in this area.</p>
                            <div class="text-xs text-slate-400 pt-1 flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-location-dot text-cyan-400"></i> Central Atolls (Faafu, Dhaalu, Thaa)
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-end md:self-center">
                        <span class="bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-bold px-3 py-1 rounded-full">High risk</span>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Notification 2 -->
                <div class="notification-item rounded-2xl p-5 border-l-4 border-l-amber-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="p-2.5 bg-amber-500/20 text-amber-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-wind text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Travel Advisory</span>
                                <span class="text-xs text-slate-400">• Jun 20, 2025 &nbsp; 11:15</span>
                            </div>
                            <h2 class="text-base font-bold text-white">Strong winds in southern atolls</h2>
                            <p class="text-xs text-slate-300">Wind speed expected to be 20–25 km/h from 21 Jun, 12:00 to 22 Jun, 00:00.<br>Proceed with caution, especially for smaller vessels.</p>
                            <div class="text-xs text-slate-400 pt-1 flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-location-dot text-cyan-400"></i> Addu Atoll, Fuvahmulah Atoll
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-end md:self-center">
                        <span class="bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs font-bold px-3 py-1 rounded-full">Caution</span>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Notification 3 -->
                <div class="notification-item rounded-2xl p-5 border-l-4 border-l-cyan-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="p-2.5 bg-cyan-500/20 text-cyan-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-route text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-cyan-400 uppercase tracking-wider">Route Update</span>
                                <span class="text-xs text-slate-400">• Jun 20, 2025 &nbsp; 09:42</span>
                            </div>
                            <h2 class="text-base font-bold text-white">Alternative route recommended (Malé → Thulusdhoo)</h2>
                            <p class="text-xs text-slate-300">Due to rough seas on the main route, an alternative route via Kaafu Atoll is recommended. Estimated travel time: 1h 45m (vs. 1h 10m).</p>
                            <div class="text-xs text-slate-400 pt-1 flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-location-dot text-cyan-400"></i> Malé → Thulusdhoo
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-end md:self-center">
                        <span class="bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 text-xs font-bold px-3 py-1 rounded-full">Recommended</span>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Notification 4 -->
                <div class="notification-item rounded-2xl p-5 border-l-4 border-l-purple-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="p-2.5 bg-purple-500/20 text-purple-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-cloud-rain text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-purple-400 uppercase tracking-wider">Weather Alert</span>
                                <span class="text-xs text-slate-400">• Jun 20, 2025 &nbsp; 08:10</span>
                            </div>
                            <h2 class="text-base font-bold text-white">Moderate rain expected in northern atolls</h2>
                            <p class="text-xs text-slate-300">Rain showers may reduce visibility and affect sea conditions from 21 Jun, 09:00 to 21 Jun, 16:00.</p>
                            <div class="text-xs text-slate-400 pt-1 flex items-center gap-1.5 font-medium">
                                <i class="fa-solid fa-location-dot text-cyan-400"></i> Haa Alifu, Haa Dhaalu, Shaviyani
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-end md:self-center">
                        <span class="bg-purple-500/20 text-purple-400 border border-purple-500/30 text-xs font-bold px-3 py-1 rounded-full">Moderate</span>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                    </div>
                </div>

                <!-- Notification 5 -->
                <div class="notification-item rounded-2xl p-5 border-l-4 border-l-teal-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="p-2.5 bg-teal-500/20 text-teal-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-circle-info text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold text-teal-400 uppercase tracking-wider">System Update</span>
                                <span class="text-xs text-slate-400">• Jun 19, 2025 &nbsp; 16:45</span>
                            </div>
                            <h2 class="text-base font-bold text-white">New feature available: Route comparison</h2>
                            <p class="text-xs text-slate-300">You can now compare multiple routes with real-time weather conditions and estimated travel time.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-end md:self-center">
                        <span class="bg-teal-500/20 text-teal-400 border border-teal-500/30 text-xs font-bold px-3 py-1 rounded-full">Info</span>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-sm"></i>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: Filters & Summary Panels -->
            <div class="space-y-6">

                <!-- Filter Notifications Card -->
                <section class="glass-card rounded-2xl p-5 shadow-xl space-y-4">
                    <div class="flex items-center gap-2 text-white font-bold pb-2 border-b border-blue-900/50">
                        <i class="fa-solid fa-filter text-cyan-400"></i> Filter Notifications
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Notification type</label>
                        <select class="w-full bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none">
                            <option>All types</option>
                            <option>Weather Alerts</option>
                            <option>Travel Advisories</option>
                            <option>Route Updates</option>
                            <option>System Updates</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Date range</label>
                        <div class="flex items-center bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-xs text-white">
                            <i class="fa-regular fa-calendar text-cyan-400 mr-2"></i>
                            <select class="bg-transparent w-full text-xs text-white focus:outline-none cursor-pointer">
                                <option>Last 7 days</option>
                                <option>Last 24 hours</option>
                                <option>Last 30 days</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">Status</label>
                        <select class="w-full bg-[#0b284f] border border-blue-900/60 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none">
                            <option>All status</option>
                            <option>High Risk</option>
                            <option>Caution</option>
                            <option>Recommended</option>
                        </select>
                    </div>

                    <button class="w-full bg-transparent hover:bg-blue-900/30 text-slate-300 border border-blue-900/60 font-semibold text-xs py-2.5 rounded-xl transition duration-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rotate-left"></i> Clear filters
                    </button>
                </section>

                <!-- Notification Summary Card -->
                <section class="glass-card rounded-2xl p-5 shadow-xl space-y-4">
                    <div class="flex items-center gap-2 text-white font-bold pb-2 border-b border-blue-900/50">
                        <i class="fa-solid fa-chart-pie text-cyan-400"></i> Notification Summary
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-red-400"></i> Weather Alerts</span>
                            <span class="font-bold text-white">4</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2"><i class="fa-solid fa-wind text-amber-400"></i> Travel Advisories</span>
                            <span class="font-bold text-white">2</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2"><i class="fa-solid fa-route text-cyan-400"></i> Route Updates</span>
                            <span class="font-bold text-white">1</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-2"><i class="fa-solid fa-circle-info text-teal-400"></i> System Updates</span>
                            <span class="font-bold text-white">1</span>
                        </div>
                    </div>
                </section>

                <!-- Info Tip Box -->
                <section class="glass-card rounded-2xl p-4 shadow-xl border-cyan-500/30 bg-[#082242]/80 flex items-start gap-3">
                    <div class="text-cyan-400 text-lg mt-0.5">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Always check the latest updates before travelling. Conditions can change quickly in the Maldives.
                    </p>
                </section>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

</body>
</html>