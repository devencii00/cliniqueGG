<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Clinique — Live Queue Display</title>
<link rel="icon" href="{{ asset('images/weblog.ico') }}" type="image/x-icon">

<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@600;700&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --bg:        #040F1A;
    --panel-bg:  #071523;
    --surface:   #0B1F30;
    --divider:   #112336;
    --accent:    #00C2D4;
    --accent-dim:#007A8A;
    --accent-glow: rgba(0,194,212,0.18);
    --green:     #22C55E;
    --green-dim: rgba(34,197,94,0.12);
    --white:     #FFFFFF;
    --text-1:    #F1F5F9;
    --text-2:    #94A3B8;
    --text-3:    #475569;
}

html, body {
    height: 100%; overflow: hidden;
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text-1);
}

/* ─── LAYOUT ─────────────────────────────────────── */
.screen {
    display: grid;
    grid-template-columns: 1fr 360px;
    grid-template-rows: auto 1fr auto;
    height: 100vh;
}

/* ─── TOPBAR ─────────────────────────────────────── */
.topbar {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    height: 64px;
    background: var(--panel-bg);
    border-bottom: 1px solid var(--divider);
}

.topbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.topbar-brand .logo-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: var(--accent);
    box-shadow: 0 0 12px var(--accent);
}

.topbar-brand h1 {
    font-family: 'Syne', sans-serif;
    font-size: 18px; font-weight: 800;
    letter-spacing: -0.3px;
    color: var(--white);
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 24px;
}

.live-badge {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 600;
    letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--accent);
}

.live-badge .dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--accent);
    animation: blink 1.4s ease-in-out infinite;
}

.clock {
    font-family: 'JetBrains Mono', monospace;
    font-size: 16px; font-weight: 600;
    color: var(--text-2);
    letter-spacing: 1px;
}

/* ─── MAIN SERVING AREA ──────────────────────────── */
.main-area {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px 60px;
    position: relative;
    overflow: hidden;
}

/* ambient glow behind the serving card */
.main-area::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,194,212,0.07) 0%, transparent 70%);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
}

.serving-label {
    font-size: 11px; font-weight: 600;
    letter-spacing: 3px; text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 32px;
}

/* Multi-serving grid */
.serving-grid {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    justify-content: center;
    width: 100%;
    max-width: 720px;
}

.serving-card {
    flex: 1;
    min-width: 240px;
    max-width: 360px;
    background: var(--surface);
    border: 1px solid var(--accent-dim);
    border-radius: 24px;
    padding: 40px 36px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 0 0 1px var(--accent-dim), 0 0 48px rgba(0,194,212,0.08);
}

.serving-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--accent), transparent);
}

.sc-eyebrow {
    font-size: 10px; font-weight: 600;
    letter-spacing: 2.5px; text-transform: uppercase;
    color: var(--accent-dim);
    margin-bottom: 16px;
}

.sc-number {
    font-family: 'JetBrains Mono', monospace;
    font-size: 100px; font-weight: 700;
    line-height: 1;
    color: var(--white);
    letter-spacing: -4px;
    margin-bottom: 20px;
    text-shadow: 0 0 60px rgba(0,194,212,0.3);
}

.sc-name {
    font-size: 20px; font-weight: 600;
    color: var(--text-1);
    margin-bottom: 16px;
}

.sc-window {
    font-size: 11px; font-weight: 600;
    letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--accent);
    background: var(--accent-glow);
    padding: 6px 18px;
    border-radius: 20px;
    border: 1px solid rgba(0,194,212,0.2);
}

.empty-serving {
    text-align: center;
}

.empty-serving .big-text {
    font-family: 'Syne', sans-serif;
    font-size: 22px; font-weight: 700;
    color: var(--text-3);
    margin-bottom: 8px;
}

.empty-serving .sub-text {
    font-size: 14px;
    color: var(--text-3);
}


.right-panel {
    display: flex;
    flex-direction: column;
    background: var(--panel-bg);
    border-left: 1px solid var(--divider);
    overflow: hidden;
}

.panel-header {
    padding: 24px 24px 16px;
    border-bottom: 1px solid var(--divider);
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    flex-shrink: 0;
}

.panel-header h2 {
    font-family: 'Syne', sans-serif;
    font-size: 13px; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase;
    color: var(--text-2);
}

.panel-count {
    font-family: 'JetBrains Mono', monospace;
    font-size: 13px; font-weight: 700;
    color: var(--accent);
    background: var(--accent-glow);
    padding: 3px 10px;
    border-radius: 20px;
}

.queue-list {
    flex: 1;
    overflow-y: auto;
    padding: 12px 16px;
    scrollbar-width: none;
}

.queue-list::-webkit-scrollbar { display: none; }

.queue-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 12px;
    margin-bottom: 6px;
    background: var(--surface);
    border: 1px solid var(--divider);
    transition: background 0.2s;
}

.queue-item:first-child {
    background: var(--green-dim);
    border-color: rgba(34,197,94,0.2);
}

.queue-item:first-child .qi-num {
    color: var(--green);
}

.queue-item:first-child .qi-next {
    display: flex;
}

.qi-num {
    font-family: 'JetBrains Mono', monospace;
    font-size: 18px; font-weight: 700;
    color: var(--accent);
    min-width: 44px;
}

.qi-info {
    flex: 1;
    min-width: 0;
}

.qi-name {
    font-size: 13px; font-weight: 600;
    color: var(--text-1);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.qi-next {
    display: none;
    font-size: 10px; font-weight: 600;
    letter-spacing: 1.5px; text-transform: uppercase;
    color: var(--green);
    background: var(--green-dim);
    padding: 3px 8px;
    border-radius: 8px;
    flex-shrink: 0;
}

.panel-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    flex-direction: column;
    gap: 8px;
    color: var(--text-3);
    font-size: 13px;
}


.bottombar {
    grid-column: 1 / -1;
    height: 44px;
    background: var(--panel-bg);
    border-top: 1px solid var(--divider);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 11px;
    color: var(--text-3);
    letter-spacing: 0.5px;
}

.bottombar span { color: var(--text-3); }
.bottombar strong { color: var(--text-2); font-weight: 600; }


@keyframes blink {
    0%, 100% { opacity: 1; box-shadow: 0 0 8px var(--accent); }
    50%       { opacity: 0.3; box-shadow: none; }
}

@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

.serving-card { animation: fadeSlideIn 0.4s ease both; }
.queue-item   { animation: fadeSlideIn 0.3s ease both; }
</style>

@vite('resources/js/app.js')
</head>
<body>

<div class="screen">


    <header class="topbar">
        <div class="topbar-brand">
            <div class="logo-dot"></div>
            <h1>Clinique</h1>
        </div>
        <div class="topbar-right">
            <div class="live-badge">
                <div class="dot"></div>
                Live
            </div>
            <div class="clock" id="clock">--:--:--</div>
        </div>
    </header>

 
    <main class="main-area">
        <div class="serving-label">Now Serving</div>
        <div class="serving-grid" id="servingGrid">
            <div class="empty-serving">
                <div class="big-text">No active patients</div>
                <div class="sub-text">Waiting for the next call…</div>
            </div>
        </div>
    </main>

 
    <aside class="right-panel">
        <div class="panel-header">
            <h2>Up Next</h2>
            <div class="panel-count" id="waitingCount">0</div>
        </div>
        <div class="queue-list" id="waitingList">
            <div class="panel-empty">
                <span>Queue is empty</span>
            </div>
        </div>
    </aside>

   
    <footer class="bottombar">
        <strong>Clinique</strong>
        <span>&bull; Smart Queue System &bull; Your wait, redefined.</span>
    </footer>

</div>

<script>
(function () {
   
    function tickClock() {
        const now = new Date();
        document.getElementById('clock').textContent =
            now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tickClock();
    setInterval(tickClock, 1000);

  
    function fetchPublicQueue() {
        fetch('/api/queue/public')
            .then(r => r.json())
            .then(data => {
                const servingGrid  = document.getElementById('servingGrid');
                const waitingList  = document.getElementById('waitingList');
                const waitingCount = document.getElementById('waitingCount');

                if (data.serving && data.serving.length) {
                    servingGrid.innerHTML = data.serving.map(s => {
                        const name = s.user?.name || 'Patient';
                        const num  = s.queue_number || '?';
                        const win  = s.window_number || '';
                        return `<div class="serving-card">
                            <div class="sc-eyebrow">Queue Number</div>
                            <div class="sc-number">${num}</div>
                            <div class="sc-name">${name}</div>
                            ${win ? `<div class="sc-window">Window ${win}</div>` : ''}
                        </div>`;
                    }).join('');
                } else {
                    servingGrid.innerHTML = `<div class="empty-serving">
                        <div class="big-text">No active patients</div>
                        <div class="sub-text">Waiting for the next call…</div>
                    </div>`;
                }

          
                if (data.waiting && data.waiting.length) {
                    waitingList.innerHTML = data.waiting.map(w => {
                        const name = w.user?.name || 'Patient';
                        const num  = w.queue_number || '?';
                        return `<div class="queue-item">
                            <div class="qi-num">#${num}</div>
                            <div class="qi-info">
                                <div class="qi-name">${name}</div>
                            </div>
                            <div class="qi-next">Next</div>
                        </div>`;
                    }).join('');
                    waitingCount.textContent = data.waiting.length;
                } else {
                    waitingList.innerHTML = `<div class="panel-empty"><span>Queue is empty</span></div>`;
                    waitingCount.textContent = '0';
                }
            })
            .catch(() => {});
    }

    fetchPublicQueue();
    document.addEventListener('queue:updated', fetchPublicQueue);
    setInterval(fetchPublicQueue, 60000);
})();
</script>
</body>
</html>