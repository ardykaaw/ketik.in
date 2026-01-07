<x-admin-layout>
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title text-dark fw-bold">
                    Manajemen Pengguna
                </h2>
                <div class="text-muted mt-1">Kelola data pengguna terdaftar aplikasi Ketik.in</div>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <button class="btn btn-primary d-none d-sm-inline-block px-4 shadow-sm" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modal-add-user">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Tambah Pengguna
                    </button>
                    <button class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-add-user">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead class="bg-light">
                    <tr>
                        <th class="w-1 py-3">No.</th>
                        <th class="py-3">Nama Pengguna</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Role</th>
                        <th class="py-3">Terdaftar Pada</th>
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
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-red-lt' : 'bg-blue-lt' }} px-3 py-1" style="border-radius: 6px;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-end px-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-outline-primary px-3 shadow-none border-2" 
                                    style="border-radius: 8px;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal-edit-user"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}"
                                    onclick="populateEditModal(this)">
                                    Edit
                                </button>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 shadow-none border-2" style="border-radius: 8px;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pengguna terdaftar.</td>
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

    <!-- Modal Add User -->
    <div class="modal modal-blur fade" id="modal-add-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control border-2" placeholder="Masukkan nama" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control border-2" placeholder="email@contoh.com" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control border-2" placeholder="Minimal 8 karakter" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <select name="role" class="form-select border-2" style="border-radius: 10px;">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal modal-blur fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <form id="edit-user-form" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Data Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="edit-name" class="form-control border-2" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="edit-email" class="form-control border-2" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control border-2" placeholder="Kosongkan jika tidak ingin ganti" style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <select name="role" id="edit-role" class="form-select border-2" style="border-radius: 10px;">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function populateEditModal(btn) {
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            const email = btn.getAttribute('data-email');
            const role = btn.getAttribute('data-role');
            
            document.getElementById('edit-user-form').action = `/admin/users/${id}`;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
        }
    </script>
    @endpush
</x-admin-layout>
