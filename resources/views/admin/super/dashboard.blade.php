<x-admin-layout>
    <style>

        /* Stat Cards */
        .monitor-stat-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            padding: 1.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .monitor-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(0,0,0,0.10);
        }
        .stat-icon-bubble {
            width: 52px; height: 52px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
            color: #1A1A2E;
        }
        .stat-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }
        .stat-trend {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Main Cards */
        .monitor-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        }

        /* Top creators row */
        .creator-row {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #F3F4F6;
        }
        .creator-row:last-child { border-bottom: none; }
        .creator-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem; flex-shrink: 0;
        }
        .creator-bar-track {
            flex: 1; height: 6px; background: #F3F4F6; border-radius: 99px; overflow: hidden;
        }
        .creator-bar-fill {
            height: 100%; border-radius: 99px;
        }

        /* Table */
        .monitor-table thead th {
            background: #FAF7F5;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9CA3AF;
            border: none;
            padding: 14px 20px;
        }
        .monitor-table tbody td {
            padding: 14px 20px;
            border-color: #F3F4F6;
            vertical-align: middle;
        }
        .monitor-table tbody tr:hover { background: #FAFAFA; }

        /* Pagination styling fix */
        .pagination {
            margin: 0;
            display: flex;
            list-style: none;
            padding: 0;
            gap: 4px;
        }
        .pagination .page-item {
            margin: 0;
        }
        .pagination .page-link {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            color: #6c757d;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            background: #fff;
            transition: all 0.2s;
        }
        .pagination .page-link:hover {
            background: #f8f9fa;
            color: #0d6efd;
            border-color: #0d6efd;
        }
        .pagination .page-item.active .page-link {
            background: #e8735a;
            border-color: #e8735a;
            color: #fff;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background: #fff;
            border-color: #dee2e6;
        }

        /* Header btn */
        .btn-warm {
            background: #fff;
            border: 2px solid #E5E7EB;
            color: #374151;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.88rem;
            transition: all 0.2s;
        }
        .btn-warm:hover {
            border-color: #E8735A;
            color: #E8735A;
            background: #FEF5F2;
        }

        /* Live badge */
        .live-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #ECFDF5; color: #059669;
            font-size: 0.78rem; font-weight: 700;
            padding: 4px 12px; border-radius: 20px;
        }
        .live-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #10B981;
            animation: pulse-dot 1.4s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }
    .super-hero {
        background: linear-gradient(135deg, #1a0a00 0%, #431407 55%, #7c2d12 100%);
        border-radius: 24px;
        padding: 2.2rem 2rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.75rem;
    }
    .super-hero::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 260px; height: 260px;
        background: radial-gradient(circle, rgba(232,115,90,0.18) 0%, transparent 70%);
        border-radius: 50%;
    }
    .super-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 30%;
        width: 300px; height: 180px;
        background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .monitor-stat-card { border-left: 4px solid transparent; }
    </style>

    {{-- ========== HERO ========== --}}
    <div class="super-hero mb-4">
        <div class="row align-items-center position-relative" style="z-index:1;">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="background:rgba(232,115,90,0.2);color:#fdba74;border:1px solid rgba(232,115,90,0.35);border-radius:99px;font-size:0.72rem;font-weight:700;letter-spacing:0.08em;padding:4px 12px;">⭐ SUPER ADMIN</span>
                    <span class="live-badge"><span class="live-dot"></span>Live</span>
                </div>
                <h1 class="fw-bold mb-2" style="color:white;font-size:1.85rem;line-height:1.2;">System Monitoring 🔭</h1>
                <p style="color:rgba(253,186,116,0.8);font-size:0.9rem;margin-bottom:1.5rem;max-width:480px;line-height:1.6;">
                    Status real-time sistem, trafik, dan penggunaan AI Ketik.in. Data diperbarui setiap kunjungan.
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.super.traffic') }}" class="btn fw-semibold px-4" style="background:#e8735a;color:white;border-radius:10px;border:none;box-shadow:0 4px 14px rgba(232,115,90,.35);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg>
                        Trafik Real-time
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn fw-semibold px-4" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);border-radius:10px;backdrop-filter:blur(4px);">
                        ← Kembali ke Admin
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <div class="d-flex gap-3">
                    @php
                        $heroStats = [
                            ['val' => number_format($stats['total_users']),       'label' => 'Total User'],
                            ['val' => number_format($stats['online_users']),      'label' => 'Online Kini'],
                            ['val' => number_format($stats['daily_ai_content']),  'label' => 'AI Hari Ini'],
                        ];
                    @endphp
                    @foreach($heroStats as $hs)
                    <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:16px;padding:1.25rem 1rem;text-align:center;min-width:88px;backdrop-filter:blur(8px);">
                        <div style="font-size:1.65rem;font-weight:800;color:white;line-height:1;">{{ $hs['val'] }}</div>
                        <div style="font-size:0.7rem;color:rgba(253,186,116,0.7);margin-top:4px;font-weight:500;">{{ $hs['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ========== STATS ROW ========== --}}
    <div class="row g-3 mb-4">
        {{-- Total Users --}}
        <div class="col-6 col-lg-3">
            <div class="monitor-stat-card" style="border-left-color:#e8735a;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-bubble" style="background:#FEF0EA;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#E8735A" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                    </div>
                    <span class="stat-trend" style="background:#FEF0EA;color:#E8735A;">All time</span>
                </div>
                <div class="stat-number">{{ number_format($stats['total_users']) }}</div>
                <div class="stat-label">Total Pengguna</div>
            </div>
        </div>

        {{-- Online Users --}}
        <div class="col-6 col-lg-3">
            <div class="monitor-stat-card" style="border-left-color:#10b981;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-bubble" style="background:#d1fae5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#059669" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M12 9v.01" /><path d="M2 12a10 10 0 1 0 20 0a10 10 0 0 0 -20 0" /><path d="M8.5 8.5a5 5 0 0 1 7 7" /></svg>
                    </div>
                    <span class="live-badge"><span class="live-dot"></span>Live</span>
                </div>
                <div class="stat-number">{{ number_format($stats['online_users']) }}</div>
                <div class="stat-label">User Online (5 mnt)</div>
            </div>
        </div>

        {{-- AI Content Today --}}
        <div class="col-6 col-lg-3">
            <div class="monitor-stat-card" style="border-left-color:#8b5cf6;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-bubble" style="background:#EEE8F8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#8B5CF6" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                    </div>
                    <span class="stat-trend" style="background:#EEE8F8;color:#8B5CF6;">Hari ini</span>
                </div>
                <div class="stat-number">{{ number_format($stats['daily_ai_content']) }}</div>
                <div class="stat-label">AI Content Dibuat</div>
            </div>
        </div>

        {{-- API Health --}}
        <div class="col-6 col-lg-3">
            <div class="monitor-stat-card" style="border-left-color:{{ $stats['api_success_rate'] > 90 ? '#f59e0b' : '#e8735a' }};">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-bubble" style="background:{{ $stats['api_success_rate'] > 90 ? '#FEF7E8' : '#FEF0EA' }};">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="{{ $stats['api_success_rate'] > 90 ? '#F59E0B' : '#E8735A' }}" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="7 8 3 12 7 16" /><polyline points="17 8 21 12 17 16" /><line x1="14" y1="4" x2="10" y2="20" /></svg>
                    </div>
                    <span class="stat-trend" style="background:{{ $stats['api_success_rate'] > 90 ? '#FEF7E8' : '#FEF0EA' }};color:{{ $stats['api_success_rate'] > 90 ? '#D97706' : '#E8735A' }};">
                        {{ $stats['api_success_rate'] > 90 ? 'Sehat' : 'Perhatian' }}
                    </span>
                </div>
                <div class="stat-number">{{ $stats['api_success_rate'] }}<span style="font-size:1.2rem;font-weight:600;color:#9CA3AF;">%</span></div>
                <div class="stat-label">API Health Today</div>
            </div>
        </div>
    </div>

    {{-- ========== CHARTS ROW ========== --}}
    <div class="row g-3 mb-4">
        {{-- Activity Chart --}}
        <div class="col-lg-8">
            <div class="monitor-card h-100">
                <div class="p-4 pb-2 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0">📊 Trafik & Produksi AI</h5>
                        <p class="mb-0" style="font-size:0.8rem;color:#9CA3AF;">Data 7 hari terakhir</p>
                    </div>
                    <span class="live-badge"><span class="live-dot"></span>Live Update</span>
                </div>
                <div class="p-4 pt-2">
                    <div id="super-admin-chart" style="height: 310px;"></div>
                </div>
            </div>
        </div>

        {{-- Right Column: API Health + Top Creators --}}
        <div class="col-lg-4 d-flex flex-column gap-3">
            {{-- API Health bar chart --}}
            <div class="monitor-card p-4">
                <h5 class="fw-bold mb-3">🔌 API Health (7 Hari)</h5>
                <div id="api-health-chart" style="height: 140px;"></div>
            </div>

            {{-- Top Creators --}}
            <div class="monitor-card p-4 flex-grow-1">
                <h5 class="fw-bold mb-1">🏆 Top AI Creators</h5>
                <p class="mb-3" style="font-size:0.78rem;color:#9CA3AF;">Pengguna paling aktif</p>

                @php
                    $avatarColors = ['#FEF0EA', '#E8F5F2', '#EEE8F8', '#FEF7E8', '#FCE4EC'];
                    $avatarTextColors = ['#E8735A', '#4E9E8E', '#8B5CF6', '#F59E0B', '#E91E63'];
                    $barColors = ['#E8735A', '#4E9E8E', '#8B5CF6', '#F59E0B', '#F06292'];
                    $maxCount = $topUsers->max('contents_count') ?: 1;
                @endphp

                @forelse($topUsers as $i => $user)
                <div class="creator-row">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="creator-avatar" style="object-fit:cover;">
                    @else
                        <div class="creator-avatar" style="background:{{ $avatarColors[$i % 5] }};color:{{ $avatarTextColors[$i % 5] }};">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-bold text-truncate" style="font-size:0.875rem;color:#1A1A2E;">{{ $user->name }}</div>
                        <div class="creator-bar-track mt-1">
                            <div class="creator-bar-fill" style="width:{{ min(100, round(($user->contents_count / $maxCount) * 100)) }}%;background:{{ $barColors[$i % 5] }};"></div>
                        </div>
                    </div>
                    <div style="font-size:0.8rem;font-weight:700;color:{{ $barColors[$i % 5] }};min-width:30px;text-align:right;">
                        {{ $user->contents_count }}
                    </div>
                </div>
                @empty
                <div class="text-center py-4" style="color:#9CA3AF;font-size:0.85rem;">Belum ada data kreator.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ========== ERROR LOGS TABLE ========== --}}
    <div class="monitor-card mb-4" style="overflow:hidden;">
        <div class="d-flex align-items-center justify-content-between p-4 pb-0">
            <div>
                <h5 class="fw-bold mb-1">🚨 API Error Logs</h5>
                <p class="mb-0" style="font-size:0.8rem;color:#9CA3AF;">Log error terbaru — membantu debugging Gemini AI</p>
            </div>
            @if($errorLogs->count() > 0)
            <span style="background:#FEF0EA;color:#E8735A;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
                {{ $errorLogs->count() }} Error
            </span>
            @else
            <span style="background:#ECFDF5;color:#059669;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:20px;">
                ✓ Semua Normal
            </span>
            @endif
        </div>

        <div class="table-responsive mt-3">
            <table class="table monitor-table mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Feature</th>
                        <th>Waktu</th>
                        <th>Pesan Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($errorLogs as $log)
                    <tr>
                        <td>
                            <div class="fw-bold" style="font-size:0.875rem;color:#1A1A2E;">{{ $log->user->name }}</div>
                        </td>
                        <td>
                            <span style="background:#F3F4F6;color:#6B7280;font-size:0.75rem;font-weight:700;padding:3px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:0.04em;">
                                {{ $log->feature_type }}
                            </span>
                        </td>
                        <td style="color:#9CA3AF;font-size:0.82rem;">{{ $log->created_at->format('d M H:i') }}</td>
                        <td>
                            <div style="max-width:380px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#E8735A;font-size:0.82rem;" title="{{ $log->error_message }}">
                                {{ $log->error_message }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div style="color:#059669;font-weight:700;font-size:0.9rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="#059669" fill="none" class="me-1" style="vertical-align:-4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                                Semua API berjalan lancar! Tidak ada error terdeteksi.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- ========== AI QUEUE MONITORING ========== --}}
    <h2 class="page-title mt-5 mb-3" style="color:#022c22;">
        <i class="ti ti-activity me-2"></i> Monitoring Antrean AI
    </h2>
    <div id="queue-realtime-container">
        @include("admin.super.partials.queue_table")
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Popover Initialization
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })

            // Charts
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
                        colors: ['#10b981', '#34d399'],
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
        // Polling Queue Data Real-time (Every 3 seconds)
        const queueContainer = document.getElementById('queue-realtime-container');
        if (queueContainer) {
            setInterval(() => {
                // Get current status filter from URL if any
                const urlParams = new URLSearchParams(window.location.search);
                const status = urlParams.get('status') || '';
                const page = urlParams.get('page') || '1';
                
                fetch(`{{ route('admin.super.queue_data') }}?status=${status}&page=${page}`)
                    .then(response => {
                        if (response.ok) return response.text();
                        throw new Error('Network error');
                    })
                    .then(html => {
                        queueContainer.innerHTML = html;
                        // Re-initialize popovers if any new ones exist
                        var newPopovers = [].slice.call(queueContainer.querySelectorAll('[data-bs-toggle="popover"]'));
                        newPopovers.map(function (el) { return new bootstrap.Popover(el); });
                    })
                    .catch(err => console.error('Error fetching real-time queue:', err));
            }, 3000);
        }
    </script>
    @endpush
</x-admin-layout>
