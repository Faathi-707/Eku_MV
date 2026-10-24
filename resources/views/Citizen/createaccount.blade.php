<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Create Citizen Account</title>
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

        /* Glassmorphism Card Matching Design */
        .auth-card {
            background: #051933;
            border: 1.5px solid #00aaff;
            box-shadow: 0 0 25px rgba(0, 170, 255, 0.15);
        }

        /* Form Input Styling */
        .auth-input {
            background-color: #03162e !important;
            border: 1.5px solid #0099e6 !important;
            color: #ffffff !important;
            transition: all 0.2s ease;
        }

        .auth-input:focus {
            border-color: #00d2ff !important;
            outline: none;
            box-shadow: 0 0 10px rgba(0, 210, 255, 0.3);
        }

        .auth-input::placeholder {
            color: #5c7b9e;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <!-- Included Navbar -->
    @include('Both.navbar')

    <!-- Main Container Centering Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        
        <div class="auth-card w-full max-w-lg rounded-3xl p-8 md:p-10 text-white space-y-6">
            
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white">Create Citizen Account</h1>
                <p class="text-xs text-slate-300 mt-1">Your account for safer travel across the Maldives.</p>
            </div>

            <!-- Registration Form -->
            <form action="#" method="POST" class="space-y-5">
                @csrf

                <!-- Full Name -->
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-semibold text-slate-200">Full name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-semibold text-slate-200">Email address</label>
                    <input type="email" id="email" name="email" required placeholder="you@example.com" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                </div>

                <!-- Phone Number -->
                <div class="space-y-1.5">
                    <label for="phone" class="block text-xs font-semibold text-slate-200">Phone number</label>
                    <input type="tel" id="phone" name="phone" required placeholder="Enter your phone number" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                </div>

                <!-- Island / Atoll Dropdown -->
                <div class="space-y-1.5">
                    <label for="location" class="block text-xs font-semibold text-slate-200">Island / Atoll</label>
                    <div class="relative">
                        <select id="location" name="location" required class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium appearance-none cursor-pointer">
                            <option value="" disabled selected class="bg-[#03162e]">Select your island or atoll</option>
                            <option value="Male" class="bg-[#03162e]">Malé (Kaafu Atoll)</option>
                            <option value="Hulhumale" class="bg-[#03162e]">Hulhumalé (Kaafu Atoll)</option>
                            <option value="Maafushi" class="bg-[#03162e]">Maafushi (Kaafu Atoll)</option>
                            <option value="Addu" class="bg-[#03162e]">Addu City</option>
                            <option value="Fuvahmulah" class="bg-[#03162e]">Fuvahmulah City</option>
                            <option value="Kulhudhuffushi" class="bg-[#03162e]">Kulhudhuffushi City</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-xs text-cyan-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-semibold text-slate-200">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Create a strong password" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-200">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter your password" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#00d8ff] hover:bg-[#33e1ff] text-slate-950 font-bold text-sm py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-cyan-500/20 mt-4">
                    Create Citizen Account
                </button>

            </form>

            <!-- Bottom Login Link -->
            <div class="text-center pt-2">
                <p class="text-xs text-slate-400 font-medium">
                    Already registered? 
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