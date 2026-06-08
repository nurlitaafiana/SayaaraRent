<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SayaaraRent Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root{
            --sidebar-width:260px;
            --primary:#2563eb;
            --primary-dark:#1d4ed8;
            --sidebar:#0f172a;
            --sidebar-hover:#1e293b;
            --text:#94a3b8;
            --bg:#f8fafc;
            --border:#e2e8f0;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            background:var(--bg);
            color:#0f172a;
        }

        /* SIDEBAR */

        .sidebar{
            position:fixed;
            top:0;
            left:0;
            width:var(--sidebar-width);
            height:100vh;
            background:var(--sidebar);
            display:flex;
            flex-direction:column;
            z-index:1000;
            box-shadow:4px 0 25px rgba(0,0,0,.08);
        }

        .sidebar-logo{
            padding:25px;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .brand{
            color:white;
            font-size:22px;
            font-weight:800;
            letter-spacing:.5px;
        }

        .sub{
            color:#64748b;
            font-size:12px;
            margin-top:3px;
            text-transform:uppercase;
        }

        .sidebar-menu{
            flex:1;
            padding:15px;
            overflow-y:auto;
        }

        .menu-label{
            color:#64748b;
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:1px;
            margin-bottom:10px;
            padding-left:10px;
        }

        .menu-item{
            display:flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
            color:var(--text);
            padding:13px 15px;
            border-radius:14px;
            transition:.25s;
            margin-bottom:6px;
            font-size:14px;
            font-weight:500;
            position:relative;
        }

        .menu-item i{
            font-size:18px;
            min-width:20px;
        }

        .menu-item:hover{
            background:var(--sidebar-hover);
            color:white;
        }

        .menu-item.active{
            background:linear-gradient(
                135deg,
                var(--primary),
                var(--primary-dark)
            );
            color:white;
            box-shadow:0 8px 20px rgba(37,99,235,.25);
        }

        .nav-dot{
            width:8px;
            height:8px;
            background:#ef4444;
            border-radius:50%;
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
        }

        .sidebar-bottom{
            padding:15px;
            border-top:1px solid rgba(255,255,255,.08);
        }

        .logout-btn{
            width:100%;
            border:none;
            background:transparent;
            color:#ef4444;
            display:flex;
            align-items:center;
            gap:10px;
            padding:13px 15px;
            border-radius:14px;
            cursor:pointer;
            transition:.25s;
        }

        .logout-btn:hover{
            background:var(--sidebar-hover);
        }

        /* MAIN */

        .main-wrap{
            margin-left:var(--sidebar-width);
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        /* TOPBAR */

        .topbar{
            background:white;
            border-bottom:1px solid var(--border);
            padding:20px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            position:sticky;
            top:0;
            z-index:100;
        }

        .topbar-title{
            font-size:24px;
            font-weight:700;
            color:#0f172a;
        }

        .topbar-sub{
            font-size:13px;
            color:#64748b;
            margin-top:2px;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .avatar{
            width:44px;
            height:44px;
            border-radius:50%;
            background:#dbeafe;
            color:#2563eb;
            font-weight:700;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        /* CONTENT */

        .page-content{
            flex:1;
            padding:30px;
        }

        /* CARD */

        .card{
            border:none;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 2px 15px rgba(0,0,0,.05);
        }

        .card-header{
            background:white;
            border-bottom:1px solid var(--border);
        }

        /* TABLE */

        .table{
            margin-bottom:0;
        }

        .table thead{
            background:#f8fafc;
        }

        .table th{
            font-size:13px;
            font-weight:600;
            color:#475569;
            border-bottom:1px solid var(--border);
        }

        .table td{
            vertical-align:middle;
        }

        tr[onclick]{
            cursor:pointer;
            transition:.2s;
        }

        tr[onclick]:hover{
            background:#eff6ff !important;
        }

        /* BADGE */

        .badge{
            padding:8px 12px;
            border-radius:999px;
            font-weight:600;
        }

        /* MOBILE */

        @media(max-width:992px){

            .sidebar{
                width:85px;
            }

            .brand,
            .sub,
            .menu-label{
                display:none;
            }

            .menu-item{
                justify-content:center;
            }

            .menu-item span{
                display:none;
            }

            .main-wrap{
                margin-left:85px;
            }

            .nav-dot{
                right:8px;
            }
        }

        @media(max-width:768px){

            .topbar{
                padding:15px;
            }

            .page-content{
                padding:15px;
            }

            .topbar-title{
                font-size:18px;
            }

            .topbar-sub{
                display:none;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">

    <div class="sidebar-logo">
        <div class="brand">SAYAARARENT</div>
        <div class="sub">Admin Panel</div>
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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>
    </div>

</div>

<div class="main-wrap">

    <div class="topbar">

        <div>
            <div class="topbar-title">
                @yield('page-title', 'Dashboard Admin')
            </div>

            <div class="topbar-sub">
                @yield('page-sub', 'Monitoring rental dan pembayaran')
            </div>
        </div>

        <div class="topbar-right">

            <div class="text-end">
                <div class="fw-semibold">
                    {{ auth()->user()->name ?? 'Admin' }}
                </div>

                <small class="text-muted">
                    Super Admin
                </small>
            </div>

            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}
            </div>

        </div>

    </div>

    <div class="page-content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>