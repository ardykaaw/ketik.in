<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-dark fw-bold">
                    Verifikasi Member Baru
                </h2>
                <div class="text-muted mt-1">Daftar pengguna yang menunggu persetujuan admin</div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success shadow-sm border-0 mb-4" style="border-radius: 12px;">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center">
                <div class="text-muted">
                    Pastikan Anda telah mengecek dashboard <strong>Lynk.id</strong> untuk memverifikasi pembayaran user ini sebelum mengaktifkan akun.
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="w-1 py-3">No.</th>
                        <th class="py-3">Nama Pengguna</th>
                        <th class="py-3">Email & Lynk.id</th>
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
                                    Lynk.id: <strong class="text-primary">{{ $user->lynk_id ?? '-' }}</strong>
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
