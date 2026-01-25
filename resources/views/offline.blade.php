<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Koneksi Terputus - Ketik.in</title>
    <!-- CSS files -->
    <link href="{{ asset('css/tabler.min.css') }}" rel="stylesheet"/>
    <style>
      body {
        background-color: #0f172a;
        color: white;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
    </style>
  </head>
  <body>
    <div class="container-tight py-4">
      <div class="empty">
        <div class="empty-header display-1 text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="120" height="120" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 13v-8" /><path d="M7 16l4 -4" /><path d="M15 16l-4 -4" /><path d="M18 16a4 4 0 0 1 0 8a4 4 0 0 1 0 -8z" /></svg>
        </div>
        <h1 class="empty-title mb-4">Kamu Sedang Offline</h1>
        <p class="empty-subtitle text-muted fs-3">
          Sepertinya internet kamu terputus. <br>
          Coba cek koneksi wifi atau data seluler kamu ya.
        </p>
        <div class="empty-action">
          <button onclick="window.location.reload()" class="btn btn-primary btn-lg rounded-pill px-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
            Coba Lagi
          </button>
        </div>
      </div>
    </div>
  </body>
</html>
