<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #F7F9FC; }
        .card {
            max-width: 450px;
            margin: 60px auto;
            padding: 25px;
            border-radius: 16px;
        }
    </style>
</head>
<body>

<div class="card">
    <h3 class="text-center mb-3">Register</h3>

    <form method="POST" action="{{ route('register') }}">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}" class="form-control mb-2">
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="form-control mb-2">
    <input type="text" name="phone" placeholder="Nomor Telepon" value="{{ old('phone') }}" class="form-control mb-2">
    <input type="password" name="password" placeholder="Password" class="form-control mb-2">
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="form-control mb-2">

    <button type="submit" class="btn btn-dark w-100">Daftar</button>
</form>
</div>

</body>
</html>