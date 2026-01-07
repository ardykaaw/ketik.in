<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="mb-5">
            <h1 class="display-5 fw-bold mb-2">Ringkasan Aktivitas</h1>
            <p class="text-secondary fs-3">Akumulasi data penggunaan fitur Ketik.in Anda</p>
        </div>

        <!-- Stats Cards -->
        <div class="row row-cards mb-6">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ number_format($totalDocs) }}</div>
                                <div class="text-secondary">Dokumen Dibuat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12l3 3l3 -3l-3 -3z" /><path d="M15 12l3 3l3 -3l-3 -3z" /><path d="M9 6l3 3l3 -3l-3 -3z" /><path d="M9 18l3 3l3 -3l-3 -3z" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ number_format($totalWords) }}</div>
                                <div class="text-secondary">Prakiraan Kata</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-twitter text-white avatar shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" /><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $ebookCount }}</div>
                                <div class="text-secondary">E-book Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-facebook text-white avatar shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7l0 10" /><path d="M9 10l0 7" /><path d="M15 4l0 13" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">{{ $targetKinerja }}%</div>
                                <div class="text-secondary">Target Kinerja</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="card-title">Tren Pembuatan Dokumen (7 Hari Terakhir)</h3>
                        <div id="chart-content-trend" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="card-title">Distribusi Fitur</h3>
                        <div id="chart-feature-dist" style="min-height: 240px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-content-trend'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 240,
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
                colors: ["#206bc4"],
                legend: { show: false },
            })).render();

            window.ApexCharts && (new ApexCharts(document.getElementById('chart-feature-dist'), {
                chart: {
                    type: "donut",
                    fontFamily: 'inherit',
                    height: 240,
                    sparkline: { enabled: true },
                    animations: { enabled: true },
                },
                fill: { opacity: 1 },
                series: @json($featureDist),
                labels: ["Story", "E-book", "Opini", "Script", "Essay", "E-Kinerja"],
                grid: { strokeDashArray: 4 },
                colors: ["#206bc4", "#5eba00", "#fa4654", "#fab005", "#4299e1", "#6574cd"],
                legend: { show: true, position: 'bottom', offsetTop: 12 },
                tooltip: { fillSeriesColor: false },
            })).render();
        });
    </script>
    @endpush
</x-dashboard-layout>
