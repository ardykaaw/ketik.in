<x-admin-layout>
    <div class="container-xl py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">📚 Academy</h1>
                <p class="text-muted mb-0">Kelola kursus, modul, dan materi pembelajaran</p>
            </div>
            <a href="{{ route('admin.academy.courses.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Tambah Kursus
            </a>
        </div>

        @if($courses->isEmpty())
            <div class="card" style="border-radius: 16px; border: 2px dashed #e2e8f0;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-muted" width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                    </div>
                    <h3 class="fw-bold text-muted">Belum ada kursus</h3>
                    <p class="text-muted">Mulai buat kursus pertama Anda!</p>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm" style="border-radius: 16px; border: none; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;" onmouseenter="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 40px rgba(0,0,0,0.12)'" onmouseleave="this.style.transform=''; this.style.boxShadow=''">
                        @if($course->cover_image)
                            <div style="height: 160px; background-image: url('{{ asset('storage/' . $course->cover_image) }}'); background-size: cover; background-position: center;"></div>
                        @else
                            <div style="height: 160px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="48" height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge {{ $course->status === 'published' ? 'bg-green-lt' : 'bg-yellow-lt' }}" style="border-radius: 6px;">
                                    {{ $course->status === 'published' ? '✅ Published' : '📝 Draft' }}
                                </span>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $course->title }}</h3>
                            <p class="text-muted small mb-3">{{ Str::limit($course->description, 80) }}</p>
                            <div class="d-flex gap-3 text-muted small mb-3">
                                <span><strong>{{ $course->modules_count }}</strong> Modul</span>
                                <span><strong>{{ $course->lessons_count }}</strong> Materi</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pt-0 pb-3 px-3">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.academy.modules', $course) }}" class="btn btn-sm btn-outline-primary flex-fill" style="border-radius: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l12 0" /></svg>
                                    Kelola
                                </a>
                                <a href="{{ route('admin.academy.courses.edit', $course) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                                </a>
                                <form action="{{ route('admin.academy.courses.destroy', $course) }}" method="POST" class="delete-course-form" data-title="{{ $course->title }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.delete-course-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Kursus?',
                    html: `<p>Kursus <strong>${this.dataset.title}</strong> beserta semua modul dan materi di dalamnya akan dihapus permanen.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d63939',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>
