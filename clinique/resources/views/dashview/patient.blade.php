<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Clinique — My Queue</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        --border:       #E2E8F0;
        --border-soft:  #E0F7FA;
        --green-bg: #F0FDF4; --green-text: #16A34A; --green-dot:#4ADE80;
    }

    html, body {
        min-height: 100%;
        font-family: 'Inter', sans-serif;
        background: var(--cyan-ice);
        color: var(--ink);
    }

    .page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .main {
        flex: 1;
        max-width: 560px;
        margin: 0 auto;
        padding: 56px 24px 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 28px;
    }

    button { font-family: inherit; }

    :focus-visible { outline: 2px solid var(--cyan-mid); outline-offset: 2px; border-radius: 4px; }

    /* ══════════════════════════════
       TOP BAR
    ══════════════════════════════ */
    .topbar {
        background: var(--white);
        border-bottom: 1px solid var(--border-soft);
        padding: 16px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .wordmark { display: flex; align-items: center; gap: 9px; }
    .wordmark-icon {
        width: 32px; height: 32px;
        background: linear-gradient(145deg, var(--cyan-deep), var(--cyan-mid));
        border-radius: 9px;
        display: grid; place-items: center;
    }
    .wordmark-icon svg { width: 17px; height: 17px; fill: none; stroke: var(--cyan-bright); stroke-width: 2; stroke-linecap: round; }
    .wordmark-text { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); letter-spacing: -0.3px; }
    .wordmark-text span { color: var(--cyan-mid); }

    .topbar-right { display: flex; align-items: center; gap: 10px; }

    .icon-btn {
        width: 36px; height: 36px;
        display: grid; place-items: center;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        cursor: pointer;
        color: var(--ink-soft);
        transition: background 0.15s ease, border-color 0.15s ease;
    }
    .icon-btn:hover { background: var(--cyan-ice); border-color: var(--border-soft); }
    .icon-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

    .profile-chip { display: flex; align-items: center; gap: 9px; padding: 5px 12px 5px 6px; border-radius: 24px; border: 1px solid var(--border); background: var(--white); }
    .avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(145deg, var(--cyan-mid), var(--cyan-deep));
        color: var(--white); font-size: 11px; font-weight: 700;
        display: grid; place-items: center; flex-shrink: 0;
    }
    .profile-meta { line-height: 1.2; }
    .profile-name { font-size: 12.5px; font-weight: 600; color: var(--ink); }
    .profile-role { font-size: 10.5px; color: var(--ink-muted); }

    /* ══════════════════════════════
       MAIN
    ══════════════════════════════ */

    .page-eyebrow { font-size: 10.5px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--cyan-mid); text-align: center; }
    .page-title { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; letter-spacing: -0.7px; color: var(--ink); text-align: center; }
    .page-sub { font-size: 13.5px; color: var(--ink-soft); text-align: center; max-width: 380px; line-height: 1.65; }

    /* ── STATUS CARD ── */
    .status-card {
        width: 100%;
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: 22px;
        padding: 44px 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 22px;
        box-shadow: 0 8px 36px rgba(14,116,144,0.08);
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    /* — empty state — */
    .empty-icon {
        width: 76px; height: 76px;
        border-radius: 50%;
        background: var(--cyan-ice);
        display: grid; place-items: center;
    }
    .empty-icon svg { width: 32px; height: 32px; stroke: var(--cyan-mid); fill: none; stroke-width: 1.6; stroke-linecap: round; stroke-linejoin: round; }
    .empty-heading { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: var(--ink); text-align: center; }
    .empty-text { font-size: 13px; color: var(--ink-soft); text-align: center; max-width: 320px; line-height: 1.6; }

    /* — joined state — */
    .ticket-label { font-size: 10.5px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--ink-muted); }
    .ticket-number { font-family: 'Syne', sans-serif; font-size: 64px; font-weight: 800; color: var(--cyan-deep); line-height: 1; letter-spacing: -2px; }

    .position-pill {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--cyan-ice);
        border: 1px solid var(--border-soft);
        padding: 9px 18px;
        border-radius: 30px;
        font-size: 13.5px; font-weight: 600; color: var(--cyan-deep);
    }
    .position-pill .live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--cyan-bright); animation: pulse-dot 1.6s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.35; transform:scale(0.75); } }

    .meta-row { display: flex; gap: 28px; }
    .meta-item { text-align: center; }
    .meta-value { font-family: 'Syne', sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); }
    .meta-label { font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--ink-muted); margin-top: 3px; }
    .meta-sep { width: 1px; background: var(--border); }

    .auto-note { font-size: 11px; color: var(--ink-muted); display: flex; align-items: center; gap: 6px; }
    .auto-note svg { width: 12px; height: 12px; stroke: var(--ink-muted); fill: none; stroke-width: 1.8; stroke-linecap: round; }

    /* — stepper — */
    .stepper { width: 100%; display: flex; align-items: flex-start; padding: 4px 6px; }
    .step { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; position: relative; }
    .step-dot {
        width: 22px; height: 22px; border-radius: 50%;
        background: var(--border); border: 2px solid var(--border);
        display: grid; place-items: center;
        transition: background 0.3s ease, border-color 0.3s ease;
        z-index: 1;
    }
    .step-dot svg { width: 11px; height: 11px; stroke: var(--white); fill: none; stroke-width: 2.4; stroke-linecap: round; stroke-linejoin: round; opacity: 0; transition: opacity 0.2s ease; }
    .step-line {
        position: absolute; top: 10px; left: -50%; width: 100%; height: 2px;
        background: var(--border); z-index: 0;
    }
    .step:first-child .step-line { display: none; }
    .step-label { font-size: 10.5px; font-weight: 600; color: var(--ink-muted); text-align: center; max-width: 76px; line-height: 1.3; }

    .step.done .step-dot { background: var(--cyan-mid); border-color: var(--cyan-mid); }
    .step.done .step-dot svg { opacity: 1; }
    .step.done .step-line { background: var(--cyan-mid); }
    .step.current .step-dot { background: var(--white); border-color: var(--cyan-mid); box-shadow: 0 0 0 4px var(--cyan-pale); }
    .step.current .step-label { color: var(--cyan-deep); }
    .step.done .step-label { color: var(--ink); }

    /* — now serving strip — */
    .now-serving-strip {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--cyan-ice);
        border: 1px solid var(--border-soft);
        border-radius: 14px;
        padding: 14px 18px;
    }
    .ns-left { display: flex; align-items: center; gap: 12px; }
    .ns-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--white); display: grid; place-items: center; }
    .ns-icon svg { width: 17px; height: 17px; stroke: var(--cyan-mid); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .ns-label { font-size: 10px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase; color: var(--ink-muted); }
    .ns-value { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: var(--ink); margin-top: 1px; }

    /* — your turn state — */
    .turn-card {
        width: 100%;
        background: linear-gradient(150deg, #0C4A6E 0%, #0E7490 55%, #0891B2 100%);
        border-radius: 18px;
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        text-align: center;
        box-shadow: 0 12px 40px rgba(14,116,144,0.30);
    }
    .turn-badge {
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.2);
        color: var(--white);
        font-size: 10.5px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
        padding: 6px 14px; border-radius: 20px;
    }
    .turn-heading { font-family: 'Syne', sans-serif; font-size: 24px; font-weight: 800; color: var(--white); letter-spacing: -0.5px; }
    .turn-sub { font-size: 13px; color: rgba(255,255,255,0.7); max-width: 280px; line-height: 1.6; }

    /* — buttons — */
    .btn {
        display: inline-flex; align-items: center; gap: 9px; justify-content: center;
        padding: 15px 30px; border-radius: 13px;
        font-size: 14.5px; font-weight: 600;
        border: none; cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        white-space: nowrap;
    }
    .btn svg { width: 16px; height: 16px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

    .btn-join {
        background: linear-gradient(135deg, var(--cyan-mid), var(--cyan-deep));
        color: var(--white);
        box-shadow: 0 6px 22px rgba(14,116,144,0.32);
        width: 100%;
        max-width: 280px;
        padding: 16px 30px;
    }
    .btn-join:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(14,116,144,0.40); }

    .btn-leave {
        background: var(--white);
        color: var(--ink-soft);
        border: 1.5px solid var(--border);
    }
    .btn-leave:hover { background: #FEF2F2; border-color: #FECACA; color: #B91C1C; }

    .btn-white {
        background: var(--white);
        color: var(--cyan-deep);
        width: 100%;
        max-width: 240px;
    }
    .btn-white:hover { background: var(--cyan-pale); transform: translateY(-2px); }

    @media (prefers-reduced-motion: reduce) {
        .live-dot, .position-pill .live-dot { animation: none; }
        .btn-join:hover, .btn-white:hover { transform: none; }
    }

    /* ══════════════════════════════
       FOOTER
    ══════════════════════════════ */
    .footer-bar {
        background: var(--white);
        border-top: 1px solid var(--border-soft);
        padding: 18px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        color: var(--ink-muted);
        margin-top: auto;
    }
    .footer-bar strong { font-family: 'Syne', sans-serif; color: var(--ink); font-weight: 700; }

    /* ══════════════════════════════
       RESPONSIVE
    ══════════════════════════════ */
    @media (max-width: 600px) {
        .topbar { padding: 14px 20px; }
        .profile-meta { display: none; }
        .main { padding: 40px 16px 48px; }
        .status-card { padding: 36px 20px; }
        .ticket-number { font-size: 52px; }
        .meta-row { gap: 18px; }
        .footer-bar { flex-direction: column; gap: 6px; text-align: center; padding: 16px 20px; }
        .step-label { font-size: 9.5px; max-width: 58px; }
    }

    /* ── LOADING SPINNER ON BUTTONS ── */
    .btn-loading {
        pointer-events: none !important;
        opacity: 0.7 !important;
    }
    .btn-loading .btn-label { display: none; }
    .btn-loading .btn-spinner { display: inline-flex !important; }
    .btn .btn-spinner { display: none; }
    .spinner { animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ── TOAST ── */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .toast {
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        color: var(--white);
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 260px;
        max-width: 400px;
        animation: slideIn 0.3s ease;
        transition: opacity 0.3s ease;
    }
    .toast-success { background: #16A34A; }
    .toast-error { background: #DC2626; }
    .toast-info { background: var(--cyan-deep); }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
</head>
<body>

<div class="page">

<div class="toast-container" id="toastContainer"></div>

<!-- ═══════════════ TOP BAR ═══════════════ -->
<header class="topbar">
    <div class="wordmark">
        <div class="wordmark-icon">
            <svg viewBox="0 0 18 18"><path d="M9 2v4M9 12v4M2 9h4M12 9h4"/><circle cx="9" cy="9" r="2.5"/></svg>
        </div>
        <span class="wordmark-text">Clini<span>que</span></span>
    </div>
    <div class="topbar-right">
        <button class="icon-btn" title="Notifications" aria-label="Notifications">
            <svg viewBox="0 0 18 18"><path d="M5 7a4 4 0 0 1 8 0c0 2 1 3 1 4H4c0-1 1-2 1-4Z"/><path d="M7.5 13.5a1.5 1.5 0 0 0 3 0"/></svg>
        </button>
        <div class="profile-chip">
            <div class="avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
            <div class="profile-meta">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">Patient</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="icon-btn" title="Log out" aria-label="Log out">
                <svg viewBox="0 0 18 18"><path d="M7 3H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h3"/><path d="M12 12l3-3-3-3M15 9H7"/></svg>
            </button>
        </form>
    </div>
</header>

<!-- ═══════════════ MAIN ═══════════════ -->
<main class="main">

    <div>
        <p class="page-eyebrow">Your queue</p>
        <h1 class="page-title">Track your turn in real time</h1>
       
    </div>

    <!-- STATUS CARD -->
    <div class="status-card" id="statusCard">

        <!-- empty state -->
        <div id="emptyState" style="display:flex;flex-direction:column;align-items:center;gap:18px;">
            <div class="empty-icon">
                <svg viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M9 9h6M9 13h6M9 17h3"/></svg>
            </div>
            <div>
                <div class="empty-heading">You're not in the queue yet</div>
                <p class="empty-text">Tap below to get your queue number. You'll be able to see exactly where you stand in line.</p>
            </div>
            <button class="btn btn-join" id="joinBtn">
                <svg viewBox="0 0 16 16"><circle cx="8" cy="8" r="6.5"/><path d="M8 5v6M5 8h6"/></svg>
                Join Queue
            </button>
        </div>

        <!-- joined / waiting state -->
        <div id="joinedState" style="display:none;flex-direction:column;align-items:center;gap:22px;width:100%;">
            <div style="display:flex;flex-direction:column;align-items:center;gap:6px;">
                <span class="ticket-label">Your queue number</span>
                <span class="ticket-number" id="ticketNumber">#050</span>
                <span class="position-pill"><span class="live-dot"></span><span id="positionText">4th in line</span></span>
            </div>

            <div class="meta-row">
                <div class="meta-item">
                    <div class="meta-value" id="estWaitValue">16 min</div>
                    <div class="meta-label">Est. wait</div>
                </div>
                <div class="meta-sep"></div>
                <div class="meta-item">
                    <div class="meta-value" id="aheadValue">3</div>
                    <div class="meta-label">Ahead of you</div>
                </div>
            </div>

            <div class="stepper" id="stepper">
                <div class="step" data-step="0">
                    <div class="step-line"></div>
                    <div class="step-dot"><svg viewBox="0 0 12 12"><path d="M2 6l3 3 5-6"/></svg></div>
                    <div class="step-label">Joined</div>
                </div>
                <div class="step" data-step="1">
                    <div class="step-line"></div>
                    <div class="step-dot"><svg viewBox="0 0 12 12"><path d="M2 6l3 3 5-6"/></svg></div>
                    <div class="step-label">Waiting</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-line"></div>
                    <div class="step-dot"><svg viewBox="0 0 12 12"><path d="M2 6l3 3 5-6"/></svg></div>
                    <div class="step-label">Almost your turn</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-line"></div>
                    <div class="step-dot"><svg viewBox="0 0 12 12"><path d="M2 6l3 3 5-6"/></svg></div>
                    <div class="step-label">Now serving</div>
                </div>
            </div>

            <div class="now-serving-strip">
                <div class="ns-left">
                    <div class="ns-icon"><svg viewBox="0 0 18 18"><rect x="2" y="4" width="14" height="10" rx="2"/><path d="M6 4V3M12 4V3"/><path d="M2 8h14"/></svg></div>
                    <div>
                        <div class="ns-label">Now Serving</div>
                        <div class="ns-value">#039 · Window 2</div>
                    </div>
                </div>
                <span class="auto-note">
                    <svg viewBox="0 0 14 14"><circle cx="7" cy="7" r="5.5"/><path d="M7 4v3l2 1.5"/></svg>
                    Updates live
                </span>
            </div>

            <button class="btn btn-leave" id="leaveBtn" style="width:100%;">
                <span class="btn-label">
                    <svg viewBox="0 0 16 16"><path d="M6 3H3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h3"/><path d="M11 11l3-3-3-3M14 8H6"/></svg>
                    Leave queue
                </span>
                <span class="btn-spinner">
                    <svg class="spinner" viewBox="0 0 20 20" width="16" height="16"><circle cx="10" cy="10" r="7" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="30 20"/></svg>
                    Leaving…
                </span>
            </button>
        </div>

        <!-- your turn state -->
        <div id="turnState" style="display:none;width:100%;flex-direction:column;align-items:center;gap:18px;">
            <div class="turn-card">
                <span class="turn-badge">It's your turn</span>
                <span class="ticket-number" style="color:var(--white);font-size:48px;" id="turnTicketNumber">#050</span>
                <div class="turn-heading">Please proceed to Window 2</div>
                <p class="turn-sub">Bring a valid ID and your queue number. We're ready for you.</p>
            </div>
            <button class="btn btn-leave" id="doneBtn" style="width:100%;">
                <svg viewBox="0 0 16 16"><path d="M3 8.5l3.5 3.5L13 4"/></svg>
                Done — leave queue
            </button>
        </div>

    </div>
</main>

<footer class="footer-bar">
    <span><strong>Clinique</strong> — Smart Queue System</span>
    <span>Your wait, redefined.</span>
</footer>

</div><!-- /.page -->

<script>
(function () {
    "use strict";

    let pollingHandle = null;

    const emptyState = document.getElementById("emptyState");
    const joinedState = document.getElementById("joinedState");
    const turnState = document.getElementById("turnState");

    const ticketNumber = document.getElementById("ticketNumber");
    const turnTicketNumber = document.getElementById("turnTicketNumber");
    const positionText = document.getElementById("positionText");
    const estWaitValue = document.getElementById("estWaitValue");
    const aheadValue = document.getElementById("aheadValue");
    const stepper = document.getElementById("stepper");
    const nowServingValue = document.querySelector("#joinedState .ns-value");
    const turnServingText = document.querySelector("#turnState .turn-heading");

    const joinBtn = document.getElementById("joinBtn");
    const leaveBtn = document.getElementById("leaveBtn");
    const doneBtn = document.getElementById("doneBtn");
    const toastContainer = document.getElementById("toastContainer");

    function toast(message, type) {
        type = type || 'info';
        var el = document.createElement('div');
        el.className = 'toast toast-' + type;
        el.textContent = message;
        toastContainer.appendChild(el);
        setTimeout(function () {
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 300);
        }, 3000);
    }

    function setLoading(btn, loading) {
        if (!btn) return;
        if (loading) {
            btn.classList.add('btn-loading');
            btn.disabled = true;
        } else {
            btn.classList.remove('btn-loading');
            btn.disabled = false;
        }
    }

    function ordinal(n) {
        var s = ["th", "st", "nd", "rd"], v = n % 100;
        return n + (s[(v - 20) % 10] || s[v] || s[0]);
    }

    function setStage(position) {
        var stage;
        if (position === null || position === undefined) return;
        if (position > 3) stage = 1;
        else if (position > 0) stage = 2;
        else stage = 3;

        stepper.querySelectorAll(".step").forEach(function (step) {
            var idx = Number(step.dataset.step);
            step.classList.remove("done", "current");
            if (idx < stage) step.classList.add("done");
            else if (idx === stage) step.classList.add("current");
        });
    }

    function render(data) {
        if (!data || !data.queue || ['left', 'done'].indexOf(data.queue.status) !== -1) {
            emptyState.style.display = "flex";
            joinedState.style.display = "none";
            turnState.style.display = "none";
            return;
        }

        var q = data.queue;
        var pos = data.position;

        if (q.status === 'called') {
            emptyState.style.display = "none";
            joinedState.style.display = "none";
            turnState.style.display = "flex";
            turnTicketNumber.textContent = '#' + q.queue_number;
            turnServingText.textContent = q.window_number ? 'Please proceed to ' + q.window_number : 'Please proceed to the front desk';
            return;
        }

        emptyState.style.display = "none";
        joinedState.style.display = "flex";
        turnState.style.display = "none";

        ticketNumber.textContent = '#' + q.queue_number;
        positionText.textContent = ordinal(pos) + ' in line';
        aheadValue.textContent = Math.max(0, pos - 1);
        estWaitValue.textContent = (pos * 4) + ' min';
        setStage(pos);

        if (data.now_serving) {
            var ns = data.now_serving;
            nowServingValue.textContent = '#' + ns.queue_number + (ns.window_number ? ' \u00B7 ' + ns.window_number : '');
        }
    }

    function fetchMyQueue() {
        fetch('/queue/my').then(function (r) { return r.json(); }).then(function (data) { render(data); }).catch(function () {});
    }

    function startPolling() {
        stopPolling();
        pollingHandle = setInterval(fetchMyQueue, 5000);
    }

    function stopPolling() {
        if (pollingHandle) { clearInterval(pollingHandle); pollingHandle = null; }
    }

    function joinQueue() {
        setLoading(joinBtn, true);
        fetch('/queue/join', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
            .then(function (r) {
                if (!r.ok) { return r.json().then(function (d) { throw new Error(d.message || 'Failed to join'); }); }
                return r.json();
            })
            .then(function (data) {
                if (data.entry) {
                    toast('Joined queue! Your number is #' + data.entry.queue_number, 'success');
                    fetchMyQueue();
                    startPolling();
                }
            })
            .catch(function (e) { toast(e.message, 'error'); })
            .finally(function () { setLoading(joinBtn, false); });
    }

    function leaveQueue() {
        var btn = this;
        setLoading(btn, true);
        fetch('/queue/leave', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
            .then(function (r) {
                if (!r.ok) { return r.json().then(function (d) { throw new Error(d.message || 'Failed to leave'); }); }
                return r.json();
            })
            .then(function () {
                toast('Left the queue', 'info');
                stopPolling();
                fetchMyQueue();
            })
            .catch(function (e) { toast(e.message, 'error'); })
            .finally(function () { setLoading(btn, false); });
    }

    joinBtn.addEventListener("click", joinQueue);
    leaveBtn.addEventListener("click", leaveQueue);
    doneBtn.addEventListener("click", leaveQueue);

    fetchMyQueue();
    startPolling();
})();
</script>
</body>
</html>