<x-admin-layout>
    <div class="container-xl py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">🎓 Academy Manager</h1>
                <p class="text-muted mb-0">Kelola e-course, modul, dan materi pembelajaran</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center gap-2 px-4" style="border-radius: 12px;" data-bs-toggle="modal" data-bs-target="#modal-add-course">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah E-Course
            </button>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 14px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 14px;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Courses Grid --}}
        <div class="row g-4">
            @forelse($courses as $course)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 h-100" style="border-radius: 20px; overflow: hidden; transition: transform 0.2s;">
                    {{-- Cover --}}
                    <div style="height: 160px; position: relative; overflow: hidden;">
                        @if($course->cover_image)
                            <img src="{{ asset('storage/' . $course->cover_image) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                            </div>
                        @endif
                        <span class="badge {{ $course->status === 'published' ? 'bg-success' : 'bg-warning' }} px-2 py-1" style="position: absolute; top: 12px; right: 12px; border-radius: 8px; font-size: 0.7rem;">
                            {{ $course->status === 'published' ? 'Live' : 'Draft' }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ $course->title }}</h3>
                        <p class="text-muted small mb-3" style="line-height: 1.5;">{{ Str::limit($course->description, 80) ?: 'Belum ada deskripsi' }}</p>
                        <div class="d-flex gap-3 mb-3">
                            <div class="d-flex align-items-center gap-1 text-muted small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                <span>{{ $course->modules_count }} modul</span>
                            </div>
                            <div class="d-flex align-items-center gap-1 text-muted small">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <span>{{ $course->lessons_count }} materi</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.academy.show', $course) }}" class="btn btn-primary btn-sm flex-fill" style="border-radius: 10px;">Kelola</a>
                            <form action="{{ route('admin.academy.course.destroy', $course) }}" method="POST" class="delete-form" data-name="E-Course {{ $course->title }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body text-center py-5">
                        <div class="mb-3 text-muted" style="opacity: 0.3;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                        </div>
                        <h3 class="fw-bold text-muted">Belum ada e-course</h3>
                        <p class="text-muted">Klik tombol "Tambah E-Course" untuk membuat yang pertama.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Add Course Modal --}}
    <div class="modal modal-blur fade" id="modal-add-course" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 24px;">
                <form action="{{ route('admin.academy.course.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <h3 class="fw-bold mb-4">Tambah E-Course Baru</h3>

                        @if($errors->any())
                        <div class="alert alert-danger mb-3" style="border-radius: 12px;">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-1 ps-3 small">
                                @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Judul E-Course</label>
                            <input type="text" name="title" class="form-control border-2 @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Copywriting Mastery" style="border-radius: 12px;" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Deskripsi (opsional)</label>
                            <textarea name="description" class="form-control border-2 @error('description') is-invalid @enderror" rows="3" placeholder="Deskripsi singkat e-course..." style="border-radius: 12px;">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Cover Image (opsional, max 50MB)</label>
                            <input type="file" name="cover_image" class="form-control border-2 @error('cover_image') is-invalid @enderror" accept="image/*" style="border-radius: 12px;">
                            @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 12px;">Tambah E-Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Re-open modal if validation failed
        @if($errors->has('title') || $errors->has('description') || $errors->has('cover_image'))
            new bootstrap.Modal(document.getElementById('modal-add-course')).show();
        @endif

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus?',
                    text: `Konfirmasi penghapusan: ${this.dataset.name}. Semua modul dan materi di dalamnya juga akan dihapus!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d63939',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(r => { if (r.isConfirmed) this.submit(); });
            });
        });
    </script>
    @endpush
</x-admin-layout>
