<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinique — Smart Queue System</title>
    <link rel="icon" href="{{ asset('images/weblog.ico') }}" type="image/x-icon">
  
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cyan-deep:    #0E7490;
            --cyan-mid:     #0891B2;
            --cyan-bright:  #22D3EE;
            --cyan-pale:    #CFFAFE;
            --cyan-ice:     #F0FDFF;
            --white:        #FFFFFF;
            --ink:          #0F172A;
            --ink-soft:     #475569;
            --ink-muted:    #94A3B8;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--cyan-ice);
            color: var(--ink);
            overflow-x: hidden;
        }

   
        .top-panel {
            background: linear-gradient(145deg, #0C4A6E 0%, #0E7490 50%, #0891B2 100%);
            min-height: 72vh;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

     
        .top-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

    
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .orb-1 {
            width: 500px; height: 500px;
            background: rgba(34,211,238,0.10);
            top: -160px; right: 10%;
            animation: drift1 9s ease-in-out infinite;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: rgba(8,145,178,0.18);
            bottom: -80px; left: 5%;
            animation: drift2 12s ease-in-out infinite;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: rgba(34,211,238,0.07);
            top: 30%; left: 30%;
            animation: drift1 15s ease-in-out infinite reverse;
        }

        @keyframes drift1 {
            0%,100% { transform: translate(0,0); }
            50%      { transform: translate(-24px, 24px); }
        }
        @keyframes drift2 {
            0%,100% { transform: translate(0,0); }
            50%      { transform: translate(18px, -18px); }
        }

      
        .nav {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 56px;
        }

        .wordmark {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wordmark-logo {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .nav-badge {
            display: flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 11px;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .live-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--cyan-bright);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:0.35; transform:scale(0.75); }
        }

        .hero-body {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px 32px 56px;
        }

        .hero-eyebrow {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--cyan-bright);
            margin-bottom: 20px;
            opacity: 0.85;
        }

        .hero-headline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(42px, 6vw, 74px);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -2px;
            color: var(--white);
            margin-bottom: 20px;
        }

        .hero-headline em {
            font-style: normal;
            color: var(--cyan-bright);
        }

        .hero-sub {
            font-size: 15px;
            line-height: 1.75;
            color: rgba(255,255,255,0.55);
            max-width: 440px;
            margin-bottom: 44px;
        }

   
        .cta-group {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 28px;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.22s ease;
            letter-spacing: 0.1px;
            white-space: nowrap;
        }

        .btn svg {
            width: 15px; height: 15px;
            flex-shrink: 0;
        }

        .btn-primary {
            background: var(--white);
            color: var(--cyan-deep);
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 36px rgba(0,0,0,0.28);
            background: var(--cyan-pale);
        }

        .btn-outline {
            background: rgba(255,255,255,0.08);
            color: var(--white);
            border: 1.5px solid rgba(255,255,255,0.22);
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.14);
            border-color: rgba(255,255,255,0.38);
            transform: translateY(-2px);
        }

        .btn:active { transform: translateY(0); }


        .ticket-strip-wrap {
            position: relative;
            z-index: 20;
            margin-top: -48px;
            padding: 0 56px;
            display: flex;
            justify-content: center;
        }

        .ticket-strip {
            display: flex;
            gap: 16px;
            background: var(--white);
            border-radius: 20px;
            padding: 20px 28px;
            box-shadow:
                0 20px 60px rgba(14,116,144,0.16),
                0 4px 16px rgba(0,0,0,0.08);
            align-items: center;
            width: 100%;
            max-width: 820px;
            border: 1px solid rgba(34,211,238,0.12);
            overflow-x: auto;
        }

        .t-item {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 140px;
        }

        .t-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .t-icon svg {
            width: 18px; height: 18px;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .t-icon.cyan  { background: #ECFEFF; }
        .t-icon.cyan svg  { stroke: var(--cyan-mid); }
        .t-icon.blue  { background: #EFF6FF; }
        .t-icon.blue svg  { stroke: #3B82F6; }
        .t-icon.green { background: #F0FDF4; }
        .t-icon.green svg { stroke: #22C55E; }

        .t-info {}
        .t-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--ink-muted); }
        .t-value { font-size: 15px; font-weight: 600; color: var(--ink); margin-top: 2px; }
        .t-value.live { color: var(--cyan-deep); }

        .t-sep {
            width: 1px;
            height: 40px;
            background: #E2E8F0;
            flex-shrink: 0;
        }

  
        .bottom-panel {
            background: var(--white);
            padding: 80px 56px 72px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 64px;
        }

        .section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--cyan-mid);
            text-align: center;
            margin-bottom: 12px;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(26px, 3.5vw, 38px);
            font-weight: 800;
            color: var(--ink);
            text-align: center;
            letter-spacing: -1px;
            max-width: 480px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            width: 100%;
            max-width: 820px;
        }

        .step-card {
            background: var(--cyan-ice);
            border: 1px solid #E0F7FA;
            border-radius: 16px;
            padding: 28px 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .step-card:hover {
            box-shadow: 0 8px 32px rgba(14,116,144,0.10);
            transform: translateY(-3px);
        }

        .step-num {
            font-family: 'Syne', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--cyan-bright);
        }

        .step-icon {
            width: 44px; height: 44px;
            background: var(--white);
            border-radius: 12px;
            display: grid;
            place-items: center;
            box-shadow: 0 2px 8px rgba(14,116,144,0.10);
        }

        .step-icon svg {
            width: 20px; height: 20px;
            fill: none;
            stroke: var(--cyan-mid);
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .step-heading {
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
        }

        .step-desc {
            font-size: 13px;
            line-height: 1.65;
            color: var(--ink-soft);
        }

      
        .footer-cta {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .footer-cta p {
            font-size: 13px;
            color: var(--ink-muted);
        }

        .footer-cta .cta-group { margin-top: 4px; }

        .btn-footer-primary {
            background: linear-gradient(135deg, var(--cyan-mid), var(--cyan-deep));
            color: var(--white);
            box-shadow: 0 4px 20px rgba(14,116,144,0.28);
        }

        .btn-footer-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(14,116,144,0.40);
        }

        .btn-footer-outline {
            background: var(--white);
            color: var(--ink);
            border: 1.5px solid #E2E8F0;
        }

        .btn-footer-outline:hover {
            border-color: var(--cyan-pale);
            background: var(--cyan-ice);
            color: var(--cyan-deep);
        }

  
        .footer-bar {
            background: var(--cyan-ice);
            border-top: 1px solid #E0F7FA;
            padding: 20px 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--ink-muted);
        }

        .footer-bar strong {
            font-family: 'Syne', sans-serif;
            color: var(--ink);
            font-weight: 700;
        }

        @media (max-width: 860px) {
            .nav, .bottom-panel, .footer-bar { padding-left: 28px; padding-right: 28px; }
            .ticket-strip-wrap { padding: 0 20px; }
            .steps-grid { grid-template-columns: 1fr; max-width: 400px; }
        }

        @media (max-width: 600px) {
            .top-panel { min-height: 80vh; }
            .nav { padding: 20px 20px; }
            .hero-headline { letter-spacing: -1px; }
            .cta-group { flex-direction: column; width: 100%; max-width: 300px; }
            .btn { width: 100%; justify-content: center; }
            .ticket-strip { flex-direction: column; gap: 12px; }
            .t-sep { width: 100%; height: 1px; }
            .bottom-panel { padding: 60px 20px 56px; }
            .footer-bar { flex-direction: column; gap: 6px; text-align: center; }
        }

        @media (prefers-reduced-motion: reduce) {
            .orb, .live-dot { animation: none; }
            .step-card:hover, .btn:hover { transform: none; }
        }
    </style>
</head>
<body>


    <section class="top-panel">

     
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

     
        <nav class="nav">
           <div class="wordmark">
    <img src="{{ asset('images/logo2.png') }}" alt="Clinique logo" style="height: 32px; width: auto;">
    <span class="wordmark-logo">Clinique</span>
</div>

            <div class="nav-badge">
                <span class="live-dot"></span>
                Queue system live
            </div>
        </nav>

  
        <div class="hero-body">
            <p class="hero-eyebrow">Digital Queue Management</p>

            <h1 class="hero-headline">
                Your wait,<br>
                <em>redefined.</em>
            </h1>

            <p class="hero-sub">
                Join the clinic queue digitally, monitor your position in real time,
                and get attended to no physical lines, no guessing.
            </p>

            <div class="cta-group">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h3"/>
                        <path d="M11 11l3-3-3-3M14 8H7"/>
                    </svg>
                    Login to your account
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="7.5" cy="5" r="2.5"/>
                        <path d="M2 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/>
                        <path d="M12 3v4M10 5h4"/>
                    </svg>
                    Create an account
                </a>
            </div>
        </div>

    </section>


    <div class="ticket-strip-wrap">
        <div class="ticket-strip">

            <div class="t-item">
                <div class="t-icon cyan">
                    <svg viewBox="0 0 18 18"><rect x="2" y="4" width="14" height="10" rx="2"/><path d="M6 4V3M12 4V3"/><path d="M2 8h14"/></svg>
                </div>
                <div class="t-info">
                    <div class="t-label">Now Serving</div>
                    <div class="t-value live">#039</div>
                </div>
            </div>

            <div class="t-sep"></div>

            <div class="t-item">
                <div class="t-icon blue">
                    <svg viewBox="0 0 18 18"><circle cx="9" cy="9" r="7"/><path d="M9 5v4l3 2"/></svg>
                </div>
                <div class="t-info">
                    <div class="t-label">Avg. Wait</div>
                    <div class="t-value">~8 min</div>
                </div>
            </div>

            <div class="t-sep"></div>

            <div class="t-item">
                <div class="t-icon green">
                    <svg viewBox="0 0 18 18"><path d="M9 2a5 5 0 0 0 0 10A5 5 0 0 0 9 2z"/><path d="M3 16c0-2.5 2.7-4 6-4s6 1.5 6 4"/></svg>
                </div>
                <div class="t-info">
                    <div class="t-label">In Queue</div>
                    <div class="t-value">12 patients</div>
                </div>
            </div>

            <div class="t-sep"></div>

            <div class="t-item">
                <div class="t-icon cyan">
                    <svg viewBox="0 0 18 18"><rect x="3" y="2" width="12" height="14" rx="2"/><path d="M6 6h6M6 9h6M6 12h4"/></svg>
                </div>
                <div class="t-info">
                    <div class="t-label">Open Windows</div>
                    <div class="t-value">3 of 4</div>
                </div>
            </div>

        </div>
    </div>

 
    <section class="bottom-panel">

   
        <div style="display:flex;flex-direction:column;align-items:center;gap:36px;width:100%;max-width:820px;">
            <div>
                <p class="section-label">How it works</p>
                <h2 class="section-title">Three steps to a smoother visit</h2>
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <span class="step-num">STEP 01</span>
                    <div class="step-icon">
                        <svg viewBox="0 0 20 20">
                            <circle cx="10" cy="6" r="3"/>
                            <path d="M4 17c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
                            <path d="M14 4v4M12 6h4"/>
                        </svg>
                    </div>
                    <div class="step-heading">Create an account</div>
                    <p class="step-desc">Sign up once with your basic details. Your profile is saved for future visits.</p>
                </div>

                <div class="step-card">
                    <span class="step-num">STEP 02</span>
                    <div class="step-icon">
                        <svg viewBox="0 0 20 20">
                            <rect x="3" y="3" width="14" height="14" rx="3"/>
                            <path d="M10 7v6M7 10h6"/>
                        </svg>
                    </div>
                    <div class="step-heading">Join the queue</div>
                    <p class="step-desc">Log in and tap to join. You'll receive a queue number instantly — no paper needed.</p>
                </div>

                <div class="step-card">
                    <span class="step-num">STEP 03</span>
                    <div class="step-icon">
                        <svg viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="7"/>
                            <path d="M10 6v4l3 2"/>
                        </svg>
                    </div>
                    <div class="step-heading">Track your status</div>
                    <p class="step-desc">Watch your position update live. You'll know exactly when it's your turn.</p>
                </div>
            </div>
        </div>

       
        <div class="footer-cta">
            <p class="section-label">Ready to get started?</p>
            <h2 class="section-title" style="font-size:clamp(22px,3vw,30px);">Skip the line. Join Clinique today.</h2>
            <p>Already have an account? Log in and join the queue in seconds.</p>
            <div class="cta-group">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="7.5" cy="5" r="2.5"/><path d="M2 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><path d="M12 3v4M10 5h4"/>
                    </svg>
                    Create an account
                </a>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h3"/><path d="M11 11l3-3-3-3M14 8H7"/>
                    </svg>
                    Login to your account
                </a>
            </div>
        </div>

    </section>


    <footer class="footer-bar">
        <span><strong>Clinique</strong> — Smart Queue System</span>
        <span>Built for efficient, stress-free clinic visits.</span>
    </footer>

</body>
</html>