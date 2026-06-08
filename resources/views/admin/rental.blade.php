@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2 class="fw-bold">Verifikasi Rental</h2>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#0B1F3B; color:white;">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Customer</th>
                    <th class="p-3">Kendaraan</th>
                    <th class="p-3">Tanggal Sewa</th>
                    <th class="p-3">Tanggal Kembali</th>
                    <th class="p-3">KTP</th>
                    <th class="p-3">SIM</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $r)
                <tr>
                    <td class="p-3">#{{ $r->id }}</td>
                    <td class="p-3">{{ $r->user->name }}</td>
                    <td class="p-3">{{ $r->detailRental->kendaraan->nama_mobil ?? '-' }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($r->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($r->tanggal_selesai)->translatedFormat('d F Y') }}</td>
                    <td class="p-3">
                        <a href="{{ asset('storage/'.$r->upload_ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat KTP
                        </a>
                    </td>
                    <td class="p-3">
                        <a href="{{ asset('storage/'.$r->upload_sim) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            Lihat SIM
                        </a>
                    </td>
                    <td class="p-3">
                        <span class="badge bg-warning text-dark">{{ $r->status }}</span>
                    </td>
                    <td class="p-3">
                        <form action="{{ route('admin.rental.verify', $r->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('admin.rental.reject', $r->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted p-4">Belum ada rental pending</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection