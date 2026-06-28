/**
 * Queue real-time listener using Laravel Echo (Reverb).
 * Dispatches a custom DOM event 'queue:updated' on the document
 * whenever a queue change is broadcast.
 */
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: 'zgvldxyjlcsynuifm2ls',
    wsHost: '127.0.0.1',
    wsPort: 8080,
    wssPort: 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

window.Echo.channel('queue')
    .listen('.queue.joined', function (data) {
        const timeReceived = Date.now();
        const absoluteDelay = timeReceived - data.fired_at;
        console.log('Reverb fired: ' + absoluteDelay + 'ms');
        document.dispatchEvent(new CustomEvent('queue:updated', { detail: data }));
    });
