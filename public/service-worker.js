self.addEventListener('install', function(e) {
  e.waitUntil(
    caches.open('grow-build-cache').then(function(cache) {
      return cache.addAll([
        '/',
        '/css/app.css',
        '/js/app.js',
        // adicione outros arquivos importantes se necessário
      ]);
    })
  );
});
self.addEventListener('fetch', function(e) {
  e.respondWith(
    caches.match(e.request).then(function(response) {
      return response || fetch(e.request);
    })
  );
}); 