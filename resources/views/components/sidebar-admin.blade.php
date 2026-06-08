<div class="sidebar">

    <div class="sidebar-logo">
        <div class="brand">SAYAARARENT</div>
        <div class="sub">Admin Panel</div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">Menu</div>

        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('admin.rental.index') }}"
           class="menu-item {{ request()->routeIs('admin.rental.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Rental
            @if(isset($pendingRentalCount) && $pendingRentalCount > 0)
                <span class="nav-dot"></span>
            @endif
        </a>

        <a href="{{ route('admin.pembayaran.index') }}"
           class="menu-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i> Pembayaran
            @if(isset($waitingPaymentCount) && $waitingPaymentCount > 0)
                <span class="nav-dot"></span>
            @endif
        </a>

        <a href="{{ route('admin.kendaraan.index') }}"
           class="menu-item {{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}">
            <i class="bi bi-car-front"></i> Kendaraan
        </a>

        <a href="{{ route('admin.kategori.index') }}"
           class="menu-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Kategori
        </a>
    </nav>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>

</div>