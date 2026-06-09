@extends('layouts.admin')

@push('styles')
<style>
.rental-page .page-header h4 { font-size: 22px; font-weight: 600; color: #1a3a6e; margin-bottom: 4px; }
.rental-page .page-header p  { font-size: 13px; color: #6c757d; margin: 0; }

.filter-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 1.25rem; }
.filter-pill {
    padding: 5px 16px; border-radius: 20px; border: 1px solid #dee2e6;
    font-size: 12px; font-weight: 500; text-decoration: none;
    color: #6c757d; background: #fff; transition: all 0.15s;
}
.filter-pill:hover { border-color: #1a3a6e; color: #1a3a6e; text-decoration: none; }
.filter-pill.active { background: #1a3a6e; color: #fff; border-color: #1a3a6e; }

.section-label {
    font-size: 11px; font-weight: 600; color: #9ca3af;
    letter-spacing: 0.07em; text-transform: uppercase; margin-bottom: 12px;
}

.rental-card-list { display: flex; flex-direction: column; gap: 12px; }

.rental-card {
    background: #fff; border-radius: 12px; border: 1px solid #e9ecef;
    overflow: hidden; display: flex; transition: box-shadow 0.15s, border-color 0.15s;
}
.rental-card:hover { box-shadow: 0 4px 16px rgba(26,58,110,0.08); border-color: #c5d3e8; }

.car-thumb {
    width: 150px; min-height: 120px; background: #eef1f7;
    flex-shrink: 0; display: flex; align-items: center;
    justify-content: center; position: relative; overflow: hidden;
}
.car-thumb img { width: 100%; height: 100%; object-fit: cover; }
.thumb-placeholder { display: flex; flex-direction: column; align-items: center; gap: 6px; color: #a0aec0; }
.plate-badge {
    position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%);
    background: #fff; border: 1px solid #d1d5db; border-radius: 4px;
    font-size: 10px; font-weight: 600; padding: 2px 8px;
    color: #374151; white-space: nowrap; letter-spacing: 0.04em;
}

.rental-card-body {
    flex: 1; padding: 14px 18px;
    display: flex; flex-direction: column; gap: 9px; min-width: 0;
}
.card-top-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; }
.rental-id-tag { font-size: 11px; color: #9ca3af; font-weight: 500; margin-bottom: 2px; }
.car-name { font-size: 14px; font-weight: 600; color: #1a3a6e; }

.status-badge { font-size: 11px; font-weight: 600; padding: 3px 11px; border-radius: 12px; white-space: nowrap; flex-shrink: 0; }
.badge-pending_verification { background: #fef3c7; color: #92400e; }
.badge-waiting_payment      { background: #d1fae5; color: #065f46; }
.badge-active               { background: #dcfce7; color: #166534; }
.badge-completed            { background: #dbeafe; color: #1e40af; }
.badge-rejected             { background: #fee2e2; color: #991b1b; }
.badge-cancelled            { background: #f3f4f6; color: #6b7280; }

.customer-row { display: flex; align-items: center; gap: 7px; }
.customer-avatar {
    width: 22px; height: 22px; border-radius: 50%; background: #dbeafe;
    display: flex; align-items: center; justify-content: center;
    font-size: 9px; font-weight: 700; color: #1e40af; flex-shrink: 0;
}
.customer-name { font-size: 12px; color: #6b7280; }

.date-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #6b7280; }

.card-footer-row {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 10px; border-top: 1px solid #f3f4f6; margin-top: auto;
}
.doc-group { display: flex; gap: 6px; }
.doc-btn {
    font-size: 11px; padding: 4px 11px; border-radius: 6px;
    border: 1px solid #d1d5db; background: #f9fafb; color: #374151;
    text-decoration: none; display: inline-flex; align-items: center;
    gap: 4px; font-weight: 500; transition: all 0.15s;
}
.doc-btn:hover { background: #e5e7eb; text-decoration: none; color: #111827; }

.action-group { display: flex; gap: 6px; align-items: center; }
.btn-approve-sm {
    font-size: 12px; padding: 5px 14px; border-radius: 7px;
    border: none; background: #1a3a6e; color: #fff; cursor: pointer; font-weight: 600;
}
.btn-approve-sm:hover { background: #14306b; }
.btn-reject-sm {
    font-size: 12px; padding: 5px 14px; border-radius: 7px;
    border: 1px solid #fca5a5; background: #fee2e2; color: #991b1b;
    cursor: pointer; font-weight: 600;
}
.btn-done-sm {
    font-size: 12px; padding: 5px 14px; border-radius: 7px;
    border: none; background: #1e40af; color: #fff; cursor: pointer; font-weight: 600;
}
.btn-reset-sm {
    font-size: 12px; padding: 5px 14px; border-radius: 7px;
    border: none; background: #6b7280; color: #fff; cursor: pointer; font-weight: 600;
}
.btn-reset-sm:hover { background: #4b5563; }

.empty-state {
    text-align: center; padding: 3rem 1rem; background: #fff;
    border-radius: 12px; border: 1px solid #e9ecef; color: #9ca3af;
}
</style>
@endpush

@section('content')

@php
$statusLabels = [
    'semua'                => 'Semua',
    'pending_verification' => 'Pending Verification',
    'waiting_payment'      => 'Waiting Payment',
    'active'               => 'Active',
    'completed'            => 'Completed',
    'rejected'             => 'Rejected',
    'cancelled'            => 'Cancelled',
];
@endphp

<div class="rental-page">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Verifikasi Rental</h4>
            <p>Monitoring rental dan pembayaran</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="filter-pills">
        @foreach($statusLabels as $s => $label)
            <a href="?status={{ $s }}"
               class="filter-pill {{ request('status', 'semua') === $s ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="section-label">Daftar Rental</div>

    <div class="rental-card-list">
        @forelse($rentals as $r)
            @php
                $kendaraan   = $r->detailRental->kendaraan ?? null;
                $namaInitial = strtoupper(substr($r->user->name ?? 'U', 0, 2));
                $statusClass = 'badge-' . $r->status;
                $statusLabel = $statusLabels[$r->status] ?? ucfirst($r->status);
                $platNomor   = $kendaraan->plat_nomor ?? null;
                $fotoUrl     = $kendaraan?->gambar ? asset('storage/' . $kendaraan->gambar) : null;
            @endphp

            <div class="rental-card">
                <div class="car-thumb">
                    @if($fotoUrl)
                        <img src="{{ $fotoUrl }}" alt="{{ $kendaraan->nama_mobil ?? 'Kendaraan' }}">
                    @else
                        <div class="thumb-placeholder">
                            <svg width="56" height="34" viewBox="0 0 64 36" fill="none">
                                <rect x="3" y="13" width="58" height="16" rx="3" fill="#9ca3af"/>
                                <rect x="9" y="7" width="42" height="14" rx="2" fill="#6b7280"/>
                                <rect x="13" y="9" width="16" height="9" rx="1.5" fill="#d1d5db"/>
                                <rect x="32" y="9" width="16" height="9" rx="1.5" fill="#d1d5db"/>
                                <circle cx="14" cy="29" r="6" fill="#4b5563"/>
                                <circle cx="14" cy="29" r="3" fill="#9ca3af"/>
                                <circle cx="50" cy="29" r="6" fill="#4b5563"/>
                                <circle cx="50" cy="29" r="3" fill="#9ca3af"/>
                            </svg>
                        </div>
                    @endif
                    @if($platNomor)
                        <span class="plate-badge">{{ $platNomor }}</span>
                    @endif
                </div>

                <div class="rental-card-body">
                    <div class="card-top-row">
                        <div>
                            <div class="rental-id-tag">#{{ $r->id }}</div>
                            <div class="car-name">{{ $kendaraan->nama_mobil ?? '-' }}</div>
                        </div>
                        <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="customer-row">
                        <div class="customer-avatar">{{ $namaInitial }}</div>
                        <span class="customer-name">{{ $r->user->name ?? '-' }}</span>
                    </div>

                    <div class="date-row">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($r->tanggal_mulai)->format('d M Y') }}
                        <span style="color:#d1d5db;">→</span>
                        {{ \Carbon\Carbon::parse($r->tanggal_selesai)->format('d M Y') }}
                    </div>

                    <div class="card-footer-row">
                        <div class="doc-group">
                            <a href="{{ asset('storage/' . $r->upload_ktp) }}" target="_blank" class="doc-btn">
                                📄 KTP
                            </a>
                            <a href="{{ asset('storage/' . $r->upload_sim) }}" target="_blank" class="doc-btn">
                                🪪 SIM
                            </a>
                        </div>

                        <div class="action-group">
                            @if($r->status === 'pending_verification')
                                <form action="{{ route('admin.rental.verify', $r->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-approve-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.rental.reject', $r->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-reject-sm">Reject</button>
                                </form>

                            @elseif($r->status === 'active')
                                <form action="{{ route('admin.rental.complete', $r->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-done-sm">Selesai</button>
                                </form>

                            @elseif(in_array($r->status, ['completed', 'rejected', 'cancelled']))
                                <form action="{{ route('admin.rental.reset-status', $r->id) }}" method="POST" class="d-inline d-flex align-items-center gap-2">
                                    @csrf @method('PATCH')
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto" style="font-size:11px; border-radius:6px;">
                                        <option value="pending_verification">Pending Verification</option>
                                        <option value="waiting_payment">Waiting Payment</option>
                                        <option value="active">Active</option>
                                    </select>
                                    <button type="submit" class="btn-reset-sm">Reset</button>
                                </form>

                            @else
                                <span style="font-size:12px;color:#d1d5db;">—</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p style="font-size:14px; margin:0;">Tidak ada data rental</p>
            </div>
        @endforelse
    </div>
</div>

@endsection