@extends('layouts.customer')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

```
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Upload Bukti Pembayaran</h4>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('customer.payment.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="hidden"
                           name="rental_id"
                           value="{{ $rental_id }}">

                    <div class="mb-3">
                        <label class="form-label">
                            Metode Pembayaran
                        </label>

                        <select name="metode_pembayaran"
                                class="form-control"
                                required>
                            <option value="">
                                -- Pilih Metode --
                            </option>
                            <option value="Transfer BCA">
                                Transfer BCA
                            </option>
                            <option value="Transfer BRI">
                                Transfer BRI
                            </option>
                            <option value="Transfer Mandiri">
                                Transfer Mandiri
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Jumlah Bayar
                        </label>

                        <input type="number"
                               name="jumlah_bayar"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Bukti Pembayaran
                        </label>

                        <input type="file"
       name="bukti_pembayaran"
       class="form-control"
       accept="image/*"
       required>
                    </div>

                    <button type="submit"
                            class="btn btn-primary">
                        Kirim Pembayaran
                    </button>

                    <a href="{{ route('customer.rental.history') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>
```

</div>

@endsection
