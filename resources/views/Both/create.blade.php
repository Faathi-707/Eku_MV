<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Create Your Account</title>
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
            background-color: #031226 !important;
            color: var(--ink);
            font-family: var(--f-display);
        }

        /* Outer Glassmorphism Card */
        .register-card {
            background: #051933;
            border: 1px solid rgba(0, 153, 230, 0.3);
            box-shadow: 0 0 30px rgba(0, 170, 255, 0.12);
        }

        /* Role Option Cards */
        .role-card-active {
            background: rgba(3, 22, 46, 0.9);
            border: 2px solid #00d2ff;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.2);
        }

        .role-card-inactive {
            background: rgba(3, 22, 46, 0.5);
            border: 1px solid rgba(0, 153, 230, 0.3);
            transition: all 0.2s ease;
        }

        .role-card-inactive:hover {
            border-color: #0099e6;
            background: rgba(6, 34, 71, 0.7);
        }

        .official-btn {
            background: transparent;
            border: 1px solid #0099e6;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .official-btn:hover {
            background: rgba(0, 210, 255, 0.1);
            border-color: #00d2ff;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <!-- Included Navbar -->
    @include('Both.navbar')

    <!-- Main Content Container -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">

        <div class="register-card w-full max-w-3xl rounded-3xl p-8 md:p-10 text-white space-y-8">
            
            <!-- Header with Waves Icon -->
            <div class="text-center space-y-3">
                <div class="text-cyan-400 text-4xl flex justify-center mb-1">
                    <i class="fa-solid fa-water"></i>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Create Your Account</h1>
                <p class="text-sm text-slate-300">Join Maldives Eku.mv for safer sea journeys.</p>
            </div>

            <hr class="border-blue-900/60">

            <!-- Role Selection Heading -->
            <div>
                <h2 class="text-base font-semibold text-slate-200">I am creating an account as a...</h2>
            </div>

            <!-- Role Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Citizen Role Box -->
                <div class="role-card-active rounded-2xl p-6 md:p-8 flex flex-col items-center text-center justify-between space-y-6">
                    <div class="space-y-4 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-2xl">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Citizen</h3>
                        <p class="text-xs text-slate-300 leading-relaxed max-w-xs">Access alerts, marine conditions and routes.</p>
                    </div>

                    <a href="{{ url('/createaccount') }}" class="w-full bg-[#00d8ff] hover:bg-[#33e1ff] text-slate-950 font-bold text-sm py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-cyan-500/20 text-center block">
                        Register as Citizen
                    </a>
                </div>

                <!-- Official Role Box -->
                <div class="role-card-inactive rounded-2xl p-6 md:p-8 flex flex-col items-center text-center justify-between space-y-6">
                    <div class="space-y-4 flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Official</h3>
                        <p class="text-xs text-slate-300 leading-relaxed max-w-xs">Register a government agency or organization.</p>
                    </div>

                    <a href="{{ route('official.createaccount') }}" class="official-btn w-full font-bold text-sm py-3 px-4 rounded-xl text-center block">
                        Register as Official
                    </a>
                </div>

            </div>

            <!-- Footer Link -->
            <div class="text-center pt-2">
                <p class="text-xs text-slate-400 font-medium">
                    Already have an account? 
                    <a href="{{ url('/login') }}" class="text-[#00d2ff] hover:underline font-semibold ml-1">Log in</a>
                </p>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

</body>
</html>