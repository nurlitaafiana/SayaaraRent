<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – SayaaraRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:   #0f2044;
            --blue:   #1a3a6e;
            --accent: #2563eb;
            --sky:    #c8dcf8;
            --light:  #e8f0fb;
            --white:  #ffffff;
            --gray:   #6b7a99;
            --border: #d0dcee;
            --shadow: 0 24px 60px rgba(15,32,68,.14);
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ── LEFT PANEL ─────────────────────────────── */
        .panel-left {
            flex: 0 0 52%;
            background: linear-gradient(135deg, #c8dcf8 0%, #ddeafc 40%, #e8f2ff 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 48px 52px;
            overflow: hidden;
        }

        /* decorative circles */
        .panel-left::before,
        .panel-left::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            opacity: .35;
        }
        .panel-left::before {
            width: 460px; height: 460px;
            background: radial-gradient(circle, #93b8f0 0%, transparent 70%);
            right: -120px; top: -80px;
        }
        .panel-left::after {
            width: 320px; height: 320px;
            background: radial-gradient(circle, #a8caf5 0%, transparent 70%);
            left: -60px; bottom: 60px;
        }

        /* dot grid */
        .dots {
            position: absolute;
            top: 56px; right: 80px;
            display: grid;
            grid-template-columns: repeat(6,1fr);
            gap: 10px;
            opacity: .55;
        }
        .dots span {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--accent);
            display: block;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 2;
        }
        .brand svg { width: 52px; height: 32px; }
        .brand-name { line-height: 1; }
        .brand-name span:first-child {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: .04em;
            color: var(--navy);
        }
        .brand-name span:last-child {
            display: block;
            font-size: 10px;
            letter-spacing: .18em;
            color: var(--blue);
            text-transform: uppercase;
            margin-top: 2px;
        }
        .hero-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 3.6vw, 46px);
            color: var(--navy);
            line-height: 1.18;
        }
        .hero-text h1 .accent { color: var(--accent); }
        .hero-text p {
            margin-top: 14px;
            font-size: 14px;
            color: var(--blue);
            font-weight: 400;
            max-width: 340px;
            line-height: 1.65;
        }

        .hero-text{
    margin-top:auto;
    position:relative;
    z-index:3;
    padding-bottom:180px;
    max-width:520px;
}

.cars-wrap{
    position:absolute;
    bottom:0;
    right:0;
    width:min(700px,75%);
    z-index:1;
}

.cars-wrap img{
    width:100%;
    height:auto;
    display:block;
    object-fit:contain;
}

        /* ── RIGHT PANEL ─────────────────────────────── */
        .panel-right {
            flex: 1;
            background: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 52px;
            position: relative;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
        }

        .form-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            margin-bottom: 32px;
        }
        .form-brand svg { width: 64px; height: 42px; }
        .form-brand-name {
            font-family: 'DM Sans', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--navy);
        }
        .form-brand-name span { color: var(--accent); }
        .form-brand-sub {
            font-size: 10px;
            letter-spacing: .22em;
            color: var(--gray);
            text-transform: uppercase;
        }

        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome h2 {
            font-family: 'DM Sans', sans-serif;
            font-size: 20px;
            font-weight: 500;
            color: var(--navy);
        }

        /* ── FORM ELEMENTS ───────────────────────────── */
        .field {
            position: relative;
            margin-bottom: 16px;
        }
        .field input {
            width: 100%;
            padding: 15px 20px;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--navy);
            outline: none;
            background: var(--white);
            transition: border-color .2s, box-shadow .2s;
        }
        .field input::placeholder { color: var(--gray); }
        .field input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
        }
        .field .toggle-pw {
            position: absolute;
            right: 18px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--gray);
            display: flex; align-items: center;
            padding: 0;
        }
        .field .toggle-pw:hover { color: var(--accent); }

        .row-opts {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--navy); cursor: pointer;
            user-select: none;
        }
        .remember input[type="checkbox"] {
            appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: background .2s, border-color .2s;
        }
        .remember input[type="checkbox"]:checked {
            background: var(--accent);
            border-color: var(--accent);
        }
        .remember input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 9px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }
        .forgot {
            font-size: 13px;
            color: var(--navy);
            font-weight: 600;
            text-decoration: none;
        }
        .forgot:hover { color: var(--accent); }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--navy);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: .04em;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 8px 24px rgba(15,32,68,.28);
        }
        .btn-login:hover {
            background: var(--blue);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(15,32,68,.32);
        }
        .btn-login:active { transform: translateY(0); }

        .signup-row {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: var(--gray);
        }
        .signup-row a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
        }
        .signup-row a:hover { text-decoration: underline; }

        /* ── ALERTS (Laravel Blade) ──────────────────── */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }

        /* ── RESPONSIVE ──────────────────────────────── */
        /* ===== TABLET ===== */
@media (max-width: 992px){

    .panel-left{
        padding:40px;
    }

    .hero-text{
        padding-bottom:120px;
    }

    .hero-text h1{
        font-size:40px;
    }

    .cars-wrap{
        width:65%;
        right:0;
        bottom:0;
    }
}

/* ===== MOBILE ===== */
@media (max-width:768px){

    body{
        flex-direction:column;
        overflow:auto;
    }

    .panel-left{
        flex:none;
        width:100%;
        min-height:auto;
        padding:30px 24px;
    }

    .panel-right{
        width:100%;
        padding:40px 24px;
    }

    .hero-text{
        margin-top:30px;
        padding-bottom:0;
    }

    .hero-text h1{
        font-size:34px;
        line-height:1.2;
    }

    .hero-text p{
        max-width:100%;
    }

    .cars-wrap{
        position:relative;
        width:90%;
        margin:30px auto 0;
        right:auto;
        bottom:auto;
    }

    .cars-wrap img{
        width:100%;
    }

    .dots{
        display:none;
    }

    .brand{
        justify-content:center;
    }
}
    </style>
</head>
<body>

    <!-- ═══════════ LEFT PANEL ═══════════ -->
    <div class="panel-left">
        <!-- dot decoration -->
        <div class="dots">
            @for($i = 0; $i < 30; $i++)
                <span></span>
            @endfor
        </div>

        <!-- Brand -->
        <div class="brand">
            <svg viewBox="0 0 64 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="8" y="18" width="48" height="14" rx="4" stroke="#0f2044" stroke-width="2"/>
                <path d="M14 18 L18 8 H46 L50 18" stroke="#0f2044" stroke-width="2" fill="none"/>
                <circle cx="18" cy="34" r="5" stroke="#0f2044" stroke-width="2"/>
                <circle cx="46" cy="34" r="5" stroke="#0f2044" stroke-width="2"/>
            </svg>
            <div class="brand-name">
                <span>SAYAARARENT</span>
                <span>Sewa Mobil Premium</span>
            </div>
        </div>

        <!-- Hero text -->
        <div class="hero-text">
            <h1>Standar Baru dalam<br>Sewa Mobil:<br><span class="accent">Layanan Premium.</span></h1>
            <p>Pilih kendaraan impian Anda dan nikmati pengalaman berkendara yang tak terlupakan bersama SayaaraRent.</p>
        </div>

        <!-- Car illustration placeholder -->
        <div class="cars-wrap">
            {{-- Ganti src dengan path asset mobil Anda --}}
            <img src="{{ asset('images/cars-hero.png') }}" alt="Premium Cars" onerror="this.style.display='none'">
        </div>
    </div>

    <!-- ═══════════ RIGHT PANEL ═══════════ -->
    <div class="panel-right">
        <div class="form-box">

            <!-- Brand mark -->
            <div class="form-brand">
                <svg viewBox="0 0 64 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="18" width="48" height="14" rx="4" stroke="#0f2044" stroke-width="2"/>
                    <path d="M14 18 L18 8 H46 L50 18" stroke="#0f2044" stroke-width="2" fill="none"/>
                    <circle cx="18" cy="34" r="5" stroke="#0f2044" stroke-width="2"/>
                    <circle cx="46" cy="34" r="5" stroke="#0f2044" stroke-width="2"/>
                </svg>
                <div class="form-brand-name">Sayaara<span>Rent</span></div>
                <div class="form-brand-sub">Premium Car Rentals</div>
            </div>

            <!-- Welcome -->
            <div class="welcome">
                <h2>Welcome to Your Premium Journey</h2>
            </div>

            {{-- Session / validation errors --}}
            @if ($errors->any())
            <div class="alert alert-error">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $errors->first() }}
            </div>
            @endif

            @if (session('status'))
            <div class="alert alert-success">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('status') }}
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <input
                        type="text"
                        name="email"
                        placeholder="Username or Email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="field">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        id="passwordInput"
                        autocomplete="current-password"
                        required
                    >
                    <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Toggle password">
                        <svg id="eyeIcon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>

                <div class="row-opts">
                    <label class="remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">Log In</button>
            </form>

            @if (Route::has('register'))
            <p class="signup-row">
                Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
            </p>
            @endif

        </div>
    </div>

    <script>
        function togglePw() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                    <line x1="1" y1="1" x2="23" y2="23"/>
                `;
            }
        }
    </script>

</body>
</html>