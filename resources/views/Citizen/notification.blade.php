<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Notifications</title>
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
        .glass-card {
            background: rgba(10, 35, 66, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 64, 115, 0.6);
        }
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
    @include('Both.navbar')
    <main class="max-w-5xl mx-auto w-full px-4 py-6 flex-grow space-y-6">
        <header class="space-y-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-3">
                    <i class="fa-solid fa-bell text-cyan-400"></i> Notifications
                </h1>
                <p class="text-sm text-slate-400 mt-1">Stay updated with the latest weather alerts, travel advisories and system updates for your sea journey.</p>
            </div>
            <x-category-filter class="pt-2" />
        </header>
        <div>
            <div class="space-y-4" id="notifications-list">
                @forelse ($notifications as $notification)
                    <div class="notification-item rounded-2xl p-5 border-l-4 border-l-red-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <a href="{{ route('notifications.show', $notification->id) }}" class="flex items-start gap-3.5 flex-grow">
                            <div class="p-2.5 bg-red-500/20 text-red-400 rounded-xl mt-0.5">
                                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-bold text-red-400 uppercase tracking-wider">{{ $notification->data['title'] }}</span>
                                    <span class="text-xs text-slate-400">• {{ $notification->created_at->format('M j, Y - H:i') }}</span>
                                </div>
                                <h2 class="text-base font-bold text-white">{{ $notification->data['message'] }}</h2>
                                <span class="text-xs text-cyan-400">View full report <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                            </div>
                        </a>
                        @if ($notification->read_at === null)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="text-xs text-cyan-400 hover:underline">Mark as read</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-slate-400">No notifications yet.</div>
                @endforelse
            </div>
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

            const notificationsList = document.getElementById('notifications-list');
            window.Echo.private('App.Models.User.{{ auth()->id() }}')
                .notification((notification) => {
                    const selectedCategory = new URLSearchParams(window.location.search).get('category');
                    if (selectedCategory && notification.category !== selectedCategory) {
                        return;
                    }

                    const notificationEl = document.createElement('div');
                    notificationEl.className = 'notification-item rounded-2xl p-5 border-l-4 border-l-red-500 relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4';
                    notificationEl.innerHTML = `
                        <a href="{{ url('notifications') }}/${notification.id}" class="flex items-start gap-3.5 flex-grow">
                            <div class="p-2.5 bg-red-500/20 text-red-400 rounded-xl mt-0.5">
                                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-bold text-red-400 uppercase tracking-wider">${notification.title}</span>
                                    <span class="text-xs text-slate-400">• Just now</span>
                                </div>
                                <h2 class="text-base font-bold text-white">${notification.message}</h2>
                                <span class="text-xs text-cyan-400">View full report <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                            </div>
                        </a>
                    `;
                    notificationsList.prepend(notificationEl);
                });
        });
    </script>
</body>
</html>