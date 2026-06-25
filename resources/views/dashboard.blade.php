<x-dashboard-layout>
<style>
.dash-hero {
    background: linear-gradient(135deg, #022c22 0%, #065f46 60%, #047857 100%);
    border-radius: 24px;
    padding: 2.5rem 2rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.75rem;
}
.dash-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(16,185,129,0.2) 0%, transparent 70%);
    border-radius: 50%;
}
.dash-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: 25%;
    width: 320px; height: 200px;
    background: radial-gradient(circle, rgba(52,211,153,0.12) 0%, transparent 70%);
    border-radius: 50%;
}
.dash-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .16s, box-shadow .16s;
    border-left: 4px solid transparent;
}
.dash-stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(0,0,0,.09); }
.feature-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .18s, box-shadow .18s;
    text-decoration: none !important;
    display: block;
    height: 100%;
}
.feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,.10); }
.feature-card .card-top { padding: 1.5rem 1.5rem 1rem; }
.feature-card .card-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.8rem 1.5rem;
    border-top: 1px solid #f3f4f6;
    font-size: 0.85rem;
    font-weight: 600;
}
</style>

<div class="container-xl" style="padding: 1.5rem 1.5rem 2.5rem;">

    @if(Auth::user()->package_type === 'worksheet_anak')
    {{-- ===== DASHBOARD ANAK ===== --}}
    <div class="dash-hero mb-4" style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); text-align: center; border-radius: 32px; padding: 4rem 2rem;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">🚀🌈✨</div>
        <h1 class="fw-bold mb-3" style="color:white; font-size:2.5rem; letter-spacing: 1px; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">Halo, {{ Auth::user()->name }}!</h1>
        <p style="color:#ccfbf1; font-size:1.2rem; max-width:600px; margin: 0 auto 2rem; line-height:1.6; font-weight: 500;">
            Selamat datang di Dunia Belajar! Yuk, kita mulai petualangan belajar hari ini dengan menyenangkan.
        </p>
        <a href="{{ route('academy.index') }}" class="btn fw-bold px-5 py-3" style="background:#f59e0b; color:white; border-radius:24px; font-size: 1.25rem; border:none; box-shadow:0 8px 24px rgba(245,158,11,.4); transition: transform 0.2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" class="me-2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Mulai Belajar Sekarang!
        </a>
    </div>
    <style>
        .dash-hero a.btn:hover {
            transform: scale(1.05) translateY(-4px);
        }
    </style>
    @else
    {{-- ===== DASHBOARD DEWASA ===== --}}
    <div class="dash-hero mb-4">
        <div class="row align-items-center position-relative" style="z-index:1;">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="background:rgba(16,185,129,0.2);color:#6ee7b7;border:1px solid rgba(16,185,129,0.3);border-radius:99px;font-size:0.72rem;font-weight:700;letter-spacing:0.08em;padding:4px 12px;">✍️ KETIK.IN</span>
                    @if(Auth::user()->isPremium())
                        <span style="background:rgba(245,158,11,0.2);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);border-radius:99px;font-size:0.72rem;font-weight:700;letter-spacing:0.06em;padding:4px 12px;">⭐ PREMIUM</span>
                    @endif
                </div>
                <h1 class="fw-bold mb-2" style="color:white;font-size:1.9rem;line-height:1.2;">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p style="color:rgba(167,243,208,0.85);font-size:0.93rem;margin-bottom:1.5rem;max-width:480px;line-height:1.6;">
                    Selamat datang kembali. Mulai buat konten AI berkualitas hari ini — cepat, mudah, dan profesional.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    @if(Auth::user()->hasUtamaAccess())
                    <a href="{{ route('feature.story-telling') }}" class="btn fw-semibold px-4" style="background:#10b981;color:white;border-radius:10px;border:none;box-shadow:0 4px 14px rgba(16,185,129,.35);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Buat Konten
                    </a>
                    @elseif(Auth::user()->hasGuruAccess())
                    <a href="{{ route('guru.index') }}" class="btn fw-semibold px-4" style="background:#10b981;color:white;border-radius:10px;border:none;box-shadow:0 4px 14px rgba(16,185,129,.35);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                        Mode Guru
                    </a>
                    @endif
                    <a href="{{ route('library.index') }}" class="btn fw-semibold px-4" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);border-radius:10px;backdrop-filter:blur(4px);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M3 12h1m16 0h1M12 3v1m0 16v1M5.6 5.6l.7.7m11.4-.7l-.7.7M5.6 18.4l.7-.7m11.4.7l-.7-.7"/><circle cx="12" cy="12" r="4"/></svg>
                        Pustaka Saya
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <div class="d-flex gap-3">
                    @php
                        $heroStats = [
                            ['val' => number_format($totalDocs),  'label' => 'Dokumen'],
                            ['val' => number_format($totalWords), 'label' => 'Total Kata'],
                            ['val' => $ebookCount,                'label' => 'E-book'],
                        ];
                    @endphp
                    @foreach($heroStats as $hs)
                    <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:16px;padding:1.25rem 1rem;text-align:center;min-width:88px;backdrop-filter:blur(8px);">
                        <div style="font-size:1.7rem;font-weight:800;color:white;line-height:1;">{{ $hs['val'] }}</div>
                        <div style="font-size:0.7rem;color:rgba(167,243,208,0.7);margin-top:4px;font-weight:500;">{{ $hs['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- PWA Install Banner --}}
    <div id="pwa-dashboard-install-card" class="card mb-4 d-none" style="background:linear-gradient(135deg,#10b981,#059669);border:none;border-radius:20px;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <span class="bg-white avatar rounded-circle me-3 shadow-sm" style="color:#059669;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 3m0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-8a2 2 0 0 1-2-2z"/><path d="M11 4h2"/><path d="M12 17v.01"/></svg>
                        </span>
                        <div>
                            <div class="fw-bold text-white">Install Aplikasi Ketik.in</div>
                            <div class="text-white-50 small">Akses lebih cepat & bisa offline!</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <button id="pwa-dashboard-install-btn" class="btn btn-light btn-sm fw-bold rounded-pill px-4">Install</button>
                </div>
            </div>
        </div>
    </div>
    <div id="ios-install-card" class="card mb-4 d-none" style="background:linear-gradient(135deg,#022c22,#065f46);border:none;border-radius:20px;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <span class="bg-white avatar rounded-circle me-3 shadow-sm" style="color:#059669;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 7c-3 0-4 3-4 5.5c0 3 2 7.5 4 7.5c1.088-.046 1.679-.5 3-.5c1.312 0 1.5.5 3 .5s4-3 4-5c-.028-.01-2.472-.403-2.5-3c-.019-2.17 2.416-2.954 2.5-3c-1.023-1.492-2.951-1.963-3.5-2c-1.433-.111-2.83 1-3.5 1c-.68 0-1.9-1-3-1z"/><path d="M12 4a2 2 0 0 0 2-2a2 2 0 0 0-2 2"/></svg>
                        </span>
                        <div>
                            <div class="fw-bold text-white">Install di iPhone/iPad</div>
                            <div class="text-white-50 small">Klik <strong>Share</strong> → <strong>Add to Home Screen</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STAT STRIP ===== --}}
    <div class="row g-3 mb-4">
        @php
            $dashStats = [
                ['val' => number_format($totalDocs),  'label' => 'Dokumen Dibuat',  'color' => '#10b981', 'bg' => '#d1fae5',
                 'icon' => 'M4 20h4l10.5-10.5a1.5 1.5 0 0 0-4-4L4 16v4 M13.5 6.5l4 4'],
                ['val' => number_format($totalWords), 'label' => 'Prakiraan Kata',  'color' => '#8b5cf6', 'bg' => '#ede9fe',
                 'icon' => 'M4 6h16 M4 12h16 M4 18h12'],
                ['val' => $ebookCount,                'label' => 'E-book Selesai',  'color' => '#f59e0b', 'bg' => '#fef3c7',
                 'icon' => 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20 M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z'],
                ['val' => $targetKinerja.'%',          'label' => 'Target Kinerja',  'color' => '#ef4444', 'bg' => '#fee2e2',
                 'icon' => 'M12 7l0 10 M9 10l0 7 M15 4l0 13'],
            ];
        @endphp
        @foreach($dashStats as $s)
        <div class="col-6 col-lg-3">
            <div class="dash-stat-card" style="border-left-color:{{ $s['color'] }};">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size:1.65rem;font-weight:800;color:#111827;line-height:1;">{{ $s['val'] }}</div>
                        <div class="text-secondary mt-1" style="font-size:0.8rem;font-weight:500;">{{ $s['label'] }}</div>
                    </div>
                    <div style="width:40px;height:40px;border-radius:10px;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="{{ $s['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            @foreach(explode(' M', $s['icon']) as $i => $path)
                                <path d="{{ ($i === 0 ? '' : 'M') . $path }}"/>
                            @endforeach
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ===== FITUR AI + CHART ===== --}}
    <div class="row g-4 mb-4">

        {{-- Feature Cards (kiri) --}}
        @if(Auth::user()->hasUtamaAccess())
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">✨ Fitur AI Unggulan</h5>
            </div>
            <div class="row g-3">
                @php
                    $features = [
                        ['label'=>'Story Telling', 'desc'=>'Buat cerita menarik dan kreatif dengan narasi yang mengalir.', 'route'=>'feature.story-telling', 'color'=>'#f59e0b', 'grad'=>'linear-gradient(135deg,#f59e0b,#d97706)',
                         'cta'=>'Buat Cerita', 'icon'=>'M12 20h9 M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z'],
                        ['label'=>'E-book',       'desc'=>'Generate e-book lengkap multi-bab untuk berbagai topik.', 'route'=>'feature.ebook',        'color'=>'#8b5cf6', 'grad'=>'linear-gradient(135deg,#8b5cf6,#7c3aed)',
                         'cta'=>'Buat E-book', 'icon'=>'M4 19.5A2.5 2.5 0 0 1 6.5 17H20 M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z'],
                        ['label'=>'Essay',        'desc'=>'Tulis esai argumentatif akademis dengan struktur yang kuat.', 'route'=>'feature.essay',        'color'=>'#3b82f6', 'grad'=>'linear-gradient(135deg,#3b82f6,#2563eb)',
                         'cta'=>'Tulis Essay', 'icon'=>'M4 6h16 M4 12h16 M4 18h7'],
                        ['label'=>'Copywriting',  'desc'=>'Teks iklan dan sales copy yang persuasif dan konversi tinggi.', 'route'=>'feature.copywriting',  'color'=>'#ec4899', 'grad'=>'linear-gradient(135deg,#ec4899,#db2777)',
                         'cta'=>'Buat Copy', 'icon'=>'M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3'],
                        ['label'=>'Laporan',      'desc'=>'Buat laporan profesional lengkap dengan analisis mendalam.', 'route'=>'feature.laporan',      'color'=>'#10b981', 'grad'=>'linear-gradient(135deg,#10b981,#059669)',
                         'cta'=>'Buat Laporan', 'icon'=>'M9 12h6 M9 16h6 M9 8h6 M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z'],
                        ['label'=>'E-Kinerja',    'desc'=>'Susun dokumen kinerja SKP dan RHK sesuai regulasi ASN.', 'route'=>'feature.e-kinerja',    'color'=>'#ef4444', 'grad'=>'linear-gradient(135deg,#ef4444,#dc2626)',
                         'cta'=>'Buat Kinerja', 'icon'=>'M9 11l3 3L22 4 M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11'],
                        ['label'=>'Surat',        'desc'=>'Buat surat resmi dan formal dengan bahasa yang tepat.', 'route'=>'feature.surat',        'color'=>'#06b6d4', 'grad'=>'linear-gradient(135deg,#06b6d4,#0891b2)',
                         'cta'=>'Buat Surat', 'icon'=>'M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8 M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z'],
                        ['label'=>'SOP',          'desc'=>'Susun prosedur operasional standar yang terstruktur rapi.', 'route'=>'feature.sop',          'color'=>'#f97316', 'grad'=>'linear-gradient(135deg,#f97316,#ea580c)',
                         'cta'=>'Buat SOP', 'icon'=>'M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2 M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2 M9 5a2 2 0 0 0 2-2h2a2 2 0 0 0 2 2 M12 12h.01 M12 16h.01'],
                    ];
                @endphp
                @foreach($features as $f)
                <div class="col-sm-6">
                    <a href="{{ route($f['route']) }}" class="feature-card">
                        <div class="card-top">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div style="width:44px;height:44px;border-radius:12px;background:{{ $f['grad'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,.12);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        @foreach(explode(' M', $f['icon']) as $i => $path)
                                            <path d="{{ ($i === 0 ? '' : 'M') . $path }}"/>
                                        @endforeach
                                    </svg>
                                </div>
                                <div class="fw-bold" style="font-size:0.95rem;">{{ $f['label'] }}</div>
                            </div>
                            <p class="text-secondary mb-0" style="font-size:0.8rem;line-height:1.5;">{{ $f['desc'] }}</p>
                        </div>
                        <div class="card-cta" style="color:{{ $f['color'] }};">
                            <span>{{ $f['cta'] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Chart + quick links (kanan) --}}
        <div class="{{ Auth::user()->hasUtamaAccess() ? 'col-lg-4' : 'col-lg-6' }}">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">📊 Aktivitas 7 Hari</h5>
            </div>
            <div class="card border-0 mb-3" style="border-radius:16px;box-shadow:0 2px 16px rgba(16,185,129,.07);">
                <div class="card-body p-3">
                    <div id="chart-content-trend" style="min-height:200px;"></div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">🔗 Akses Cepat</h5>
            </div>
            <div class="card border-0" style="border-radius:16px;box-shadow:0 2px 16px rgba(16,185,129,.07);">
                <div class="card-body p-3">
                    @php
                        $quickLinks = [
                            ['label'=>'Pustaka Dokumen', 'route'=>'library.index',    'icon'=>'M19 11H5m14 0a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2m14 0V9a2 2 0 0 0-2-2M5 11V9a2 2 0 0 1 2-2m0 0V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2M7 7h10', 'color'=>'#10b981'],
                            ['label'=>'Academy',          'route'=>'academy.index',    'icon'=>'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z', 'color'=>'#8b5cf6'],
                            ['label'=>'Langganan',        'route'=>'billing.index',    'icon'=>'M3 10h18 M7 15h1m4 0h1m-7 4h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z', 'color'=>'#f59e0b'],
                            ['label'=>'Profil Saya',      'route'=>'profile.edit',     'icon'=>'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z M12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z', 'color'=>'#ef4444'],
                        ];
                    @endphp
                    <div class="d-grid gap-2">
                        @foreach($quickLinks as $ql)
                        <a href="{{ route($ql['route']) }}" class="d-flex align-items-center text-decoration-none p-2 rounded-2" style="transition:background .15s;" onmouseover="this.style.background='#f0fdf9'" onmouseout="this.style.background='transparent'">
                            <div style="width:34px;height:34px;border-radius:9px;background:{{ $ql['color'] }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="{{ $ql['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    @foreach(explode(' M', $ql['icon']) as $i => $path)
                                        <path d="{{ ($i === 0 ? '' : 'M') . $path }}"/>
                                    @endforeach
                                </svg>
                            </div>
                            <span class="fw-semibold" style="font-size:0.875rem;color:#374151;">{{ $ql['label'] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24" class="ms-auto"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== DISTRIBUSI FITUR ===== --}}
    <div class="row g-4">
        @if(Auth::user()->hasUtamaAccess())
        <div class="col-lg-5">
            <div class="card border-0" style="border-radius:16px;box-shadow:0 2px 16px rgba(16,185,129,.07);">
                <div class="card-body">
                    <h5 class="fw-bold mb-1">Distribusi Fitur</h5>
                    <p class="text-secondary small mb-2">Proporsi penggunaan fitur AI Anda</p>
                    <div id="chart-feature-dist" style="min-height:220px;"></div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="{{ Auth::user()->hasUtamaAccess() ? 'col-lg-7' : 'col-lg-6' }}">
            <div class="card border-0 h-100" style="border-radius:16px;box-shadow:0 2px 16px rgba(16,185,129,.07);background:linear-gradient(135deg,#022c22 0%,#065f46 100%);">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <span style="background:rgba(16,185,129,.2);color:#6ee7b7;border:1px solid rgba(16,185,129,.3);border-radius:99px;font-size:0.7rem;font-weight:700;padding:3px 10px;">💡 Tips Hari Ini</span>
                        <h4 class="fw-bold text-white mt-3 mb-2">Maksimalkan Produktivitas Anda</h4>
                        <p style="color:rgba(167,243,208,.8);font-size:0.9rem;line-height:1.7;">
                            Coba <strong class="text-white">Mode Guru</strong> untuk membuat Modul Ajar Deep Learning, soal, dan rekap nilai lengkap dengan AI — dirancang khusus untuk guru Kurikulum Merdeka.
                        </p>
                    </div>
                    <div class="d-flex gap-2 mt-3 flex-wrap">
                        @if(Auth::user()->hasGuruAccess())
                        <a href="{{ route('guru.index') }}" class="btn btn-sm fw-semibold" style="background:#10b981;color:white;border-radius:8px;border:none;">Coba Mode Guru →</a>
                        @endif
                        @if(Auth::user()->hasAcademyAccess())
                        <a href="{{ route('academy.index') }}" class="btn btn-sm fw-semibold" style="background:rgba(255,255,255,.1);color:white;border:1px solid rgba(255,255,255,.2);border-radius:8px;">Belajar di Academy</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-content-trend'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 200,
                    parentHeightOffset: 0,
                    toolbar: { show: false },
                    animations: { enabled: true },
                },
                dataLabels: { enabled: false },
                fill: { opacity: .16, type: 'solid' },
                stroke: { width: 2, lineCap: "round", curve: "smooth" },
                series: [{
                    name: "Dokumen",
                    data: @json($chartCounts)
                }],
                grid: {
                    padding: { top: -20, right: 0, left: -4, bottom: -4 },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: { padding: 0 },
                    tooltip: { enabled: false },
                    axisBorder: { show: false },
                    categories: @json($chartDays),
                },
                yaxis: { labels: { padding: 4 } },
                colors: ["#10b981"],
                legend: { show: false },
            })).render();

            window.ApexCharts && (new ApexCharts(document.getElementById('chart-feature-dist'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 220,
                    sparkline: { enabled: false },
                    animations: { enabled: true },
                },
                fill: { opacity: 1 },
                series: @json($featureDist),
                labels: ["Story", "E-book", "Opini", "Script", "Essay", "E-Kinerja"],
                grid: { strokeDashArray: 4 },
                colors: ["#10b981", "#059669", "#34d399", "#6ee7b7", "#a7f3d0", "#d1fae5"],
                legend: { show: true, position: 'bottom', offsetTop: 12 },
                tooltip: { fillSeriesColor: false },
            })).render();
        });

        // --- DEVICE BINDING MODAL ---
        @if(session('device_needs_binding'))
        Swal.fire({
            title: 'Ikat Perangkat Ini?',
            html: '<p class="text-muted mb-0">Untuk keamanan akun, sistem Ketik.in mengharuskan <strong>1 akun hanya untuk 1 perangkat</strong>.</p><p class="text-muted mt-2">Apakah Anda ingin menjadikan perangkat ini sebagai perangkat utama Anda?</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ikat Sekarang',
            cancelButtonText: 'Nanti',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to bind device
                fetch('{{ route('device.binding.confirm') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonColor: '#10b981'
                    });
                });
            }
        });
        @endif
    </script>
    @endpush
</x-dashboard-layout>
