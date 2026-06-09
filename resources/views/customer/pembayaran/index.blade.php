@extends('layouts.customer')

@section('content')

<style>
.pembayaran-page .page-header h4 { font-size: 22px; font-weight: 600; color: #1a3a6e; margin-bottom: 4px; }
.pembayaran-page .page-header p  { font-size: 13px; color: #6c757d; margin: 0; }

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

.payment-card-list { display: flex; flex-direction: column; gap: 12px; }

.payment-card {
    background: #fff; border-radius: 12px; border: 1px solid #e9ecef;
    overflow: hidden; display: flex; transition: box-shadow 0.15s, border-color 0.15s;
}
.payment-card:hover { box-shadow: 0 4px 16px rgba(26,58,110,0.08); border-color: #c5d3e8; }

/* Left accent bar */
.payment-accent {
    width: 5px; flex-shrink: 0;
}
.accent-pending  { background: #f59e0b; }
.accent-verified { background: #10b981; }
.accent-rejected { background: #ef4444; }

/* Car thumb */
.car-thumb {
    width: 130px; min-height: 110px; background: #eef1f7;
    flex-shrink: 0; display: flex; align-items: center;
    justify-content: center; position: relative; overflow: hidden;
}
.car-thumb img { width: 100%; height: 100%; object-fit: cover; }
.thumb-placeholder { display: flex; align-items: center; justify-content: center; }
.plate-badge {
    position: absolute; bottom: 7px; left: 50%; transform: translateX(-50%);
    background: #fff; border: 1px solid #d1d5db; border-radius: 4px;
    font-size: 10px; font-weight: 600; padding: 2px 7px;
    color: #374151; white-space: nowrap; letter-spacing: 0.04em;
}

.payment-card-body {
    flex: 1; padding: 14px 18px;
    display: flex; flex-direction: column; gap: 8px; min-width: 0;
}
.card-top-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; }
.payment-id-tag { font-size: 11px; color: #9ca3af; font-weight: 500; margin-bottom: 2px; }
.car-name { font-size: 14px; font-weight: 600; color: #1a3a6e; }

.status-badge { font-size: 11px; font-weight: 600; padding: 3px 11px; border-radius: 12px; white-space: nowrap; flex-shrink: 0; }
.badge-pending  { background: #fef3c7; color: #92400e; }
.badge-verified { background: #dcfce7; color: #166534; }
.badge-rejected { background: #fee2e2; color: #991b1b; }

.customer-row { display: flex; align-items: center; gap: 7px; }
.customer-avatar {
    width: 22px; height: 22px; border-radius: 50%; background: #dbeafe;
    display: flex; align-items: center; justify-content: center;
    font-size: 9px; font-weight: 700; color: #1e40af; flex-shrink: 0;
}
.customer-name { font-size: 12px; color: #6b7280; }

.amount-row { font-size: 15px; font-weight: 700; color: #1a3a6e; }
.rental-ref { font-size: 11px; color: #9ca3af; font-weight: 500; }

.card-footer-row {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 10px; border-top: 1px solid #f3f4f6; margin-top: auto;
}
.doc-group { display: flex; gap: 6px; }
.bukti-btn {
    font-size: 11px; padding: 4px 11px; border-radius: 6px;
    border: 1px solid #d1d5db; background: #f9fafb; color: #374151;
    text-decoration: none; display: inline-flex; align-items: center;
    gap: 4px; font-weight: 500; transition: all 0.15s;
}
.bukti-btn:hover { background: #e5e7eb; text-decoration: none; color: #111827; }

.action-group { display: flex; gap: 6px; }
.btn-verify-sm {
    font-size: 12px; padding: 5px 14px; border-radius: 7px;
    border: none; background: #1a3a6e; color: #fff; cursor: pointer; font-weight: 600;
}
.btn-verify-sm:hover { background: #14306b; }
.btn-tolak-sm {
    font-size: 12px; padding: 5px 14px; border-radius: 7px;
    border: 1px solid #fca5a5; background: #fee2e2; color: #991b1b;
    cursor: pointer; font-weight: 600;
}

.empty-state {
    text-align: center; padding: 3rem 1rem; background: #fff;
    border-radius: 12px; border: 1px solid #e9ecef; color: #9ca3af;
}
</style>

<div class="pembayaran-page">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Riwayat Pembayaran</h4>
            <p>Semua transaksi & verifikasi pembayaran</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="filter-pills">
        @foreach(['semua','pending','verified','rejected'] as $s)
        <a href="?status={{ $s }}"
           class="filter-pill {{ request('status', 'semua') === $s ? 'active' : '' }}">
            {{ ucfirst($s) }}
        </a>
        @endforeach
    </div>

    <div class="section-label">Daftar Pembayaran</div>

    <div class="payment-card-list">
        @php
            $filtered = request('status', 'semua') === 'semua'
                ? $payments
                : $payments->where('status_pembayaran', request('status'));
        @endphp

        @forelse($filtered as $payment)
        @php
            $kendaraan   = $payment->rental->detailRental->kendaraan ?? null;
            $namaInitial = strtoupper(substr($payment->rental->user->name ?? 'U', 0, 2));
            $statusClass = 'badge-' . $payment->status_pembayaran;
            $accentClass = 'accent-' . $payment->status_pembayaran;
            $platNomor   = $kendaraan->plat_nomor ?? null;
            $fotoUrl     = ($kendaraan && $kendaraan->gambar)
                            ? asset('storage/' . $kendaraan->gambar)
                            : null;
        @endphp

        <div class="payment-card">
            <div class="payment-accent {{ $accentClass }}"></div>

            {{-- Car Thumbnail --}}
            <div class="car-thumb">
                @if($fotoUrl)
                    <img src="{{ $fotoUrl }}" alt="{{ $kendaraan->nama_mobil ?? 'Kendaraan' }}">
                @else
                    <div class="thumb-placeholder">
                        <svg width="52" height="32" viewBox="0 0 64 36" fill="none">
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

            {{-- Body --}}
            <div class="payment-card-body">
                <div class="card-top-row">
                    <div>
                        <div class="payment-id-tag">{{ $payment->id }} &nbsp;·&nbsp; <span class="rental-ref">Rental #{{ $payment->rental_id }}</span></div>
                        <div class="car-name">{{ $kendaraan->nama_mobil ?? '-' }}</div>
                    </div>
                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($payment->status_pembayaran) }}</span>
                </div>

                <div class="customer-row">
                    <div class="customer-avatar">{{ $namaInitial }}</div>
                    <span class="customer-name">{{ $payment->rental->user->name ?? '-' }}</span>
                </div>

                <div class="amount-row">
                    Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                </div>

                <div class="card-footer-row">
                    <div class="doc-group">
                        <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}"
                           target="_blank" class="bukti-btn">
                            🧾 Lihat Bukti
                        </a>
                    </div>

                    <div class="action-group">
                        @if($payment->status_pembayaran === 'pending')
                            <span style="font-size:12px; color:#92400e; background:#fef3c7; padding:4px 10px; border-radius:6px; font-weight:600;">
                                ⏳ Menunggu Verifikasi
                            </span>
                        @elseif($payment->status_pembayaran === 'rejected')
                            <span style="font-size:12px; color:#991b1b; background:#fee2e2; padding:4px 10px; border-radius:6px; font-weight:600;">
                                ❌ Ditolak
                            </span>
                        @else
                            <span style="font-size:12px;color:#d1d5db;">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p style="font-size:14px; margin:0;">Tidak ada data pembayaran</p>
        </div>
        @endforelse
    </div>
</div>

@endsection