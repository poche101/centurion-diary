if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', async () => {
        try {
            // 1. Register service worker
            const registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered', registration);

            // 2. Request notification permission
            const permission = await Notification.requestPermission();
            if (permission !== 'granted') {
                console.warn('Notification permission not granted.');
                return;
            }

            // 3. Subscribe to push
            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array('YOUR_PUBLIC_VAPID_KEY')
            });

            // 4. Send subscription to Laravel backend
            await fetch('/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(subscription)
            });

            console.log('Push subscription saved.');

        } catch (err) {
            console.error('Service Worker / Push setup failed:', err);
        }
    });
}

// Required helper to convert VAPID key
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = atob(base64);
    return Uint8Array.from([...rawData].map(c => c.charCodeAt(0)));
}
