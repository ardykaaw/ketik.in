<script>
// ===== Web Push Notifications =====
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            if (Notification.permission === 'default') {
                Notification.requestPermission().then(function(permission) {
                    if (permission === 'granted') {
                        subscribeUser(registration);
                    }
                });
            } else if (Notification.permission === 'granted') {
                subscribeUser(registration);
            }
        });
    });

    function subscribeUser(registration) {
        const vapidPublicKey = '{{ env("VAPID_PUBLIC_KEY") }}';
        if (!vapidPublicKey) return;
        
        const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);

        registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: convertedVapidKey
        }).then(function(subscription) {
            fetch('/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(subscription)
            });
        }).catch(function(err) {
            console.log('Failed to subscribe the user: ', err);
        });
    }
}
</script>
