@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:#1a3a6e;">Riwayat Rental</h4>
        <p class="text-muted mb-0" style="font-size:14px;">Semua data rental & verifikasi</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Filter Status --}}
<div class="d-flex gap-2 mb-3 flex-wrap">
    @foreach(['semua','pending_verification','waiting_payment','active','completed','rejected','cancelled'] as $s)
    <a href="?status={{ $s }}"
       class="btn btn-sm {{ request('status', 'semua') === $s ? 'btn-primary' : 'btn-outline-secondary' }}">
        {{ ucfirst(str_replace('_', ' ', $s)) }}
    </a>
    @endforeach
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0" style="font-size:14px;">
            <thead style="background:#1a3a6e; color:white;">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Customer</th>
                    <th class="p-3">Kendaraan</th>
                    <th class="p-3">Tgl Mulai</th>
                    <th class="p-3">Tgl Selesai</th>
                    <th class="p-3">Dokumen</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $filtered = request('status', 'semua') === 'semua'
                        ? $rentals
                        : $rentals->where('status', request('status'));
                @endphp

                @forelse($filtered as $r)
                <tr>
                    <td class="p-3">#{{ $r->id }}</td>
                    <td class="p-3">{{ $r->user->name ?? '-' }}</td>
                    <td class="p-3">{{ $r->detailRental->kendaraan->nama_mobil ?? '-' }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d M Y') }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($r->tanggal_selesai)->format('d M Y') }}</td>
                    <td class="p-3">
                        <a href="{{ asset('storage/'.$r->upload_ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm">KTP</a>
                        <a href="{{ asset('storage/'.$r->upload_sim) }}" target="_blank" class="btn btn-outline-primary btn-sm">SIM</a>
                    </td>
                    <td class="p-3">
                        @php
                            $badgeColor = match($r->status) {
                                'pending_verification' => 'warning text-dark',
                                'waiting_payment'      => 'info text-dark',
                                'active'               => 'success',
                                'completed'            => 'primary',
                                'rejected'             => 'danger',
                                'cancelled'            => 'secondary',
                                default                => 'light text-dark',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ str_replace('_', ' ', $r->status) }}</span>
                    </td>
                    <td class="p-3">
                        @if($r->status === 'pending_verification')
                            <form action="{{ route('admin.rental.verify', $r->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.rental.reject', $r->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @elseif($r->status === 'active')
                            <form action="{{ route('admin.rental.complete', $r->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary btn-sm">Selesai</button>
                            </form>
                        @else
                            <span class="text-muted" style="font-size:12px;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted p-4">Tidak ada data rental</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection