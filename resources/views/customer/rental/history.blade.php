@extends('layouts.customer')

@section('content')

<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body d-flex justify-content-between align-items-center py-3 px-4">
        <div>
            <p class="small mb-0 text-uppercase fw-semibold" style="letter-spacing: 0.05em; color: #0ea5e9;">RIWAYAT RENTAL</p>
            <h4 class="fw-bold mb-0">Riwayat Rental</h4>
            <p class="text-muted mb-0 small">Lihat semua riwayat penyewaan kendaraan kamu.</p>
        </div>
        <a href="{{ route('customer.kendaraan.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <span style="font-size: 1.1rem;">+</span> Booking Baru
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@php
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
@endphp

<div class="d-flex flex-wrap gap-2 mb-3">
    @foreach($statusList as $key => $label)
        <a href="{{ request()->fullUrlWithQuery(['status' => $key]) }}"
           class="badge rounded-pill px-3 py-2 text-decoration-none"
           style="font-size: 0.8rem; font-weight: 500; cursor: pointer;
               {{ $activeFilter === $key ? 'background:#0ea5e9; color:#fff;' : 'background:#f1f5f9; color:#475569;' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <th class="px-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Kode</th>
                    <th class="px-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Kendaraan</th>
                    <th class="px-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Tanggal Sewa</th>
                    <th class="px-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Tanggal Kembali</th>
                    <th class="px-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Total Harga</th>
                    <th class="px-4 py-3 text-muted small fw-semibold text-uppercase" style="letter-spacing: 0.05em;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $rental)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td class="px-4 py-3 text-muted small">#{{ str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3 fw-semibold">{{ $rental->detailRental->kendaraan->nama_mobil ?? '-' }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($rental->tanggal_selesai)->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-3 fw-semibold">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        @switch($rental->status)
                            @case('pending_verification')
                                <span class="badge rounded-pill px-3 py-2" style="background:#fef9c3; color:#854d0e; font-weight:500;">Menunggu Verifikasi</span>
                            @break
                            @case('waiting_payment')
                                <span class="badge rounded-pill px-3 py-2" style="background:#e0f2fe; color:#075985; font-weight:500;">Menunggu Pembayaran</span>
                            @break
                            @case('active')
                                <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#166534; font-weight:500;">Aktif</span>
                            @break
                            @case('completed')
                                <span class="badge rounded-pill px-3 py-2" style="background:#dbeafe; color:#1e40af; font-weight:500;">Selesai</span>
                            @break
                            @case('rejected')
                                <span class="badge rounded-pill px-3 py-2" style="background:#fee2e2; color:#991b1b; font-weight:500;">Ditolak</span>
                            @break
                            @case('cancelled')
                                <span class="badge rounded-pill px-3 py-2" style="background:#f1f5f9; color:#475569; font-weight:500;">Dibatalkan</span>
                            @break
                        @endswitch
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