@extends('layouts.customer')

@section('content')

@php
/** @var \App\Models\Kendaraan|null $kendaraan */
/** @var \Illuminate\Database\Eloquent\Collection $kendaraans */
/** @var array $bookedDates */
@endphp

<div class="container mb-5">
    <h4 class="fw-bold mb-4">Formulir Booking Kendaraan</h4>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('customer.rental.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Info kendaraan yang dipilih --}}
                @if($kendaraan)
                    <div class="alert alert-info mb-4">
                        <b>{{ $kendaraan->nama_mobil }}</b> —
                        Rp {{ number_format($kendaraan->harga_sewa_per_hari, 0, ',', '.') }}/hari
                        @if(count($bookedDates) > 0)
                            <br>
                            <small class="text-danger">
                                <i class="bi bi-calendar-x"></i>
                                Tanggal tidak tersedia: sudah ada booking aktif
                            </small>
                        @endif
                    </div>
                @endif

                {{-- Pilih Kendaraan --}}
                <div class="mb-3">
                    <label class="form-label">Pilih Kendaraan</label>
                    <select name="kendaraan_id" id="kendaraan_id"
                            class="form-select @error('kendaraan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($kendaraans as $mobil)
                            <option value="{{ $mobil->id }}"
                                {{ old('kendaraan_id', $kendaraan ? $kendaraan->id : null) == $mobil->id ? 'selected' : '' }}>
                                {{ $mobil->nama_mobil }} — Rp {{ number_format($mobil->harga_sewa_per_hari, 0, ',', '.') }}/hari
                            </option>
                        @endforeach
                    </select>
                    @error('kendaraan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Mulai Sewa</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                           class="form-control @error('tanggal_mulai') is-invalid @enderror"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Selesai Sewa</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                           class="form-control @error('tanggal_selesai') is-invalid @enderror"
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload KTP --}}
                <div class="mb-3">
                    <label class="form-label">Upload KTP</label>
                    <input type="file" name="upload_ktp"
                           class="form-control @error('upload_ktp') is-invalid @enderror" required>
                    @error('upload_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload SIM --}}
                <div class="mb-3">
                    <label class="form-label">Upload SIM</label>
                    <input type="file" name="upload_sim"
                           class="form-control @error('upload_sim') is-invalid @enderror" required>
                    @error('upload_sim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Ajukan Booking</button>
                    <a href="{{ route('customer.kendaraan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    <?php /** @var array $bookedDates */ ?>
    const bookedDates = <?= json_encode($bookedDates) ?>;

    function isBooked(dateStr) {
        return bookedDates.includes(dateStr);
    }

    document.getElementById('tanggal_mulai').addEventListener('change', function () {
        const val = this.value;
        if (isBooked(val)) {
            alert('Tanggal ' + val + ' sudah dipesan. Silakan pilih tanggal lain.');
            this.value = '';
            return;
        }
        document.getElementById('tanggal_selesai').min = val;
    });

    document.getElementById('tanggal_selesai').addEventListener('change', function () {
        const val = this.value;
        if (isBooked(val)) {
            alert('Tanggal ' + val + ' sudah dipesan. Silakan pilih tanggal lain.');
            this.value = '';
        }
    });

    document.getElementById('kendaraan_id').addEventListener('change', function () {
        if (this.value) {
            window.location.href = "{{ route('customer.rental.create') }}" + '?kendaraan_id=' + this.value;
        }
    });
</script>
@endpush