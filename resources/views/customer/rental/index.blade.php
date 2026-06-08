@extends('layouts.customer')

@section('content')

<style>
    .page-header {
        background: #fff;
        border: 0.5px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .page-header::after {
        content: '';
        position: absolute;
        right: 0; top: 0; bottom: 0;
        width: 200px;
        background: linear-gradient(135deg, #e8f5fe, #f0faff);
        border-left: 0.5px solid #daeefb;
        border-radius: 0 15px 15px 0;
        z-index: 0;
    }
    .page-header-deco {
        position: absolute;
        right: 28px; top: 50%;
        transform: translateY(-50%);
        font-size: 56px;
        color: #bde5f8;
        opacity: 0.4;
        z-index: 1;
    }
    .page-header-left { position: relative; z-index: 2; }
    .page-header-label {
        font-size: 11px; font-weight: 600;
        color: #0ea5e9; letter-spacing: 1.5px; margin-bottom: 4px;
    }
    .page-header-title {
        font-size: 20px; font-weight: 700;
        color: #0d1b2a; margin: 0 0 3px;
    }
    .page-header-sub { font-size: 13px; color: #7a9bb5; margin: 0; }
    .page-header-right { position: relative; z-index: 2; }

    .btn-booking-new {
        background: #0ea5e9; color: #fff;
        border: none; border-radius: 9px;
        padding: 10px 18px; font-size: 13px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 7px;
        text-decoration: none; transition: background 0.18s;
        white-space: nowrap;
    }
    .btn-booking-new:hover { background: #0284c7; color: #fff; }

    .rental-table-wrap {
        background: #fff;
        border-radius: 14px;
        border: 0.5px solid #e2e8f0;
        overflow: hidden;
    }

    .rental-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .rental-table thead tr {
        background: #f8faff;
        border-bottom: 0.5px solid #e2e8f0;
    }

    .rental-table thead th {
        padding: 12px 16px;
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 1px;
        text-transform: uppercase;
        white-space: nowrap;
        border: none;
    }

    .rental-table tbody tr {
        border-bottom: 0.5px solid #f0f4fa;
        transition: background 0.15s;
    }
    .rental-table tbody tr:last-child { border-bottom: none; }
    .rental-table tbody tr:hover { background: #f8fbff; }

    .rental-table tbody td {
        padding: 14px 16px;
        color: #0d1b2a;
        vertical-align: middle;
        border: none;
    }

    .rental-kode {
        font-size: 12px; font-weight: 700;
        color: #94a3b8; font-family: monospace;
    }

    .rental-kendaraan { font-weight: 600; color: #0d1b2a; }
    .rental-tgl { color: #64748b; font-size: 12px; }
    .rental-harga { font-weight: 700; color: #0d1b2a; }

    .badge-status {
        font-size: 10px; font-weight: 600;
        padding: 4px 10px; border-radius: 20px;
        display: inline-block; white-space: nowrap;
    }
    .badge-pending   { background: #fff8e6; color: #9a5f00; }
    .badge-waiting   { background: #e8f1ff; color: #1d4ed8; }
    .badge-active    { background: #e8f5ee; color: #16713e; }
    .badge-completed { background: #f0fdf4; color: #166534; }
    .badge-rejected  { background: #fdecea; color: #a33030; }
    .badge-cancelled { background: #f1f5f9; color: #64748b; }

    .btn-detail {
        background: #f0f9ff; color: #0369a1;
        border: 0.5px solid #bae6fd; border-radius: 7px;
        padding: 6px 12px; font-size: 11px; font-weight: 600;
        text-decoration: none; display: inline-flex;
        align-items: center; gap: 4px;
        transition: all 0.15s; white-space: nowrap;
    }
    .btn-detail:hover { background: #0ea5e9; color: #fff; border-color: #0ea5e9; }

    .btn-bayar {
        background: #0ea5e9; color: #fff;
        border: none; border-radius: 7px;
        padding: 6px 12px; font-size: 11px; font-weight: 600;
        text-decoration: none; display: inline-flex;
        align-items: center; gap: 4px;
        transition: background 0.15s; white-space: nowrap;
    }
    .btn-bayar:hover { background: #0284c7; color: #fff; }

    .btn-batal {
        background: #fdecea; color: #dc2626;
        border: 0.5px solid #fecaca; border-radius: 7px;
        padding: 6px 12px; font-size: 11px; font-weight: 600;
        cursor: pointer; display: inline-flex;
        align-items: center; gap: 4px;
        transition: all 0.15s; white-space: nowrap;
        font-family: inherit;
    }
    .btn-batal:hover { background: #dc2626; color: #fff; border-color: #dc2626; }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
    }
    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        display: block;
        margin-bottom: 12px;
    }
    .empty-state p {
        color: #94a3b8;
        font-size: 14px;
        margin-bottom: 16px;
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header mb-4">
    <div class="page-header-left">
        <div class="page-header-label">RENTAL SAYA</div>
        <div class="page-header-title">Daftar Rental</div>
        <p class="page-header-sub">Kelola dan pantau status rental kendaraan kamu.</p>
    </div>
    <i class="bi bi-file-earmark-text page-header-deco"></i>
    <div class="page-header-right">
        <a href="{{ route('customer.kendaraan.index') }}" class="btn-booking-new">
            <i class="bi bi-plus-lg"></i> Booking Baru
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert border-0 rounded-3 mb-4"
     style="background:#e8f5ee; color:#166534; font-size:13px;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert border-0 rounded-3 mb-4"
     style="background:#fdecea; color:#a33030; font-size:13px;">
    <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
</div>
@endif

<div class="rental-table-wrap">
    @if($rentals->count() > 0)
    <table class="rental-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Kendaraan</th>
                <th>Tanggal Sewa</th>
                <th>Tanggal Kembali</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
            <tr>
                <td><span class="rental-kode">#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                <td><span class="rental-kendaraan">{{ $rental->detailRental->kendaraan->nama_mobil ?? '-' }}</span></td>
                <td><span class="rental-tgl">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }}</span></td>
                <td><span class="rental-tgl">{{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}</span></td>
                <td><span class="rental-harga">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</span></td>
                <td>
                    @switch($rental->status)
                        @case('pending_verification')
                            <span class="badge-status badge-pending">Menunggu Verifikasi</span>
                        @break
                        @case('waiting_payment')
                            <span class="badge-status badge-waiting">Menunggu Pembayaran</span>
                        @break
                        @case('active')
                            <span class="badge-status badge-active">Aktif</span>
                        @break
                        @case('completed')
                            <span class="badge-status badge-completed">Selesai</span>
                        @break
                        @case('rejected')
                            <span class="badge-status badge-rejected">Ditolak</span>
                        @break
                        @case('cancelled')
                            <span class="badge-status badge-cancelled">Dibatalkan</span>
                        @break
                    @endswitch
                </td>
                <td>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
                        @if($rental->status == 'waiting_payment')
                        <a href="{{ route('customer.payment.create', $rental->id) }}" class="btn-bayar">
                            <i class="bi bi-credit-card"></i> Bayar
                        </a>
                        @endif
                        @if(in_array($rental->status, ['pending_verification', 'waiting_payment']))
                        <form action="{{ route('customer.rental.cancel', $rental->id) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Batalkan rental ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-batal">
                                <i class="bi bi-x"></i> Batal
                            </button>
                        </form>
                        @endif
                        @if(in_array($rental->status, ['active', 'completed', 'rejected', 'cancelled']))
                        <span style="font-size:11px; color:#cbd5e1;">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="bi bi-file-earmark-text"></i>
        <p>Kamu belum memiliki rental apapun.</p>
        <a href="{{ route('customer.kendaraan.index') }}" class="btn-booking-new">
            <i class="bi bi-plus-lg"></i> Mulai Booking
        </a>
    </div>
    @endif
</div>

@endsection