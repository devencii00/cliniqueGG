<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Clinique</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
            --success:     #22C55E;
            --input-border:#CBD5E1;
        }

        html, body {
            min-height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--cyan-ice);
            color: var(--ink);
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

        /* ── ACCENT BAR ── */
        .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--cyan-deep), var(--cyan-bright), var(--cyan-mid));
        }

        /* ── NAV ── */
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

        .wordmark-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--cyan-mid), var(--cyan-deep));
            border-radius: 9px;
            display: grid;
            place-items: center;
        }

        .wordmark-icon svg {
            width: 17px; height: 17px;
            fill: none;
            stroke: white;
            stroke-width: 2;
            stroke-linecap: round;
        }

        .wordmark-text {
            font-family: 'Syne', sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.3px;
        }

        .wordmark-text span { color: var(--cyan-mid); }

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

        /* ── MAIN ── */
        .main {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 48px 20px 60px;
            position: relative;
            overflow: hidden;
        }

        .main::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34,211,238,0.07) 0%, transparent 65%);
            top: -250px; right: -200px;
            pointer-events: none;
        }

        .main::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(14,116,144,0.05) 0%, transparent 65%);
            bottom: -100px; left: -100px;
            pointer-events: none;
        }

        /* ── CARD ── */
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
            max-width: 520px;
            overflow: hidden;
        }

        /* ── CARD HEADER ── */
        .card-header {
            background: linear-gradient(135deg, #0C4A6E 0%, #0E7490 60%, #0891B2 100%);
            padding: 36px 40px 32px;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.07);
            top: -100px; right: -80px;
        }

        .card-header::after {
            content: '';
            position: absolute;
            width: 160px; height: 160px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.05);
            bottom: -70px; left: -30px;
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

        /* ── STEP INDICATORS ── */
        .steps-bar {
            display: flex;
            align-items: center;
            gap: 0;
            margin-top: 24px;
            position: relative;
            z-index: 1;
        }

        .step-pip {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
        }

        .step-pip:not(:last-child)::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.18);
            margin: 0 4px;
        }

        .pip-circle {
            width: 24px; height: 24px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .pip-circle.active {
            background: var(--cyan-bright);
            color: var(--cyan-deep);
        }

        .pip-circle.done {
            background: rgba(34,211,238,0.25);
            color: var(--cyan-bright);
        }

        .pip-circle.inactive {
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.35);
        }

        .pip-label {
            font-size: 10px;
            font-weight: 500;
            color: rgba(255,255,255,0.45);
            white-space: nowrap;
        }

        .pip-label.active { color: rgba(255,255,255,0.85); }

        /* ── CARD BODY ── */
        .card-body {
            padding: 36px 40px 40px;
        }

        /* ── ALERT ── */
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

        /* ── SECTION LABEL ── */
        .field-section {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--cyan-mid);
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #F1F5F9;
        }

        /* ── FORM ROW (2-col) ── */
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ── FORM GROUP ── */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }

        .form-group:last-child { margin-bottom: 0; }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: 0.1px;
        }

        /* ── INPUT ── */
        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .input-icon svg {
            width: 15px; height: 15px;
            fill: none;
            stroke: var(--ink-muted);
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 11px 13px 11px 40px;
            border: 1.5px solid var(--input-border);
            border-radius: 11px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
            -webkit-appearance: none;
        }

        .form-input::placeholder { color: var(--ink-muted); font-size: 13px; }

        .form-input:focus {
            border-color: var(--cyan-mid);
            box-shadow: 0 0 0 3px rgba(8,145,178,0.12);
        }

        .form-input.is-error {
            border-color: var(--danger);
        }

        .form-input.is-error:focus {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }

        /* password toggle */
        .has-toggle .form-input { padding-right: 40px; }

        .input-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--ink-muted);
            display: flex;
            padding: 2px;
            transition: color 0.15s;
        }

        .input-toggle:hover { color: var(--cyan-mid); }

        .input-toggle svg {
            width: 15px; height: 15px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── PASSWORD STRENGTH ── */
        .strength-wrap {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 8px;
        }

        .strength-bars {
            display: flex;
            gap: 4px;
        }

        .strength-bar {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: #E2E8F0;
            transition: background 0.25s;
        }

        .strength-bar.weak   { background: #EF4444; }
        .strength-bar.fair   { background: #F59E0B; }
        .strength-bar.good   { background: #22C55E; }
        .strength-bar.strong { background: var(--cyan-mid); }

        .strength-label {
            font-size: 11px;
            color: var(--ink-muted);
        }

        /* ── SPACER ── */
        .section-gap { margin-bottom: 28px; }
        .section-gap-sm { margin-bottom: 20px; }

        /* ── TERMS ── */
        .terms-wrap {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 28px;
            padding: 14px 16px;
            background: var(--cyan-ice);
            border: 1px solid #E0F7FA;
            border-radius: 11px;
        }

        .terms-wrap input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: var(--cyan-mid);
            cursor: pointer;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .terms-text {
            font-size: 12px;
            color: var(--ink-soft);
            line-height: 1.6;
        }

        .terms-text a {
            color: var(--cyan-mid);
            font-weight: 500;
            text-decoration: none;
        }

        .terms-text a:hover { color: var(--cyan-deep); }

        /* ── SUBMIT ── */
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
            transition: transform 0.2s, box-shadow 0.2s;
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

        /* ── DIVIDER + LOGIN LINK ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
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

        .login-prompt {
            text-align: center;
            font-size: 13px;
            color: var(--ink-muted);
        }

        .login-prompt a {
            color: var(--cyan-mid);
            font-weight: 600;
            text-decoration: none;
        }

        .login-prompt a:hover { color: var(--cyan-deep); }

        /* ── FOOTER ── */
        .page-footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: var(--ink-muted);
            border-top: 1px solid #E2E8F0;
            background: var(--white);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 540px) {
            .nav { padding: 16px 20px; }
            .card-header { padding: 28px 24px 24px; }
            .card-body { padding: 28px 20px 32px; }
            .main { padding: 32px 14px 48px; }
            .form-row-2 { grid-template-columns: 1fr; }
            .steps-bar { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .btn-submit:hover { transform: none; }
        }
    </style>
</head>
<body>

<div class="page">

    <div class="accent-bar"></div>

    <!-- Nav -->
    <nav class="nav">
        <a href="{{ route('landing') }}" class="wordmark">
            <div class="wordmark-icon">
                <svg viewBox="0 0 18 18">
                    <path d="M9 2v4M9 12v4M2 9h4M12 9h4"/>
                    <circle cx="9" cy="9" r="2.5"/>
                </svg>
            </div>
            <span class="wordmark-text">Clini<span>que</span></span>
        </a>
        <span class="nav-right">
            Have an account? <a href="{{ route('login') }}">Sign in</a>
        </span>
    </nav>

    <!-- Main -->
    <main class="main">
        <div class="card">

            <!-- Card header -->
            <div class="card-header">
                <div class="card-icon">
                    <svg viewBox="0 0 22 22">
                        <circle cx="10" cy="7" r="3.5"/>
                        <path d="M3 19c0-3.9 3.1-7 7-7s7 3.1 7 7"/>
                        <path d="M16 4v6M13 7h6"/>
                    </svg>
                </div>
                <h1 class="card-title">Create your account</h1>
                <p class="card-subtitle">Join Clinique and skip the physical line</p>

                <!-- Step indicators -->
                <div class="steps-bar">
                    <div class="step-pip">
                        <div class="pip-circle active">1</div>
                        <span class="pip-label active">Personal Info</span>
                    </div>
                    <div class="step-pip">
                        <div class="pip-circle inactive">2</div>
                        <span class="pip-label">Security</span>
                    </div>
                    <div class="step-pip">
                        <div class="pip-circle inactive">3</div>
                        <span class="pip-label">Done</span>
                    </div>
                </div>
            </div>

            <!-- Card body -->
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- ── SECTION 1: Personal Info ── -->
                    <p class="field-section">Personal Information</p>

                    <div class="form-row-2 section-gap-sm">
                        <div class="form-group">
                            <label class="form-label" for="first_name">First name</label>
                            <div class="input-wrap">
                                <span class="input-icon">
                                    <svg viewBox="0 0 16 16">
                                        <circle cx="8" cy="5" r="3"/>
                                        <path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
                                    </svg>
                                </span>
                                <input
                                    id="first_name"
                                    type="text"
                                    name="first_name"
                                    class="form-input @error('first_name') is-error @enderror"
                                    placeholder="Juan"
                                    value="{{ old('first_name') }}"
                                    required
                                    autocomplete="given-name"
                                    autofocus
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="last_name">Last name</label>
                            <div class="input-wrap">
                                <span class="input-icon">
                                    <svg viewBox="0 0 16 16">
                                        <circle cx="8" cy="5" r="3"/>
                                        <path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
                                    </svg>
                                </span>
                                <input
                                    id="last_name"
                                    type="text"
                                    name="last_name"
                                    class="form-input @error('last_name') is-error @enderror"
                                    placeholder="dela Cruz"
                                    value="{{ old('last_name') }}"
                                    required
                                    autocomplete="family-name"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-group section-gap">
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
                                placeholder="juan@example.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <!-- ── SECTION 2: Security ── -->
                    <p class="field-section">Security</p>

                    <div class="form-group section-gap-sm">
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
                                placeholder="Min. 8 characters"
                                required
                                autocomplete="new-password"
                                oninput="checkStrength(this.value)"
                            >
                            <button type="button" class="input-toggle" onclick="togglePw('password','eye1')" aria-label="Show password">
                                <svg id="eye1" viewBox="0 0 16 16">
                                    <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/>
                                    <circle cx="8" cy="8" r="2"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Strength meter -->
                        <div class="strength-wrap" id="strength-wrap" style="display:none;">
                            <div class="strength-bars">
                                <div class="strength-bar" id="sb1"></div>
                                <div class="strength-bar" id="sb2"></div>
                                <div class="strength-bar" id="sb3"></div>
                                <div class="strength-bar" id="sb4"></div>
                            </div>
                            <span class="strength-label" id="strength-label"></span>
                        </div>
                    </div>

                    <div class="form-group section-gap">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <div class="input-wrap has-toggle">
                            <span class="input-icon">
                                <svg viewBox="0 0 16 16">
                                    <rect x="3" y="7" width="10" height="8" rx="1.5"/>
                                    <path d="M5 7V5a3 3 0 0 1 6 0v2"/>
                                </svg>
                            </span>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Re-enter your password"
                                required
                                autocomplete="new-password"
                            >
                            <button type="button" class="input-toggle" onclick="togglePw('password_confirmation','eye2')" aria-label="Show password">
                                <svg id="eye2" viewBox="0 0 16 16">
                                    <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/>
                                    <circle cx="8" cy="8" r="2"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="terms-wrap">
                        <input type="checkbox" id="terms" name="terms" required>
                        <p class="terms-text">
                            By creating an account, you agree to Clinique's
                            <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                            Your data is used only to manage your queue position.
                        </p>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-submit" id="registerSubmitBtn" disabled>
                        <span class="btn-text" id="registerBtnText">
                            <svg viewBox="0 0 16 16">
                                <circle cx="7.5" cy="5" r="2.5"/>
                                <path d="M2 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/>
                                <path d="M12 3v4M10 5h4"/>
                            </svg>
                            Create my account
                        </span>
                        <span class="btn-spinner" id="registerBtnSpinner" style="display:none;">
                            <svg class="spinner" viewBox="0 0 20 20" width="18" height="18">
                                <circle cx="10" cy="10" r="7" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="30 20"/>
                            </svg>
                            Creating account…
                        </span>
                    </button>

                </form>

                <div class="divider">already have an account?</div>

                <p class="login-prompt">
                    <a href="{{ route('login') }}">Sign in instead</a>
                </p>

            </div>
        </div>
    </main>

    <footer class="page-footer">
        &copy; {{ date('Y') }} Clinique — Smart Queue Management System
    </footer>

</div>

<script>
    /* ── Password visibility toggle ── */
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.innerHTML = show
            ? `<path d="M2 2l12 12M6.5 6.6A3 3 0 0 0 8 11a3 3 0 0 0 2.9-2.3"/>
               <path d="M9.9 3.2A7 7 0 0 1 15 8s-.8 1.7-2.2 3M1 8s1.3-3 4-4.2"/>`
            : `<path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z"/>
               <circle cx="8" cy="8" r="2"/>`;
    }

    /* ── Password strength meter ── */
    function checkStrength(val) {
        const wrap  = document.getElementById('strength-wrap');
        const label = document.getElementById('strength-label');
        const bars  = [sb1, sb2, sb3, sb4];

        if (!val.length) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'flex';

        let score = 0;
        if (val.length >= 8)              score++;
        if (/[A-Z]/.test(val))            score++;
        if (/[0-9]/.test(val))            score++;
        if (/[^A-Za-z0-9]/.test(val))     score++;

        const levels = [
            { cls: 'weak',   text: 'Weak — add uppercase, numbers or symbols' },
            { cls: 'fair',   text: 'Fair — getting there' },
            { cls: 'good',   text: 'Good — almost there' },
            { cls: 'strong', text: 'Strong password' },
        ];

        bars.forEach((b, i) => {
            b.className = 'strength-bar' + (i < score ? ' ' + levels[score - 1].cls : '');
        });

        label.textContent = levels[score - 1]?.text ?? '';
        label.style.color = { weak:'#EF4444', fair:'#F59E0B', good:'#22C55E', strong:'#0891B2' }[levels[score-1]?.cls] ?? '#94A3B8';
    }

    // Terms checkbox toggle
    const termsCheck = document.getElementById('terms');
    const submitBtn = document.getElementById('registerSubmitBtn');
    termsCheck.addEventListener('change', function () {
        submitBtn.disabled = !this.checked;
    });

    // Loading state on submit
    document.querySelector('form').addEventListener('submit', function () {
        const btn = document.getElementById('registerSubmitBtn');
        btn.disabled = true;
        document.getElementById('registerBtnText').style.display = 'none';
        document.getElementById('registerBtnSpinner').style.display = 'inline-flex';
    });
</script>

</body>
</html>