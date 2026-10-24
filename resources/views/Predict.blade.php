<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Predict Travel</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Laravel Vite Asset Directive -->
    @vite(['resources/css/predict.css'])
</head>

<body class="min-h-screen flex flex-col">

    <!-- Include your separate navigation bar file -->
    
    @include('navbar')

    <!-- Main Content Container -->
    <main class="max-w-5xl mx-auto w-full px-6 py-8 flex-grow space-y-8">

        <!-- Form Container -->
        <form id="predictForm" onsubmit="handlePrediction(event)" class="space-y-8">
            
            <!-- Enter Destination Section -->
            <div>
                <h2 class="text-2xl font-semibold mb-4 text-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-cyan-400"></i>
                    Enter destination
                </h2>
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="w-full">
                        <select id="from" required class="w-full py-3.5 px-5 rounded-full bg-slate-200 text-slate-800 font-medium border-2 border-transparent focus:border-cyan-400 focus:outline-none shadow">
                            <option value="" disabled selected>From (e.g. Malé)</option>
                            <option value="Male">Malé</option>
                            <option value="Hulhumale">Hulhumalé</option>
                            <option value="Maafushi">Maafushi</option>
                            <option value="Rasdhoo">Rasdhoo</option>
                        </select>
                    </div>

                    <div class="text-2xl text-cyan-300 transform md:rotate-0 rotate-90">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>

                    <div class="w-full">
                        <select id="to" required class="w-full py-3.5 px-5 rounded-full bg-slate-200 text-slate-800 font-medium border-2 border-transparent focus:border-cyan-400 focus:outline-none shadow">
                            <option value="" disabled selected>To (Destination Atoll/Island)</option>
                            <option value="Maafushi">Maafushi</option>
                            <option value="Ukulhas">Ukulhas</option>
                            <option value="Dhigurah">Dhigurah</option>
                            <option value="Fulidhoo">Fulidhoo</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Date Section -->
            <div>
                <h2 class="text-2xl font-semibold mb-4 text-slate-100 flex items-center gap-2">
                    <i class="fa-regular fa-calendar-days text-cyan-400"></i>
                    Date
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Calendar Picker Box -->
                    <div class="bg-slate-200 p-4 rounded-2xl text-slate-800 flex flex-col items-center justify-center min-h-[160px] shadow">
                        <label for="travelDate" class="text-sm font-semibold text-slate-600 mb-2">Select Travel Date</label>
                        <input type="date" id="travelDate" required class="bg-white border border-slate-300 text-slate-800 font-semibold py-2 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 shadow-sm cursor-pointer">
                    </div>

                    <!-- Date Range Inputs / Action Button -->
                    <div class="flex flex-col justify-center space-y-4">
                        <div class="relative">
                            <input type="date" id="startDate" class="w-full py-3 px-5 rounded-full bg-slate-200 text-slate-800 font-medium border-2 border-transparent focus:border-cyan-400 focus:outline-none shadow">
                            <span class="absolute right-5 top-3.5 text-xs text-slate-500 font-semibold pointer-events-none">Start Date</span>
                        </div>
                        <div class="relative">
                            <input type="date" id="endDate" class="w-full py-3 px-5 rounded-full bg-slate-200 text-slate-800 font-medium border-2 border-transparent focus:border-cyan-400 focus:outline-none shadow">
                            <span class="absolute right-5 top-3.5 text-xs text-slate-500 font-semibold pointer-events-none">End Date</span>
                        </div>
                        <button type="submit" class="w-full py-3.5 px-6 rounded-full bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold transition duration-200 shadow-lg flex items-center justify-center gap-2">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            Get AI Travel Predictions
                        </button>
                    </div>
                </div>
            </div>

        </form>

        <!-- AI Predictions Results Panel -->
        <div id="aiOutput" class="bg-slate-200 text-slate-900 rounded-2xl p-6 md:p-8 shadow-2xl transition-all duration-300">
            <div class="flex items-center gap-3 border-b border-slate-300 pb-4 mb-6">
                <i class="fa-solid fa-robot text-2xl text-cyan-600"></i>
                <h2 class="text-2xl font-bold tracking-tight text-slate-800">*AI predictions*</h2>
            </div>

            <!-- Initial State Placeholder -->
            <div id="placeholderText" class="text-slate-600 space-y-4 text-lg">
                <p class="font-medium">Please select your route and date above to generate AI maritime safety predictions, swell alerts, and recommended alternative travel dates.</p>
            </div>

            <!-- Dynamic Result Area -->
            <div id="predictionResults" class="hidden space-y-6">
                <!-- Travel Safety Status Badge -->
                <div id="safetyBadge" class="p-4 rounded-xl flex items-center gap-4 border"></div>

                <!-- Weather & Sea Conditions -->
                <div class="bg-white p-5 rounded-xl border border-slate-300 shadow-sm space-y-2">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-cloud-sun-rain text-cyan-600"></i>
                        Weather & Sea Condition Forecast
                    </h3>
                    <p id="weatherSummary" class="text-slate-700 leading-relaxed">--</p>
                </div>

                <!-- Maritime Safety Alerts & Disruptions -->
                <div class="bg-white p-5 rounded-xl border border-slate-300 shadow-sm space-y-2">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                        Maritime Alerts & Rerouting
                    </h3>
                    <p id="alertsSummary" class="text-slate-700 leading-relaxed">--</p>
                </div>

                <!-- Recommended Days / Schedule -->
                <div class="bg-white p-5 rounded-xl border border-slate-300 shadow-sm space-y-3">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                        Suggested Safe Travel Window
                    </h3>
                    <p id="suggestedDays" class="text-slate-700 leading-relaxed">--</p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-blue-200/60 border-t border-blue-900/40">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

    <!-- Interactive Mock Script -->
    <script>
        function handlePrediction(event) {
            event.preventDefault();

            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;
            const date = document.getElementById('travelDate').value;

            document.getElementById('placeholderText').classList.add('hidden');
            document.getElementById('predictionResults').classList.remove('hidden');

            const safetyBadge = document.getElementById('safetyBadge');
            const weatherSummary = document.getElementById('weatherSummary');
            const alertsSummary = document.getElementById('alertsSummary');
            const suggestedDays = document.getElementById('suggestedDays');

            safetyBadge.className = "p-4 rounded-xl flex items-start gap-4 border bg-amber-50 border-amber-300 text-amber-900";
            safetyBadge.innerHTML = `
                <i class="fa-solid fa-circle-exclamation text-3xl text-amber-500 mt-1"></i>
                <div>
                    <h4 class="font-bold text-lg">Caution Advised for High Swells</h4>
                    <p class="text-sm text-amber-800">Small craft and speedboats are advised to exercise extreme caution or hold travel until afternoon.</p>
                </div>
            `;

            weatherSummary.innerHTML = `Weather on <strong>${date}</strong> from <strong>${from}</strong> to <strong>${to}</strong> will experience squally showers with gusty winds up to 28 knots. Wave heights are expected to reach 4-6 feet across open channels.`;

            alertsSummary.innerHTML = `Yellow Maritime Alert active for central atolls. High risk of rough seas. Speedboat travel is restricted between 08:00 AM and 01:00 PM. Alternate inland channel routing recommended if travel is urgent.`;

            suggestedDays.innerHTML = `For a safer and smoother journey, AI recommends travelling on <strong>${date} after 15:00 hrs</strong> or rescheduling to the next clear weather window: <strong>2 days after target date</strong>.`;
        }
    </script>
</body>
</html>