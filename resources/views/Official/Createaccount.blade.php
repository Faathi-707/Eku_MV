<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Official Registration</title>
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

        /* Glassmorphism Outer Card */
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
        
        <div class="auth-card w-full max-w-xl rounded-3xl p-8 md:p-10 text-white space-y-8">
            
            <!-- Header -->
            <div class="flex items-start gap-3">
                <div class="p-2.5 bg-cyan-500/10 text-cyan-400 rounded-xl mt-1">
                    <i class="fa-solid fa-shield-halved text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-white">Official Registration</h1>
                    <p class="text-xs text-slate-300 mt-0.5">Request access for your organization.</p>
                </div>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('official.createaccount.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- SECTION 1: Account Administrator -->
                <div class="space-y-5">
                    <div class="border-t border-blue-900/60 pt-4 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-cyan-400">Account administrator</h2>
                        <i class="fa-solid fa-circle-arrow-down text-cyan-400 text-sm"></i>
                    </div>

                    <!-- Official's Full Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-semibold text-slate-200">Official's full name</label>
                        <input type="text" id="name" name="name" required placeholder="Enter official's full name" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                    </div>

                    <!-- Official Contact Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-semibold text-slate-200">Official contact email</label>
                        <input type="email" id="email" name="email" required placeholder="Enter official contact email" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-200">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter password" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-200">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Enter confirm password" class="auth-input w-full px-4 py-3 rounded-xl text-xs md:text-sm font-medium">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#00d8ff] hover:bg-[#33e1ff] text-slate-950 font-bold text-sm py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-cyan-500/20 mt-4">
                    Submit Official Registration
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