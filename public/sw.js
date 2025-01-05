const staticCacheName = 'saveat-static-v1';
const dynamicCacheName = 'saveat-dynamic-v1';

// Assets to cache
const assets = [
    '/',
    '/offline',
    '/manifest.json',
    // Icons PNG
    '/app-icons/logo-72x72.png',
    '/app-icons/logo-96x96.png',
    '/app-icons/logo-128x128.png',
    '/app-icons/logo-144x144.png',
    '/app-icons/logo-152x152.png',
    '/app-icons/logo-192x192.png',
    '/app-icons/logo-384x384.png',
    '/app-icons/logo-512x512.png',
    // SVG icons
    '/app-icons/delete.svg',
    '/app-icons/filter-outline.svg',
    '/app-icons/filter.svg',
    '/app-icons/food-bank-outline.svg',
    '/app-icons/food-bank.svg',
    '/app-icons/location-outline.svg',
    '/app-icons/location.svg',
    '/app-icons/search-outline.svg',
    '/app-icons/star-gray.svg',
    '/app-icons/star-half.svg',
    '/app-icons/star-yellow.svg',
    '/app-icons/tag-outline.svg',
    '/app-icons/tag.svg',
    '/app-icons/user-filters-outline.svg',
    '/app-icons/user-filters.svg',
    '/app-icons/user-outline.svg',
    '/app-icons/user-tag-outline.svg',
    '/app-icons/user-tag.svg',
    '/app-icons/user.svg',
    '/app-icons/favicon-16x16.png',
    '/app-icons/favicon-32x32.png'
];

// Install Service Worker
self.addEventListener('install', event => {
    // console.log('Service worker has been installed');
    event.waitUntil(
        caches.open(staticCacheName).then(cache => {
            return cache.addAll(assets);
        })
    );
});

// Activate Event
self.addEventListener('activate', event => {
    // console.log('Service worker has been activated');
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
                .filter(key => key !== staticCacheName && key !== dynamicCacheName)
                .map(key => caches.delete(key))
            );
        })
    );
});

// Fetch Event
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(cacheRes => {
                return cacheRes || fetch(event.request)
                    .then(fetchRes => {
                        return caches.open(dynamicCacheName)
                            .then(cache => {
                                // Don't cache POST requests or browser-sync requests
                                if (event.request.method !== 'POST' && !event.request.url.includes('browser-sync')) {
                                    cache.put(event.request.url, fetchRes.clone());
                                }
                                return fetchRes;
                            });
                    });
            })
            .catch(() => {
                if (event.request.url.indexOf('.html') > -1) {
                    return caches.match('/offline');
                }
            })
    );
});
