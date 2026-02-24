<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-dark fw-bold">
                    Super Admin Monitoring
                </h2>
                <div class="text-muted mt-1">Status real-time sistem, trafik, dan penggunaan AI Ketik.in</div>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="{{ route('admin.super.traffic') }}" class="btn btn-outline-primary border-2 px-4 shadow-sm" style="border-radius: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12h4l3 8l4 -16l3 8h4" /></svg>
                        Trafik Real-time
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0 bg-primary-lt" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center text-primary">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['total_users']) }}</div>
                            <div class="small fw-bold">Total Pengguna</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0 bg-green-lt" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center text-green">
                        <div class="col-auto">
                            <span class="bg-green text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7l0 10" /><path d="M9 10l0 7" /><path d="M15 4l0 13" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['online_users']) }}</div>
                            <div class="small fw-bold">User Online (5m)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0 bg-purple-lt" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center text-purple">
                        <div class="col-auto">
                            <span class="bg-purple text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ number_format($stats['daily_ai_content']) }}</div>
                            <div class="small fw-bold">AI Content Today</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm shadow-sm border-0 bg-{{ $stats['api_success_rate'] > 90 ? 'blue' : 'orange' }}-lt" style="border-radius: 16px;">
                <div class="card-body p-3">
                    <div class="row align-items-center text-{{ $stats['api_success_rate'] > 90 ? 'blue' : 'orange' }}">
                        <div class="col-auto">
                            <span class="bg-{{ $stats['api_success_rate'] > 90 ? 'blue' : 'orange' }} text-white avatar shadow-sm" style="border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="7 8 3 12 7 16" /><polyline points="17 8 21 12 17 16" /><line x1="14" y1="4" x2="10" y2="20" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-bold fs-2">{{ $stats['api_success_rate'] }}%</div>
                            <div class="small fw-bold">API Health Today</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts -->
    <div class="row row-cards mb-4">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="card-title fw-bold m-0">Trafik & Produksi AI (Last 7 Days)</h3>
                        <div class="badge bg-green-lt px-2 py-1">Live Update</div>
                    </div>
                    <div id="super-admin-chart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-lg border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold mb-4">API Health Monitor</h3>
                    <div id="api-health-chart" style="height: 200px;"></div>
                    <div class="mt-4">
                        <h3 class="card-title fw-bold mb-3">Top AI Creators</h3>
                        <div class="list-group list-group-flush">
                            @forelse($topUsers as $user)
                            <div class="list-group-item px-0 py-3 border-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if($user->avatar)
                                            <span class="avatar rounded-circle" style="background-image: url({{ asset('storage/' . $user->avatar) }})"></span>
                                        @else
                                            <span class="avatar rounded-circle bg-primary-lt fw-bold">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->contents_count }} konten dibuat</div>
                                    </div>
                                    <div class="col-auto text-end">
                                        <div class="badge bg-azure-lt px-2 py-1">{{ number_format(($user->contents_count / ($stats['total_users'] ?: 1)) * 100, 1) }}%</div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-muted small">Belum ada data kreator.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Errors -->
    <div class="row row-cards">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold m-0 text-danger d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg>
                        API Error Logs (Recent)
                    </h3>
                    <div class="text-muted small">Membantu debugging penggunaan Gemini AI</div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3">User</th>
                                <th class="py-3">Feature</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Error Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($errorLogs as $log)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold">{{ $log->user->name }}</div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary-lt">{{ strtoupper($log->feature_type) }}</span></td>
                                <td class="text-muted small">{{ $log->created_at->format('d M H:i') }}</td>
                                <td>
                                    <div class="text-danger small" style="max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $log->error_message }}">
                                        {{ $log->error_message }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-success fw-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                                        Semua API berjalan lancar! Tidak ada error terdeteksi.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chartEl = document.querySelector("#super-admin-chart");
            const apiChartEl = document.querySelector("#api-health-chart");

            if (!chartEl || !apiChartEl) return;

            fetch('{{ route("admin.super.analytics") }}')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Check if we have data to show
                    const hasData = data.content.some(v => v > 0) || data.traffic.some(v => v > 0);
                    
                    // Main Activity Chart
                    const options = {
                        series: [
                            { name: 'Produksi AI', data: data.content },
                            { name: 'Trafik Sistem', data: data.traffic }
                        ],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: { show: false },
                            animations: { enabled: true }
                        },
                        colors: ['#7c3aed', '#3b82f6'],
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: {
                            categories: data.dates,
                            labels: { style: { colors: '#64748b' } }
                        },
                        yaxis: {
                            labels: { 
                                style: { colors: '#64748b' },
                                formatter: function(val) { return Math.floor(val); }
                            }
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        grid: {
                            borderColor: '#f1f5f9',
                            strokeDashArray: 4
                        },
                        legend: { position: 'top', horizontalAlign: 'right' },
                        noData: {
                          text: 'Memuat data...',
                          align: 'center',
                          verticalAlign: 'middle'
                        }
                    };

                    const chart = new ApexCharts(chartEl, options);
                    chart.render();

                    // API Health Chart
                    const apiOptions = {
                        series: [
                            { name: 'Berhasil', data: data.api_success },
                            { name: 'Gagal', data: data.api_errors }
                        ],
                        chart: {
                            type: 'bar',
                            height: 200,
                            stacked: true,
                            toolbar: { show: false }
                        },
                        colors: ['#10b981', '#ef4444'],
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                borderRadius: 4,
                                columnWidth: '40%'
                            }
                        },
                        dataLabels: { enabled: false },
                        xaxis: {
                            categories: data.dates,
                            labels: { show: false }
                        },
                        yaxis: { labels: { show: false } },
                        grid: { show: false },
                        legend: { show: false },
                        noData: {
                          text: 'No API Data',
                          style: { color: '#64748b' }
                        }
                    };

                    const apiChart = new ApexCharts(apiChartEl, apiOptions);
                    apiChart.render();
                })
                .catch(error => {
                    console.error('Error fetching analytics:', error);
                    chartEl.innerHTML = '<div class="text-center py-5 text-muted">Gagal memuat grafik. Periksa koneksi atau log sistem.</div>';
                });
        });
    </script>
    @endpush
</x-admin-layout>
