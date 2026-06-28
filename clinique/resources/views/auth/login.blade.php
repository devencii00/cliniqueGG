<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Clinique</title>
    <link rel="icon" href="{{ asset('images/weblog.ico') }}" type="image/x-icon">

    
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cyan-deep:   #0E7490;
            --cyan-mid:    #0891B2;
            --cyan-bright: #22D3EE;
            --cyan-pale:   #CFFAFE;
            --cyan-ice:    #F0FDFF;
            --white:       #FFFFFF;
            --ink:         #0F172A;
            --ink-soft:    #475569;
            --ink-muted:   #94A3B8;
            --danger:      #EF4444;
            --input-border:#CBD5E1;
            --input-focus: #0891B2;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--cyan-ice);
            color: var(--ink);
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

    
        .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--cyan-deep), var(--cyan-bright), var(--cyan-mid));
        }

   
        .nav {
            background: var(--white);
            border-bottom: 1px solid #F1F5F9;
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .wordmark {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
        }

        .wordmark-logo {
            font-family: 'Syne', sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.3px;
        }

        .nav-right {
            font-size: 13px;
            color: var(--ink-muted);
        }

        .nav-right a {
            color: var(--cyan-mid);
            font-weight: 600;
            text-decoration: none;
        }

        .nav-right a:hover { color: var(--cyan-deep); }

     
        .main {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 20px;
            position: relative;
            overflow: hidden;
        }


        .main::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34,211,238,0.07) 0%, transparent 65%);
            top: -200px; right: -150px;
            pointer-events: none;
        }

        .main::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14,116,144,0.05) 0%, transparent 65%);
            bottom: -150px; left: -100px;
            pointer-events: none;
        }

     
        .card {
            position: relative;
            z-index: 2;
            background: var(--white);
            border-radius: 24px;
            box-shadow:
                0 4px 6px rgba(0,0,0,0.04),
                0 20px 60px rgba(14,116,144,0.10),
                0 0 0 1px rgba(14,116,144,0.06);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }


        .card-header {
            background: linear-gradient(135deg, #0C4A6E 0%, #0E7490 60%, #0891B2 100%);
            padding: 36px 40px 32px;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            width: 260px; height: 260px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.07);
            top: -80px; right: -80px;
            pointer-events: none;
        }

        .card-header::after {
            content: '';
            position: absolute;
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.05);
            bottom: -60px; left: -40px;
            pointer-events: none;
        }

        .card-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 14px;
            display: grid;
            place-items: center;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .card-icon svg {
            width: 22px; height: 22px;
            fill: none;
            stroke: var(--cyan-bright);
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .card-subtitle {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            position: relative;
            z-index: 1;
        }

   
        .card-body {
            padding: 36px 40px 40px;
        }


        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--danger);
        }

        .alert-error ul { padding-left: 16px; }
        .alert-error li { margin-top: 4px; }

  
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: 0.2px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            pointer-events: none;
        }

        .input-icon svg {
            width: 16px; height: 16px;
            fill: none;
            stroke: var(--ink-muted);
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid var(--input-border);
            border-radius: 11px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
            -webkit-appearance: none;
        }

        .form-input::placeholder { color: var(--ink-muted); }

        .form-input:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(8,145,178,0.12);
        }

        .form-input.is-error {
            border-color: var(--danger);
        }

        .form-input.is-error:focus {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }

    
        .input-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 2px;
            color: var(--ink-muted);
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .input-toggle:hover { color: var(--cyan-mid); }

        .input-toggle svg {
            width: 16px; height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

 
        .has-toggle .form-input { padding-right: 42px; }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-wrap input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--cyan-mid);
            cursor: pointer;
            border-radius: 4px;
        }

        .checkbox-label {
            font-size: 13px;
            color: var(--ink-soft);
            user-select: none;
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 500;
            color: var(--cyan-mid);
            text-decoration: none;
            transition: color 0.15s;
        }

        .forgot-link:hover { color: var(--cyan-deep); }

   
        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--cyan-mid) 0%, var(--cyan-deep) 100%);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 20px rgba(14,116,144,0.30);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            letter-spacing: 0.1px;
        }

        .btn-submit svg {
            width: 16px; height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(14,116,144,0.42);
        }

        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none !important; }

        .btn-spinner { display: inline-flex; align-items: center; gap: 8px; }
        .spinner { animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

   
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            font-size: 12px;
            color: var(--ink-muted);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E2E8F0;
        }

        .register-prompt {
            text-align: center;
            font-size: 13px;
            color: var(--ink-muted);
        }

        .register-prompt a {
            color: var(--cyan-mid);
            font-weight: 600;
            text-decoration: none;
        }

        .register-prompt a:hover { color: var(--cyan-deep); }

        .page-footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: var(--ink-muted);
            border-top: 1px solid #E2E8F0;
            background: var(--white);
        }

      
        @media (max-width: 480px) {
            .nav { padding: 16px 20px; }
            .card-header { padding: 28px 24px 24px; }
            .card-body { padding: 28px 24px 32px; }
            .main { padding: 32px 16px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .btn-submit:hover { transform: none; }
        }
    </style>
</head>
<body>

<div class="page">

    <div class="accent-bar"></div>

  
    <nav class="nav">
        <a href="{{ route('landing') }}" class="wordmark">
            <img src="{{ asset('images/logo2.png') }}" alt="Clinique logo" style="height: 32px; width: auto;">
            <span class="wordmark-logo">Clinique</span>
        </a>
        <span class="nav-right">
            No account? <a href="{{ route('register') }}">Sign up</a>
        </span>
    </nav>

    
    <main class="main">
        <div class="card">

      
            <div class="card-header">
                <div class="card-icon">
                    <svg viewBox="0 0 22 22">
                        <path d="M11 2v4M11 14v4M4 11h4M14 11h4"/>
                        <circle cx="11" cy="11" r="3"/>
                    </svg>
                </div>
                <h1 class="card-title">Welcome back</h1>
                <p class="card-subtitle">Sign in to manage your queue position</p>
            </div>

        
            <div class="card-body">

                {{-- Validation errors --}}
                @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Email address</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg viewBox="0 0 16 16">
                                    <rect x="1" y="3" width="14" height="10" rx="2"/>
                                    <path d="M1 5l7 5 7-5"/>
                                </svg>
                            </span>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="form-input @error('email') is-error @enderror"
                                placeholder="you@example.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                            >
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap has-toggle">
                            <span class="input-icon">
                                <svg viewBox="0 0 16 16">
                                    <rect x="3" y="7" width="10" height="8" rx="1.5"/>
                                    <path d="M5 7V5a3 3 0 0 1 6 0v2"/>
                                </svg>
                            </span>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-input @error('password') is-error @enderror"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="input-toggle" onclick="togglePassword()" aria-label="Show password">
                                <svg id="eye-icon" viewBox="0 0 16 16">
                                    <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/>
                                    <circle cx="8" cy="8" r="2"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="form-row">
                        <label class="checkbox-wrap">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkbox-label">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-submit" id="loginSubmitBtn">
                        <span class="btn-text" id="loginBtnText">
                            <svg viewBox="0 0 16 16">
                                <path d="M6 2H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h3"/>
                                <path d="M11 11l3-3-3-3M14 8H7"/>
                            </svg>
                            Sign in to Clinique
                        </span>
                        <span class="btn-spinner" id="loginBtnSpinner" style="display:none;">
                            <svg class="spinner" viewBox="0 0 20 20" width="18" height="18">
                                <circle cx="10" cy="10" r="7" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="30 20"/>
                            </svg>
                            Signing in…
                        </span>
                    </button>

                </form>

                <div class="divider">or</div>

                <p class="register-prompt">
                    Don't have an account? <a href="{{ route('register') }}">Create one</a>
                </p>

            </div>
        </div>
    </main>

    <footer class="page-footer">
        &copy; {{ date('Y') }} Clinique — Smart Queue Management System
    </footer>

</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        const isHidden = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';

        icon.innerHTML = isHidden
            ? `<path d="M2 2l12 12M6.5 6.6A3 3 0 0 0 8 11a3 3 0 0 0 2.9-2.3"/>
               <path d="M9.9 3.2A7 7 0 0 1 15 8s-.8 1.7-2.2 3M1 8s1.3-3 4-4.2"/>`
            : `<path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/>
               <circle cx="8" cy="8" r="2"/>`;
    }

   
    document.querySelector('form').addEventListener('submit', function () {
        const btn = document.getElementById('loginSubmitBtn');
        btn.disabled = true;
        document.getElementById('loginBtnText').style.display = 'none';
        document.getElementById('loginBtnSpinner').style.display = 'inline-flex';
    });
</script>

</body>
</html>