<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Admin Panel - {{ config('app.name', 'Ketik.in') }}</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0f172a">
    <link rel="apple-touch-icon" href="{{ asset('img/icon-192.png') }}">
    <!-- CSS files -->
    <link href="{{ asset('css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/ketik-override.css') }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
        background-color: #f1f5f9; /* Slate-100 */
      }
      
      /* --- Desktop Floating Sidebar Styles (Synced with User Sidebar) --- */
      @media (min-width: 992px) {
          .navbar-vertical {
              background: transparent;
              border: none;
              padding: 0;
              width: 280px;
              position: fixed;
              top: 0;
              left: 0;
              height: 100vh;
              z-index: 1030;
              overflow-y: hidden; 
          }

          .sidebar-wrapper {
              padding: 1rem;
              height: 100%;
              box-sizing: border-box;
          }

          .sidebar-content {
              background-color: #0f172a; /* Slate-900 */
              color: white;
              border-radius: 16px;
              height: 100%;
              display: flex;
              flex-direction: column;
              padding: 1.25rem;
              box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
              overflow-y: auto;
          }

          .sidebar-content::-webkit-scrollbar {
              width: 4px;
          }
          .sidebar-content::-webkit-scrollbar-track {
              background: transparent;
          }
          .sidebar-content::-webkit-scrollbar-thumb {
              background: rgba(255, 255, 255, 0.1);
              border-radius: 4px;
          }
          
          .sidebar-logo {
              border-bottom: 1px solid rgba(255, 255, 255, 0.08);
          }

          .page-wrapper {
              margin-left: 280px;
              padding: 1rem 1rem 1rem 0; 
          }
           .container-xl, .container-fluid {
              max-width: 1400px;
          }
      }

      /* --- Mobile Standard Styles (Dark Theme) --- */
      @media (max-width: 991.98px) {
          .navbar-vertical {
              width: 100%;
              background: transparent !important;
              border-bottom: none;
              padding: 0;
              z-index: 1020;
              position: relative;
          }

          .sidebar-wrapper {
              padding: 0;
              height: auto;
              width: 100%;
          }

          .sidebar-content {
              background-color: #0f172a; 
              color: white;
              padding: 0.5rem 1rem;
              width: 100%;
              border-radius: 0;
              box-shadow: none;
              margin-top: 0; 
              border-top: 1px solid rgba(255,255,255,0.1); 
          }
          
          .page-wrapper {
              margin-left: 0;
              padding: 0;
          }

          .sidebar-logo {
              display: none;
          }
      }

      /* --- Common Styles --- */
      .sidebar-logo {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 0.5rem 0.5rem 1.5rem;
          margin-bottom: 0.5rem;
      }
      
      .logo-icon {
          width: 36px;
          height: 36px;
          background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
          color: white;
          border-radius: 10px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: 800;
          font-size: 1.2rem;
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      }

      .logo-text {
          font-size: 1.25rem;
          font-weight: 700;
          letter-spacing: -0.025em;
          color: white;
      }

      .nav-menu {
          list-style: none;
          padding: 0;
          margin: 0;
          display: flex;
          flex-direction: column;
          gap: 4px;
      }

      .nav-link {
          display: flex;
          align-items: center;
          padding: 10px 14px;
          border-radius: 8px;
          color: #94a3b8 !important; /* Slate-400 */
          text-decoration: none;
          transition: all 0.2s ease;
          font-weight: 500;
          font-size: 0.95rem;
      }

      .nav-link:hover {
          background-color: rgba(255, 255, 255, 0.05);
          color: #f8fafc !important; 
      }

      .nav-link.active {
          background-color: #f59e0b; /* Amber-500 for Admin */
          color: white !important;
          box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
      }

      .nav-icon {
          width: 20px;
          height: 20px;
          margin-right: 12px;
          stroke-width: 2;
      }

      .sidebar-footer {
          margin-top: auto;
          padding-top: 1.5rem;
      }
      @media (max-width: 991.98px) {
           .sidebar-footer {
               margin-top: 1rem;
               padding-top: 1rem;
               border-top: 1px solid rgba(255,255,255,0.1);
           }
      }
    </style>
  </head>
  <body>
    <div class="page">
      <!-- Mobile Header -->
      <header class="navbar navbar-expand-lg navbar-dark d-print-none d-lg-none border-bottom" style="background-color: #0f172a;">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-white text-decoration-none">
              <img src="{{ asset('img/ketikin/Group 20.png') }}" alt="Ketik.in" style="height: 48px; width: auto;" class="me-2">
              <span class="fs-1 fw-bold">Admin</span>
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0">
                    @if(Auth::user()->avatar)
                        <span class="avatar avatar-sm rounded-circle" style="background-image: url({{ asset('storage/' . Auth::user()->avatar) }}); background-size: cover;"></span>
                    @else
                        <span class="avatar avatar-sm rounded-circle" style="background-image: url(https://preview.tabler.io/static/avatars/000m.jpg)"></span>
                    @endif
                </a>
            </div>
          </div>
        </div>
      </header>

      <!-- Sidebar Desktop & Mobile Wrapper -->
      <aside class="navbar navbar-vertical navbar-expand-lg">
        <div class="sidebar-wrapper">
            <div class="collapse navbar-collapse sidebar-content" id="sidebar-menu">
                <!-- Logo (Hidden on mobile) -->
                <div class="sidebar-logo d-none d-lg-flex">
                     <img src="{{ asset('img/ketikin/Group 20.png') }}" alt="Ketik.in" style="height: 48px; width: auto;" class="me-2">
                     <div class="logo-text">Admin Panel</div>
                </div>

                <!-- Nav Menu -->
                <ul class="nav-menu navbar-nav pt-lg-3">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                            Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.verifications') }}" class="nav-link {{ request()->routeIs('admin.verifications*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                            Verifikasi Member
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.subscriptions') }}" class="nav-link {{ request()->routeIs('admin.subscriptions*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" /><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" /></svg>
                            Masa Waktu
                        </a>
                    </li>
                    <div class="hr-text text-muted small mt-3 mb-2" style="opacity: 0.5;">Asisten Administrasi (Beta)</div>
                    <li class="nav-item">
                        <a href="{{ route('feature.laporan') }}" class="nav-link {{ request()->routeIs('feature.laporan') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 14l2 2l4 -4" /></svg>
                            Laporan Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.sop') }}" class="nav-link {{ request()->routeIs('feature.sop') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M10 12l4 0" /><path d="M10 16l4 0" /></svg>
                            Pembuat SOP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.surat') }}" class="nav-link {{ request()->routeIs('feature.surat') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                            Surat Dinas
                        </a>
                    </li>
                    <div class="hr-text text-muted small mt-auto mb-2" style="opacity: 0.5;">Akses</div>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l-4 4l4 4" /><path d="M5 15h11a4 4 0 0 0 4 -4v-7" /></svg>
                            Kembali ke App
                        </a>
                    </li>
                </ul>

                <!-- Footer -->
                <div class="sidebar-footer">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false" style="padding-right: 1rem;">
                            @if(Auth::user()->avatar)
                                <span class="avatar avatar-sm rounded-circle me-2 border border-2 border-warning" style="background-image: url({{ asset('storage/' . Auth::user()->avatar) }}); background-size: cover;"></span>
                            @else
                                <span class="avatar avatar-sm rounded-circle me-2 border border-2 border-warning" style="background-image: url(https://preview.tabler.io/static/avatars/000m.jpg)"></span>
                            @endif
                            <div class="overflow-hidden d-none d-lg-block">
                                <div class="text-truncate fw-bold fs-5">{{ Auth::user()->name }}</div>
                                <div class="small text-muted text-truncate" style="opacity: 0.7;">Administrator</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown-menu-dark border-0 shadow-lg mt-3" style="border-radius: 12px; min-width: 160px; background-color: #1e293b;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item py-2 px-3 fw-medium text-danger d-flex align-items-center" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M7 12h14l-3 -3m0 6l3 -3" /></svg>
                                    Keluar
                                </a>
                            </form>
                        </div>
                    </div>

                    <!-- PWA Install Button (Hidden by default) -->
                    <div id="pwa-install-container" class="mt-3 d-none">
                        <button id="pwa-install-btn" class="btn btn-primary w-100 rounded-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                            Install Admin App
                        </button>
                    </div>
                </div>
            </div>
        </div>
      </aside>

      <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                {{ $slot }}
            </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="{{ asset('js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('js/demo.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    <script>
      // --- PWA LOGIC ---
      if ('serviceWorker' in navigator) {
          navigator.serviceWorker.register('/sw.js');
      }

      let deferredPrompt;
      const installContainer = document.getElementById('pwa-install-container');
      const installBtn = document.getElementById('pwa-install-btn');

      window.addEventListener('beforeinstallprompt', (e) => {
          e.preventDefault();
          deferredPrompt = e;
          installContainer.classList.remove('d-none');

          installBtn.addEventListener('click', () => {
              installContainer.classList.add('d-none');
              deferredPrompt.prompt();
              deferredPrompt.userChoice.then((choiceResult) => {
                  deferredPrompt = null;
              });
          });
      });
    </script>
  </body>
</html>
