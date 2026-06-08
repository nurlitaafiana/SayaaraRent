@extends('layouts.admin')

@section('page-title', 'Kendaraan')
@section('page-sub', 'Kelola armada kendaraan yang tersedia')

@section('content')

<div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:16px; padding:20px 24px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between;">
    <div>
        <p style="font-size:11px; font-weight:600; color:#2563eb; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 4px;">MANAJEMEN</p>
        <h5 style="font-weight:700; color:#0d1b2a; margin:0 0 2px;">Daftar Kendaraan</h5>
        <p style="font-size:13px; color:#7a9bb5; margin:0;">Kelola armada kendaraan yang tersedia untuk disewa.</p>
    </div>
    <a href="{{ route('admin.kendaraan.create') }}"
       style="background:#2563eb; color:#fff; border:none; border-radius:9px; padding:10px 18px; font-size:13px; font-weight:600; display:inline-flex; align-items:center; gap:7px; text-decoration:none; white-space:nowrap;">
        <i class="bi bi-plus-lg"></i> Tambah Kendaraan
    </a>
</div>

@if(session('success'))
<div style="background:#e8f5ee; color:#166534; border:none; border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:16px;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
</div>
@endif

<div style="background:#fff; border-radius:14px; border:0.5px solid #e2e8f0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse; font-size:13px;">
        <thead>
            <tr style="background:#f8faff; border-bottom:0.5px solid #e2e8f0;">
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">ID</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Foto</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Nama Mobil</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Merk</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Kategori</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Plat Nomor</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Harga/Hari</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Status</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kendaraans as $kendaraan)
            <tr style="border-bottom:0.5px solid #f0f4fa; transition:background 0.15s;" onmouseover="this.style.background='#f8fbff'" onmouseout="this.style.background=''">
                <td style="padding:14px 16px; color:#94a3b8; font-size:12px; font-family:monospace; font-weight:700;">#{{ str_pad($kendaraan->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td style="padding:14px 16px;">
                    @if($kendaraan->gambar)
                        <img src="{{ asset('storage/' . $kendaraan->gambar) }}" width="72" height="52" style="object-fit:cover; border-radius:8px; border:0.5px solid #e2e8f0;">
                    @else
                        <div style="width:72px; height:52px; background:#f1f5f9; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-car-front" style="color:#cbd5e1; font-size:20px;"></i>
                        </div>
                    @endif
                </td>
                <td style="padding:14px 16px; font-weight:600; color:#0d1b2a;">{{ $kendaraan->nama_mobil }}</td>
                <td style="padding:14px 16px; color:#64748b;">{{ $kendaraan->merk }}</td>
                <td style="padding:14px 16px; color:#64748b;">{{ $kendaraan->kategori->nama_kategori ?? '-' }}</td>
                <td style="padding:14px 16px; color:#64748b; font-family:monospace; font-size:12px;">{{ $kendaraan->plat_nomor }}</td>
                <td style="padding:14px 16px; font-weight:700; color:#0d1b2a;">Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}</td>
                <td style="padding:14px 16px;">
                    @if($kendaraan->status == 'tersedia')
                        <span style="background:#e8f5ee; color:#16713e; font-size:10px; font-weight:600; padding:4px 10px; border-radius:20px;">Tersedia</span>
                    @elseif($kendaraan->status == 'disewa')
                        <span style="background:#fff8e6; color:#9a5f00; font-size:10px; font-weight:600; padding:4px 10px; border-radius:20px;">Disewa</span>
                    @else
                        <span style="background:#f1f5f9; color:#64748b; font-size:10px; font-weight:600; padding:4px 10px; border-radius:20px;">{{ $kendaraan->status }}</span>
                    @endif
                </td>
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:6px; align-items:center;">
                        <a href="{{ route('admin.kendaraan.edit', $kendaraan->id) }}"
                           style="background:#f0f9ff; color:#0369a1; border:0.5px solid #bae6fd; border-radius:7px; padding:6px 12px; font-size:11px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:4px; white-space:nowrap;">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Hapus kendaraan ini?')"
                                style="background:#fdecea; color:#dc2626; border:0.5px solid #fecaca; border-radius:7px; padding:6px 12px; font-size:11px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:4px; white-space:nowrap; font-family:inherit;">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; color:#94a3b8; padding:48px 24px; font-size:14px;">
                    <i class="bi bi-car-front" style="font-size:40px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                    Belum ada kendaraan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection