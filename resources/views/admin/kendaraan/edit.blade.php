@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Edit Kendaraan</h4>
    <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0" style="max-width:800px;">
    <div class="card-body">
        <form action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Mobil</label>
                <input type="text" name="nama_mobil" class="form-control" value="{{ old('nama_mobil', $kendaraan->nama_mobil) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Merk</label>
                <input type="text" name="merk" class="form-control" value="{{ old('merk', $kendaraan->merk) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $kendaraan->kategori_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $kendaraan->tahun) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Plat Nomor</label>
                    <input type="text" name="plat_nomor" class="form-control" value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kapasitas Penumpang</label>
                    <input type="number" name="kapasitas_penumpang" class="form-control" value="{{ old('kapasitas_penumpang', $kendaraan->kapasitas_penumpang) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Sewa/Hari (Rp)</label>
                    <input type="number" name="harga_sewa_per_hari" class="form-control" value="{{ old('harga_sewa_per_hari', $kendaraan->harga_sewa_per_hari) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar</label>
                @if($kendaraan->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $kendaraan->gambar) }}" width="150" style="border-radius:8px;">
                    </div>
                @endif
                <input type="file" name="gambar" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kendaraan->deskripsi) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="tersedia" {{ $kendaraan->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="disewa" {{ $kendaraan->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    <option value="maintenance" {{ $kendaraan->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Update Kendaraan</button>
        </form>
    </div>
</div>

@endsection