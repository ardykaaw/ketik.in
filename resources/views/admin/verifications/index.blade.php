<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-dark fw-bold">
                    Verifikasi Member Baru
                </h2>
                <div class="text-muted mt-1">Daftar pengguna yang menunggu persetujuan admin</div>
            </div>
            <!-- Status Button -->
            <div class="col-auto ms-auto">
                @if($failedEmailUsers->count() > 0)
                <button type="button" class="btn btn-warning d-none d-sm-inline-block shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#failedEmailsModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg>
                    Email Gagal Terkirim
                    <span class="badge bg-white text-warning ms-2 shadow-none">{{ $failedEmailUsers->count() }}</span>
                </button>
                @else
                <button type="button" class="btn btn-ghost-success d-none d-sm-inline-block shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#failedEmailsModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-check me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 19h-6a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v6" /><path d="M15 19l2 2l4 -4" /></svg>
                    Semua Email Terkirim
                </button>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success shadow-sm border-0 mb-4" style="border-radius: 12px;">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
        <!-- ... existing verification table content ... -->
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center">
                <div class="text-muted">
                    Pastikan Anda telah mengecek dashboard <strong>Lynk.id</strong> untuk memverifikasi pembayaran dan nomor telepon user ini sebelum mengaktifkan akun.
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="w-1 py-3">No.</th>
                        <th class="py-3">Nama Pengguna</th>
                        <th class="py-3">Email & No. Telepon</th>
                        <th class="py-3">Tanggal Daftar</th>
                        <th class="text-end py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingUsers as $user)
                    <tr>
                        <td><span class="text-secondary">{{ ($pendingUsers->currentPage()-1) * $pendingUsers->perPage() + $loop->iteration }}</span></td>
                        <td>
                            <div class="d-flex py-1 align-items-center">
                                @if($user->avatar)
                                    <span class="avatar me-2 rounded-circle border shadow-sm" style="background-image: url({{ asset('storage/' . $user->avatar) }}); background-size: cover;"></span>
                                @else
                                    <span class="avatar me-2 rounded-circle border shadow-sm" style="background-image: url(https://preview.tabler.io/static/avatars/000m.jpg)"></span>
                                @endif
                                <div class="flex-fill">
                                    <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted small">Status: Menunggu</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold">{{ $user->email }}</span>
                                <span class="text-muted small">
                                    No. Telepon: <strong class="text-primary">{{ $user->phone ?? '-' }}</strong>
                                </span>
                            </div>
                        </td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                        <td class="text-end px-4">
                            <form action="{{ route('admin.verifications.approve', $user) }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="button" class="btn btn-sm btn-success px-3 shadow-sm" style="border-radius: 8px;" onclick="verifyUser(event, this, '{{ $user->name }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    Verifikasi & Aktifkan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check mb-2 text-success" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                            <br>
                            Tidak ada permintaan verifikasi baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pendingUsers->hasPages())
        <div class="card-footer d-flex align-items-center bg-transparent border-top p-4">
            <div class="ms-auto">
                {{ $pendingUsers->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- Failed Emails Modal -->
    <div class="modal modal-blur fade" id="failedEmailsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-off me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="3" y1="3" x2="21" y2="21" /><path d="M9.8 9.8l-2.8 -2.8c-.8 0 -2 .8 -2 2v10c0 1.333 .667 2 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 19h2" /><path d="M15.5 8h.5l5 -3l-5 -3v3z" /></svg>
                        Daftar Antrian Email Bermasalah
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                   <div class="table-responsive">
                        <table class="table table-vcenter card-table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="w-1">No.</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th class="w-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($failedEmailUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            @if($user->avatar)
                                                <span class="avatar me-2 rounded-circle" style="background-image: url({{ asset('storage/' . $user->avatar) }})"></span>
                                            @else
                                                <span class="avatar me-2 rounded-circle bg-secondary-lt">{{ substr($user->name, 0, 2) }}</span>
                                            @endif
                                            <div class="flex-fill">
                                                <div class="font-weight-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger text-white">Belum Ada Record Terkirim</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.verifications.resend', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-ghost-primary btn-sm fw-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                                Resend
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check mb-2 text-success" width="48" height="48" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                                            <br>
                                            Semua aman! Tidak ada email yang gagal terkirim.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                   </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    // Define function globally
    window.verifyUser = function(event, btn, name) {
        event.preventDefault(); // Stop default action immediately
        
        // Check if Swal is loaded
        if (typeof Swal === 'undefined') {
            alert("Error: SweetAlert library not loaded. Please contact developer.");
            return;
        }

        Swal.fire({
            title: 'Verifikasi Pengguna?',
            text: "Pastikan pembayaran di Lynk.id atas nama " + name + " sudah valid.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2fb344',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the form and submit it
                btn.closest('form').submit();
            }
        });
    };
</script>
@endpush

</x-admin-layout>
