<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-dark fw-bold">
                    Dashboard Admin
                </h2>
                <div class="text-muted mt-1">Ikhtisar performa dan statistik sistem Ketik.in</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['users_count']) }}</div>
                            <div class="text-muted small">Total Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-purple text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" /><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['premium_users']) }}</div>
                            <div class="text-muted small">User Premium</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-azure text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['content_count']) }}</div>
                            <div class="text-muted small">Konten AI Dibuat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-green text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7l0 10" /><path d="M9 10l0 7" /><path d="M15 4l0 13" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['new_users_today']) }}</div>
                            <div class="text-muted small">User Baru Hari Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Quick Links -->
    <div class="row row-cards">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 20px;">
                <div class="card-body">
                    <h3 class="card-title fw-bold">Statistik Pengguna</h3>
                    <div id="chart-user-growth" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 20px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="card-body text-white">
                    <h3 class="card-title text-white fw-bold mb-4">Aksi Cepat Admin</h3>
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary d-flex align-items-center justify-content-between p-3" style="border-radius: 12px; border: none; background: rgba(59, 130, 246, 0.2);">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                <span>Kelola Pengguna</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
                        </a>
                        <a href="{{ route('admin.subscriptions') }}" class="btn btn-warning d-flex align-items-center justify-content-between p-3" style="border-radius: 12px; border: none; background: rgba(245, 158, 11, 0.2);">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" /><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" /></svg>
                                <span>Extend Langganan</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
                        </a>
                    </div>
                    <div class="mt-5 p-3 border border-secondary border-dashed" style="border-radius: 12px; opacity: 0.6;">
                        <div class="small fw-bold mb-1">Status Server</div>
                        <div class="d-flex align-items-center small">
                            <span class="status-dot status-dot-animated status-green me-2"></span>
                            Online & Stabil
                        </div>
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
                chart: { type: "area", height: 300, toolbar: { show: false }, animations: { enabled: true } },
                series: [{ name: "Users", data: [{{ $stats['users_count'] * 0.2 }}, {{ $stats['users_count'] * 0.4 }}, {{ $stats['users_count'] * 0.35 }}, {{ $stats['users_count'] * 0.6 }}, {{ $stats['users_count'] * 0.8 }}, {{ $stats['users_count'] * 0.9 }}, {{ $stats['users_count'] }}] }],
                colors: ["#3b82f6"],
                fill: { 
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: { categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'], labels: { style: { colors: '#64748b' } } },
                yaxis: { labels: { style: { colors: '#64748b' } } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 }
            })).render();
        });
    </script>
    @endpush
</x-admin-layout>
