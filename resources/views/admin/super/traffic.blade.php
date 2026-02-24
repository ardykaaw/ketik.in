<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="mb-1">
                    <a href="{{ route('admin.super.dashboard') }}" class="text-muted small d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-xs me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        Kembali ke Dashboard
                    </a>
                </div>
                <h2 class="page-title text-dark fw-bold">
                    Log Trafik Sistem
                </h2>
                <div class="text-muted mt-1">Memantau setiap aktivitas request ke server Ketik.in</div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3">User</th>
                        <th class="py-3">Method & URL</th>
                        <th class="py-3">IP Address</th>
                        <th class="py-3">Latency</th>
                        <th class="py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($log->user)
                                    <div class="fw-bold text-dark">{{ $log->user->name }}</div>
                                @else
                                    <div class="text-muted italic small">Guest / System</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ match($log->method) { 'GET' => 'blue', 'POST' => 'green', 'PUT', 'PATCH' => 'yellow', 'DELETE' => 'red', default => 'secondary' } }}-lt me-2">{{ $log->method }}</span>
                                <div class="small text-truncate" style="max-width: 300px;" title="{{ $log->url }}">{{ $log->url }}</div>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $log->ip }}</td>
                        <td>
                            <span class="badge bg-{{ $log->response_time_ms > 1000 ? 'red' : ($log->response_time_ms > 500 ? 'yellow' : 'green') }}-lt px-2 py-1">
                                {{ $log->response_time_ms }}ms
                            </span>
                        </td>
                        <td class="small text-muted">{{ $log->created_at->format('d M, H:i:s') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data trafik terekam.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="card-footer d-flex align-items-center bg-transparent border-top p-4">
            <p class="m-0 text-muted">Menampilkan <span>{{ $logs->firstItem() }}</span> sampai <span>{{ $logs->lastItem() }}</span> dari <span>{{ $logs->total() }}</span> data</p>
            <div class="ms-auto">
                {{ $logs->links('vendor.pagination.tabler') }}
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>
