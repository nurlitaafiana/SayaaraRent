<nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand text-white fw-bold" href="{{ route('customer.dashboard') }}">
        🚗 SayaaraRent
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('customer.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('customer.kendaraan.index') }}">Kendaraan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('customer.rental.index') }}">Rental Saya</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('customer.rental.history') }}">Riwayat</a>
            </li>
            <li class="nav-item ms-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>