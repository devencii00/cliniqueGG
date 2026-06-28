<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Clinique — Admin · Queue Dashboard</title>
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
        --border:       #E2E8F0;
        --border-soft:  #E0F7FA;

        --amber-bg: #FFF7ED; --amber-text: #C2410C; --amber-dot:#FB923C;
        --serve-bg: #ECFEFF; --serve-text: #0E7490; --serve-dot:#22D3EE;
        --slate-bg: #F1F5F9; --slate-text: #475569; --slate-dot:#94A3B8;
        --red-bg:   #FEF2F2; --red-text:   #B91C1C; --red-dot:#F87171;
        --violet-bg:#F5F3FF; --violet-text:#6D28D9; --violet-dot:#A78BFA;
    }

    html, body {
        min-height: 100%;
        font-family: 'Inter', sans-serif;
        background: var(--cyan-ice);
        color: var(--ink);
    }

    button { font-family: inherit; }
    input, select { font-family: inherit; }

    :focus-visible {
        outline: 2px solid var(--cyan-mid);
        outline-offset: 2px;
        border-radius: 4px;
    }


    .dash-topbar {
        background: var(--white);
        border-bottom: 1px solid var(--border-soft);
        padding: 16px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 30;
    }

    .topbar-left { display: flex; align-items: center; gap: 14px; }

    .wordmark { display: flex; align-items: center; gap: 9px; }
    .wordmark-logo { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; color: var(--ink); letter-spacing: -0.3px; }

    .admin-chip {
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: 0.4px;
        color: var(--cyan-deep);
        background: var(--cyan-pale);
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
    }

    .topbar-right { display: flex; align-items: center; gap: 10px; }

    .live-chip {
        display: flex; align-items: center; gap: 7px;
        font-size: 11.5px; font-weight: 500; color: var(--ink-soft);
        padding: 6px 12px; border-radius: 20px;
        background: var(--cyan-ice);
        border: 1px solid var(--border-soft);
    }
    .live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--cyan-mid); animation: pulse-dot 2s ease-in-out infinite; }
    @keyframes pulse-dot { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.35; transform:scale(0.75); } }

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

    .profile-chip {
        display: flex; align-items: center; gap: 9px;
        padding: 5px 12px 5px 6px;
        border-radius: 24px;
        border: 1px solid var(--border);
        cursor: pointer;
        background: var(--white);
    }
    .avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: linear-gradient(145deg, var(--cyan-mid), var(--cyan-deep));
        color: var(--white);
        font-size: 11px; font-weight: 700;
        display: grid; place-items: center;
        flex-shrink: 0;
    }
    .profile-meta { line-height: 1.2; }
    .profile-name { font-size: 12.5px; font-weight: 600; color: var(--ink); }
    .profile-role { font-size: 10.5px; color: var(--ink-muted); }


    .dash-main {
        max-width: 1180px;
        margin: 0 auto;
        padding: 40px 40px 80px;
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .page-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }

    .page-eyebrow {
        font-size: 10.5px; font-weight: 700; letter-spacing: 2.5px;
        text-transform: uppercase; color: var(--cyan-mid); margin-bottom: 8px;
    }
    .page-title {
        font-family: 'Syne', sans-serif; font-size: 30px; font-weight: 800;
        letter-spacing: -0.8px; color: var(--ink); margin-bottom: 8px;
    }
    .page-sub { font-size: 13.5px; color: var(--ink-soft); max-width: 460px; line-height: 1.6; }

    .btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 12px 20px; border-radius: 11px;
        font-size: 13.5px; font-weight: 600;
        border: none; cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        white-space: nowrap;
    }
    .btn svg { width: 15px; height: 15px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

    .btn-history {
        background: linear-gradient(135deg, var(--cyan-mid), var(--cyan-deep));
        color: var(--white);
        box-shadow: 0 4px 18px rgba(14,116,144,0.28);
    }
    .btn-history:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(14,116,144,0.36); }


    .stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 42px; height: 42px;
        border-radius: 11px;
        display: grid; place-items: center;
        flex-shrink: 0;
    }
    .stat-icon svg { width: 19px; height: 19px; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .stat-icon.cyan { background: #ECFEFF; } .stat-icon.cyan svg { stroke: var(--cyan-mid); }
    .stat-icon.amber { background: #FFF7ED; } .stat-icon.amber svg { stroke: #EA580C; }
    .stat-icon.blue { background: #EFF6FF; } .stat-icon.blue svg { stroke: #3B82F6; }
    .stat-icon.green { background: #F0FDF4; } .stat-icon.green svg { stroke: #22C55E; }

    .stat-label { font-size: 10.5px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--ink-muted); }
    .stat-value { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800; color: var(--ink); margin-top: 3px; line-height: 1; }
    .stat-note { font-size: 11px; color: var(--ink-muted); margin-top: 4px; }
    .stat-value.live { color: var(--cyan-deep); display: flex; align-items: center; gap: 7px; }
    .stat-value.live .live-dot-sm { width: 7px; height: 7px; border-radius: 50%; background: var(--cyan-bright); animation: pulse-dot 1.6s ease-in-out infinite; }


    .queue-panel {
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: 18px;
        padding: 26px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .panel-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .panel-title { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; color: var(--ink); }
    .result-count { font-size: 12px; color: var(--ink-muted); font-weight: 500; }

    .controls-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        min-width: 220px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--cyan-ice);
        border: 1px solid var(--border-soft);
        border-radius: 11px;
        padding: 10px 14px;
    }
    .search-box svg { width: 15px; height: 15px; stroke: var(--ink-muted); fill: none; stroke-width: 1.8; stroke-linecap: round; flex-shrink: 0; }
    .search-box input {
        flex: 1; border: none; background: transparent; outline: none;
        font-size: 13.5px; color: var(--ink);
    }
    .search-box input::placeholder { color: var(--ink-muted); }

    .filter-group { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }

    .today-check {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 500; color: var(--ink-soft);
        cursor: pointer; user-select: none;
    }
    .today-check input { accent-color: var(--cyan-mid); width: 14px; height: 14px; }

    .select-wrap {
        position: relative;
    }
    .select-wrap select {
        appearance: none;
        border: 1px solid var(--border);
        background: var(--white);
        border-radius: 11px;
        padding: 10px 32px 10px 14px;
        font-size: 13px;
        font-weight: 500;
        color: var(--ink-soft);
        cursor: pointer;
        min-width: 150px;
    }
    .select-wrap::after {
        content: '';
        position: absolute;
        right: 13px; top: 50%;
        width: 7px; height: 7px;
        border-right: 1.6px solid var(--ink-muted);
        border-bottom: 1.6px solid var(--ink-muted);
        transform: translateY(-65%) rotate(45deg);
        pointer-events: none;
    }

   
    .table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid var(--border-soft); }

    table { width: 100%; border-collapse: collapse; min-width: 760px; }

    thead th {
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--ink-muted);
        background: var(--cyan-ice);
        padding: 13px 16px;
        border-bottom: 1px solid var(--border-soft);
        white-space: nowrap;
        cursor: pointer;
        user-select: none;
        transition: color 0.15s ease;
    }
    thead th:hover { color: var(--cyan-deep); }
    thead th.actions-col { cursor: default; }
    thead th.actions-col:hover { color: var(--ink-muted); }

    .th-inner { display: flex; align-items: center; gap: 6px; }
    .sort-arrow {
        width: 9px; height: 9px;
        opacity: 0.25;
        transition: opacity 0.15s ease, transform 0.15s ease;
        stroke: var(--cyan-deep); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }
    thead th.sorted-asc .sort-arrow { opacity: 1; transform: rotate(0deg); }
    thead th.sorted-desc .sort-arrow { opacity: 1; transform: rotate(180deg); }

    tbody td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: var(--ink);
        border-bottom: 1px solid var(--border-soft);
        white-space: nowrap;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr { transition: background 0.12s ease; }
    tbody tr:hover { background: var(--cyan-ice); }

    .queue-num { font-family: 'Syne', sans-serif; font-weight: 700; color: var(--cyan-deep); }
    .patient-cell { display: flex; align-items: center; gap: 10px; }
    .patient-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: var(--cyan-pale); color: var(--cyan-deep);
        font-size: 10.5px; font-weight: 700;
        display: grid; place-items: center; flex-shrink: 0;
    }
    .patient-name { font-weight: 500; }
    .patient-id { font-size: 11px; color: var(--ink-muted); }

    .badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11.5px; font-weight: 600;
        padding: 5px 11px; border-radius: 20px;
    }
    .badge .dot { width: 6px; height: 6px; border-radius: 50%; }
    .badge.waiting   { background: var(--amber-bg);  color: var(--amber-text); }
    .badge.waiting .dot { background: var(--amber-dot); }
    .badge.serving   { background: var(--serve-bg);  color: var(--serve-text); }
    .badge.serving .dot { background: var(--serve-dot); animation: pulse-dot 1.6s ease-in-out infinite; }
    .badge.completed { background: var(--slate-bg);  color: var(--slate-text); }
    .badge.completed .dot { background: var(--slate-dot); }
    .badge.no-show   { background: var(--red-bg);    color: var(--red-text); }
    .badge.no-show .dot { background: var(--red-dot); }
    .badge.skipped   { background: var(--violet-bg); color: var(--violet-text); }
    .badge.skipped .dot { background: var(--violet-dot); }

    .muted-cell { color: var(--ink-muted); }

    .row-actions { display: flex; gap: 6px; }
    .row-actions button {
        width: 30px; height: 30px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--white);
        display: grid; place-items: center;
        cursor: pointer;
        color: var(--ink-soft);
        transition: background 0.15s ease, border-color 0.15s ease;
    }
    .row-actions button:hover { background: var(--cyan-ice); border-color: var(--border-soft); color: var(--cyan-deep); }
    .row-actions button:disabled { opacity: 0.35; cursor: not-allowed; }
    .row-actions button:disabled:hover { background: var(--white); border-color: var(--border); color: var(--ink-soft); }
    .row-actions svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--ink-muted);
        font-size: 13.5px;
    }

 
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(15,23,42,0.48);
        display: flex; align-items: center; justify-content: center;
        padding: 24px;
        opacity: 0; visibility: hidden;
        transition: opacity 0.2s ease;
        z-index: 100;
    }
    .modal-overlay.open { opacity: 1; visibility: visible; }

    .modal-card {
        background: var(--white);
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        max-height: 86vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 30px 80px rgba(15,23,42,0.30);
        transform: translateY(14px) scale(0.98);
        transition: transform 0.2s ease;
    }
    .modal-overlay.open .modal-card { transform: translateY(0) scale(1); }

    .modal-head {
        display: flex; align-items: flex-start; justify-content: space-between;
        padding: 24px 26px 0;
    }
    .modal-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--cyan-mid); margin-bottom: 6px; }
    .modal-head h3 { font-family: 'Syne', sans-serif; font-size: 19px; font-weight: 800; color: var(--ink); letter-spacing: -0.4px; }

    .modal-close {
        width: 32px; height: 32px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--white);
        font-size: 17px; line-height: 1;
        color: var(--ink-soft);
        cursor: pointer;
        display: grid; place-items: center;
        flex-shrink: 0;
    }
    .modal-close:hover { background: var(--cyan-ice); }

    .modal-body { padding: 20px 26px 4px; overflow-y: auto; flex: 1; }

    .filter-form { display: flex; flex-direction: column; gap: 16px; }

    .form-row { display: flex; gap: 12px; }
    .form-row label {
        flex: 1;
        font-size: 11px; font-weight: 600; color: var(--ink-soft);
        display: flex; flex-direction: column; gap: 6px;
    }
    .form-row input[type="date"] {
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 9px 12px;
        font-size: 13px;
        color: var(--ink);
    }

    .field-label { font-size: 11px; font-weight: 600; color: var(--ink-soft); margin-bottom: 8px; display: block; }

    .status-checks { display: flex; flex-wrap: wrap; gap: 8px; }
    .check-pill {
        display: inline-flex; align-items: center; gap: 7px;
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 7px 13px;
        font-size: 12px; font-weight: 500; color: var(--ink-soft);
        cursor: pointer;
        user-select: none;
        transition: border-color 0.15s ease, background 0.15s ease;
    }
    .check-pill input { accent-color: var(--cyan-mid); }
    .check-pill:has(input:checked) { background: var(--cyan-ice); border-color: var(--border-soft); color: var(--cyan-deep); }

    .btn-generate {
        background: linear-gradient(135deg, var(--cyan-mid), var(--cyan-deep));
        color: var(--white);
        justify-content: center;
        box-shadow: 0 4px 16px rgba(14,116,144,0.26);
    }
    .btn-generate:hover { transform: translateY(-1px); }

    .report-placeholder {
        margin-top: 18px;
        border: 1.5px dashed var(--border);
        border-radius: 14px;
        padding: 30px 20px;
        text-align: center;
        color: var(--ink-muted);
        font-size: 12.5px;
        display: flex; flex-direction: column; align-items: center; gap: 10px;
    }
    .report-placeholder svg { width: 26px; height: 26px; stroke: var(--ink-muted); fill: none; stroke-width: 1.6; stroke-linecap: round; stroke-linejoin: round; }

    .report-results { margin-top: 18px; display: flex; flex-direction: column; gap: 16px; }
    .report-meta { font-size: 11.5px; color: var(--ink-muted); }
    .report-meta strong { color: var(--ink); font-weight: 600; }

    .report-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
    .report-stat {
        background: var(--cyan-ice);
        border: 1px solid var(--border-soft);
        border-radius: 12px;
        padding: 12px;
        text-align: center;
    }
    .report-stat .rs-value { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; color: var(--cyan-deep); }
    .report-stat .rs-label { font-size: 9.5px; font-weight: 600; letter-spacing: 0.6px; text-transform: uppercase; color: var(--ink-muted); margin-top: 3px; }

    .report-table-wrap { border: 1px solid var(--border-soft); border-radius: 12px; overflow: hidden; max-height: 220px; overflow-y: auto; }
    .report-table-wrap table { min-width: 0; }
    .report-table-wrap thead th { position: sticky; top: 0; font-size: 9.5px; padding: 9px 12px; cursor: default; }
    .report-table-wrap thead th:hover { color: var(--ink-muted); }
    .report-table-wrap tbody td { padding: 9px 12px; font-size: 12.5px; }

    .modal-foot {
        display: flex; justify-content: flex-end; gap: 10px;
        padding: 18px 26px 24px;
        border-top: 1px solid var(--border-soft);
        margin-top: 4px;
    }
    .btn-foot-outline {
        background: var(--white); color: var(--ink-soft);
        border: 1.5px solid var(--border);
    }
    .btn-foot-outline:hover { background: var(--cyan-ice); border-color: var(--border-soft); }
    .btn-foot-export {
        background: var(--cyan-ice);
        color: var(--cyan-deep);
        border: 1px solid var(--border-soft);
    }
    .btn-foot-export:disabled { opacity: 0.5; cursor: not-allowed; }

  
    .pagination {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 20px 0 4px;
    }
    .page-btn {
        min-width: 32px; height: 32px; padding: 0 8px;
        border: 1px solid var(--border); border-radius: 8px;
        background: var(--white); color: var(--ink-soft);
        font-size: 12px; font-weight: 500; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s;
    }
    .page-btn:hover:not(:disabled) { border-color: var(--cyan-mid); color: var(--cyan-deep); }
    .page-btn:disabled { opacity: 0.4; cursor: default; }
    .page-btn.active { background: var(--cyan-deep); border-color: var(--cyan-deep); color: var(--white); }
    .page-info { font-size: 12px; color: var(--ink-muted); margin: 0 8px; }

    @media (max-width: 980px) {
        .stat-row { grid-template-columns: repeat(2, 1fr); }
        .report-stats { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 720px) {
        .dash-topbar { padding: 14px 20px; }
        .profile-meta { display: none; }
        .dash-main { padding: 28px 18px 60px; }
        .page-head { flex-direction: column; align-items: stretch; }
        .btn-history { justify-content: center; }
        .queue-panel { padding: 18px; }
        .form-row { flex-direction: column; }
    }

    @media (max-width: 480px) {
        .stat-row { grid-template-columns: 1fr; }
        .live-chip span:last-child { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .live-dot, .live-dot-sm, .badge.serving .dot { animation: none; }
        .btn-history:hover, .btn-generate:hover { transform: none; }
    }


    .btn-loading {
        pointer-events: none !important;
        opacity: 0.7 !important;
    }
    .btn-loading .btn-label { display: none; }
    .btn-loading .btn-spinner { display: inline-flex !important; }
    .btn .btn-spinner { display: none; }
    .spinner { animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

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
@vite('resources/js/app.js')
</head>
<body>

<div class="toast-container" id="toastContainer"></div>

<header class="dash-topbar">
    <div class="topbar-left">
        <div class="wordmark">
            <img src="{{ asset('images/logo2.png') }}" alt="Clinique logo" style="height: 32px; width: auto;">
            <span class="wordmark-logo">Clinique</span>
        </div>
        <span class="admin-chip">Admin</span>
    </div>

    <div class="topbar-right">
        <span class="live-chip"><span class="live-dot"></span><span>Queue syncing live</span></span>
        <div class="profile-chip">
            <div class="avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
            <div class="profile-meta">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-role">Front desk admin</div>
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

<main class="dash-main">

    <div class="page-head">
        <div>
            <p class="page-eyebrow">Queue overview</p>
            <h1 class="page-title">Today's queue at a glance</h1>
            <p class="page-sub">Monitor live status, manage entries, and pull a history report whenever you need one.</p>
        </div>
        <button class="btn btn-history" id="openHistoryBtn">
            <svg viewBox="0 0 16 16"><rect x="2" y="3" width="12" height="11" rx="2"/><path d="M5 1.5v3M11 1.5v3M2 7h12"/></svg>
            Generate Queue History
        </button>
        <a href="{{ route('public.queue') }}" class="btn btn-history" target="_blank" style="text-decoration:none;">
            <svg viewBox="0 0 16 16"><path d="M2 4.5h12M2 8h12M2 11.5h8"/></svg>
            Public Queue Display
        </a>
    </div>

    <section class="stat-row">
        <div class="stat-card">
            <div class="stat-icon cyan"><svg viewBox="0 0 18 18"><rect x="2" y="4" width="14" height="10" rx="2"/><path d="M6 4V3M12 4V3"/><path d="M2 8h14"/></svg></div>
            <div>
                <div class="stat-label">Now Serving</div>
                <div class="stat-value live"><span class="live-dot-sm"></span>-</div>
                <div class="stat-note">+1 more at W-3</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><svg viewBox="0 0 18 18"><path d="M9 2a5 5 0 0 0 0 10A5 5 0 0 0 9 2z"/><path d="M3 16c0-2.5 2.7-4 6-4s6 1.5 6 4"/></svg></div>
            <div>
                <div class="stat-label">Waiting</div>
                <div class="stat-value"> 0 patients</div>
                <div class="stat-note">0 joined in the last 0 min</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><svg viewBox="0 0 18 18"><circle cx="9" cy="9" r="7"/><path d="M9 5v4l3 2"/></svg></div>
            <div>
                <div class="stat-label">Avg. Wait</div>
                <div class="stat-value">~0 min</div>
                <div class="stat-note">Across all waiting entries</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><svg viewBox="0 0 18 18"><rect x="3" y="2" width="12" height="14" rx="2"/><path d="M6 6h6M6 9h6M6 12h4"/></svg></div>
            <div>
                <div class="stat-label">Open Windows</div>
                <div class="stat-value">3 of 4</div>
                <div class="stat-note">W-4 currently idle</div>
            </div>
        </div>
    </section>


    <section class="queue-panel">
        <div class="panel-head">
            <h2 class="panel-title">Live Queue</h2>
            <span class="result-count" id="resultCount">16 entries</span>
        </div>

        <div class="controls-row">
            <div class="search-box">
                <svg viewBox="0 0 18 18"><circle cx="8" cy="8" r="5.5"/><path d="M16 16l-3.5-3.5"/></svg>
                <input type="text" id="searchInput" placeholder="Search by patient name or queue number">
            </div>
            <div class="filter-group">
                <div class="select-wrap">
                    <select id="statusFilter">
                        <option value="all">All statuses</option>
                        <option value="Waiting">Waiting</option>
                        <option value="Serving">Serving</option>
                        <option value="Completed">Completed</option>
                        <option value="Left">Left</option>
                    </select>
                </div>
                <div class="select-wrap">
                    <select id="windowFilter">
                        <option value="all">All windows</option>
                        <option value="W-1">W-1</option>
                        <option value="W-2">W-2</option>
                        <option value="W-3">W-3</option>
                        <option value="W-4">W-4</option>
                        <option value="Unassigned">Unassigned</option>
                    </select>
                </div>
                <label class="today-check">
                    <input type="checkbox" id="todayCheck" checked>
                    <span>Show today only</span>
                </label>
            </div>
        </div>

        <div class="table-wrap">
            <table id="queueTable">
                <thead>
                    <tr>
                        <th data-key="number"><span class="th-inner">Queue # <svg class="sort-arrow" viewBox="0 0 10 10"><path d="M2 6l3-3 3 3"/></svg></span></th>
                        <th data-key="name"><span class="th-inner">Patient <svg class="sort-arrow" viewBox="0 0 10 10"><path d="M2 6l3-3 3 3"/></svg></span></th>
                        <th data-key="status"><span class="th-inner">Status <svg class="sort-arrow" viewBox="0 0 10 10"><path d="M2 6l3-3 3 3"/></svg></span></th>
                        <th data-key="window"><span class="th-inner">Window <svg class="sort-arrow" viewBox="0 0 10 10"><path d="M2 6l3-3 3 3"/></svg></span></th>
                        <th data-key="joined"><span class="th-inner">Joined <svg class="sort-arrow" viewBox="0 0 10 10"><path d="M2 6l3-3 3 3"/></svg></span></th>
                        <th data-key="wait"><span class="th-inner">Wait <svg class="sort-arrow" viewBox="0 0 10 10"><path d="M2 6l3-3 3 3"/></svg></span></th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody id="queueTableBody"></tbody>
            </table>
        </div>
        <p class="empty-state" id="emptyState" hidden>No matching queue entries. Try a different search or filter.</p>

        <div class="pagination" id="pagination"></div>
    </section>

</main>

<div class="modal-overlay" id="historyModalOverlay">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="historyTitle">
        <div class="modal-head">
            <div>
                <p class="modal-eyebrow">Reporting</p>
                <h3 id="historyTitle">Generate Queue History</h3>
            </div>
            <button class="modal-close" id="closeHistoryBtnX" aria-label="Close dialog">×</button>
        </div>

        <div class="modal-body">
            <div class="filter-form">
                <div class="form-row">
                    <label>From date
                        <input type="date" id="fromDate">
                    </label>
                    <label>To date
                        <input type="date" id="toDate">
                    </label>
                </div>

                <div>
                    <span class="field-label">Include statuses</span>
                    <div class="status-checks" id="statusChecks">
                        <label class="check-pill"><input type="checkbox" value="Waiting" checked> Waiting</label>
                        <label class="check-pill"><input type="checkbox" value="Serving" checked> Serving</label>
                        <label class="check-pill"><input type="checkbox" value="Completed" checked> Completed</label>
                        <label class="check-pill"><input type="checkbox" value="Left" checked> Left</label>
                    </div>
                </div>

                <button class="btn btn-generate" id="generateBtn">
                    <svg viewBox="0 0 16 16"><path d="M8 2v8M4 6l4-4 4 4"/><path d="M2 11v2a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2"/></svg>
                    Generate report
                </button>
            </div>

            <div class="report-placeholder" id="reportPlaceholder">
                <svg viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
                Set your filters and generate a report to see results here.
            </div>

            <div class="report-results" id="reportResults" hidden>
                <p class="report-meta" id="reportMeta"></p>
                <div class="report-stats" id="reportStats"></div>
                <div class="report-table-wrap">
                    <table>
                        <thead>
                            <tr><th>Queue #</th><th>Patient</th><th>Status</th><th>Window</th><th>Joined</th><th>Wait</th></tr>
                        </thead>
                        <tbody id="reportTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-foot">
            <button class="btn btn-foot-outline" id="closeHistoryBtn">Close</button>
            <button class="btn btn-foot-export" id="exportBtn" disabled title="Generate a report first">
                <svg viewBox="0 0 16 16"><path d="M8 10V2M5 5l3-3 3 3"/><path d="M2 11v2a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2"/></svg>
                Export CSV
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    "use strict";

    var allData = [];
    var queueData = [];
    var state = { search: "", status: "all", win: "all", sortKey: "number", sortDir: "asc", page: 1 };
    var PER_PAGE = 20;

    var tbody = document.getElementById("queueTableBody");
    var resultCount = document.getElementById("resultCount");
    var emptyStateEl = document.getElementById("emptyState");
    var table = document.getElementById("queueTable");
    var paginationEl = document.getElementById("pagination");

    var statNowServing = document.querySelector(".stat-row .stat-card:first-child .stat-value");
    var statNowServingNote = document.querySelector(".stat-row .stat-card:first-child .stat-note");
    var statWaiting = document.querySelector(".stat-row .stat-card:nth-child(2) .stat-value");
    var statWaitingNote = document.querySelector(".stat-row .stat-card:nth-child(2) .stat-note");
    var statAvgWait = document.querySelector(".stat-row .stat-card:nth-child(3) .stat-value");
    var statWindows = document.querySelector(".stat-row .stat-card:nth-child(4) .stat-value");

    var toastContainer = document.getElementById("toastContainer");

    function toast(msg, type) {
        type = type || 'info';
        var el = document.createElement('div');
        el.className = 'toast toast-' + type;
        el.textContent = msg;
        toastContainer.appendChild(el);
        setTimeout(function () { el.style.opacity = '0'; setTimeout(function () { el.remove(); }, 300); }, 3000);
    }

    function setLoading(btn, loading) {
        if (!btn) return;
        btn.disabled = loading;
        if (loading) btn.classList.add('btn-loading');
        else btn.classList.remove('btn-loading');
    }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]').content || '';
    }

    var statusClassMap = { waiting: "waiting", called: "serving", done: "completed", left: "no-show" };
    var statusLabelMap = { waiting: "Waiting", called: "Serving", done: "Completed", left: "Left" };

    function initials(name) {
        return name.split(" ").map(function(p) { return p[0]; }).slice(0, 2).join("").toUpperCase();
    }

    var callNextBtn = null;

    function fetchQueueList() {
        var url = '/queue/list';
        var todayCheck = document.getElementById('todayCheck');
        if (todayCheck && todayCheck.checked) url += '?today=1';

        fetch(url)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                allData = data.entries.map(function(e) {
                    var isActive = e.status === 'waiting' || e.status === 'called';
                    return {
                        id: e.id,
                        number: e.queue_number || '000-000',
                        name: e.user && e.user.name || 'Unknown',
                        status: statusLabelMap[e.status] || e.status,
                        rawStatus: e.status,
                        window: e.window_number || 'Unassigned',
                        joinedRaw: e.created_at,
                        joinedDisplay: new Date(e.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        wait: e.status === 'waiting' ? '...' : (e.status === 'called' ? 0 : '—'),
                        isActive: isActive,
                    };
                });

                if (data.now_serving) {
                    statNowServing.innerHTML = '<span class="live-dot-sm"></span>#' + data.now_serving.queue_number;
                    statNowServingNote.textContent = data.now_serving.window_number ? 'At ' + data.now_serving.window_number : 'Called';
                } else {
                    statNowServing.innerHTML = '—';
                    statNowServingNote.textContent = 'No one serving';
                }
                statWaiting.textContent = data.waiting + ' patients';
                statWaitingNote.textContent = data.waiting + ' waiting';
                statAvgWait.textContent = '~' + (data.waiting * 4) + ' min';
                statWindows.textContent = '4 of 4';

                state.page = 1;
                renderTable();
            })
            .catch(function() {});
    }

    function callNext() {
        setLoading(callNextBtn, true);
        fetch('/queue/call-next', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken() } })
            .then(function(r) {
                if (!r.ok) { return r.json().then(function(d) { throw new Error(d.message || 'Failed to call next'); }); }
                return r.json();
            })
            .then(function(data) {
                if (data.entry) { toast('Called #' + data.entry.queue_number + ' to ' + data.entry.window_number, 'success'); fetchQueueList(); }
            })
            .catch(function(e) { toast(e.message, 'error'); })
            .finally(function() { setLoading(callNextBtn, false); });
    }

    function createCallNextBtn() {
        var btn = document.createElement('button');
        btn.id = 'callNextBtn';
        btn.className = 'btn btn-history';
        btn.innerHTML = '<span class="btn-label"><svg viewBox="0 0 16 16"><path d="M3 8h10M9 4l4 4-4 4"/></svg> Call Next Patient</span><span class="btn-spinner"><svg class="spinner" viewBox="0 0 20 20" width="16" height="16"><circle cx="10" cy="10" r="7" fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="30 20"/></svg> Calling…</span>';
        btn.addEventListener('click', callNext);
        document.querySelector('.controls-row').before(btn);
        return btn;
    }
    callNextBtn = document.getElementById("callNextBtn") || createCallNextBtn();

    function markComplete(id) {
        fetch('/queue/' + id + '/complete', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken() } })
            .then(function(r) {
                if (!r.ok) { return r.json().then(function(d) { throw new Error(d.message || 'Failed to complete'); }); }
                return r.json();
            })
            .then(function() { toast('Queue entry completed!', 'success'); fetchQueueList(); })
            .catch(function(e) { toast(e.message, 'error'); });
    }


    function statusGroup(row) {
        var st = row.rawStatus;
        if (st === 'called') return 0;
        if (st === 'waiting') return 1;
        return 2;
    }

    function getFiltered() {
        var q = state.search.trim().toLowerCase();
        return allData.filter(function(row) {
            if (state.status !== "all" && row.status !== state.status) return false;
            if (state.win !== "all" && row.window !== state.win) return false;
            if (q) {
                if (!(row.name.toLowerCase().includes(q) || row.number.toLowerCase().includes(q))) return false;
            }
            return true;
        });
    }

    function compareRows(a, b) {
     
        var gA = statusGroup(a), gB = statusGroup(b);
        if (gA !== gB) return gA - gB;

        var key = state.sortKey;
        var av, bv;
        if (key === "number") { av = a.number; bv = b.number; }
        else if (key === "name") { av = a.name.toLowerCase(); bv = b.name.toLowerCase(); }
        else if (key === "status") { av = a.rawStatus; bv = b.rawStatus; }
        else if (key === "window") { av = a.window === "Unassigned" ? "zzz" : a.window; bv = b.window === "Unassigned" ? "zzz" : b.window; }
        else if (key === "joined") { av = a.joinedRaw; bv = b.joinedRaw; }
        else if (key === "wait") { av = a.wait === null ? -1 : a.wait; bv = b.wait === null ? -1 : b.wait; }
        if (av < bv) return state.sortDir === "asc" ? -1 : 1;
        if (av > bv) return state.sortDir === "asc" ? 1 : -1;
        return 0;
    }

    function rowTemplate(row) {
        var cls = statusClassMap[row.rawStatus] || 'waiting';
        var waitDisplay = row.wait === '...' ? '...' : (row.wait === 0 ? 'Now' : (row.wait === '—' ? '—' : row.wait));
        return '<tr>' +
            '<td class="queue-num">' + row.number + '</td>' +
            '<td><div class="patient-cell"><div class="patient-avatar">' + initials(row.name) + '</div><div><div class="patient-name">' + row.name + '</div></div></div></td>' +
            '<td><span class="badge ' + cls + '"><span class="dot"></span>' + row.status + '</span></td>' +
            '<td class="' + (row.window === 'Unassigned' ? 'muted-cell' : '') + '">' + row.window + '</td>' +
            '<td>' + row.joinedDisplay + '</td>' +
            '<td class="' + (row.wait === '—' ? 'muted-cell' : '') + '">' + waitDisplay + '</td>' +
            '<td><div class="row-actions">' +
                (row.rawStatus === 'called'
                    ? '<button onclick="window.markComplete(' + row.id + ')" title="Mark complete" aria-label="Mark complete"><svg viewBox="0 0 16 16"><path d="M3 8.5l3.5 3.5L13 4"/></svg></button>'
                    : '<button disabled><svg viewBox="0 0 16 16"><path d="M3 8.5l3.5 3.5L13 4"/></svg></button>') +
            '</div></td>' +
            '</tr>';
    }

    function renderPagination(total, page) {
        var totalPages = Math.ceil(total / PER_PAGE);
        if (totalPages <= 1) { paginationEl.innerHTML = ''; return; }

        var html = '';
        html += '<button class="page-btn" data-page="prev" ' + (page <= 1 ? 'disabled' : '') + '>‹</button>';
        html += '<span class="page-info">Page ' + page + ' of ' + totalPages + '</span>';
        html += '<button class="page-btn" data-page="next" ' + (page >= totalPages ? 'disabled' : '') + '>›</button>';
        paginationEl.innerHTML = html;

        paginationEl.querySelectorAll('.page-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var p = btn.dataset.page;
                if (p === 'prev' && state.page > 1) state.page--;
                else if (p === 'next' && state.page < totalPages) state.page++;
                renderTable();
            });
        });
    }

    function renderTable() {
        var filtered = getFiltered().sort(compareRows);
        var total = filtered.length;
        var totalPages = Math.ceil(total / PER_PAGE);
        if (state.page > totalPages && totalPages > 0) state.page = totalPages;

        var start = (state.page - 1) * PER_PAGE;
        var pageRows = filtered.slice(start, start + PER_PAGE);

        tbody.innerHTML = pageRows.map(rowTemplate).join("");
        resultCount.textContent = filtered.length + ' of ' + allData.length + ' entries' + (totalPages > 1 ? ' (page ' + state.page + '/' + totalPages + ')' : '');
        emptyStateEl.hidden = filtered.length !== 0;
        table.style.display = filtered.length === 0 ? "none" : "table";
        renderPagination(total, state.page);
    }


    table.querySelectorAll("thead th[data-key]").forEach(function(th) {
        th.addEventListener("click", function() {
            var key = th.dataset.key;
            if (state.sortKey === key) state.sortDir = state.sortDir === "asc" ? "desc" : "asc";
            else { state.sortKey = key; state.sortDir = "asc"; }
            table.querySelectorAll("thead th").forEach(function(h) { h.classList.remove("sorted-asc", "sorted-desc"); });
            th.classList.add(state.sortDir === "asc" ? "sorted-asc" : "sorted-desc");
            state.page = 1;
            renderTable();
        });
    });
    table.querySelector('thead th[data-key="number"]').classList.add("sorted-asc");

    document.getElementById("searchInput").addEventListener("input", function() {
        state.search = this.value; state.page = 1; renderTable();
    });
    document.getElementById("statusFilter").addEventListener("change", function() {
        state.status = this.value; state.page = 1; renderTable();
    });
    document.getElementById("windowFilter").addEventListener("change", function() {
        state.win = this.value; state.page = 1; renderTable();
    });
    document.getElementById("todayCheck").addEventListener("change", function() {
        fetchQueueList();
    });

  
    fetchQueueList();

    document.addEventListener('queue:updated', fetchQueueList);

    setInterval(fetchQueueList, 60000);

    window.markComplete = markComplete;

    var overlay = document.getElementById("historyModalOverlay");
    var openBtn = document.getElementById("openHistoryBtn");
    var closeBtn = document.getElementById("closeHistoryBtn");
    var closeBtnX = document.getElementById("closeHistoryBtnX");
    var reportPlaceholder = document.getElementById("reportPlaceholder");
    var reportResults = document.getElementById("reportResults");
    var reportMeta = document.getElementById("reportMeta");
    var reportStats = document.getElementById("reportStats");

    const reportTableBody = document.getElementById("reportTableBody");
    const exportBtn = document.getElementById("exportBtn");
    const fromDate = document.getElementById("fromDate");
    const toDate = document.getElementById("toDate");
    const statusChecks = document.getElementById("statusChecks");
    const generateBtn = document.getElementById("generateBtn");

    const todayStr = new Date().toISOString().slice(0, 10);
    fromDate.value = todayStr;
    toDate.value = todayStr;

    function openModal() {
        overlay.classList.add("open");
        document.body.style.overflow = "hidden";
        setTimeout(() => closeBtnX.focus(), 50);
    }
    function closeModal() {
        overlay.classList.remove("open");
        document.body.style.overflow = "";
        openBtn.focus();
    }

    openBtn.addEventListener("click", openModal);
    closeBtn.addEventListener("click", closeModal);
    closeBtnX.addEventListener("click", closeModal);
    overlay.addEventListener("click", e => { if (e.target === overlay) closeModal(); });
    document.addEventListener("keydown", e => { if (e.key === "Escape" && overlay.classList.contains("open")) closeModal(); });

    generateBtn.addEventListener("click", () => {
        const checked = Array.from(document.querySelectorAll('#statusChecks input[type="checkbox"]:checked')).map(c => c.value);
        const filtered = queueData.filter(row => checked.includes(row.status));

        const completed = filtered.filter(r => r.rawStatus === "done").length;
        const waitValues = filtered.filter(r => typeof r.wait === 'number' && r.wait > 0).map(r => r.wait);
        const avgWait = waitValues.length ? Math.round(waitValues.reduce((a, b) => a + b, 0) / waitValues.length) : 0;

        const fromLabel = fromDate.value || todayStr;
        const toLabel = toDate.value || todayStr;
        reportMeta.innerHTML = 'Showing <strong>' + filtered.length + '</strong> entries from <strong>' + fromLabel + '</strong> to <strong>' + toLabel + '</strong>';

        reportStats.innerHTML =
            '<div class="report-stat"><div class="rs-value">' + filtered.length + '</div><div class="rs-label">Total entries</div></div>' +
            '<div class="report-stat"><div class="rs-value">' + completed + '</div><div class="rs-label">Completed</div></div>' +
            '<div class="report-stat"><div class="rs-value">' + avgWait + 'm</div><div class="rs-label">Avg. wait</div></div>' +
            '<div class="report-stat"><div class="rs-value">' + Math.round((filtered.length ? (completed / filtered.length) * 100 : 0)) + '%</div><div class="rs-label">Completion rate</div></div>';

        reportTableBody.innerHTML = filtered.length
            ? filtered.slice().sort((a, b) => a.number - b.number).map(row =>
                '<tr>' +
                    '<td class="queue-num">#' + String(row.number).padStart(3, "0") + '</td>' +
                    '<td>' + row.name + '</td>' +
                    '<td><span class="badge ' + (statusClassMap[row.rawStatus] || 'waiting') + '"><span class="dot"></span>' + row.status + '</span></td>' +
                    '<td class="' + (row.window === 'Unassigned' ? 'muted-cell' : '') + '">' + row.window + '</td>' +
                    '<td>' + row.joinedDisplay + '</td>' +
                    '<td>' + (row.wait === '...' ? '...' : (row.wait === 0 ? 'Now' : (row.wait === '—' ? '—' : row.wait + ' min'))) + '</td>' +
                '</tr>'
            ).join("")
            : '<tr><td colspan="6" style="text-align:center;color:var(--ink-muted);padding:18px;">No entries match the selected statuses.</td></tr>';

        reportPlaceholder.hidden = true;
        reportResults.hidden = false;
        exportBtn.disabled = filtered.length === 0;
        exportBtn.title = filtered.length === 0 ? "No data to export" : "Export this report";
    });
})();
</script>
</body>
</html>