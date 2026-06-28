<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Clinique — Live Queue Display</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
        --cyan-deep: #0E7490; --cyan-mid: #0891B2; --cyan-bright: #22D3EE;
        --cyan-pale: #CFFAFE; --cyan-ice: #F0FDFF; --white: #FFFFFF;
        --ink: #0F172A; --ink-soft: #475569; --ink-muted: #94A3B8;
        --border: #E2E8F0; --border-soft: #E0F7FA;
    }
    html, body {
        min-height: 100vh; font-family: 'Inter', sans-serif;
        background: var(--cyan-ice); color: var(--ink);
    }
    body {
        display: flex; flex-direction: column; min-height: 100vh;
    }
    header {
        background: linear-gradient(145deg, #0C4A6E, #0E7490, #0891B2);
        padding: 32px 40px 28px;
        text-align: center;
        color: var(--white);
    }
    header h1 {
        font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800;
        letter-spacing: -0.5px;
    }
    header p { font-size: 13px; color: rgba(255,255,255,0.6); margin-top: 4px; }
    main {
        flex: 1; max-width: 900px; margin: 0 auto;
        padding: 40px 24px 60px; width: 100%;
        display: flex; flex-direction: column; gap: 36px;
    }
    section h2 {
        font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700;
        color: var(--ink); margin-bottom: 16px;
        display: flex; align-items: center; gap: 10px;
    }
    section h2 .count {
        font-size: 12px; font-weight: 600; color: var(--ink-muted);
        background: var(--white); padding: 2px 10px; border-radius: 20px;
    }
    .card-grid {
        display: flex; flex-wrap: wrap; gap: 12px;
    }
    .queue-card {
        background: var(--white);
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        padding: 20px 24px;
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
    }
    .queue-card.serving {
        background: linear-gradient(150deg, #0C4A6E, #0E7490, #0891B2);
        border-color: transparent;
        color: var(--white);
    }
    .queue-card.serving .number { color: var(--white); }
    .queue-card.serving .label { color: rgba(255,255,255,0.65); }
    .queue-card.serving .window {
        background: rgba(255,255,255,0.14);
        color: var(--white);
    }
    .number {
        font-family: 'Syne', sans-serif;
        font-size: 40px; font-weight: 800;
        color: var(--cyan-deep); line-height: 1.1;
    }
    .label {
        font-size: 11px; font-weight: 600; text-transform: uppercase;
        letter-spacing: 1.5px; color: var(--ink-muted);
    }
    .name {
        font-size: 15px; font-weight: 600; color: var(--ink);
    }
    .window {
        font-size: 12px; font-weight: 600;
        background: var(--cyan-ice); padding: 4px 12px;
        border-radius: 20px; color: var(--cyan-deep);
    }
    .waiting-list {
        display: flex; flex-wrap: wrap; gap: 8px;
    }
    .waiting-chip {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 16px;
        display: flex; align-items: center; gap: 10px;
    }
    .waiting-chip .num {
        font-family: 'Syne', sans-serif;
        font-size: 16px; font-weight: 700;
        color: var(--cyan-deep);
    }
    .waiting-chip .name {
        font-size: 13px; color: var(--ink-soft); font-weight: 500;
    }
    .empty-msg {
        color: var(--ink-muted); font-size: 14px;
        padding: 24px 0;
    }
    .auto-refresh {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        font-size: 12px; color: var(--ink-muted); margin-top: 12px;
    }
    .auto-refresh .dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--cyan-bright); animation: pulse 1.6s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.35} }
    footer {
        text-align: center; padding: 20px;
        font-size: 12px; color: var(--ink-muted);
        border-top: 1px solid var(--border); background: var(--white);
    }
</style>
</head>
<body>

<header>
    <h1>Clinique Queue Status</h1>
    <p>Live public display — updates automatically</p>
</header>

<main>
    <section id="servingSection">
        <h2>Now Serving</h2>
        <div class="card-grid" id="servingGrid">
            <div class="empty-msg">No one is currently being served.</div>
        </div>
    </section>

    <section id="waitingSection">
        <h2>Waiting <span class="count" id="waitingCount">0</span></h2>
        <div class="waiting-list" id="waitingList">
            <div class="empty-msg">Queue is empty.</div>
        </div>
    </section>

    <div class="auto-refresh">
        <span class="dot"></span> Auto-refreshing every 5 seconds
    </div>
</main>

<footer>
    <strong>Clinique</strong> — Smart Queue System &bull; Your wait, redefined.
</footer>

<script>
(function () {
    function fetchPublicQueue() {
        fetch('/api/queue/public')
            .then(r => r.json())
            .then(data => {
                const servingGrid = document.getElementById('servingGrid');
                const waitingList = document.getElementById('waitingList');
                const waitingCount = document.getElementById('waitingCount');

                // Serving
                if (data.serving && data.serving.length) {
                    servingGrid.innerHTML = data.serving.map(s => {
                        const name = s.user?.name || 'Patient';
                        const num = s.queue_number || '?';
                        const win = s.window_number || '';
                        return '<div class="queue-card serving">' +
                            '<span class="label">Queue #</span>' +
                            '<span class="number">#' + num + '</span>' +
                            '<span class="name">' + name + '</span>' +
                            (win ? '<span class="window">' + win + '</span>' : '') +
                        '</div>';
                    }).join('');
                } else {
                    servingGrid.innerHTML = '<div class="empty-msg">No one is currently being served.</div>';
                }

              
                if (data.waiting && data.waiting.length) {
                    waitingList.innerHTML = data.waiting.map(w => {
                        const name = w.user?.name || 'Patient';
                        const num = w.queue_number || '?';
                        return '<div class="waiting-chip">' +
                            '<span class="num">#' + num + '</span>' +
                            '<span class="name">' + name + '</span>' +
                        '</div>';
                    }).join('');
                    waitingCount.textContent = data.waiting.length;
                } else {
                    waitingList.innerHTML = '<div class="empty-msg">Queue is empty.</div>';
                    waitingCount.textContent = '0';
                }
            })
            .catch(() => {});
    }

    fetchPublicQueue();
    setInterval(fetchPublicQueue, 5000);
})();
</script>
</body>
</html>
