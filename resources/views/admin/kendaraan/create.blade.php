@extends('layouts.admin')

@section('page-title', 'Tambah Kendaraan')
@section('page-sub', 'Tambah armada kendaraan baru')

@section('content')

<div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:16px; padding:20px 24px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between;">
    <div>
        <p style="font-size:11px; font-weight:600; color:#2563eb; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 4px;">KENDARAAN</p>
        <h5 style="font-weight:700; color:#0d1b2a; margin:0 0 2px;">Tambah Kendaraan</h5>
        <p style="font-size:13px; color:#7a9bb5; margin:0;">Isi data lengkap kendaraan baru.</p>
    </div>
    <a href="{{ route('admin.kendaraan.index') }}"
       style="background:#f1f5f9; color:#475569; border:0.5px solid #e2e8f0; border-radius:9px; padding:10px 18px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:7px;">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
<div style="background:#fdecea; color:#a33030; border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:16px;">
    <ul style="margin:0; padding-left:16px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div style="background:#fff; border-radius:14px; border:0.5px solid #e2e8f0; overflow:hidden;">
    <div style="padding:24px;">
        <form action="{{ route('admin.kendaraan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Nama Mobil</label>
                    <input type="text" name="nama_mobil" value="{{ old('nama_mobil') }}" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Merk</label>
                    <input type="text" name="merk" value="{{ old('merk') }}" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Kategori</label>
                    <select name="kategori_id" required
                            style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit; background:#fff;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Plat Nomor</label>
                    <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun') }}" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Kapasitas Penumpang</label>
                    <input type="number" name="kapasitas_penumpang" value="{{ old('kapasitas_penumpang') }}" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Harga Sewa/Hari (Rp)</label>
                    <input type="number" name="harga_sewa_per_hari" value="{{ old('harga_sewa_per_hari') }}" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Gambar</label>
                    <input type="file" name="gambar" accept="image/*"
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; font-family:inherit;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Status</label>
                    <select name="status" required
                            style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit; background:#fff;">
                        <option value="tersedia">Tersedia</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit; resize:vertical;">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit"
                    style="width:100%; background:#2563eb; color:#fff; border:none; border-radius:9px; padding:12px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit;">
                Simpan Kendaraan
            </button>
        </form>
    </div>
</div>

@endsection