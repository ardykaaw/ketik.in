<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name', 'Ketik.in') }}</title>
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
      }
    </style>
  </head>
  <body class="d-flex flex-column bg-white">
    <div class="page d-flex flex-column position-relative gradient-bg" style="min-height: 100vh;">
      <!-- Floating Shapes -->
      <div class="position-absolute" style="top: -150px; right: -150px; width: 600px; height: 600px; background: radial-gradient(circle, rgba(255, 255, 255, 0.4) 0%, transparent 70%); border-radius: 50%; z-index: 0; animation: float 10s ease-in-out infinite;"></div>
      <div class="position-absolute" style="bottom: -200px; left: -200px; width: 700px; height: 700px; background: radial-gradient(circle, rgba(117, 173, 219, 0.15) 0%, transparent 70%); border-radius: 50%; z-index: 0; animation: float 14s ease-in-out infinite reverse;"></div>
      
      <div class="container container-tight my-auto py-4 position-relative" style="z-index: 1;">
        <div class="text-center mb-2 animate-fade-in-down">
          <a href="/" class="d-flex align-items-center justify-content-center text-decoration-none">
            <!-- Logo using Brand Primary Color for contrast on light bg -->
            <x-animated-logo height="64px" color="#234f70" />
          </a>
        </div>
        <div class="animate-fade-in-up">
            {{ $slot }}
        </div>
        <div class="text-center text-muted mt-3 animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0.8; font-weight: 500;">
          &copy; {{ date('Y') }} Ketik.in
        </div>
      </div>
    </div>

    <style>
      /* Dynamic Gradient Background */
      .gradient-bg {
        background: linear-gradient(-45deg, #EDF3F8, #e0f2fe, #dbeafe, #f1f5f9);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
      }

      @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
      }

      @keyframes fadeInUp {
        from { opacity: 0; transform: translate3d(0, 40px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
      }
      @keyframes fadeInDown {
        from { opacity: 0; transform: translate3d(0, -40px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
      }
      @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
      }
      .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
      }
      .animate-fade-in-down {
        animation: fadeInDown 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
      }
      
      /* Dark mode adjustment for auth card */
      [data-theme="dark"] .gradient-bg {
         background: linear-gradient(-45deg, #070d12, #0f172a, #1e293b, #070d12);
         background-size: 400% 400%;
      }
      [data-theme="dark"] .card {
         background: rgba(12, 18, 24, 0.6) !important;
         border: 1px solid rgba(255,255,255,0.08) !important;
         box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
      }
    </style>
    <!-- Libs JS -->
    <script src="{{ asset('js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('js/demo.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
  </body>
</html>
