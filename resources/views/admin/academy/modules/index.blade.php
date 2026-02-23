<x-admin-layout>
    <div class="container-xl py-4">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <a href="{{ route('admin.academy.courses') }}" class="text-muted text-decoration-none d-inline-flex align-items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                    Kembali ke Kursus
                </a>
                <h1 class="fw-bold mb-1">{{ $course->title }}</h1>
                <p class="text-muted mb-0">Kelola modul dan materi untuk kursus ini</p>
            </div>
        </div>

        {{-- Add Module Form --}}
        <div class="card shadow-sm mb-4" style="border-radius: 16px; border: none;">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-3">Tambah Modul Baru</h3>
                <form action="{{ route('admin.academy.modules.store', $course) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="title" class="form-control border-2 @error('title') is-invalid @enderror"
                           style="border-radius: 12px;" placeholder="Nama modul, misal: Mindset dan Pondasi" required>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px; white-space: nowrap;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Tambah
                    </button>
                </form>
            </div>
        </div>

        {{-- Modules List --}}
        @if($modules->isEmpty())
            <div class="card" style="border-radius: 16px; border: 2px dashed #e2e8f0;">
                <div class="card-body text-center py-5">
                    <h3 class="fw-bold text-muted">Belum ada modul</h3>
                    <p class="text-muted">Tambahkan modul pertama menggunakan form di atas</p>
                </div>
            </div>
        @else
            @foreach($modules as $index => $module)
            <div class="card shadow-sm mb-3" style="border-radius: 16px; border: none;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 700;">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $module->title }}</h3>
                                <span class="text-muted small">{{ $module->lessons_count }} Materi</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <a href="{{ route('admin.academy.lessons.create', $module) }}" class="btn btn-sm btn-primary px-3" style="border-radius: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Tambah Materi
                            </a>
                            {{-- Edit Module (inline) --}}
                            <button class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;" title="Edit Modul"
                                    onclick="editModule({{ $module->id }}, '{{ addslashes($module->title) }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                            </button>
                            <form action="{{ route('admin.academy.modules.destroy', $module) }}" method="POST" class="delete-module-form" data-title="{{ $module->title }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus Modul">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Lessons List --}}
                    @if($module->lessons->count())
                    <div class="mt-3 ps-5">
                        @foreach($module->lessons as $lesson)
                        <div class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 rounded-3" style="background: #f8f9fa;">
                            <div class="d-flex align-items-center gap-2">
                                @if($lesson->has_video)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4l15 8l-15 8z" /></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-muted" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>
                                @endif
                                <span class="fw-medium small">{{ $lesson->title }}</span>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.academy.lessons.edit', $lesson) }}" class="btn btn-sm btn-ghost-primary p-1" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                </a>
                                <form action="{{ route('admin.academy.lessons.destroy', $lesson) }}" method="POST" class="delete-lesson-form" data-title="{{ $lesson->title }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger p-1" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>

    {{-- Edit Module Modal --}}
    <div class="modal modal-blur fade" id="modal-edit-module" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <form id="edit-module-form" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body p-4">
                        <h3 class="fw-bold mb-3">Edit Modul</h3>
                        <input type="text" name="title" id="edit-module-title" class="form-control border-2" style="border-radius: 12px;" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 10px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editModule(id, title) {
            document.getElementById('edit-module-form').action = `/admin/academy/modules/${id}`;
            document.getElementById('edit-module-title').value = title;
            new bootstrap.Modal(document.getElementById('modal-edit-module')).show();
        }

        document.querySelectorAll('.delete-module-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Modul?',
                    html: `<p>Modul <strong>${this.dataset.title}</strong> beserta semua materi di dalamnya akan dihapus.</p>`,
                    icon: 'warning', showCancelButton: true, confirmButtonColor: '#d63939',
                    cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
                }).then(r => { if (r.isConfirmed) this.submit(); });
            });
        });

        document.querySelectorAll('.delete-lesson-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Materi?',
                    text: `Materi "${this.dataset.title}" akan dihapus permanen.`,
                    icon: 'warning', showCancelButton: true, confirmButtonColor: '#d63939',
                    cancelButtonColor: '#6c757d', confirmButtonText: 'Hapus', cancelButtonText: 'Batal'
                }).then(r => { if (r.isConfirmed) this.submit(); });
            });
        });
    </script>
    @endpush
</x-admin-layout>
