@extends('layouts.admin')

@section('content')

<h2 class="fw-bold mb-4">
Verifikasi Pembayaran
</h2>

<div class="card border-0 shadow-sm">

<div class="card-body">

<table class="table align-middle">

<thead>

<tr>
    <th>ID</th>
    <th>User</th>
    <th>Rental</th>
    <th>Total</th>
    <th>Bukti</th>
    <th>Aksi</th>
</tr>

</thead>

<tbody>

@foreach($payments as $payment)

<tr>

<td>
#{{ $payment->id }}
</td>

<td>
    {{ $payment->rental->user->name ?? '-' }}
</td>

<td>
#{{ $payment->rental_id }}
</td>

<td>
Rp {{ number_format($payment->jumlah_bayar) }}
</td>

<td>

<a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}"
   target="_blank"
   class="btn btn-info btn-sm">
    Lihat Bukti
</a>

</td>

<td>

<form action="{{ route('admin.payment.verify',$payment->id) }}"
      method="POST">

    @csrf
    @method('PATCH')

    <button class="btn btn-success btn-sm">
        Verifikasi
    </button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection