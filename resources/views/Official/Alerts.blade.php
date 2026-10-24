<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Citizen Alerts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        .alert-item {
            background: rgba(12, 38, 72, 0.6);
            border: 1px solid rgba(30, 64, 115, 0.5);
            transition: all 0.2s ease;
        }
        .alert-item:hover {
            border-color: rgba(56, 189, 248, 0.4);
            background: rgba(15, 45, 85, 0.8);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('Both.navbar')
    <main class="max-w-4xl mx-auto w-full px-4 py-6 flex-grow space-y-6">
        <header>
            <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-3">
                <i class="fa-solid fa-tower-broadcast text-cyan-400"></i> Citizen Alerts
            </h1>
            <p class="text-sm text-slate-400 mt-1">Distress calls and hazard reports from citizens. Distress calls are marked urgent.</p>
        </header>
        <div class="space-y-4" id="alerts-list">
            @forelse ($alerts as $alert)
                <a href="{{ route('alerts.show', $alert->id) }}" @class([
                    'alert-item rounded-2xl p-5 border-l-4 flex items-start gap-3.5',
                    'border-l-red-500' => $alert->data['urgent'],
                    'border-l-amber-400' => ! $alert->data['urgent'],
                    'opacity-60' => $alert->read_at,
                ])>
                    <div @class([
                        'p-2.5 rounded-xl mt-0.5',
                        'bg-red-500/20 text-red-400' => $alert->data['urgent'],
                        'bg-amber-400/20 text-amber-300' => ! $alert->data['urgent'],
                    ])>
                        <i class="fa-solid {{ $alert->data['urgent'] ? 'fa-life-ring' : 'fa-triangle-exclamation' }} text-lg"></i>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider {{ $alert->data['urgent'] ? 'text-red-400' : 'text-amber-300' }}">{{ $alert->data['title'] }}</span>
                            <span class="text-xs text-slate-400">• {{ $alert->created_at->format('M j, Y - H:i') }}</span>
                            @if (! $alert->read_at)
                                <span class="text-[10px] font-bold text-cyan-300 bg-cyan-500/20 px-2 py-0.5 rounded-full">New</span>
                            @endif
                        </div>
                        <h2 class="text-sm font-semibold text-white">{{ $alert->data['message'] }}</h2>
                        <span class="text-xs text-cyan-400">View in community <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                    </div>
                </a>
            @empty
                <div id="alerts-empty" class="text-center text-slate-400">No alerts yet.</div>
            @endforelse
        </div>
    </main>
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>
    <script>
        window.addEventListener('load', () => {
            if (! window.Echo) {
                return;
            }

            const alertsList = document.getElementById('alerts-list');
            window.Echo.private('App.Models.User.{{ auth()->id() }}')
                .notification((alert) => {
                    if (alert.post_id === undefined) {
                        return;
                    }

                    document.getElementById('alerts-empty')?.remove();

                    const alertEl = document.createElement('a');
                    alertEl.href = `{{ url('official/alerts') }}/${alert.id}`;
                    alertEl.className = `alert-item rounded-2xl p-5 border-l-4 flex items-start gap-3.5 ${alert.urgent ? 'border-l-red-500' : 'border-l-amber-400'}`;
                    alertEl.innerHTML = `
                        <div class="p-2.5 rounded-xl mt-0.5 ${alert.urgent ? 'bg-red-500/20 text-red-400' : 'bg-amber-400/20 text-amber-300'}">
                            <i class="fa-solid ${alert.urgent ? 'fa-life-ring' : 'fa-triangle-exclamation'} text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="alert-title text-[11px] font-bold uppercase tracking-wider ${alert.urgent ? 'text-red-400' : 'text-amber-300'}"></span>
                                <span class="text-xs text-slate-400">• Just now</span>
                                <span class="text-[10px] font-bold text-cyan-300 bg-cyan-500/20 px-2 py-0.5 rounded-full">New</span>
                            </div>
                            <h2 class="alert-message text-sm font-semibold text-white"></h2>
                            <span class="text-xs text-cyan-400">View in community <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                        </div>
                    `;
                    alertEl.querySelector('.alert-title').textContent = alert.title;
                    alertEl.querySelector('.alert-message').textContent = alert.message;
                    alertsList.prepend(alertEl);
                });
        });
    </script>
</body>
</html>
