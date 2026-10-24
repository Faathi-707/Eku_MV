<nav class="topnav" aria-label="Main">
  <a class="brand" href="{{ route('dashboard') }}">Maldives Eku_mv</a>
  <div class="links">
    <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Map</a>

    @auth
      @if(auth()->user()->role === 'citizen')
        <a href="{{ route('predict') }}" @class(['active' => request()->routeIs('predict')])>Predict</a>
        <a href="{{ route('notifications') }}" @class(['active' => request()->routeIs('notifications')])>Notification</a>
        <a href="{{ route('profile') }}" @class(['active' => request()->routeIs('profile')])>Profile</a>
      @else
        <a href="{{ route('disruptions') }}" @class(['active' => request()->routeIs('disruptions')])>Disruptions</a>
        <a href="{{ route('report') }}" @class(['active' => request()->routeIs('report')])>Reports</a>
        <a href="{{ route('official.profile') }}" @class(['active' => request()->routeIs('official.profile')])>Profile</a>
      @endif

      <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0">
        @csrf
        <button type="submit" style="background:none;border:0;color:var(--muted);font-size:14px;font-weight:600;padding:6px 12px;border-radius:999px;cursor:pointer;font-family:inherit">Logout</button>
      </form>
    @endauth

    @guest
      <a href="{{ route('login') }}">Log in</a>
    @endguest
  </div>
</nav>

<style>
.topnav{height:52px;display:flex;align-items:center;justify-content:space-between;gap:16px;
  padding:0 max(16px,env(safe-area-inset-left,0px));background:var(--panel);border-bottom:1px solid var(--line)}
.topnav .brand{font-family:var(--f-display);font-weight:700;font-size:22px;letter-spacing:.01em;color:var(--ink);text-decoration:none;white-space:nowrap}
.topnav .links{display:flex;gap:4px}
.topnav .links a{color:var(--muted);text-decoration:none;font-size:14px;font-weight:600;padding:6px 12px;border-radius:999px}
.topnav .links a:hover{background:var(--chip);color:var(--ink)}
.topnav .links a.active{background:var(--chip);color:var(--ink)}
.topnav a:focus-visible{outline:2px solid var(--focus);outline-offset:2px}
@media (max-width:760px){.topnav .brand{font-size:18px}.topnav .links a{padding:6px 8px}}
</style>