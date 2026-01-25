const CACHE_NAME = 'ketikin-v2-unique'; // Updated to avoid conflict
const ASSETS_TO_CACHE = [
    '/offline',
    '/css/tabler.min.css',
    '/css/ketik-override.css',
    '/js/tabler.min.js',
    '/img/ketikin/Group 20.png'
];

self.addEventListener('install', (event) => {
    self.skipWaiting(); // FORCE activate immediately
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(ASSETS_TO_CACHE);
            })
    );
});

self.addEventListener('fetch', (event) => {
    // Only handle GET requests
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // If successful, clone it and store/update in cache
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseClone);
                });
                return response;
            })
            .catch(() => {
                // Network failed, try to get from cache
                return caches.match(event.request)
                    .then((cachedResponse) => {
                        if (cachedResponse) {
                            return cachedResponse;
                        }
                        // If not in cache and it's a navigation request, show offline page
                        if (event.request.mode === 'navigate') {
                            return caches.match('/offline');
                        }
                        return null;
                    });
            })
    );
});

self.addEventListener('activate', (event) => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim()) // Take control of all pages immediately
    );
});
