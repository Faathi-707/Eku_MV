<nav class="topnav" aria-label="Main">
  <a class="brand" href="{{ url('/') }}">Maldives Eku_mv</a>
  <div class="links">
    <a href="{{ url('/') }}" @class(['active' => request()->is('/')])>Map</a>
    <a href="{{ url('/predict') }}" @class(['active' => request()->is('predict')])>Predict</a>
    <a href="{{ url('/notification') }}" @class(['active' => request()->is('notification')])>Notification</a>
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