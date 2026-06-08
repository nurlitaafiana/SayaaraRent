@extends('layouts.admin')

@section('page-title', 'Kategori')
@section('page-sub', 'Kelola kategori kendaraan')

@section('content')

<div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:16px; padding:20px 24px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between;">
    <div>
        <p style="font-size:11px; font-weight:600; color:#2563eb; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 4px;">MANAJEMEN</p>
        <h5 style="font-weight:700; color:#0d1b2a; margin:0 0 2px;">Kategori Mobil</h5>
        <p style="font-size:13px; color:#7a9bb5; margin:0;">Kelola kategori kendaraan yang tersedia.</p>
    </div>
    <button data-bs-toggle="modal" data-bs-target="#createModal"
            style="background:#2563eb; color:#fff; border:none; border-radius:9px; padding:10px 18px; font-size:13px; font-weight:600; display:inline-flex; align-items:center; gap:7px; cursor:pointer; font-family:inherit;">
        <i class="bi bi-plus-lg"></i> Tambah
    </button>
</div>

@if(session('success'))
<div style="background:#e8f5ee; color:#166534; border-radius:10px; padding:12px 16px; font-size:13px; margin-bottom:16px;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
</div>
@endif

<div style="background:#fff; border-radius:14px; border:0.5px solid #e2e8f0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse; font-size:13px;">
        <thead>
            <tr style="background:#f8faff; border-bottom:0.5px solid #e2e8f0;">
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">ID</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Nama Kategori</th>
                <th style="padding:12px 16px; font-size:10px; font-weight:700; color:#94a3b8; letter-spacing:1px; text-transform:uppercase;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
            <tr style="border-bottom:0.5px solid #f0f4fa;" onmouseover="this.style.background='#f8fbff'" onmouseout="this.style.background=''">
                <td style="padding:14px 16px; color:#94a3b8; font-size:12px; font-family:monospace; font-weight:700;">{{ $kategori->id }}</td>
                <td style="padding:14px 16px; font-weight:600; color:#0d1b2a;">{{ $kategori->nama_kategori }}</td>
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:6px; align-items:center;">
                        <button data-bs-toggle="modal" data-bs-target="#editModal{{ $kategori->id }}"
                                style="background:#f0f9ff; color:#0369a1; border:0.5px solid #bae6fd; border-radius:7px; padding:6px 12px; font-size:11px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:4px; font-family:inherit;">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus kategori ini?')"
                                    style="background:#fdecea; color:#dc2626; border:0.5px solid #fecaca; border-radius:7px; padding:6px 12px; font-size:11px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:4px; font-family:inherit;">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            {{-- Modal Edit --}}
            <div class="modal fade" id="editModal{{ $kategori->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius:14px; border:0.5px solid #e2e8f0;">
                        <div class="modal-header" style="border-bottom:0.5px solid #e2e8f0;">
                            <h6 class="modal-title fw-bold">Edit Kategori</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Nama Kategori</label>
                                <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required
                                       style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                            </div>
                            <div class="modal-footer" style="border-top:0.5px solid #e2e8f0;">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit"
                                        style="background:#2563eb; color:#fff; border:none; border-radius:7px; padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit;">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="3" style="text-align:center; color:#94a3b8; padding:48px; font-size:14px;">
                    <i class="bi bi-grid" style="font-size:40px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                    Belum ada kategori
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:14px; border:0.5px solid #e2e8f0;">
            <div class="modal-header" style="border-bottom:0.5px solid #e2e8f0;">
                <h6 class="modal-title fw-bold">Tambah Kategori</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label style="font-size:12px; font-weight:600; color:#475569; display:block; margin-bottom:6px;">Nama Kategori</label>
                    <input type="text" name="nama_kategori" placeholder="Contoh: SUV, Sedan, MPV" required
                           style="width:100%; border:0.5px solid #e2e8f0; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; font-family:inherit;">
                </div>
                <div class="modal-footer" style="border-top:0.5px solid #e2e8f0;">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit"
                            style="background:#2563eb; color:#fff; border:none; border-radius:7px; padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection