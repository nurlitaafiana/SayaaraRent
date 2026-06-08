@extends('layouts.customer')

@section('content')

<style>
    .db-header-bar {
        background: #fff;
        border: 0.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 26px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    .db-header-bar::before {
        content: '';
        position: absolute;
        right: 0; top: 0; bottom: 0;
        width: 260px;
        background: linear-gradient(135deg, #e8f5fe 0%, #f0faff 100%);
        border-left: 0.5px solid #daeefb;
        border-radius: 0 15px 15px 0;
    }
    .db-header-deco {
        position: absolute;
        right: 32px; top: 50%;
        transform: translateY(-50%);
        font-size: 68px;
        color: #bde5f8;
        opacity: 0.45;
    }
    .db-header-left { position: relative; z-index: 1; }
    .db-header-right { position: relative; z-index: 1; }
    .db-greet-label {
        font-size: 11px; font-weight: 600;
        color: #0ea5e9; letter-spacing: 1.5px; margin-bottom: 5px;
    }
    .db-greet-name {
        font-size: 22px; font-weight: 700;
        color: #0d1b2a; margin: 0 0 5px;
    }
    .db-greet-sub { font-size: 13px; color: #7a9bb5; margin: 0; }
    .db-cta {
        background: #0ea5e9; color: #fff !important;
        border: none; border-radius: 9px;
        padding: 10px 20px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none; transition: background 0.18s;
    }
    .db-cta:hover { background: #0284c7; }

    .db-stat {
        background: #fff; border-radius: 12px;
        padding: 18px 20px; border: 0.5px solid #e2e8f0;
        display: flex; align-items: center; gap: 14px; height: 100%;
    }
    .db-stat-icon {
        width: 44px; height: 44px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 20px;
    }
    .db-stat-label {
        font-size: 10px; color: #8a9bb5; font-weight: 600;
        letter-spacing: 0.7px; margin-bottom: 3px; text-transform: uppercase;
    }
    .db-stat-val {
        font-size: 26px; font-weight: 700;
        color: #0d1b2a; line-height: 1;
    }

    .db-section-title {
        font-size: 13px; font-weight: 600; color: #0d1b2a;
        margin-bottom: 14px; display: flex; align-items: center; gap: 7px;
    }
    .db-section-title i { font-size: 15px; color: #0ea5e9; }

    .kat-card {
        background: #fff; border-radius: 12px;
        border: 0.5px solid #e2e8f0; padding: 16px 12px;
        text-align: center; text-decoration: none; display: block;
        transition: all 0.18s; height: 100%;
    }
    .kat-card:hover {
        border-color: #38bdf8; background: #f5fbff;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(56,189,248,0.1);
    }
    .kat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: #e9f5fe; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 10px;
        font-size: 18px; color: #0ea5e9; transition: all 0.18s;
    }
    .kat-card:hover .kat-icon { background: #0ea5e9; color: #fff; }
    .kat-name { font-size: 13px; font-weight: 600; color: #1e3a52; margin-bottom: 3px; }
    .kat-count { font-size: 11px; color: #8a9bb5; }

    .akses-card {
        background: #fff; border-radius: 12px;
        border: 0.5px solid #e2e8f0; padding: 14px 16px;
        display: flex; align-items: center; gap: 12px;
        text-decoration: none; transition: all 0.18s;
    }
    .akses-card:hover { border-color: #38bdf8; background: #f5fbff; }
    .akses-icon {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 16px;
    }
    .akses-label { font-size: 13px; font-weight: 600; color: #1e3a52; }
    .akses-sub { font-size: 11px; color: #8a9bb5; margin-top: 1px; }
    .akses-arrow { margin-left: auto; color: #c5d0e0; font-size: 14px; flex-shrink: 0; }
    .akses-card:hover .akses-arrow { color: #0ea5e9; }

    .rental-card {
        background: #fff; border-radius: 14px;
        border: 0.5px solid #e2e8f0; padding: 20px;
    }
    .rental-card-title {
        font-size: 13px; font-weight: 600; color: #0d1b2a;
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 14px;
    }
    .rental-card-title span { display: flex; align-items: center; gap: 7px; }
    .rental-card-title i { font-size: 15px; color: #0ea5e9; }
    .rental-view-all {
        font-size: 12px; color: #0ea5e9; font-weight: 500;
        text-decoration: none; display: flex; align-items: center; gap: 3px;
    }
    .rental-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 11px 0; border-bottom: 0.5px solid #f0f4fa;
    }
    .rental-row:last-child { border-bottom: none; }
    .rental-nama { font-size: 13px; font-weight: 600; color: #1e3a52; }
    .rental-tgl {
        font-size: 11px; color: #8a9bb5; margin-top: 2px;
        display: flex; align-items: center; gap: 4px;
    }
    .rental-harga { font-size: 13px; font-weight: 600; color: #0d1b2a; }
    .badge-status {
        font-size: 10px; font-weight: 600; padding: 3px 9px;
        border-radius: 20px; display: inline-block; margin-top: 3px;
    }
    .badge-active    { background: #e8f5ee; color: #16713e; }
    .badge-cancelled { background: #fdecea; color: #a33030; }
    .badge-pending   { background: #fff8e6; color: #9a5f00; }
    .badge-waiting   { background: #e8f1ff; color: #1d4ed8; }
    .badge-completed { background: #f0fdf4; color: #166534; }
</style>

{{-- HEADER BANNER --}}
<div class="db-header-bar mb-4">
    <div class="db-header-left">
        <div class="db-greet-label">SAYAARARENT</div>
        <div class="db-greet-name">Selamat datang, {{ auth()->user()->name }}</div>
        <p class="db-greet-sub">Temukan kendaraan terbaik untuk perjalanan Anda hari ini.</p>
    </div>
    <i class="bi bi-car-front db-header-deco"></i>
    <div class="db-header-right">
        <a href="{{ route('customer.kendaraan.index') }}" class="db-cta">
            <i class="bi bi-search"></i> Cari Kendaraan
        </a>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="db-stat">
            <div class="db-stat-icon" style="background:#eef3ff;">
                <i class="bi bi-file-earmark-text" style="color:#3b6be8;"></i>
            </div>
            <div>
                <div class="db-stat-label">Total Rental</div>
                <div class="db-stat-val">{{ $totalRental }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="db-stat">
            <div class="db-stat-icon" style="background:#e8f5ee;">
                <i class="bi bi-check-circle" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="db-stat-label">Rental Aktif</div>
                <div class="db-stat-val">{{ $activeRental }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="db-stat">
            <div class="db-stat-icon" style="background:#fff8e6;">
                <i class="bi bi-clock" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="db-stat-label">Menunggu Bayar</div>
                <div class="db-stat-val">{{ $pendingPayment }}</div>
            </div>
        </div>
    </div>
</div>

{{-- KATEGORI + AKSES CEPAT --}}
<div class="row g-3 mb-4">
    <div class="col-md-7">
        <div class="db-section-title">
            <i class="bi bi-grid-fill"></i> Kategori Kendaraan
        </div>
        <div class="row g-2">
            @forelse($kategoris as $kategori)
            <div class="col-6 col-md-4">
                <a href="{{ route('customer.kendaraan.index') }}?kategori={{ $kategori->id }}" class="kat-card">
                    <div class="kat-icon">
                        @php $nama = strtolower($kategori->nama_kategori); @endphp
                        @if(str_contains($nama, 'luxury'))
                            <i class="bi bi-star"></i>
                        @elseif(str_contains($nama, 'bus'))
                            <i class="bi bi-bus-front"></i>
                        @elseif(str_contains($nama, 'suv'))
                            <i class="bi bi-truck"></i>
                        @else
                            <i class="bi bi-car-front"></i>
                        @endif
                    </div>
                    <div class="kat-name">{{ $kategori->nama_kategori }}</div>
                    <div class="kat-count">{{ $kategori->kendaraans->count() }} tersedia</div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <p class="text-muted small">Belum ada kategori.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="col-md-5">
        <div class="db-section-title">
            <i class="bi bi-lightning-fill"></i> Akses Cepat
        </div>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('customer.kendaraan.index') }}" class="akses-card">
                <div class="akses-icon" style="background:#e8f5ee;">
                    <i class="bi bi-calendar-plus" style="color:#16a34a;"></i>
                </div>
                <div>
                    <div class="akses-label">Booking Baru</div>
                    <div class="akses-sub">Buat pemesanan kendaraan baru</div>
                </div>
                <i class="bi bi-chevron-right akses-arrow"></i>
            </a>
            <a href="{{ route('customer.rental.index') }}" class="akses-card">
                <div class="akses-icon" style="background:#fff8e6;">
                    <i class="bi bi-credit-card" style="color:#d97706;"></i>
                </div>
                <div>
                    <div class="akses-label">Status Pembayaran</div>
                    <div class="akses-sub">Cek tagihan & konfirmasi bayar</div>
                </div>
                <i class="bi bi-chevron-right akses-arrow"></i>
            </a>
            <a href="#" onclick="openModal('modal-kontak'); return false;" class="akses-card">
                <div class="akses-icon" style="background:#fdecea;">
                    <i class="bi bi-headset" style="color:#dc2626;"></i>
                </div>
                <div>
                    <div class="akses-label">Hubungi Admin</div>
                    <div class="akses-sub">Butuh bantuan? Kami siap membantu</div>
                </div>
                <i class="bi bi-chevron-right akses-arrow"></i>
            </a>
        </div>
    </div>
</div>

{{-- RENTAL TERAKHIR --}}
@if(isset($recentRentals) && $recentRentals->count() > 0)
<div class="rental-card">
    <div class="rental-card-title">
        <span><i class="bi bi-receipt"></i> Rental Terakhir</span>
        <a href="{{ route('customer.rental.index') }}" class="rental-view-all">
            Lihat semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    @foreach($recentRentals->take(3) as $rental)
    <div class="rental-row">
        <div>
            <div class="rental-nama">
                {{ $rental->detailRental->kendaraan->nama_mobil ?? '-' }}
            </div>
            <div class="rental-tgl">
                <i class="bi bi-calendar3" style="font-size:10px;"></i>
                {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}
                → {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
            </div>
        </div>
        <div style="text-align:right;">
            <div class="rental-harga">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</div>
            @if($rental->status == 'active')
                <span class="badge-status badge-active">Aktif</span>
            @elseif($rental->status == 'cancelled')
                <span class="badge-status badge-cancelled">Dibatalkan</span>
            @elseif($rental->status == 'waiting_payment')
                <span class="badge-status badge-waiting">Menunggu Bayar</span>
            @elseif($rental->status == 'completed')
                <span class="badge-status badge-completed">Selesai</span>
            @else
                <span class="badge-status badge-pending">{{ ucfirst($rental->status) }}</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection