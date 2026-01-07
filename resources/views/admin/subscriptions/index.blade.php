<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-dark fw-bold">
                    Masa Waktu & Langganan
                </h2>
                <div class="text-muted mt-1">Pantau durasi aktif dan masa tenggang akun pengguna</div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="w-1 py-3">No.</th>
                        <th class="py-3">Pengguna</th>
                        <th class="py-3">Paket</th>
                        <th class="py-3">Masa Berlaku</th>
                        <th class="py-3">Status</th>
                        <th class="text-end py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td><span class="text-secondary">{{ ($users->currentPage()-1) * $users->perPage() + $loop->iteration }}</span></td>
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                @if($user->avatar)
                                    <span class="avatar me-2 rounded-circle border shadow-sm" style="background-image: url({{ asset('storage/' . $user->avatar) }}); background-size: cover;"></span>
                                @else
                                    <span class="avatar me-2 rounded-circle border shadow-sm" style="background-image: url(https://preview.tabler.io/static/avatars/000m.jpg)"></span>
                                @endif
                                <div class="flex-fill">
                                    <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                    <div class="small text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $user->isPremium() ? 'bg-purple-lt' : 'bg-secondary-lt' }} px-3 py-1" style="border-radius: 6px;">
                                {{ $user->plan_name ?? 'Free Plan' }}
                            </span>
                        </td>
                        <td>
                            @if($user->premium_until)
                                <div class="small text-dark fw-bold">{{ $user->premium_until->format('d M Y') }}</div>
                                @php
                                    $daysRemaining = now()->diffInDays($user->premium_until, false);
                                @endphp
                                @if($daysRemaining > 0)
                                    <div class="small text-success fw-medium">Tersisa {{ ceil($daysRemaining) }} hari</div>
                                @else
                                    <div class="small text-danger fw-medium">Sudah habis</div>
                                @endif
                            @else
                                <div class="small text-muted italic">Tidak ada masa aktif</div>
                            @endif
                        </td>
                        <td>
                            @if($user->isPremium())
                                <span class="status-dot status-dot-animated status-green me-1"></span> Aktif
                            @else
                                <span class="status-dot status-gray me-1"></span> Tidak Aktif
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <button class="btn btn-sm btn-outline-primary px-3 shadow-none border-2" 
                                style="border-radius: 8px;"
                                data-bs-toggle="modal" 
                                data-bs-target="#modal-extend"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                onclick="populateExtendModal(this)">
                                Perpanjang
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pengguna premium.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="card-footer d-flex align-items-center bg-transparent border-top p-4">
            <p class="m-0 text-muted">Menampilkan <span>{{ $users->firstItem() }}</span> sampai <span>{{ $users->lastItem() }}</span> dari <span>{{ $users->total() }}</span> data</p>
            <div class="ms-auto">
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Modal Extend Subscription -->
    <div class="modal modal-blur fade" id="modal-extend" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <form id="extend-form" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Perpanjang Masa Aktif</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <p class="text-muted small mb-3">Pilih durasi perpanjangan untuk <span id="extend-user-name" class="fw-bold text-dark"></span></p>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Hari</label>
                            <div class="row g-2">
                                <div class="col-12">
                                    <select name="days" class="form-select border-2" style="border-radius: 10px;">
                                        <option value="7">7 Hari (1 Minggu)</option>
                                        <option value="30" selected>30 Hari (1 Bulan)</option>
                                        <option value="90">90 Hari (3 Bulan)</option>
                                        <option value="365">365 Hari (1 Tahun)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function populateExtendModal(btn) {
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            
            document.getElementById('extend-form').action = `/admin/subscriptions/${id}/extend`;
            document.getElementById('extend-user-name').innerText = name;
        }
    </script>
    @endpush
</x-admin-layout>
