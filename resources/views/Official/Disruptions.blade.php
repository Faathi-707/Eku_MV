<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Saved Drafts</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS file loaded via Laravel Vite -->
    @vite(['resources/css/DIsruption.css'])
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navigation Bar -->
    @include('Both.navbar')

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto w-full px-4 py-8 flex-grow space-y-6">

        <!-- Page Header & Add New Report Button -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-3">
                    <i class="fa-solid fa-file-lines text-cyan-400"></i> Saved Drafts
                </h1>
                <p class="text-sm text-slate-400 mt-1">View and manage your saved draft reports. Complete and submit them anytime.</p>
            </div>

            <!-- Add New Report Button linking to the form page -->
            <a href="{{ url('/report') }}" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs px-5 py-3 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-cyan-500/20 whitespace-nowrap self-start md:self-auto">
                <i class="fa-solid fa-plus"></i> Add New Report
            </a>
        </div>

        <!-- Filters and Search Bar Section -->
        <div class="flex flex-col lg:flex-row items-center justify-between gap-4 pt-2">
            <!-- Category Filter Pills -->
            <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
                <button class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold text-xs px-5 py-2 rounded-full transition shadow">All Drafts</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">Marine Disruption Reports</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">Route Updates</button>
                <button class="bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition">System Updates</button>
            </div>

            <!-- Search Drafts Input -->
            <div class="relative w-full lg:w-72">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-xs text-slate-400"></i>
                <input type="text" placeholder="Search drafts..." class="w-full bg-[#0b284f] border border-blue-900/60 rounded-full pl-10 pr-4 py-2 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-cyan-400">
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-cyan-500/40 bg-cyan-500/10 text-cyan-200 text-xs p-3">
                {{ session('status') }}
            </div>
        @endif

        <!-- Drafts List Container -->
        <div class="space-y-4">
            @forelse ($drafts as $draft)
                <div class="draft-item rounded-2xl p-5 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-red-500/20 text-red-400 rounded-xl mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </div>
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-base font-bold text-white">Marine Disruption Report</h2>
                                <span class="bg-cyan-500/20 text-cyan-400 border border-cyan-500/30 text-[10px] font-bold px-2.5 py-0.5 rounded-full">Draft</span>
                            </div>
                            <p class="text-xs text-cyan-300 font-medium flex items-center gap-1.5">
                                <i class="fa-solid fa-water text-xs"></i> {{ $draft->category->label() }}
                            </p>
                            <div class="flex flex-wrap items-center gap-6 text-xs text-slate-400 pt-1">
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar-days text-cyan-400"></i> Last edited: <strong class="text-slate-200">{{ $draft->updated_at->format('M j, Y - H:i') }}</strong></span>
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-cyan-400"></i> Estimated clearance: <strong class="text-slate-200">{{ $draft->clearance_period }}</strong></span>
                                @if ($draft->affected_area)
                                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-cyan-400"></i> Affected area: <strong class="text-slate-200">{{ $draft->affected_area }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2.5 self-end lg:self-center w-full lg:w-auto justify-end">
                        <a href="{{ route('report.edit', $draft) }}" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5 shadow">
                            <i class="fa-solid fa-pen"></i> Continue
                        </a>
                        <form method="POST" action="{{ route('disruptions.destroy', $draft) }}" onsubmit="return confirm('Delete this draft?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 font-semibold text-xs px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-blue-900/50 bg-[#0b2b52]/40 p-8 text-center text-sm text-slate-400">
                    No drafts yet. <a href="{{ route('report') }}" class="text-cyan-400 hover:underline">Create a new report</a>.
                </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>

</body>
</html>