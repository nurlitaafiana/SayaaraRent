<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SayaaraRent Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 240px;
            --primary: #1a3a6e;
            --primary-light: #2251a3;
            --sidebar-bg: #0d1f3c;
            --sidebar-hover: rgba(255,255,255,0.07);
            --sidebar-active-bg: rgba(255,255,255,0.12);
            --text-muted-sidebar: #7a90b0;
            --bg: #f4f6fb;
            --border: #e5e9f2;
            --topbar-h: 64px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: #0d1f3c;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        /* Logo area */
        .sidebar-logo {
            padding: 22px 20px 18px;
            display: flex;
            align-items: center;
            gap: 11px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #2563eb, #1a3a6e);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logo-icon i { color: #fff; font-size: 18px; }
        .logo-text .brand {
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.3px;
            line-height: 1;
        }
        .logo-text .sub {
            color: var(--text-muted-sidebar);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 3px;
        }

        /* Nav */
        .sidebar-menu {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }
        .menu-label {
            color: #4a6080;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 600;
            margin: 8px 0 8px 10px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
            color: var(--text-muted-sidebar);
            padding: 11px 12px;
            border-radius: 10px;
            transition: all 0.18s;
            margin-bottom: 2px;
            font-size: 13.5px;
            font-weight: 500;
            position: relative;
        }
        .menu-item i { font-size: 17px; min-width: 20px; }
        .menu-item:hover {
            background: var(--sidebar-hover);
            color: #fff;
            text-decoration: none;
        }
        .menu-item.active {
            background: var(--sidebar-active-bg);
            color: #fff;
            font-weight: 600;
        }
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%; bottom: 20%;
            width: 3px;
            background: #3b82f6;
            border-radius: 0 3px 3px 0;
        }
        .nav-dot {
            width: 7px; height: 7px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
        }

        /* User card at bottom */
        .sidebar-bottom {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 10px;
            margin-bottom: 6px;
            background: rgba(255,255,255,0.05);
        }
        .sidebar-user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1a3a6e);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-user-info .name {
            color: #fff; font-size: 13px; font-weight: 600; line-height: 1.2;
        }
        .sidebar-user-info .role {
            color: var(--text-muted-sidebar); font-size: 11px;
        }
        .logout-btn {
            width: 100%;
            border: none;
            background: transparent;
            color: #f87171;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.18s;
            font-size: 13.5px;
            font-weight: 500;
            font-family: inherit;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.1); }
        .logout-btn i { font-size: 16px; }

        /* ── TOPBAR ── */
        .main-wrap {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: var(--topbar-h);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-title { font-size: 18px; font-weight: 700; color: #0d1f3c; }
        .topbar-sub { font-size: 12px; color: #7a90b0; margin-top: 1px; }

        /* Profile dropdown */
        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 10px;
            transition: background 0.15s;
            border: none;
            background: transparent;
            font-family: inherit;
        }
        .profile-trigger:hover { background: #f1f5fb; }
        .profile-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1a3a6e);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .profile-info { text-align: left; }
        .profile-info .pname { font-size: 13px; font-weight: 600; color: #0d1f3c; line-height: 1.2; }
        .profile-info .prole { font-size: 11px; color: #7a90b0; }
        .profile-trigger .bi-chevron-down { font-size: 12px; color: #7a90b0; transition: transform 0.2s; }
        .profile-trigger.open .bi-chevron-down { transform: rotate(180deg); }

        /* Dropdown menu */
        .profile-dropdown {
            position: absolute;
            top: calc(var(--topbar-h) - 4px);
            right: 20px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            width: 220px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            display: none;
            z-index: 200;
            overflow: hidden;
        }
        .profile-dropdown.show { display: block; }
        .dropdown-header {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }
        .dropdown-header .dname { font-size: 14px; font-weight: 700; color: #0d1f3c; }
        .dropdown-header .demail { font-size: 12px; color: #7a90b0; margin-top: 2px; }
        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            font-size: 13px;
            color: #374151;
            text-decoration: none;
            transition: background 0.15s;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            font-family: inherit;
        }
        .dropdown-item-custom:hover { background: #f8fafc; color: #0d1f3c; text-decoration: none; }
        .dropdown-item-custom i { font-size: 15px; color: #7a90b0; }
        .dropdown-item-custom.danger { color: #ef4444; }
        .dropdown-item-custom.danger i { color: #ef4444; }
        .dropdown-divider { height: 1px; background: var(--border); }

        /* CONTENT */
        .page-content { flex: 1; padding: 28px; }

        /* CARD */
        .card { border: none; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }

        /* TABLE */
        .table { margin-bottom: 0; }
        .table thead { background: #f8fafc; }
        .table th { font-size: 12px; font-weight: 600; color: #64748b; border-bottom: 1px solid var(--border); }
        .table td { vertical-align: middle; }

        /* BADGE */
        .badge { padding: 6px 12px; border-radius: 999px; font-weight: 600; }

        /* MOBILE */
        @media(max-width: 992px) {
            .sidebar { width: 70px; }
            .logo-text, .menu-label, .menu-item span, .sidebar-user-info { display: none; }
            .menu-item { justify-content: center; padding: 12px; }
            .menu-item.active::before { display: none; }
            .sidebar-user { justify-content: center; }
            .logout-btn { justify-content: center; }
            .logout-btn span { display: none; }
            .main-wrap { margin-left: 70px; }
            .nav-dot { right: 6px; }
        }

        @media(max-width: 768px) {
            .topbar { padding: 0 16px; }
            .page-content { padding: 16px; }
            .topbar-sub { display: none; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-car-front-fill"></i></div>
        <div class="logo-text">
            <div class="brand">SAYAARARENT</div>
            <div class="sub">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>

        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.rental.index') }}"
           class="menu-item {{ request()->routeIs('admin.rental.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Rental</span>
            @if(isset($pendingRentalCount) && $pendingRentalCount > 0)
                <span class="nav-dot"></span>
            @endif
        </a>

        <a href="{{ route('admin.pembayaran.index') }}"
           class="menu-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
            @if(isset($waitingPaymentCount) && $waitingPaymentCount > 0)
                <span class="nav-dot"></span>
            @endif
        </a>

        <a href="{{ route('admin.kendaraan.index') }}"
           class="menu-item {{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
            <i class="bi bi-car-front"></i>
            <span>Kendaraan</span>
        </a>

        <a href="{{ route('admin.kategori.index') }}"
           class="menu-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            <span>Kategori</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="role">Super Admin</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- MAIN -->
<div class="main-wrap">

    <div class="topbar">
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard Admin')</div>
            <div class="topbar-sub">@yield('page-sub', 'Monitoring rental dan pembayaran')</div>
        </div>

        <div style="position:relative;">
            <button class="profile-trigger" id="profileBtn" onclick="toggleDropdown()">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="profile-info">
                    <div class="pname">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="prole">Super Admin</div>
                </div>
                <i class="bi bi-chevron-down"></i>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="dname">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="demail">{{ auth()->user()->email ?? '' }}</div>
</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item-custom danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="page-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleDropdown() {
    const btn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');
    btn.classList.toggle('open');
    dropdown.classList.toggle('show');
}

document.addEventListener('click', function(e) {
    const btn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
        btn.classList.remove('open');
        dropdown.classList.remove('show');
    }
});
</script>

@stack('scripts')
</body>
</html>