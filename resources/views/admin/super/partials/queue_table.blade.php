    <style>
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
    </style>

    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar" style="border-radius:12px;"><i class="ti ti-list"></i></span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Total Antrean</div>
                            <div class="text-muted">{{ number_format($queueStats['total']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar" style="border-radius:12px;"><i class="ti ti-clock"></i></span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Pending & Processing</div>
                            <div class="text-muted">{{ number_format($queueStats['pending'] + $queueStats['processing']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar" style="border-radius:12px;"><i class="ti ti-check"></i></span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Selesai</div>
                            <div class="text-muted">{{ number_format($queueStats['completed']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-danger text-white avatar" style="border-radius:12px;"><i class="ti ti-alert-circle"></i></span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">Gagal</div>
                            <div class="text-muted">{{ number_format($queueStats['failed']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Table -->
    <div class="card mb-4 border-0 shadow-sm" id="antrean" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
            <h3 class="card-title fw-bold">Daftar Antrean</h3>
            <form method="GET" action="{{ route('admin.super.dashboard') }}#antrean" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="border-radius:8px;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3">ID</th>
                        <th class="py-3">Pengguna</th>
                        <th class="py-3">Fitur</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Dibuat Pada</th>
                        <th class="py-3">Pesan Error</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($queues as $queue)
                    <tr>
                        <td><span class="text-muted">{{ Str::limit($queue->id, 8) }}</span></td>
                        <td>
                            <div class="fw-bold">{{ $queue->user->name ?? 'User Terhapus' }}</div>
                            <div class="text-muted small">{{ $queue->user->email ?? '' }}</div>
                        </td>
                        <td>
                            <span class="badge bg-blue-lt" style="border-radius:6px;">{{ strtoupper(str_replace('_', ' ', $queue->feature_type)) }}</span>
                        </td>
                        <td>
                            @if($queue->status === 'pending')
                                <span class="badge bg-warning" style="border-radius:6px;">Pending</span>
                            @elseif($queue->status === 'processing')
                                <span class="badge bg-info" style="border-radius:6px;">Processing</span>
                            @elseif($queue->status === 'completed')
                                <span class="badge bg-success" style="border-radius:6px;">Completed</span>
                            @elseif($queue->status === 'failed')
                                <span class="badge bg-danger" style="border-radius:6px;">Failed</span>
                            @endif
                        </td>
                        <td>{{ $queue->created_at->diffForHumans() }}</td>
                        <td>
                            @if($queue->status === 'failed' && $queue->error_message)
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="popover" title="Detail Error" data-bs-content="{{ $queue->error_message }}">
                                    Lihat Error
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($queue->status === 'failed' || $queue->status === 'pending')
                                <form action="{{ route('admin.super.queues.retry', $queue->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memproses ulang antrean ini?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm text-white rounded-pill px-3" style="background:#10b981;">
                                        <i class="ti ti-refresh me-1"></i> Retry
                                    </button>
                                </form>
                                @endif

                                @if($queue->status === 'pending')
                                <form action="{{ route('admin.super.queues.delete', $queue->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus antrean pending ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="ti ti-trash me-1"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data antrean AI.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($queues->hasPages())
        <div class="card-footer bg-white d-flex align-items-center">
            {{ $queues->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
