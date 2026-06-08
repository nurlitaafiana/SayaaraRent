@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:#1a3a6e;">Riwayat Pembayaran</h4>
        <p class="text-muted mb-0" style="font-size:14px;">Semua transaksi & verifikasi pembayaran</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Filter Status --}}
<div class="d-flex gap-2 mb-3">
    @foreach(['semua','pending','verified','rejected'] as $s)
    <a href="?status={{ $s }}"
       class="btn btn-sm {{ request('status', 'semua') === $s ? 'btn-primary' : 'btn-outline-secondary' }}">
        {{ ucfirst($s) }}
    </a>
    @endforeach
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0" style="font-size:14px;">
            <thead style="background:#1a3a6e; color:white;">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Rental ID</th>
                    <th class="p-3">Jumlah</th>
                    <th class="p-3">Bukti</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $filtered = request('status', 'semua') === 'semua'
                        ? $payments
                        : $payments->where('status_pembayaran', request('status'));
                @endphp

                @forelse($filtered as $payment)
                <tr>
                    <td class="p-3">#{{ $payment->id }}</td>
                    <td class="p-3">{{ $payment->rental->user->name ?? '-' }}</td>
                    <td class="p-3">#{{ $payment->rental_id }}</td>
                    <td class="p-3">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}"
                           target="_blank" class="btn btn-outline-info btn-sm">
                            Lihat Bukti
                        </a>
                    </td>
                    <td class="p-3">
                        @php
                            $badgeColor = match($payment->status_pembayaran) {
                                'pending'  => 'warning text-dark',
                                'verified' => 'success',
                                'rejected' => 'danger',
                                default    => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ ucfirst($payment->status_pembayaran) }}</span>
                    </td>
                    <td class="p-3">
                        @if($payment->status_pembayaran === 'pending')
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.pembayaran.verify', $payment->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-success btn-sm">Verifikasi</button>
                                </form>
                                <form action="{{ route('admin.pembayaran.reject', $payment->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-muted" style="font-size:12px;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted p-4">Tidak ada data pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection