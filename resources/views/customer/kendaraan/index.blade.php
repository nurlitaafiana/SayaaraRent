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
    }
    .page-header-deco {
        position: absolute;
        right: 28px; top: 50%;
        transform: translateY(-50%);
        font-size: 56px;
        color: #bde5f8;
        opacity: 0.4;
        z-index: 0;
    }
    .page-header-left { position: relative; z-index: 1; }
    .page-header-label {
        font-size: 11px; font-weight: 600;
        color: #0ea5e9; letter-spacing: 1.5px; margin-bottom: 4px;
    }
    .page-header-title {
        font-size: 20px; font-weight: 700;
        color: #0d1b2a; margin: 0 0 3px;
    }
    .page-header-sub { font-size: 13px; color: #7a9bb5; margin: 0; }

    .section-label {
        font-size: 13px; font-weight: 700;
        color: #0d1b2a; margin-bottom: 14px;
        display: flex; align-items: center; gap: 8px;
        padding-bottom: 10px;
        border-bottom: 0.5px solid #e8f1fb;
    }
    .section-label i { color: #0ea5e9; font-size: 15px; }
    .section-label .count-badge {
        margin-left: auto;
        font-size: 11px; font-weight: 600;
        background: #eef3ff; color: #3b6be8;
        padding: 2px 9px; border-radius: 20px;
    }

    .kendaraan-card {
        background: #fff;
        border-radius: 14px;
        border: 0.5px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .kendaraan-card:hover {
        border-color: #38bdf8;
        box-shadow: 0 8px 28px rgba(56,189,248,0.12);
        transform: translateY(-3px);
    }
    .kendaraan-img {
        width: 100%; height: 185px;
        object-fit: cover;
        display: block;
    }
    .kendaraan-img-placeholder {
        width: 100%; height: 185px;
        background: linear-gradient(135deg, #e8f4fe, #f0faff);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 8px; color: #38bdf8;
    }
    .kendaraan-img-placeholder i { font-size: 40px; opacity: 0.5; }
    .kendaraan-img-placeholder span { font-size: 11px; color: #94a3b8; }

    .kendaraan-body {
        padding: 16px 18px 18px;
        flex: 1; display: flex; flex-direction: column;
    }
    .kendaraan-detail {
        background: #f8faff;
        border: 0.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 12px;
        display: flex;
        flex-direction: column;
        gap: 7px;
    }
    .detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }
    .detail-label {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
        min-width: 90px;
    }
    .detail-label i { font-size: 11px; }
    .detail-val {
        font-size: 12px;
        font-weight: 600;
        color: #0d1b2a;
        text-align: right;
    }
    .detail-desc {
        flex-direction: column;
        gap: 3px;
    }
    .detail-desc .detail-val {
        text-align: left;
        font-weight: 400;
    }
    .kendaraan-badge {
        font-size: 10px; font-weight: 600;
        padding: 3px 9px; border-radius: 20px;
        background: #e8f5fe; color: #0369a1;
        display: inline-block; margin-bottom: 10px;
    }
    .kendaraan-nama {
        font-size: 14px; font-weight: 700;
        color: #0d1b2a; margin-bottom: 4px;
    }
    .kendaraan-meta {
        font-size: 12px; color: #7a9bb5;
        display: flex; align-items: center; gap: 12px;
        margin-bottom: 12px; flex-wrap: wrap;
    }
    .kendaraan-meta span { display: flex; align-items: center; gap: 4px; }

    .booked-dates {
        background: #fff5f5;
        border: 0.5px solid #fecaca;
        border-radius: 8px;
        padding: 8px 10px;
        margin-bottom: 12px;
    }
    .booked-dates-label {
        font-size: 11px; font-weight: 600;
        color: #dc2626; margin-bottom: 5px;
        display: flex; align-items: center; gap: 4px;
    }
    .booked-date-badge {
        font-size: 10px; font-weight: 500;
        background: #fdecea; color: #b91c1c;
        padding: 2px 8px; border-radius: 20px;
        display: inline-block; margin: 2px 2px 0 0;
    }

    .kendaraan-footer {
        margin-top: auto;
        display: flex; align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 0.5px solid #f0f4fa;
    }
    .kendaraan-harga {
        font-size: 16px; font-weight: 700; color: #0d1b2a;
    }
    .kendaraan-harga small {
        font-size: 11px; font-weight: 400; color: #94a3b8;
    }
    .btn-booking {
        background: #0ea5e9; color: #fff;
        border: none; border-radius: 8px;
        padding: 8px 16px; font-size: 12px; font-weight: 600;
        text-decoration: none; display: inline-flex;
        align-items: center; gap: 5px;
        transition: background 0.18s;
    }
    .btn-booking:hover { background: #0284c7; color: #fff; }
</style>

{{-- PAGE HEADER --}}
<div class="page-header mb-4">
    <div class="page-header-left">
        <div class="page-header-label">ARMADA KAMI</div>
        <div class="page-header-title">Pilih Kendaraan</div>
        <p class="page-header-sub">Pilih kategori dan kendaraan yang sesuai kebutuhanmu.</p>
    </div>
    <i class="bi bi-car-front page-header-deco"></i>
</div>

@if(session('success'))
<div class="alert border-0 rounded-3 mb-4"
     style="background:#e8f5ee; color:#166534; font-size:13px;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
</div>
@endif

@forelse($kategoris as $kategori)
    @if($kategori->kendaraans->count() > 0)
    <div class="mb-4">
        <div class="section-label">
            @php $nama = strtolower($kategori->nama_kategori); @endphp
            @if(str_contains($nama, 'luxury'))
                <i class="bi bi-star-fill"></i>
            @elseif(str_contains($nama, 'bus'))
                <i class="bi bi-bus-front"></i>
            @elseif(str_contains($nama, 'suv'))
                <i class="bi bi-truck"></i>
            @else
                <i class="bi bi-car-front"></i>
            @endif
            {{ $kategori->nama_kategori }}
            <span class="count-badge">{{ $kategori->kendaraans->count() }} unit</span>
        </div>

        <div class="row g-3">
            @foreach($kategori->kendaraans as $kendaraan)
            @php $bookedDates = $bookedDatesMap[$kendaraan->id] ?? []; @endphp
            <div class="col-md-4">
                <div class="kendaraan-card">
                    {{-- GAMBAR --}}
                    @if($kendaraan->gambar)
                        <img src="{{ asset('storage/' . $kendaraan->gambar) }}"
                             class="kendaraan-img" alt="{{ $kendaraan->nama_mobil }}">
                    @else
                        <div class="kendaraan-img-placeholder">
                            <i class="bi bi-car-front"></i>
                            <span>Tidak ada gambar</span>
                        </div>
                    @endif

                    <div class="kendaraan-body">
                        <span class="kendaraan-badge">{{ $kategori->nama_kategori }}</span>
                        <div class="kendaraan-nama">{{ $kendaraan->nama_mobil }}</div>
                        <div class="kendaraan-meta">
                            <span><i class="bi bi-building"></i> {{ $kendaraan->merk }}</span>
                            <span><i class="bi bi-calendar3"></i> {{ $kendaraan->tahun }}</span>
                            <span><i class="bi bi-people"></i> {{ $kendaraan->kapasitas_penumpang }} orang</span>
                        </div>

                        {{-- DETAIL SPESIFIKASI --}}
                        <div class="kendaraan-detail mb-3">
                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-card-text"></i> Plat Nomor</span>
                                <span class="detail-val">{{ $kendaraan->plat_nomor }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-people"></i> Kapasitas</span>
                                <span class="detail-val">{{ $kendaraan->kapasitas_penumpang }} Penumpang</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label"><i class="bi bi-circle-fill" style="font-size:8px; color:
                                    @if($kendaraan->status == 'tersedia') #16a34a
                                    @elseif($kendaraan->status == 'disewa') #d97706
                                    @else #dc2626 @endif
                                "></i> Status</span>
                                <span class="detail-val">
                                    @if($kendaraan->status == 'tersedia')
                                        <span style="color:#16a34a; font-weight:600;">Tersedia</span>
                                    @elseif($kendaraan->status == 'disewa')
                                        <span style="color:#d97706; font-weight:600;">Sedang Disewa</span>
                                    @else
                                        <span style="color:#dc2626; font-weight:600;">Maintenance</span>
                                    @endif
                                </span>
                            </div>

                            {{-- DESKRIPSI TAMPIL PENUH --}}
                            @if($kendaraan->deskripsi)
                            <div class="detail-row detail-desc">
                                <span class="detail-label"><i class="bi bi-info-circle"></i> Deskripsi</span>
                                <div style="color:#64748b; font-size:11px; line-height:1.5;">
                                    {{ $kendaraan->deskripsi }}
                                </div>
                            </div>
                            @endif

                        </div>

                        {{-- TANGGAL TIDAK TERSEDIA --}}
                        @if(count($bookedDates) > 0)
                        @php
                            $bookedRentals = \App\Models\DetailRental::where('kendaraan_id', $kendaraan->id)
                                ->with('rental')
                                ->get()
                                ->filter(fn($d) => $d->rental && in_array($d->rental->status, [
                                    'pending_verification','waiting_payment','active'
                                ]));
                        @endphp
                        @if($bookedRentals->count() > 0)
                        <div class="booked-dates">
                            <div class="booked-dates-label">
                                <i class="bi bi-calendar-x"></i> Tidak tersedia:
                            </div>
                            @foreach($bookedRentals as $br)
                            <span class="booked-date-badge">
                                {{ \Carbon\Carbon::parse($br->rental->tanggal_mulai)->format('d M') }}
                                –
                                {{ \Carbon\Carbon::parse($br->rental->tanggal_selesai)->format('d M Y') }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                        @endif

                        <div class="kendaraan-footer">
                            <div class="kendaraan-harga">
                                Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}
                                <small>/hari</small>
                            </div>
                            <a href="{{ route('customer.rental.create', ['kendaraan_id' => $kendaraan->id]) }}"
                               class="btn-booking">
                                <i class="bi bi-calendar-check"></i> Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@empty
    <div class="text-center py-5" style="color:#94a3b8;">
        <i class="bi bi-car-front" style="font-size:48px; opacity:0.3;"></i>
        <p class="mt-3 mb-0">Belum ada kendaraan tersedia.</p>
    </div>
@endforelse

@endsection