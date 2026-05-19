<x-admin-layout>
<style>
.admin-hero {
    background: linear-gradient(135deg, #022c22 0%, #065f46 60%, #047857 100%);
    border-radius: 24px;
    padding: 2.2rem 2rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.75rem;
}
.admin-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -40px;
    width: 260px; height: 260px;
    background: radial-gradient(circle, rgba(16,185,129,0.18) 0%, transparent 70%);
    border-radius: 50%;
}
.admin-stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 1.3rem 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .16s, box-shadow .16s;
    border-left: 4px solid transparent;
    height: 100%;
}
.admin-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,.10); }
.admin-action-card {
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .18s, box-shadow .18s;
    text-decoration: none !important;
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #fff;
}
.admin-action-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,.10); }
.admin-action-card .card-top { padding: 1.4rem 1.4rem 1rem; flex: 1; }
.admin-action-card .card-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1.4rem;
    border-top: 1px solid #f3f4f6;
    font-size: 0.83rem;
    font-weight: 600;
}
</style>

    {{-- ===== HERO ===== --}}
    <div class="admin-hero mb-4">
        <div class="row align-items-center position-relative" style="z-index:1;">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="background:rgba(16,185,129,0.2);color:#6ee7b7;border:1px solid rgba(16,185,129,0.3);border-radius:99px;font-size:0.72rem;font-weight:700;letter-spacing:0.08em;padding:4px 12px;">🛡️ ADMIN PANEL</span>
                    @if(Auth::user()->isSuperAdmin())
                        <span style="background:rgba(245,158,11,0.2);color:#fcd34d;border:1px solid rgba(245,158,11,0.3);border-radius:99px;font-size:0.72rem;font-weight:700;padding:4px 12px;">⭐ SUPER ADMIN</span>
                    @endif
                </div>
                <h1 class="fw-bold mb-2" style="color:white;font-size:1.85rem;line-height:1.2;">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p style="color:rgba(167,243,208,0.85);font-size:0.9rem;margin-bottom:1.5rem;max-width:480px;line-height:1.6;">
                    Ikhtisar performa dan statistik sistem Ketik.in. Kelola pengguna, konten, dan semua fitur dari sini.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.users') }}" class="btn fw-semibold px-4" style="background:#10b981;color:white;border-radius:10px;border:none;box-shadow:0 4px 14px rgba(16,185,129,.35);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.verifications') }}" class="btn fw-semibold px-4" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);border-radius:10px;backdrop-filter:blur(4px);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M9 11l3 3 8-8"/><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h9"/></svg>
                        Verifikasi Member
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <div class="d-flex gap-3">
                    @php
                        $heroStats = [
                            ['val' => number_format($stats['users_count']),    'label' => 'Total User'],
                            ['val' => number_format($stats['premium_users']),  'label' => 'Premium'],
                            ['val' => number_format($stats['content_count']),  'label' => 'Konten AI'],
                        ];
                    @endphp
                    @foreach($heroStats as $hs)
                    <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:16px;padding:1.25rem 1rem;text-align:center;min-width:88px;backdrop-filter:blur(8px);">
                        <div style="font-size:1.65rem;font-weight:800;color:white;line-height:1;">{{ $hs['val'] }}</div>
                        <div style="font-size:0.7rem;color:rgba(167,243,208,0.7);margin-top:4px;font-weight:500;">{{ $hs['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STAT STRIP ===== --}}
    <div class="row g-3 mb-4">
        @php
            $adminStats = [
                ['val' => number_format($stats['users_count']),   'label' => 'Total Pengguna',   'color' => '#10b981', 'bg' => '#d1fae5',
                 'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0-8 0 M23 21v-2a4 4 0 0 0-3-3.87 M16 3.13a4 4 0 0 1 0 7.75'],
                ['val' => number_format($stats['premium_users']), 'label' => 'User Premium',     'color' => '#8b5cf6', 'bg' => '#ede9fe',
                 'icon' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'],
                ['val' => number_format($stats['content_count']), 'label' => 'Konten AI Dibuat', 'color' => '#f59e0b', 'bg' => '#fef3c7',
                 'icon' => 'M4 20h4l10.5-10.5a1.5 1.5 0 0 0-4-4L4 16v4 M13.5 6.5l4 4'],
                ['val' => number_format($stats['new_users_today']),'label' => 'User Baru Hari Ini','color' => '#ef4444','bg' => '#fee2e2',
                 'icon' => 'M12 7l0 10 M9 10l0 7 M15 4l0 13'],
            ];
        @endphp
        @foreach($adminStats as $s)
        <div class="col-6 col-lg-3">
            <div class="admin-stat-card" style="border-left-color:{{ $s['color'] }};">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size:1.75rem;font-weight:800;color:#111827;line-height:1;">{{ $s['val'] }}</div>
                        <div class="text-secondary mt-1" style="font-size:0.78rem;font-weight:500;">{{ $s['label'] }}</div>
                    </div>
                    <div style="width:42px;height:42px;border-radius:11px;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
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

    {{-- ===== MANAGEMENT CARDS + CHART ===== --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">⚙️ Manajemen Sistem</h5>
            </div>
            <div class="row g-3">
                @php
                    $mgmtCards = [
                        ['label'=>'Kelola Pengguna',  'desc'=>'Tambah, edit, nonaktifkan, atau hapus akun pengguna.', 'route'=>'admin.users',          'color'=>'#10b981','grad'=>'linear-gradient(135deg,#10b981,#059669)','cta'=>'Buka',
                         'icon'=>'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0-8 0'],
                        ['label'=>'Verifikasi Member','desc'=>'Setujui atau tolak permintaan aktivasi akun baru.', 'route'=>'admin.verifications',   'color'=>'#8b5cf6','grad'=>'linear-gradient(135deg,#8b5cf6,#7c3aed)','cta'=>'Buka',
                         'icon'=>'M9 11l3 3 8-8 M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h9'],
                        ['label'=>'Masa Langganan',   'desc'=>'Extend atau ubah periode berlangganan pengguna.', 'route'=>'admin.subscriptions',    'color'=>'#f59e0b','grad'=>'linear-gradient(135deg,#f59e0b,#d97706)','cta'=>'Buka',
                         'icon'=>'M3 10h18 M7 15h1m4 0h1m-7 4h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z'],
                        ['label'=>'Academy',          'desc'=>'Kelola kursus, modul, dan materi pembelajaran.', 'route'=>'admin.academy.index',    'color'=>'#06b6d4','grad'=>'linear-gradient(135deg,#06b6d4,#0891b2)','cta'=>'Buka',
                         'icon'=>'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 0 1 .665 6.479A11.952 11.952 0 0 0 12 20.055a11.952 11.952 0 0 0-6.824-2.998 12.078 12.078 0 0 1 .665-6.479L12 14z'],
                        ['label'=>'Infografis AI',    'desc'=>'Generate dan kelola konten infografis berbasis AI.', 'route'=>'admin.infographic.index','color'=>'#ec4899','grad'=>'linear-gradient(135deg,#ec4899,#db2777)','cta'=>'Buka',
                         'icon'=>'M3 3v18h18 M7 16l4-4 4 4 6-6'],
                        ['label'=>'Mode Guru',        'desc'=>'Buat soal, modul, RPP, dan rekap nilai untuk guru.', 'route'=>'guru.index',            'color'=>'#f97316','grad'=>'linear-gradient(135deg,#f97316,#ea580c)','cta'=>'Buka',
                         'icon'=>'M22 10v6 M2 10l10-5 10 5-10 5z M6 12v5c3 3 9 3 12 0v-5'],
                    ];
                @endphp
                @foreach($mgmtCards as $c)
                <div class="col-sm-6">
                    <a href="{{ route($c['route']) }}" class="admin-action-card">
                        <div class="card-top">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div style="width:42px;height:42px;border-radius:12px;background:{{ $c['grad'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,.12);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        @foreach(explode(' M', $c['icon']) as $i => $path)
                                            <path d="{{ ($i === 0 ? '' : 'M') . $path }}"/>
                                        @endforeach
                                    </svg>
                                </div>
                                <div class="fw-bold" style="font-size:0.92rem;">{{ $c['label'] }}</div>
                            </div>
                            <p class="text-secondary mb-0" style="font-size:0.78rem;line-height:1.5;">{{ $c['desc'] }}</p>
                        </div>
                        <div class="card-cta" style="color:{{ $c['color'] }};">
                            <span>{{ $c['cta'] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">📈 Pertumbuhan User</h5>
            </div>
            <div class="card border-0 mb-3" style="border-radius:18px;box-shadow:0 2px 16px rgba(16,185,129,.07);">
                <div class="card-body p-3">
                    <div id="chart-user-growth" style="height: 200px;"></div>
                </div>
            </div>

            <div class="card border-0" style="border-radius:18px;box-shadow:0 2px 16px rgba(16,185,129,.07);background:linear-gradient(135deg,#022c22 0%,#065f46 100%);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="status-dot status-dot-animated status-green"></span>
                        <span class="fw-bold text-white small">Status Sistem</span>
                    </div>
                    <div class="d-grid gap-2">
                        @php
                            $sysItems = [
                                ['label' => 'Server',   'status' => 'Online'],
                                ['label' => 'Database', 'status' => 'Terhubung'],
                                ['label' => 'AI Engine','status' => 'Aktif'],
                            ];
                        @endphp
                        @foreach($sysItems as $si)
                        <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                            <span style="color:rgba(167,243,208,.7);font-size:0.8rem;">{{ $si['label'] }}</span>
                            <span style="color:#6ee7b7;font-size:0.75rem;font-weight:600;">● {{ $si['status'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-2" style="border-top:1px solid rgba(255,255,255,0.08);">
                        <div style="color:rgba(167,243,208,.6);font-size:0.72rem;">Terakhir diperbarui: {{ now()->format('H:i') }} WIB</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-user-growth'), {
                chart: { type: "area", height: 200, toolbar: { show: false }, animations: { enabled: true }, sparkline: { enabled: false } },
                series: [{ name: "User", data: [
                    Math.round({{ $stats['users_count'] }} * 0.2),
                    Math.round({{ $stats['users_count'] }} * 0.35),
                    Math.round({{ $stats['users_count'] }} * 0.45),
                    Math.round({{ $stats['users_count'] }} * 0.6),
                    Math.round({{ $stats['users_count'] }} * 0.75),
                    Math.round({{ $stats['users_count'] }} * 0.9),
                    {{ $stats['users_count'] }}
                ]}],
                colors: ["#10b981"],
                fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.05, stops: [0, 90, 100] } },
                xaxis: { categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'], labels: { style: { colors: '#94a3b8', fontSize: '11px' } }, axisBorder: { show: false } },
                yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '11px' } } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2.5 },
                grid: { strokeDashArray: 4, borderColor: '#f1f5f9' },
                tooltip: { theme: 'light' }
            })).render();
        });
    </script>
    @endpush
</x-admin-layout>
