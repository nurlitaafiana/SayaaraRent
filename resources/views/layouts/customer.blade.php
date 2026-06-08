<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SayaaraRent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4fa;
            color: #0d1b2a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* LAYOUT */
        .app-shell {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            flex-shrink: 0;
            background: #fff;
            border-right: 0.5px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sb-brand {
            padding: 22px 20px 16px;
            border-bottom: 0.5px solid #f0f4fa;
            text-decoration: none;
            display: block;
        }
        .sb-brand-name {
            font-family: 'Sora', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: #0d1b2a;
            letter-spacing: 2px;
        }
        .sb-brand-name span { color: #0ea5e9; }
        .sb-brand-sub {
            font-size: 7px;
            letter-spacing: 2px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .sb-user {
            padding: 14px 20px 12px;
            border-bottom: 0.5px solid #f0f4fa;
        }
        .sb-user-label {
            font-size: 9px;
            font-weight: 600;
            color: #94a3b8;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        .sb-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #0d1b2a;
        }

        .sb-nav {
            padding: 12px;
            flex: 1;
        }
        .sb-nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 11px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            margin-bottom: 2px;
            transition: all 0.15s;
        }
        .sb-nav-item i { font-size: 15px; flex-shrink: 0; }
        .sb-nav-item:hover { background: #f5fbff; color: #0ea5e9; }
        .sb-nav-item.active {
            background: #eef7ff;
            color: #0ea5e9;
            font-weight: 600;
        }

        .sb-footer {
            padding: 12px;
            border-top: 0.5px solid #f0f4fa;
        }
        .btn-logout-sb {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 100%;
            padding: 9px 11px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #ef4444;
            border: 0.5px solid rgba(239,68,68,0.2);
            background: rgba(239,68,68,0.04);
            cursor: pointer;
            transition: all 0.15s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-logout-sb:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
        .btn-logout-sb i { font-size: 15px; }

        /* MAIN AREA */
        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .page-content {
            flex: 1;
            padding: 28px 32px;
            max-width: 1100px;
            width: 100%;
            min-height: calc(100vh - 66px);
        }

        /* FLASH MESSAGE */
        .flash-wrapper {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 360px;
        }
        .flash-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            animation: slideIn 0.3s ease;
        }
        .flash-success { background: #fff; border-left: 4px solid #10b981; }
        .flash-error   { background: #fff; border-left: 4px solid #ef4444; }
        .flash-warning { background: #fff; border-left: 4px solid #f59e0b; }
        .flash-icon { font-size: 18px; margin-top: 1px; flex-shrink: 0; }
        .flash-success .flash-icon { color: #10b981; }
        .flash-error   .flash-icon { color: #ef4444; }
        .flash-warning .flash-icon { color: #f59e0b; }
        .flash-body { flex: 1; }
        .flash-title { font-size: 13px; font-weight: 700; color: #0d1b2a; margin-bottom: 2px; }
        .flash-msg   { font-size: 12px; color: #64748b; line-height: 1.4; }
        .flash-close {
            background: none; border: none; color: #b0c4d8;
            cursor: pointer; font-size: 14px; padding: 0; flex-shrink: 0;
        }
        .flash-close:hover { color: #64748b; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(20px); }
        }
        .flash-item.hiding { animation: slideOut 0.3s ease forwards; }

        /* FOOTER */
        .footer-custom {
            background: #0d1b2a;
            padding: 36px 32px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 36px;
            padding-bottom: 28px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .footer-brand .brand-name {
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #fff;
        }
        .footer-brand .brand-name span { color: #38bdf8; }
        .footer-brand .brand-sub {
            font-size: 7px; letter-spacing: 2px;
            color: #4a6a85; margin-top: 2px; margin-bottom: 12px;
        }
        .footer-brand .brand-desc {
            font-size: 12px; color: #4a6a85; line-height: 1.7; margin-bottom: 12px;
        }
        .footer-address {
            display: flex; align-items: flex-start; gap: 8px;
            font-size: 12px; color: #4a6a85; line-height: 1.6;
        }
        .footer-address i { color: #38bdf8; margin-top: 2px; flex-shrink: 0; }
        .footer-col-title {
            font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
            color: #fff; margin-bottom: 14px; display: block;
        }
        .footer-col-links { display: flex; flex-direction: column; gap: 9px; }
        .footer-col-links a {
            font-size: 12px; color: #7a9bb5; text-decoration: none;
            transition: color 0.2s; cursor: pointer; display: block;
        }
        .footer-col-links a:hover { color: #38bdf8; }
        .footer-bottom {
            padding-top: 18px; display: flex; align-items: center;
            justify-content: space-between; flex-wrap: wrap; gap: 12px;
        }
        .footer-copy { font-size: 12px; color: #4a6a85; }

        /* MODAL */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.55); z-index: 10000;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: #fff; border-radius: 16px; padding: 32px;
            max-width: 480px; width: 90%; position: relative;
            animation: modalIn 0.25s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-close-btn {
            position: absolute; top: 16px; right: 16px;
            background: #f0f4fa; border: none; border-radius: 8px;
            width: 32px; height: 32px; display: flex;
            align-items: center; justify-content: center;
            cursor: pointer; color: #64748b; transition: all 0.2s;
        }
        .modal-close-btn:hover { background: #e2e8f0; color: #0d1b2a; }
        .modal-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 16px;
        }
        .modal-title { font-size: 17px; font-weight: 700; color: #0d1b2a; margin-bottom: 8px; }
        .modal-body-text { font-size: 13.5px; color: #64748b; line-height: 1.7; }

        /* MOBILE SIDEBAR TOGGLE */
        .sb-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 200;
            background: #0ea5e9;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 44px; height: 44px;
            font-size: 20px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(14,165,233,0.4);
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .sidebar {
                position: fixed;
                left: -230px;
                top: 0;
                transition: left 0.25s ease;
            }
            .sidebar.open { left: 0; }
            .sb-toggle { display: flex; }
            .page-content { padding: 20px 16px; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 24px; }
        }
        @media (max-width: 500px) {
            .footer-top { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="app-shell">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">
        <a href="/customer/dashboard" class="sb-brand">
            <div class="sb-brand-name">SAYAARA<span>RENT</span></div>
            <div class="sb-brand-sub">PREMIUM CAR RENTALS</div>
        </a>

        <div class="sb-user">
            <div class="sb-user-label">SELAMAT DATANG</div>
            <div class="sb-user-name">{{ auth()->user()->name }}</div>
        </div>

        <nav class="sb-nav">
            <a href="/customer/dashboard"
               class="sb-nav-item {{ request()->is('customer/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('customer.kendaraan.index') }}"
               class="sb-nav-item {{ request()->is('customer/kendaraan*') ? 'active' : '' }}">
                <i class="bi bi-car-front"></i> Armada Kami
            </a>
            <a href="{{ route('customer.rental.index') }}"
               class="sb-nav-item {{ request()->is('customer/rental') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Rental Saya
            </a>
            <a href="{{ route('customer.rental.history') }}"
               class="sb-nav-item {{ request()->is('customer/riwayat*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
            <a href="{{ route('customer.payment.index') }}"
                class="sb-nav-item {{ request()->is('customer/payment*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card"></i> Pembayaran

            </a>
            <a href="#"
               class="sb-nav-item {{ request()->is('customer/profil*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> Profil Saya
            </a>
        </nav>

        <div class="sb-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout-sb">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN AREA --}}
    <div class="main-area">

        {{-- FLASH MESSAGE --}}
        <div class="flash-wrapper">
            @if(session('success'))
            <div class="flash-item flash-success" id="flash-success">
                <i class="bi bi-check-circle-fill flash-icon"></i>
                <div class="flash-body">
                    <div class="flash-title">Berhasil</div>
                    <div class="flash-msg">{{ session('success') }}</div>
                </div>
                <button class="flash-close" onclick="dismissFlash('flash-success')">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div class="flash-item flash-error" id="flash-error">
                <i class="bi bi-x-circle-fill flash-icon"></i>
                <div class="flash-body">
                    <div class="flash-title">Gagal</div>
                    <div class="flash-msg">{{ session('error') }}</div>
                </div>
                <button class="flash-close" onclick="dismissFlash('flash-error')">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            @endif
            @if(session('warning'))
            <div class="flash-item flash-warning" id="flash-warning">
                <i class="bi bi-exclamation-circle-fill flash-icon"></i>
                <div class="flash-body">
                    <div class="flash-title">Perhatian</div>
                    <div class="flash-msg">{{ session('warning') }}</div>
                </div>
                <button class="flash-close" onclick="dismissFlash('flash-warning')">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            @endif
        </div>

        {{-- PAGE CONTENT --}}
        <main class="page-content">
            @yield('content')
        </main>

        </div> {{-- end main-area --}}
</div> {{-- end app-shell --}}

{{-- FOOTER --}}
<footer class="footer-custom">
    <div class="footer-top">
        <div class="footer-brand">
            <div class="brand-name">SAYAARA<span>RENT</span></div>
            <div class="brand-sub">PREMIUM CAR RENTALS</div>
            <div class="brand-desc">
                Layanan rental kendaraan premium dengan armada terlengkap dan pelayanan terbaik untuk perjalananmu.
            </div>
            <div class="footer-address">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Permata Regency 1 Blok 10 No 24</span>
            </div>
        </div>
        <div>
            <span class="footer-col-title">PERUSAHAAN</span>
            <div class="footer-col-links">
                <a href="#" onclick="openModal('modal-tentang'); return false;">Tentang Kami</a>
                <a href="#" onclick="openModal('modal-sk'); return false;">Syarat & Ketentuan</a>
                <a href="#" onclick="openModal('modal-kontak'); return false;">Hubungi Kami</a>
            </div>
        </div>
        <div>
            <span class="footer-col-title">LAYANAN</span>
            <div class="footer-col-links">
                <a href="{{ route('customer.kendaraan.index') }}">Cari Kendaraan</a>
                <a href="{{ route('customer.rental.index') }}">Rental Saya</a>
                <a href="{{ route('customer.rental.history') }}">Riwayat Rental</a>
            </div>
        </div>
        <div>
            <span class="footer-col-title">KONTAK</span>
            <div class="footer-col-links">
                <a href="#"><i class="bi bi-telephone me-1"></i> +62 827-6510-5641</a>
                <a href="#"><i class="bi bi-envelope me-1"></i> hello@sayaaraRent.id</a>
                <a href="#"><i class="bi bi-instagram me-1"></i> @sayaaraRent</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-copy">© {{ date('Y') }} SayaaraRent. All rights reserved.</div>
        <div class="footer-copy">Made with <span style="color:#ef4444;">♥</span> in Indonesia</div>
    </div>
</footer>

    </div>
</div>

{{-- MOBILE TOGGLE BUTTON --}}
<button class="sb-toggle" id="sb-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>

{{-- MODALS --}}
<div class="modal-overlay" id="modal-tentang" onclick="closeModalOutside(event, 'modal-tentang')">
    <div class="modal-box">
        <button class="modal-close-btn" onclick="closeModal('modal-tentang')"><i class="bi bi-x"></i></button>
        <div class="modal-icon" style="background:#e0f5ff;">
            <i class="bi bi-building" style="color:#38bdf8;"></i>
        </div>
        <div class="modal-title">Tentang SayaaraRent</div>
        <div class="modal-body-text">
            SayaaraRent adalah layanan rental kendaraan premium yang hadir untuk memenuhi kebutuhan mobilitas Anda.
            Kami menyediakan armada kendaraan berkualitas dengan pengemudi berpengalaman dan layanan 24 jam.
            <br><br>
            Berlokasi di <strong>Permata Regency 1 Blok 10 No 24</strong>, kami siap melayani perjalanan bisnis maupun wisata dengan standar pelayanan terbaik.
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-sk" onclick="closeModalOutside(event, 'modal-sk')">
    <div class="modal-box">
        <button class="modal-close-btn" onclick="closeModal('modal-sk')"><i class="bi bi-x"></i></button>
        <div class="modal-icon" style="background:#f0fdf4;">
            <i class="bi bi-file-earmark-text" style="color:#10b981;"></i>
        </div>
        <div class="modal-title">Syarat & Ketentuan</div>
        <div class="modal-body-text">
            <strong>1. Persyaratan Penyewa</strong><br>
            Penyewa wajib memiliki KTP dan SIM yang masih berlaku.<br><br>
            <strong>2. Pembayaran</strong><br>
            Pembayaran dilakukan setelah rental diverifikasi oleh admin.<br><br>
            <strong>3. Pembatalan</strong><br>
            Pembatalan hanya dapat dilakukan sebelum rental diverifikasi atau sebelum pembayaran dilakukan.<br><br>
            <strong>4. Kerusakan</strong><br>
            Kerusakan kendaraan selama masa sewa menjadi tanggung jawab penyewa.
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-kontak" onclick="closeModalOutside(event, 'modal-kontak')">
    <div class="modal-box">
        <button class="modal-close-btn" onclick="closeModal('modal-kontak')"><i class="bi bi-x"></i></button>
        <div class="modal-icon" style="background:#fff7e0;">
            <i class="bi bi-headset" style="color:#f59e0b;"></i>
        </div>
        <div class="modal-title">Hubungi Kami</div>
        <div class="modal-body-text">
            <div style="display:flex;flex-direction:column;gap:12px;margin-top:4px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="background:#e0f5ff;border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-geo-alt-fill" style="color:#38bdf8;"></i>
                    </div>
                    <span>Permata Regency 1 Blok 10 No 24</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="background:#e0f5ff;border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-telephone-fill" style="color:#38bdf8;"></i>
                    </div>
                    <span>+62 827-6510-5641</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="background:#e0f5ff;border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-envelope-fill" style="color:#38bdf8;"></i>
                    </div>
                    <span>hello@sayaaraRent.id</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="background:#e0f5ff;border-radius:8px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-instagram" style="color:#38bdf8;"></i>
                    </div>
                    <span>@sayaaraRent</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function dismissFlash(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add('hiding');
        setTimeout(() => el.remove(), 300);
    }
    ['flash-success', 'flash-error', 'flash-warning'].forEach(id => {
        setTimeout(() => dismissFlash(id), 4000);
    });

    function openModal(id) { document.getElementById(id).classList.add('show'); }
    function closeModal(id) { document.getElementById(id).classList.remove('show'); }
    function closeModalOutside(e, id) {
        if (e.target === document.getElementById(id)) closeModal(id);
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sb-toggle');
        if (window.innerWidth <= 900 && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });
</script>

@stack('scripts')
</body>
</html>