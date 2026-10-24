<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Profile</title>
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

        /* Glassmorphism containers matching the dark ocean theme */
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }

        /* Interactive row hover effect */
        .setting-row {
            transition: all 0.2s ease;
        }
        .setting-row:hover {
            background: rgba(15, 45, 85, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('Both.navbar')

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto w-full px-4 py-6 flex-grow space-y-6">

        <!-- Top Profile Banner -->
        <div class="glass-card rounded-2xl p-6 shadow-2xl relative overflow-hidden flex items-center justify-between">
            <div class="flex items-center gap-4 z-10">
                <div class="w-14 h-14 rounded-full bg-cyan-500/20 border border-cyan-400 flex items-center justify-center text-cyan-400 text-2xl">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white">Profile</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Manage your account information and preferences.</p>
                </div>
            </div>
            <!-- Decorative Ship & Waves Icon -->
            <div class="hidden md:flex items-center text-cyan-400/20 text-6xl">
                <i class="fa-solid fa-ship"></i>
            </div>
        </div>

        <!-- Main 2-Column Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

            <!-- LEFT COLUMN: Account Information & Account Settings -->
            <div class="space-y-6">

                <!-- 1. Account Information Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl space-y-6">
                    <div class="flex items-center justify-between border-b border-blue-900/50 pb-4">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-user text-cyan-400 text-lg"></i>
                            <h2 class="font-bold text-base text-white">Account Information</h2>
                        </div>
                        <button class="bg-blue-900/40 hover:bg-blue-900/80 text-cyan-400 border border-cyan-500/30 text-xs font-semibold px-4 py-1.5 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-pen text-[10px]"></i> Edit
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start gap-6">
                        <!-- Profile Avatar with Camera Overlay -->
                        <div class="relative mx-auto sm:mx-0">
                            <div class="w-24 h-24 rounded-full border-2 border-cyan-400 p-1 flex items-center justify-center bg-[#0b284f]">
                                <div class="w-full h-full rounded-full bg-cyan-500/10 flex items-center justify-center text-cyan-400 text-3xl">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <button class="absolute bottom-0 right-0 bg-cyan-500 hover:bg-cyan-400 text-slate-950 p-1.5 rounded-full border-2 border-[#071930] shadow transition">
                                <i class="fa-solid fa-camera text-xs"></i>
                            </button>
                        </div>

                        <!-- User Info Fields -->
                        <div class="space-y-3 w-full">
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-white">Ahmed Shareef</h3>
                                <i class="fa-solid fa-circle-check text-cyan-400 text-sm" title="Verified Official"></i>
                            </div>
                            <p class="text-xs font-semibold text-cyan-300">Marine Safety Officer</p>
                            <p class="text-xs text-slate-400">Ministry of Transport and Civil Aviation</p>

                            <div class="pt-2 space-y-2 text-xs text-slate-300">
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-envelope text-cyan-400 w-4"></i>
                                    <span>ahmed.shareef@motca.gov.mv</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-phone text-cyan-400 w-4"></i>
                                    <span>+960 332 1234</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-location-dot text-cyan-400 w-4"></i>
                                    <span>Malé, Maldives</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2. Account Settings Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl space-y-4">
                    <div class="flex items-center gap-2.5 border-b border-blue-900/50 pb-4">
                        <i class="fa-solid fa-gear text-cyan-400 text-lg"></i>
                        <h2 class="font-bold text-base text-white">Account Settings</h2>
                    </div>

                    <div class="space-y-1">
                        <!-- Change Password -->
                        <a href="#" class="setting-row flex items-center justify-between p-3 rounded-xl cursor-pointer">
                            <div class="flex items-center gap-3.5">
                                <div class="p-2 bg-cyan-500/10 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white">Change Password</h3>
                                    <p class="text-[11px] text-slate-400">Update your password for better security.</p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
                        </a>

                        <!-- Two-Factor Authentication -->
                        <div class="setting-row flex items-center justify-between p-3 rounded-xl">
                            <div class="flex items-center gap-3.5">
                                <div class="p-2 bg-cyan-500/10 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-shield-halved text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white">Two-Factor Authentication</h3>
                                    <p class="text-[11px] text-slate-400">Add an extra layer of security to your account.</p>
                                </div>
                            </div>
                            <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[11px] font-bold px-3 py-1 rounded-full flex items-center gap-1 cursor-pointer">
                                Enabled <i class="fa-solid fa-chevron-right text-[9px] ml-0.5"></i>
                            </span>
                        </div>

                        <!-- Email Notifications -->
                        <div class="setting-row flex items-center justify-between p-3 rounded-xl">
                            <div class="flex items-center gap-3.5">
                                <div class="p-2 bg-cyan-500/10 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-envelope-open-text text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white">Email Notifications</h3>
                                    <p class="text-[11px] text-slate-400">Manage your notification preferences.</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>

                        <!-- Location -->
                        <a href="#" class="setting-row flex items-center justify-between p-3 rounded-xl cursor-pointer">
                            <div class="flex items-center gap-3.5">
                                <div class="p-2 bg-cyan-500/10 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-location-dot text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white">Location</h3>
                                    <p class="text-[11px] text-slate-400">Set your preferred home location.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-300 font-medium">Malé, Maldives</span>
                                <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
                            </div>
                        </a>

                        <!-- Dark Mode -->
                        <div class="setting-row flex items-center justify-between p-3 rounded-xl">
                            <div class="flex items-center gap-3.5">
                                <div class="p-2 bg-cyan-500/10 text-cyan-400 rounded-lg">
                                    <i class="fa-solid fa-moon text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-white">Dark Mode</h3>
                                    <p class="text-[11px] text-slate-400">Switch between light and dark themes.</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-cyan-500"></div>
                            </label>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN: Organization Details & Recent Activity -->
            <div class="space-y-6">

                <!-- 3. Organization Details Card -->
                <section class="glass-card rounded-2xl p-6 shadow-xl space-y-5">
                    <div class="flex items-center justify-between border-b border-blue-900/50 pb-4">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-building text-cyan-400 text-lg"></i>
                            <h2 class="font-bold text-base text-white">Organization Details</h2>
                        </div>
                        <button class="bg-blue-900/40 hover:bg-blue-900/80 text-cyan-400 border border-cyan-500/30 text-xs font-semibold px-4 py-1.5 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-pen text-[10px]"></i> Edit
                        </button>
                    </div>

                    <div class="space-y-4 text-xs">
                        <!-- Organization Name -->
                        <div class