@extends('layouts.customer')

@section('content')

@php
use Carbon\Carbon;

$activeFilter = request('status', 'all');
$statusList = [
    'all'                  => 'Semua',
    'active'               => 'Aktif',
    'pending_verification' => 'Menunggu Verifikasi',
    'waiting_payment'      => 'Menunggu Pembayaran',
    'completed'            => 'Selesai',
    'cancelled'            => 'Dibatalkan',
    'rejected'             => 'Ditolak',
];
$statusBadge = [
    'pending_verification' => ['bg' => '#fef9c3', 'color' => '#854d0e', 'label' => 'Menunggu Verifikasi'],
    'waiting_payment'      => ['bg' => '#e0f2fe', 'color' => '#075985', 'label' => 'Menunggu Pembayaran'],
    'active'               => ['bg' => '#dcfce7', 'color' => '#166534', 'label' => 'Aktif'],
    'completed'            => ['bg' => '#dbeafe', 'color' => '#1e40af', 'label' => 'Selesai'],
    'rejected'             => ['bg' => '#fee2e2', 'color' => '#991b1b', 'label' => 'Ditolak'],
    'cancelled'            => ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => 'Dibatalkan'],
];
@endphp

{{-- Header --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body d-flex justify-content-between align-items-center py-3 px-4">
        <div>
            <p class="small mb-0 fw-semibold text-uppercase" style="letter-spacing: 0.05em; color: #0ea5e9;">Riwayat Rental</p>
            <h4 class="fw-bold mb-0">Riwayat Rental</h4>
            <p class="text-muted mb-0 small">Lihat semua riwayat penyewaan kendaraan kamu.</p>
        </div>
        <a href="{{ route('customer.kendaraan.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <span>+</span> Booking Baru
        </a>
    </div>
</div>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filter Pills --}}
<div class="d-flex flex-wrap gap-2 mb-3">
    @foreach($statusList as $key => $label)
        @php
            $pillStyle = $activeFilter === $key
                ? 'background:#0ea5e9; color:#fff;'
                : 'background:#f1f5f9; color:#475569;';
        @endphp
        <a href="{{ request()->fullUrlWithQuery(['status' => $key]) }}"
           class="badge rounded-pill px-3 py-2 text-decoration-none"
           style="font-size: 0.8rem; font-weight: 500; cursor: pointer; {{ $pillStyle }}">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Tabel --}}
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    @foreach(['Kode', 'Kendaraan', 'Tanggal Sewa', 'Tanggal Kembali', 'Total Harga', 'Status'] as $col)
                        <th class="px-4 py-3 text-muted small fw-semibold text-uppercase"
                            style="letter-spacing: 0.05em;">{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $rental)
                    @php
                        $badge     = $statusBadge[$rental->status] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => ucfirst($rental->status)];
                        $badgeStyle = 'background:' . $badge['bg'] . '; color:' . $badge['color'] . '; font-weight:500;';
                    @endphp
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td class="px-4 py-3 text-muted small">#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 fw-semibold">{{ $rental->detailRental->kendaraan->nama_mobil ?? '-' }}</td>
                        <td class="px-4 py-3">{{ Carbon::parse($rental->tanggal_mulai)->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">{{ Carbon::parse($rental->tanggal_selesai)->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3 fw-semibold">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span class="badge rounded-pill px-3 py-2" style="{{ $badgeStyle }}">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-5">Tidak ada rental dengan status ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection