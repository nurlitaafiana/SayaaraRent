@extends('layouts.admin')

@section('page-title', 'Dashboard Admin')
@section('page-sub', 'Monitoring request rental & pembayaran masuk')

@section('content')

<style>
    /* ── Stat Cards ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 18px;
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #64748b;
    }

    .stat-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .si-blue  { background: #e0f2fe; color: #0369a1; }
    .si-amber { background: #fef3c7; color: #92400e; }
    .si-teal  { background: #ccfbf1; color: #0f766e; }
    .si-green { background: #dcfce7; color: #15803d; }

    .stat-val {
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-change {
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stat-change.up   { color: #16a34a; }
    .stat-change.down { color: #dc2626; }
    .stat-change.warn { color: #d97706; }
    .stat-change.info { color: #0f766e; }

    /* ── Notif Cards ── */
    .notif-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }

    .notif-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }

    .notif-head {
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }

    .notif-head-left {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
        font-weight: 600;
    }

    .notif-head-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .count-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
    }

    .cb-amber { background: #fef3c7; color: #92400e; }
    .cb-blue  { background: #dbeafe; color: #1e40af; }

    .notif-row {
        padding: 12px 16px;
        border-bottom: 1px solid #f8fafc;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notif-row:last-child { border-bottom: none; }

    .notif-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .nd-amber { background: #f59e0b; }
    .nd-blue  { background: #3b82f6; }

    .notif-info { flex: 1; min-width: 0; }

    .notif-name {
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notif-meta {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .notif-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 5px;
        flex-shrink: 0;
    }

    .notif-time { font-size: 11px; color: #94a3b8; }

    .notif-btn {
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 7px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        cursor: pointer;
        color: #0f172a;
        white-space: nowrap;
        transition: background .15s;
        text-decoration: none;
    }

    .notif-btn:hover { background: #f1f5f9; }

    .empty-notif {
        padding: 20px 16px;
        text-align: center;
        color: #94a3b8;
        font-size: 12.5px;
    }

    .empty-notif i { font-size: 22px; display: block; margin-bottom: 5px; }

    /* ── Chart Cards ── */
    .chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }

    .chart-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
    }

    .chart-card h6 {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 14px;
    }

    /* ── Table Cards ── */
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-card-head {
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-card-head h6 {
        font-size: 13px;
        font-weight: 600;
        margin: 0;
    }
</style>

<!-- ─── Header ─── -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="font-size:20px;">Dashboard Admin</h2>
        <p class="text-muted mb-0" style="font-size:13px;">Monitoring rental, pembayaran dan aktivitas sistem</p>
    </div>
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:10px 16px;">
        <div style="font-size:11px; color:#64748b;">Hari Ini</div>
        <div style="font-size:13px; font-weight:600;">{{ now()->format('d M Y') }}</div>
    </div>
</div>

<!-- ─── Stat Cards ─── -->
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Total Rental</div>
            <div class="stat-icon si-blue"><i class="bi bi-file-earmark-text"></i></div>
        </div>
        <div class="stat-val">{{ $totalRental }}</div>
        @php $r = $pctRental; @endphp
        <div class="stat-change {{ $r['naik'] ? 'up' : 'down' }}">
            <i class="bi bi-{{ $r['naik'] ? 'arrow-up' : 'arrow-down' }}"></i>
            {{ abs($r['pct']) }}% vs bulan lalu
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Pending Rental</div>
            <div class="stat-icon si-amber"><i class="bi bi-clock"></i></div>
        </div>
        <div class="stat-val">{{ $pendingRental }}</div>
        <div class="stat-change warn">
            <i class="bi bi-exclamation-circle"></i> Menunggu verifikasi
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-label">Waiting Payment</div>
            <div class="stat-icon si-teal"><i class="bi bi-credit-card"></i></div>
        </div>
        <div class="stat-val">{{ $waitingPayment }}</div>
        <div class="stat-change info">
            <i class="bi bi-exclamation-circle"></i> Perlu dikonfirmasi
        </div>
    </div>

    <div class="stat-card">
        @php $p = $pctPendapatan; @endphp
        <div class="stat-top">
            <div class="stat-label">Pendapatan Bulan Ini</div>
            <div class="stat-icon si-green"><i class="bi bi-wallet2"></i></div>
        </div>
        <div class="stat-val" style="font-size:18px;">Rp {{ number_format($p['nilai'], 0, ',', '.') }}</div>
        <div class="stat-change {{ $p['naik'] ? 'up' : 'down' }}">
            <i class="bi bi-{{ $p['naik'] ? 'arrow-up' : 'arrow-down' }}"></i>
            {{ abs($p['pct']) }}% vs bulan lalu
        </div>
    </div>

</div>

<!-- ─── Notif Cards ─── -->
<div class="notif-grid">

    {{-- Booking Menunggu Verifikasi --}}
    <div class="notif-card">
        <div class="notif-head">
            <div class="notif-head-left">
                <div class="notif-head-icon si-amber"><i class="bi bi-clock-history"></i></div>
                Booking Menunggu Verifikasi
            </div>
            <span class="count-badge cb-amber">{{ $pendingRental }} baru</span>
        </div>

        @forelse($recentPendingRentals as $rental)
        <div class="notif-row">
            <div class="notif-dot nd-amber"></div>
            <div class="notif-info">
                <div class="notif-name">
                    {{ $rental->user->name ?? '-' }} — {{ $rental->kendaraan->nama ?? '-' }}
                </div>
                <div class="notif-meta">
                    {{ $rental->tanggal_mulai ? \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M') : '-' }}
                    →
                    {{ $rental->tanggal_selesai ? \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') : '-' }}
                    · KTP & SIM diunggah
                </div>
            </div>
            <div class="notif-right">
                <span class="notif-time">{{ $rental->created_at->diffForHumans() }}</span>
                <a href="{{ route('admin.rental.show', $rental->id) }}" class="notif-btn">
                    Verifikasi →
                </a>
            </div>
        </div>
        @empty
        <div class="empty-notif">
            <i class="bi bi-check2-all"></i>
            Tidak ada rental pending
        </div>
        @endforelse
    </div>

    {{-- Pembayaran Menunggu Konfirmasi --}}
    <div class="notif-card">
        <div class="notif-head">
            <div class="notif-head-left">
                <div class="notif-head-icon si-blue"><i class="bi bi-receipt"></i></div>
                Pembayaran Menunggu Konfirmasi
            </div>
            <span class="count-badge cb-blue">{{ $waitingPayment }} baru</span>
        </div>

        @forelse($recentPayments as $bayar)
        <div class="notif-row">
            <div class="notif-dot nd-blue"></div>
            <div class="notif-info">
                <div class="notif-name">
                    {{ $bayar->rental->user->name ?? '-' }} — Rental #{{ $bayar->rental_id }}
                </div>
                <div class="notif-meta">
                    Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }} · Bukti transfer diunggah
                </div>
            </div>
            <div class="notif-right">
                <span class="notif-time">{{ $bayar->created_at->diffForHumans() }}</span>
                <a href="{{ route('admin.pembayaran.show', $bayar->id) }}" class="notif-btn">
                    Konfirmasi →
                </a>
            </div>
        </div>
        @empty
        <div class="empty-notif">
            <i class="bi bi-check2-all"></i>
            Tidak ada pembayaran pending
        </div>
        @endforelse
    </div>

</div>

<!-- ─── Charts ─── -->
<div class="chart-grid">
    <div class="chart-card">
        <h6>Rental per Bulan</h6>
        <canvas id="chartRental" height="90"></canvas>
    </div>
    <div class="chart-card">
        <h6>Pendapatan per Bulan</h6>
        <canvas id="chartPendapatan" height="90"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bulanLabel     = JSON.parse('{!! addslashes($bulanLabel) !!}');
    const dataRental     = JSON.parse('{!! addslashes($dataRental) !!}');
    const dataPendapatan = JSON.parse('{!! addslashes($dataPendapatan) !!}');

    new Chart(document.getElementById('chartRental'), {
        type: 'bar',
        data: {
            labels: bulanLabel,
            datasets: [{
                data: dataRental,
                backgroundColor: (ctx) => {
                    const i = ctx.dataIndex;
                    return i === dataRental.length - 1 ? '#0ea5e9' : '#bae6fd';
                },
                borderRadius: 6,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }
            }
        }
    });

    new Chart(document.getElementById('chartPendapatan'), {
        type: 'line',
        data: {
            labels: bulanLabel,
            datasets: [{
                data: dataPendapatan,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,.08)',
                fill: true,
                tension: .4,
                pointBackgroundColor: '#10b981',
                pointRadius: 4,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }
            }
        }
    });
</script>
@endpush