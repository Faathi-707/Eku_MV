<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maldives Eku_mv - Community</title>
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
        .form-input-box {
            background-color: #0b284f !important;
            border: 1px solid rgba(30, 75, 135, 0.6) !important;
            color: #ffffff !important;
        }
        .form-input-box:focus {
            border-color: #38bdf8 !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
        }
        .post-bubble {
            background: rgba(12, 38, 72, 0.8);
            border: 1px solid rgba(30, 64, 115, 0.5);
        }
        .post-bubble.is-mine {
            background: rgba(8, 72, 105, 0.6);
            border-color: rgba(56, 189, 248, 0.35);
        }
        .post-bubble { border-left-width: 4px; }
        .edge-hazard { border-left-color: #fbbf24; }
        .edge-reroute { border-left-color: #38bdf8; }
        .edge-distress { border-left-color: #f87171; }
        .post-bubble.is-mine.edge-hazard { border-left-color: #fbbf24; }
        .post-bubble.is-mine.edge-reroute { border-left-color: #38bdf8; }
        .post-bubble.is-mine.edge-distress { border-left-color: #f87171; }
        .post-bubble.is-highlighted {
            box-shadow: 0 0 0 2px #38bdf8;
        }
        .type-hazard { color: #fbbf24; background: rgba(251, 191, 36, 0.15); border-color: rgba(251, 191, 36, 0.35); }
        .type-reroute { color: #38bdf8; background: rgba(56, 189, 248, 0.15); border-color: rgba(56, 189, 248, 0.35); }
        .type-distress { color: #f87171; background: rgba(248, 113, 113, 0.15); border-color: rgba(248, 113, 113, 0.4); }
        .type-option input:checked + span { outline: 2px solid currentColor; }
        #community-feed { scrollbar-width: thin; scrollbar-color: #1e4b87 transparent; }
        .photo-thumb {
            position: relative;
            flex-shrink: 0;
            width: 100%;
            aspect-ratio: 4 / 3;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid rgba(30, 75, 135, 0.6);
            cursor: zoom-in;
        }
        @media (min-width: 640px) {
            .photo-thumb { width: 12rem; }
        }
        .photo-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s ease; }
        .photo-thumb:hover img { transform: scale(1.05); }
        .photo-thumb-icon {
            position: absolute;
            right: 0.375rem;
            bottom: 0.375rem;
            font-size: 0.625rem;
            color: #fff;
            background: rgba(7, 25, 48, 0.75);
            padding: 0.25rem 0.375rem;
            border-radius: 0.375rem;
        }
        .photo-thumb:focus-visible { outline: 2px solid #38bdf8; outline-offset: 2px; }
        #photo-lightbox {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(3, 12, 26, 0.9);
            cursor: zoom-out;
        }
        #photo-lightbox img { max-width: 100%; max-height: 85vh; border-radius: 0.75rem; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('Both.navbar')
    @php
        $typeIcons = [
            'hazard' => 'fa-triangle-exclamation',
            'reroute' => 'fa-route',
            'distress' => 'fa-life-ring',
        ];
        $selectedType = request('type');
        $activePill = 'bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-semibold text-xs px-5 py-2 rounded-full transition shadow';
        $inactivePill = 'bg-[#0b2b52] hover:bg-blue-900/60 text-slate-300 border border-blue-900/60 font-medium text-xs px-4 py-2 rounded-full transition';
        $isCitizen = auth()->user()->role === 'citizen';
    @endphp
    <main class="max-w-4xl mx-auto w-full px-4 py-6 flex-grow space-y-4">
        <header class="space-y-3">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white flex items-center gap-3">
                    <i class="fa-solid fa-users text-cyan-400"></i> Community
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Warn fellow seafarers about hazards and rerouting, or send a distress call to alert officials immediately.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('community') }}" class="{{ $selectedType ? $inactivePill : $activePill }}">All</a>
                @foreach (\App\Enums\CommunityPostType::cases() as $type)
                    <a href="{{ route('community', ['type' => $type->value]) }}" class="{{ $selectedType === $type->value ? $activePill : $inactivePill }}">{{ $type->label() }}</a>
                @endforeach
            </div>
        </header>

        @if (session('status'))
            <div class="rounded-xl border border-cyan-500/40 bg-cyan-500/10 text-cyan-200 text-xs p-3">
                {{ session('status') }}
            </div>
        @endif

        <section id="community-feed" class="glass-card rounded-2xl p-4 space-y-4 overflow-y-auto" style="height: 60vh;">
            @forelse ($posts as $post)
                @php $isMine = $post->user_id === auth()->id(); @endphp
                <div id="post-{{ $post->id }}">
                    <article class="post-bubble edge-{{ $post->type->value }} {{ $isMine ? 'is-mine' : '' }} rounded-2xl p-4 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="type-{{ $post->type->value }} border text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                                <i class="fa-solid {{ $typeIcons[$post->type->value] }}"></i> {{ $post->type->label() }}
                            </span>
                            <span class="text-xs font-semibold text-slate-200">{{ $isMine ? 'You' : $post->user->name }}</span>
                            <span class="text-xs text-slate-500">• {{ $post->created_at->format('M j, H:i') }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if ($post->photoUrl())
                                <button type="button" class="photo-thumb" data-photo="{{ $post->photoUrl() }}" aria-label="View photo proof full size">
                                    <img src="{{ $post->photoUrl() }}" alt="Photo proof attached by {{ $post->user->name }}" loading="lazy">
                                    <span class="photo-thumb-icon"><i class="fa-solid fa-expand"></i></span>
                                </button>
                            @endif
                            <div class="space-y-1.5 min-w-0">
                                <p class="text-xs text-cyan-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot"></i> {{ $post->location }}
                                </p>
                                <p class="text-sm text-white whitespace-pre-line break-words">{{ $post->message }}</p>
                            </div>
                        </div>
                        @if ($post->distress_status)
                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                <span @class([
                                    'text-[11px] font-bold px-2.5 py-0.5 rounded-full border',
                                    'type-distress' => $post->distress_status === \App\Enums\DistressStatus::Open,
                                    'type-hazard' => $post->distress_status === \App\Enums\DistressStatus::Responding,
                                    'text-emerald-400 bg-emerald-500/15 border-emerald-500/35' => $post->distress_status === \App\Enums\DistressStatus::Resolved,
                                ])>{{ $post->distress_status->label() }}</span>
                                @unless ($isCitizen)
                                    @foreach ([\App\Enums\DistressStatus::Responding, \App\Enums\DistressStatus::Resolved] as $status)
                                        @if ($post->distress_status !== $status)
                                            <form method="POST" action="{{ route('community.status', $post) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="distress_status" value="{{ $status->value }}">
                                                <button type="submit" class="text-[11px] font-semibold text-cyan-400 border border-cyan-500/40 hover:bg-cyan-500/10 px-2.5 py-0.5 rounded-full">
                                                    Mark {{ $status === \App\Enums\DistressStatus::Responding ? 'responding' : 'resolved' }}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                @endunless
                            </div>
                        @endif
                    </article>
                </div>
            @empty
                <p id="community-empty" class="text-center text-sm text-slate-400 py-10">No posts yet. Be the first to share an update.</p>
            @endforelse
        </section>

        @if ($isCitizen)
            <form method="POST" action="{{ route('community.store') }}" enctype="multipart/form-data" class="glass-card rounded-2xl p-4 space-y-3">
                @csrf
                @if ($errors->any())
                    <div class="rounded-xl border border-red-500/40 bg-red-500/10 text-red-300 text-xs p-3 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap gap-2">
                    @foreach (\App\Enums\CommunityPostType::cases() as $type)
                        <label class="type-option cursor-pointer">
                            <input type="radio" name="type" value="{{ $type->value }}" class="sr-only" @checked(old('type', 'hazard') === $type->value) required>
                            <span class="type-{{ $type->value }} border inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full">
                                <i class="fa-solid {{ $typeIcons[$type->value] }}"></i> {{ $type->label() }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <p id="distress-hint" class="text-xs text-red-300" hidden>
                    <i class="fa-solid fa-circle-info"></i> Distress calls alert officials immediately. A photo is optional.
                </p>

                <input type="text" name="location" value="{{ old('location') }}" required maxlength="255" placeholder="Location (e.g. 2 nm north of Malé harbour)" class="w-full form-input-box rounded-xl px-4 py-2.5 text-sm">

                <textarea name="message" rows="2" required maxlength="2000" placeholder="Describe what you're seeing or what help you need..." class="w-full form-input-box rounded-xl p-3 text-sm resize-none">{{ old('message') }}</textarea>

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <label class="inline-flex items-center gap-2 text-xs text-slate-300 cursor-pointer">
                        <i class="fa-solid fa-camera text-cyan-400"></i>
                        <span id="photo-label">Attach photo proof</span>
                        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp" class="sr-only" id="photo-input">
                    </label>
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-sm px-5 py-2 rounded-xl transition flex items-center gap-2 shadow">
                        <i class="fa-solid fa-paper-plane"></i> Send
                    </button>
                </div>
            </form>
        @endif
    </main>
    <div id="photo-lightbox" role="dialog" aria-modal="true" aria-label="Photo proof" hidden>
        <img src="" alt="Photo proof, full size">
    </div>
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-blue-950 mt-8">
        © Maldives Eku_mv - AI Maritime & Travel Safety System
    </footer>
    <script>
        const feed = document.getElementById('community-feed');
        const highlightedPost = window.location.hash ? document.querySelector(window.location.hash) : null;

        if (highlightedPost) {
            highlightedPost.querySelector('.post-bubble').classList.add('is-highlighted');
            feed.scrollTop = highlightedPost.offsetTop - feed.offsetTop - 16;
        } else {
            feed.scrollTop = feed.scrollHeight;
        }

        const lightbox = document.getElementById('photo-lightbox');
        const lightboxImage = lightbox.querySelector('img');
        const closeLightbox = () => {
            lightbox.hidden = true;
            lightboxImage.src = '';
        };
        feed.addEventListener('click', (event) => {
            const thumb = event.target.closest('.photo-thumb');
            if (thumb) {
                lightboxImage.src = thumb.dataset.photo;
                lightbox.hidden = false;
            }
        });
        lightbox.addEventListener('click', closeLightbox);
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && ! lightbox.hidden) {
                closeLightbox();
            }
        });

        const photoInput = document.getElementById('photo-input');
        const maxPhotoBytes = 5 * 1024 * 1024;
        photoInput?.addEventListener('change', () => {
            const photo = photoInput.files[0];
            const photoLabel = document.getElementById('photo-label');

            if (photo && photo.size > maxPhotoBytes) {
                photoInput.value = '';
                photoLabel.textContent = 'Photo too large (max 5 MB). Choose another.';
                photoLabel.classList.add('text-red-300');
                return;
            }

            photoLabel.textContent = photo?.name ?? 'Attach photo proof';
            photoLabel.classList.remove('text-red-300');
        });

        const distressHint = document.getElementById('distress-hint');
        const syncDistressHint = () => {
            if (distressHint) {
                distressHint.hidden = document.querySelector('input[name="type"]:checked')?.value !== 'distress';
            }
        };
        document.querySelectorAll('input[name="type"]').forEach((input) => input.addEventListener('change', syncDistressHint));
        syncDistressHint();

        const typeIcons = @json($typeIcons);
        const selectedType = @json($selectedType);

        function renderPost(post) {
            const wrapper = document.createElement('div');
            wrapper.id = `post-${post.id}`;

            const bubble = document.createElement('article');
            bubble.className = `post-bubble edge-${post.type} rounded-2xl p-4 space-y-3`;

            const meta = document.createElement('div');
            meta.className = 'flex flex-wrap items-center gap-2';
            const badge = document.createElement('span');
            badge.className = `type-${post.type} border text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full`;
            badge.innerHTML = `<i class="fa-solid ${typeIcons[post.type]}"></i> `;
            badge.append(post.type_label);
            const author = document.createElement('span');
            author.className = 'text-xs font-semibold text-slate-200';
            author.textContent = post.author;
            const time = document.createElement('span');
            time.className = 'text-xs text-slate-500';
            time.textContent = '• Just now';
            meta.append(badge, author, time);

            const location = document.createElement('p');
            location.className = 'text-xs text-cyan-300 flex items-center gap-1.5';
            location.innerHTML = '<i class="fa-solid fa-location-dot"></i> ';
            location.append(post.location);

            const message = document.createElement('p');
            message.className = 'text-sm text-white whitespace-pre-line break-words';
            message.textContent = post.message;

            const body = document.createElement('div');
            body.className = 'flex flex-col sm:flex-row gap-3';

            if (post.photo_url) {
                const thumb = document.createElement('button');
                thumb.type = 'button';
                thumb.className = 'photo-thumb';
                thumb.dataset.photo = post.photo_url;
                thumb.setAttribute('aria-label', 'View photo proof full size');
                const image = document.createElement('img');
                image.src = post.photo_url;
                image.alt = `Photo proof attached by ${post.author}`;
                const icon = document.createElement('span');
                icon.className = 'photo-thumb-icon';
                icon.innerHTML = '<i class="fa-solid fa-expand"></i>';
                thumb.append(image, icon);
                body.append(thumb);
            }

            const text = document.createElement('div');
            text.className = 'space-y-1.5 min-w-0';
            text.append(location, message);
            body.append(text);

            bubble.append(meta, body);

            if (post.distress_status) {
                const status = document.createElement('span');
                status.className = 'type-distress inline-block text-[11px] font-bold px-2.5 py-0.5 rounded-full border';
                status.textContent = post.distress_status;
                bubble.append(status);
            }

            wrapper.append(bubble);
            return wrapper;
        }

        window.addEventListener('load', () => {
            if (! window.Echo) {
                return;
            }

            window.Echo.private('community').listen('CommunityPostCreated', (post) => {
                if (document.getElementById(`post-${post.id}`) || (selectedType && post.type !== selectedType)) {
                    return;
                }

                document.getElementById('community-empty')?.remove();
                const isNearBottom = feed.scrollHeight - feed.scrollTop - feed.clientHeight < 120;
                feed.append(renderPost(post));
                if (isNearBottom) {
                    feed.scrollTop = feed.scrollHeight;
                }
            });
        });
    </script>
</body>
</html>
