<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Login</title>
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
        .login-card {
            background: #051933;
            border: 1.5px solid #00aaff;
            box-shadow: 0 0 25px rgba(0, 170, 255, 0.15);
        }

        /* Input Box Styling */
        .login-input {
            background-color: #03162e !important;
            border: 1.5px solid #0099e6 !important;
            color: #ffffff !important;
            transition: all 0.2s ease;
        }

        .login-input:focus {
            border-color: #00d2ff !important;
            outline: none;
            box-shadow: 0 0 10px rgba(0, 210, 255, 0.3);
        }

        .login-input::placeholder {
            color: #5c7b9e;
        }

        /* Continue with Google Button */
        .google-btn {
            background-color: #03162e;
            border: 1.5px solid #0099e6;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .google-btn:hover {
            background-color: #062247;
            border-color: #00d2ff;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <!-- Included Navbar -->
    @include('Both.navbar')

    <!-- Main Container Centering the Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        
        <div class="login-card w-full max-w-md rounded-3xl p-8 md:p-10 text-white space-y-7">
            
            <!-- Card Heading -->
            <h1 class="text-3xl font-bold tracking-tight text-white">Welcome</h1>

            <!-- Form -->
            <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                @csrf

                @if($errors->any())
                    <div class="text-sm text-red-400">{{ $errors->first() }}</div>
                @endif

                <!-- Email / Phone Input -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-slate-200">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email" class="login-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-slate-200">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" class="login-input w-full px-4 py-3 rounded-xl text-sm font-medium">
                </div>

                <!-- Log In Button -->
                <button type="submit" class="w-full bg-[#00d8ff] hover:bg-[#33e1ff] text-slate-950 font-bold text-base py-3 px-4 rounded-xl transition duration-200 shadow-lg shadow-cyan-500/20 mt-2">
                    Log in
                </button>

                <!-- Google OAuth Button -->
                <a href="{{ route('google.redirect') }}" class="google-btn w-full py-3 px-4 rounded-xl text-sm font-semibold flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    Continue with Google
                </a>

            </form>

            <!-- Bottom Link -->
            <div class="text-center pt-2">
                <p class="text-xs text-slate-400 font-medium">
                    Don't have an account? 
                    <a href="{{ url('/create') }}" class="text-[#00d2ff] hover:underline font-semibold ml-1"> {{ route('create') }} </a>
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