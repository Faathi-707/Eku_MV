<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Profile & Settings</title>
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

        /* Glassmorphism containers */
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }

        /* Setting row hover effect */
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
    <main class="max-w-4xl mx-auto w-full px-4 py-8 flex-grow space-y-6">

        <!-- User Banner Card -->
        <div class="glass-card rounded-2xl p-6 flex items-center justify-between shadow-2xl relative overflow-hidden">
            <div class="flex items-center gap-5 z-10">
                <div class="relative">
                    <div class="w-16 h-16 rounded-full bg-cyan-500/20 border-2 border-cyan-400 flex items-center justify-center text-cyan-400 text-2xl">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-white">Aishath Mariyam</h1>
                        <span class="bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 text-xs font-semibold px-3 py-0.5 rounded-full">Citizen</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Explore the ocean. Stay informed. Travel safely.</p>
                </div>
            </div>
            <!-- Decorative Wave Graphic -->
            <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-20 pointer-events-none flex items-center justify-end">
                <i class="fa-solid fa-water text-8xl text-cyan-400"></i>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="glass-card rounded-2xl p-6 md:p-8 shadow-2xl space-y-6">
            
            <!-- Header with Edit Button -->
            <div class="flex items-center justify-between border-b border-blue-900/50 pb-4">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-user text-cyan-400 text-lg"></i>
                    <h2 class="font-bold text-base text-white">Personal Information</h2>
                </div>
                <button class="bg-blue-900/40 hover:bg-blue-900/80 text-cyan-400 border border-cyan-500/30 text-xs font-semibold px-4 py-2 rounded-xl transition flex items-center gap-2">
                    <i class="fa-solid fa-pen text-[10px]"></i> Edit
                </button>
            </div>

            <!-- Profile Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                
                <!-- Avatar Upload Slot -->
                <div class="flex justify-center md:justify-start">
                    <div class="relative">
                        <div class="w-28 h-28 rounded-full border-2 border-cyan-400 p-1 flex items-center justify-center bg-[#0b284f]">
                            <div class="w-full h-full rounded-full bg-cyan-500/10 flex items-center justify-center text-cyan-400 text-4xl">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                        <button class="absolute bottom-0 right-0 bg-cyan-500 hover:bg-cyan-400 text-slate-950 p-2 rounded-full border-2 border-[#071930] shadow transition">
                            <i class="fa-solid fa-camera text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Info Fields Grid -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    
                    <!-- Full Name -->
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block">Full Name</span>
                            <strong class="text-sm text-white font-semibold block mt-0.5">Aishath Mariyam</strong>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block">Email Address</span>
                            <strong class="text-sm text-white font-semibold block mt-0.5">mariyam@gmail.com</strong>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block">Phone Number</span>
                            <strong class="text-sm text-white font-semibold block mt-0.5">+960 777 1234</strong>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="flex items-start gap-3">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="text-slate-400 font-medium block">Location</span>
                            <strong class="text-sm text-white font-semibold block mt-0.5">Malé, Maldives</strong>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Account Settings Section -->
        <div class="glass-card rounded-2xl p-6 md:p-8 shadow-2xl space-y-6">
            
            <div class="flex items-center gap-3 border-b border-blue-900/50 pb-4">
                <i class="fa-solid fa-gear text-cyan-400 text-lg"></i>
                <h2 class="font-bold text-base text-white">Account Settings</h2>
            </div>

            <div class="space-y-2">
                
                <!-- Change Password -->
                <a href="#" class="setting-row flex items-center justify-between p-4 rounded-xl border border-transparent hover:border-blue-900/60 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">Change Password</h3>
                            <p class="text-xs text-slate-400">Update your password for better security.</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
                </a>

                <!-- Email Notifications -->
                <div class="setting-row flex items-center justify-between p-4 rounded-xl border border-transparent hover:border-blue-900/60">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">Email Notifications</h3>
                            <p class="text-xs text-slate-400">Manage your notification preferences.</p>
                        </div>
                    </div>
                    <!-- Toggle Switch -->
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-500"></div>
                    </label>
                </div>

                <!-- Location Setting (Replaced Language) -->
                <a href="#" class="setting-row flex items-center justify-between p-4 rounded-xl border border-transparent hover:border-blue-900/60 cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">Location</h3>
                            <p class="text-xs text-slate-400">Set your preferred home location for local marine alerts.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-300 font-medium">Malé, Maldives</span>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
                    </div>
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="setting-row flex items-center justify-between p-4 rounded-xl border border-transparent hover:border-red-900/60 cursor-pointer w-full text-left">
                        <div class="flex items-center gap-4">
                            <div class="p-2.5 bg-red-500/10 text-red-400 rounded-xl">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-red-400">Logout</h3>
                                <p class="text-xs text-slate-400">End your current session.</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-xs"></i>
                    </button>
                </form>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

</body>
</html>