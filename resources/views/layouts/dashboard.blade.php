<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name', 'Ketik.in') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
      
      /* --- Desktop Floating Sidebar Styles --- */
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
              background: transparent !important; /* Fix: Transparent so no "dark frame" when closed */
              border-bottom: none;
              padding: 0;
              z-index: 1020;
              position: relative; /* Standard flow effectively, but won't show if empty/transparent */
          }

          .sidebar-wrapper {
              padding: 0;
              height: auto;
              width: 100%;
          }

          /* The inner content gets the background, valid only when expanded */
          .sidebar-content {
              background-color: #0f172a; 
              color: white;
              padding: 0.5rem 1rem;
              width: 100%;
              border-radius: 0;
              box-shadow: none;
              /* Ensure proper spacing when opened */
              margin-top: 0; 
              border-top: 1px solid rgba(255,255,255,0.1); 
          }
          
          .page-wrapper {
              margin-left: 0;
              padding: 0;
          }

          /* Hide sidebar logo on mobile since header has it */
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
          background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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
          background-color: #3b82f6;
          color: white !important;
          box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
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

      .admin-card {
          background: rgba(255, 255, 255, 0.03);
          border: 1px solid rgba(255, 255, 255, 0.05);
          border-radius: 12px;
          padding: 12px;
          margin-bottom: 12px;
          transition: background 0.2s;
      }
      
      .admin-card:hover {
          background: rgba(255, 255, 255, 0.06);
      }
      
      /* Mobile Toggle Visibility Fixes REMOVED to allow smooth animation */
      /* Bootstrap/Tabler handles collapse/show classes automatically */
    </style>
  </head>
  <body >
    <div class="page">
      <!-- Mobile Header -->
      <header class="navbar navbar-expand-lg navbar-dark d-print-none d-lg-none border-bottom" style="background-color: #0f172a;">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="." class="d-flex align-items-center text-white text-decoration-none">
              <x-animated-logo height="44px" color="#EDF3F8" />
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item me-3">
                <x-theme-toggle />
            </div>
            <div class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link d-flex lh-1 text-reset p-0">
                    @if(Auth::user()->avatar)
                        <span class="avatar avatar-sm rounded-circle" style="background-image: url({{ asset('storage/' . Auth::user()->avatar) }})"></span>
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
                     <x-animated-logo height="52px" color="#EDF3F8" />
                </div>

                <!-- Nav Menu -->
                <ul class="nav-menu navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('library.index') }}" class="nav-link {{ request()->routeIs('library.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            Pustaka Saya
                        </a>
                    </li>
                    
                    <div class="hr-text text-muted small mt-3 mb-2" style="opacity: 0.5;">Fitur Penulisan</div>

                    <li class="nav-item">
                        <a href="{{ route('feature.story-telling') }}" class="nav-link {{ request()->routeIs('feature.story-telling') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            Story Telling
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.ebook') }}" class="nav-link {{ request()->routeIs('feature.ebook') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                            Membuat E-book
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.opini') }}" class="nav-link {{ request()->routeIs('feature.opini') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-7.6 8.38 8.38 0 0 1 3.8.9L21 3l-3 9z"></path></svg>
                            Opini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.script') }}" class="nav-link {{ request()->routeIs('feature.script') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>
                            Script Video
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.copywriting') }}" class="nav-link {{ request()->routeIs('feature.copywriting') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                            Copywriting (Ads)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.essay') }}" class="nav-link {{ request()->routeIs('feature.essay') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            Essay
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.e-kinerja') }}" class="nav-link {{ request()->routeIs('feature.e-kinerja') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                            E-Kinerja
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.e-kinerja-atasan') }}" class="nav-link {{ request()->routeIs('feature.e-kinerja-atasan') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            E-Kinerja (Atasan)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.news') }}" class="nav-link {{ request()->routeIs('feature.news') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" /><path d="M8 8l4 0" /><path d="M8 12l4 0" /><path d="M8 16l4 0" /></svg>
                            Berita AI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.speech') }}" class="nav-link {{ request()->routeIs('feature.speech') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 2m0 3a3 3 0 0 1 3 -3h0a3 3 0 0 1 3 3v5a3 3 0 0 1 -3 3h0a3 3 0 0 1 -3 -3z" /><path d="M5 10a7 7 0 0 0 14 0" /><path d="M8 21l8 0" /><path d="M12 17l0 4" /></svg>
                            Kata Sambutan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('feature.social-media') }}" class="nav-link {{ request()->routeIs('feature.social-media') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="4" /><circle cx="12" cy="12" r="3" /><line x1="16.5" y1="7.5" x2="16.5" y2="7.501" /></svg>
                            Social Media
                        </a>
                    </li>

                    <div class="hr-text text-muted small mt-3 mb-2" style="opacity: 0.5;">Lainnya</div>

                    <li class="nav-item">
                        <a href="{{ route('billing.index') }}" class="nav-link {{ request()->routeIs('billing.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            Pembayaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            Pengaturan
                        </a>
                    </li>

          </ul>

                <!-- Footer -->
                <div class="sidebar-footer">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                         <div class="text-white small fw-bold" style="opacity: 0.7;">Mode Tampilan</div>
                         <x-theme-toggle />
                    </div>


                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false" style="padding-right: 1rem;">
                            @if(Auth::user()->avatar)
                                <span class="avatar avatar-sm rounded-circle me-2 border border-2 border-primary" style="background-image: url({{ asset('storage/' . Auth::user()->avatar) }}); background-size: cover;"></span>
                            @else
                                <span class="avatar avatar-sm rounded-circle me-2 border border-2 border-primary" style="background-image: url(https://preview.tabler.io/static/avatars/000m.jpg)"></span>
                            @endif
                            <div class="overflow-hidden d-none d-lg-block">
                                <div class="text-truncate fw-bold fs-5">{{ Auth::user()->name }}</div>
                                <div class="small text-muted text-truncate" style="opacity: 0.7;">{{ Auth::user()->plan_name ?? 'Free Plan' }}</div>
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
                            Install App
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Toggle fix inside sidebar structure if needed, or kept in header -->
            <!-- Typically toggle is in main layout header for mobile, but here for structure correctness -->
        </div>
      </aside>

      <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
            {{ $slot }}
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="{{ asset('js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('js/demo.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Dibatasi',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#d63939',
                });
            @endif
        });
    </script>
    @stack('scripts')
    <!-- Global Loading Script for AI Generation -->
    <!-- Global Loading Script for AI Generation -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // --- SMART AUTO-SAVE SYSTEM ---
        const forms = document.querySelectorAll('form');
        const STORAGE_PREFIX = 'ketik_draft_';

        forms.forEach(form => {
            // Unique ID for this form based on action URL
            const formId = STORAGE_PREFIX + btoa(form.action).slice(0, 16);
            
            // 1. Restore Logic
            const restoreData = () => {
                const draft = localStorage.getItem(formId);
                if (draft) {
                    try {
                        const data = JSON.parse(draft);
                        let restoredCount = 0;
                        
                        Object.keys(data).forEach(name => {
                            const input = form.querySelector(`[name="${name}"]`);
                            if (input && !input.value) { // Only restore if empty (don't overwrite server-side old input)
                                input.value = data[name];
                                restoredCount++;
                            }
                        });

                        if (restoredCount > 0) {
                             // Show small toast
                             const toast = document.createElement('div');
                             toast.className = 'position-fixed bottom-0 end-0 p-3';
                             toast.style.zIndex = '1100';
                             toast.innerHTML = `
                                <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4" /></svg>
                                            Draf tulisan Anda dipulihkan otomatis.
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                             `;
                             document.body.appendChild(toast);
                             setTimeout(() => toast.remove(), 4000);
                        }
                    } catch (e) {
                        console.error('Failed to restore draft', e);
                    }
                }
            };

            // Call restore immediately
            restoreData();

            // 2. Save Logic (Debounced)
            let saveTimeout;
            const saveDraft = () => {
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                     // Skip csrf token and passwords
                     if (key !== '_token' && key !== 'password' && typeof value === 'string') {
                         data[key] = value;
                     }
                });
                localStorage.setItem(formId, JSON.stringify(data));
                
                // Visual Indicator 'Disimpan...'
                showSavingIndicator();
            };

            const showSavingIndicator = () => {
                let indicator = document.getElementById('save-indicator');
                if (!indicator) {
                    indicator = document.createElement('div');
                    indicator.id = 'save-indicator';
                    indicator.className = 'text-muted small position-fixed bottom-0 start-0 p-3';
                    indicator.style.zIndex = '1000';
                    indicator.style.transition = 'opacity 0.5s';
                    document.body.appendChild(indicator);
                }
                indicator.innerHTML = '<span class="status-dot status-dot-animated bg-green me-2"></span>Menyimpan draf otomatis...';
                indicator.style.opacity = '1';
                
                setTimeout(() => {
                    indicator.style.opacity = '0';
                }, 2000);
            };

            form.addEventListener('input', () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(saveDraft, 1000); // Save 1s after typing stops
            });

            // 3. Clear Logic on Success
            // If the user submits, we don't clear immediately because it might fail.
            // We only clear if likely successful or specifically requested. 
            // Actually, keeping the draft until manually cleared or successfully redirected is safer.
            // For now, let's keep it. If they come back, it restores. If they change it, it updates.
        });


        // --- FORM SUBMISSION & SMART TIMEOUT ---
        forms.forEach(form => {
          form.addEventListener('submit', function(e) {
            if (this.checkValidity()) {
              const submitBtn = this.querySelector('button[type="submit"]');
              
              if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
              }

              const isDarkMode = document.body.classList.contains('theme-dark');

              // Initial Loading Alert
              let popup = Swal.fire({
                title: 'Sedang Berpikir...',
                text: 'AI sedang menyusun tulisan terbaik untuk Anda. Mohon tunggu sebentar.',
                icon: 'info',
                background: isDarkMode ? '#1e293b' : '#ffffff',
                color: isDarkMode ? '#ffffff' : '#000000',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading();
                }
              });

              // Smart Timeout Logic (60 Seconds)
              setTimeout(() => {
                  Swal.update({
                      title: 'Sedang Bekerja Keras...',
                      text: 'Permintaan ini butuh waktu lebih lama karena AI sedang menyusun tabel/konten yang detail. Mohon jangan tutup halaman ini.',
                      icon: 'warning',
                      showConfirmButton: false
                  });
              }, 60000); // 1 minute warning

              // Extended Timeout Logic (90 Seconds) - Reassure Safety
              setTimeout(() => {
                  Swal.update({
                      title: 'Koneksi Lambat?',
                      html: `
                        Waktu proses hampir habis. Jika halaman ini macet:
                        <br><br>
                        <strong>Jangan khawatir!</strong> Data yang Anda ketik sudah tersimpan otomatis.
                        <br>
                        Anda aman untuk me-refresh halaman jika perlu.
                      `,
                      icon: 'question',
                      showConfirmButton: true,
                      confirmButtonText: 'Saya Mengerti, Tunggu Sebentar Lagi',
                      showCancelButton: true, 
                      cancelButtonText: 'Refresh Halaman',
                      cancelButtonColor: '#d63939'
                  }).then((result) => {
                      if (result.dismiss === Swal.DismissReason.cancel) {
                          location.reload();
                      } else {
                          Swal.showLoading(); // Resume spinning if they choose to wait
                      }
                  });
              }, 120000); // 2 minutes critical warning
            }
          });
        });
      });
    </script>
  </body>
</html>
