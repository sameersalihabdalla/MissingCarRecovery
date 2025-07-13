const CACHE_NAME = "jobsagent-cache-v1";
const OFFLINE_URL = "/offline.html";

// 🗂️ ملفات يتم تخزينها مؤقتًا عند التثبيت
const PRECACHE_ASSETS = [
  "/",
  "/index.html",
  "/styles.css",
  "/app.js",
  "/logo.png",
  OFFLINE_URL
];

// ✅ تثبيت Service Worker وتخزين الملفات
self.addEventListener("install", (event) => {
  console.log("🔧 Service Worker: install event");
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(PRECACHE_ASSETS);
    })
  );
  self.skipWaiting(); // تفعيل التحديث فورًا
});

// ✅ تفعيل Service Worker وحذف الكاش القديم
self.addEventListener("activate", (event) => {
  console.log("🚀 Service Worker: activate event");
  event.waitUntil(
    caches.keys().then((cacheNames) =>
      Promise.all(
        cacheNames
          .filter((name) => name !== CACHE_NAME)
          .map((name) => caches.delete(name))
      )
    )
  );
  self.clients.claim(); // السيطرة على الصفحات المفتوحة
});

// ✅ التعامل مع الطلبات
self.addEventListener("fetch", (event) => {
  if (event.request.method !== "GET") return;

  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      if (cachedResponse) {
        return cachedResponse; // ✅ الرد من الكاش
      }

      return fetch(event.request)
        .then((networkResponse) => {
          // 🧠 تخزين نسخة من الطلب الجديد
          return caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, networkResponse.clone());
            return networkResponse;
          });
        })
        .catch(() => {
          // ❌ في حال عدم وجود اتصال، عرض صفحة offline
          if (event.request.mode === "navigate") {
            return caches.match(OFFLINE_URL);
          }
        });
    })
  );
});
