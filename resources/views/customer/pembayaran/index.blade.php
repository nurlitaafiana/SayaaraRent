@extends('layouts.customer')

@section('content')

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2">
                    Pembayaran
                </h6>

                <h2 class="fw-bold mb-2">
                    Riwayat Pembayaran
                </h2>

                <p class="text-muted mb-0">
                    Lihat status pembayaran rental kendaraan kamu.
                </p>
            </div>

        </div>

    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">KODE</th>
                        <th>RENTAL</th>
                        <th>TOTAL PEMBAYARAN</th>
                        <th>STATUS</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($payments as $payment)

                    <tr>

                        <td class="ps-4 fw-semibold">
                            #{{ str_pad($payment->rental_id,4,'0',STR_PAD_LEFT) }}
                        </td>

                        <td>
                            Rental #{{ $payment->rental_id }}
                        </td>

                        <td class="fw-bold">
                            Rp {{ number_format($payment->jumlah_bayar,0,',','.') }}
                        </td>

                        <td>

                            @if($payment->status_pembayaran == 'pending')

                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                    Menunggu Verifikasi
                                </span>

                            @elseif($payment->status_pembayaran == 'verified')

                                <span class="badge rounded-pill bg-success px-3 py-2">
                                    Verified
                                </span>

                            @else

                                <span class="badge rounded-pill bg-danger px-3 py-2">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="text-center py-5">
                            Belum ada data pembayaran
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection