const CACHE_NAME = 'centurion-diary-v2';
const STATIC_ASSETS = [
    '/',
    '/dashboard',
    '/manifest.json',
];

// ── Install ───────────────────────────────────────────────────────
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(STATIC_ASSETS))
    );
    self.skipWaiting();
});

// ── Activate: delete old caches ───────────────────────────────────
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        )
    );
    self.clients.claim();
});

// ── Fetch: network-first, fallback to cache ───────────────────────
self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .then(response => {
                const clone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                return response;
            })
            .catch(() => caches.match(event.request))
    );
});

// ── Push Notifications ────────────────────────────────────────────
// ── Push Notifications ────────────────────────────────────────────
self.addEventListener('push', event => {
    let data = {};

    if (event.data) {
        try {
            // Attempt to parse the incoming data as JSON
            data = event.data.json();
        } catch (e) {
            // If parsing fails (e.g., plain text), use the text as the notification body
            data = {
                body: event.data.text()
            };
        }
    }

    const title   = data.title   || 'Centurion Diary';
    const options = {
        body:    data.body    || 'Time to pray! 🙏',
        icon:    '/images/icon-192.png',
        badge:   '/images/icon-192.png',
        vibrate: [200, 100, 200],
        data:    { url: data.url || '/dashboard' },
        actions: [
            { action: 'open',    title: 'Open App' },
            { action: 'dismiss', title: 'Dismiss' },
        ],
    };

    event.waitUntil(self.registration.showNotification(title, options));
});
// ── Notification Click ────────────────────────────────────────────
self.addEventListener('notificationclick', event => {
    event.notification.close();
    if (event.action === 'dismiss') return;

    const url = event.notification.data?.url || '/dashboard';
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(clientList => {
            for (const client of clientList) {
                if (client.url === url && 'focus' in client) return client.focus();
            }
            if (clients.openWindow) return clients.openWindow(url);
        })
    );
});
