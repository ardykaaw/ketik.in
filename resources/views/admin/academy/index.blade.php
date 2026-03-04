<x-admin-layout>
    <div class="container-xl py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">🎓 Academy Manager</h1>
                <p class="text-muted mb-0">Kelola kurikulum, modul, dan materi pembelajaran</p>
            </div>
            <span class="badge {{ $course->status === 'published' ? 'bg-success' : 'bg-warning' }} px-3 py-2 fs-5" style="border-radius: 10px;">
                {{ $course->status === 'published' ? '● Live' : '● Draft' }}
            </span>
        </div>

        <div class="row g-4">
            {{-- Left Column: Settings --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius: 20px; position: sticky; top: 20px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4 d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            Pengaturan
                        </h3>
                        <form action="{{ route('admin.academy.course.update', $course) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Judul Academy</label>
                                <input type="text" name="title" class="form-control border-2" value="{{ $course->title }}" required style="border-radius: 12px;">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Deskripsi</label>
                                <textarea name="description" class="form-control border-2" rows="3" style="border-radius: 12px;">{{ $course->description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                                <select name="status" class="form-select border-2" style="border-radius: 12px;">
                                    <option value="draft" {{ $course->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $course->status === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2" style="border-radius: 12px;">Simpan Perubahan</button>
                        </form>

                        <hr class="my-4">
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="card border-0 bg-primary-lt text-center p-3" style="border-radius: 14px;">
                                    <div class="fw-bold fs-1 text-primary">{{ $modules->count() }}</div>
                                    <div class="small text-muted fw-bold">Modul</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-0 bg-success-lt text-center p-3" style="border-radius: 14px;">
                                    <div class="fw-bold fs-1 text-success">{{ $modules->sum('lessons_count') }}</div>
                                    <div class="small text-muted fw-bold">Materi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Modules --}}
            <div class="col-lg-8">
                {{-- Add Module --}}
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">+ Tambah Modul Baru</h3>
                        <form action="{{ route('admin.academy.modules.store', $course) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" name="title" class="form-control border-2" placeholder="Judul modul..." required style="border-radius: 12px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small text-muted fw-bold">Thumbnail Modul (opsional)</label>
                                    <input type="file" name="thumbnail" class="form-control border-2" accept="image/*" style="border-radius: 12px;">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-dark px-5" style="border-radius: 12px;">Tambah Modul</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @forelse($modules as $index => $module)
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px; overflow: hidden;" id="module-{{ $module->id }}">
                    {{-- Module Header with Thumbnail --}}
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                @if($module->thumbnail)
                                    <img src="{{ asset('storage/' . $module->thumbnail) }}" alt="{{ $module->title }}" class="rounded-3 shadow-sm" style="width: 56px; height: 56px; object-fit: cover;">
                                @else
                                    <div class="rounded-3 d-flex align-items-center justify-content-center fw-bold text-white" style="width: 56px; height: 56px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 1.4rem;">
                                        {{ $index + 1 }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="card-title fw-bold mb-0">{{ $module->title }}</h3>
                                    <span class="text-muted small">{{ $module->lessons_count }} materi</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.academy.lessons.create', $module) }}" class="btn btn-sm btn-primary px-3" style="border-radius: 8px;">+ Materi</a>
                                <button class="btn btn-sm btn-ghost-secondary p-1" onclick="editModule({{ $module->id }}, '{{ addslashes($module->title) }}', '{{ $module->thumbnail ? asset('storage/' . $module->thumbnail) : '' }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                </button>
                                <form action="{{ route('admin.academy.modules.destroy', $module) }}" method="POST" class="delete-form" data-name="Modul {{ $module->title }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($module->lessons as $lesson)
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 border-0">
                                <div class="d-flex align-items-center gap-3">
                                    @if($lesson->has_file)
                                        <div class="avatar avatar-xs rounded-circle {{ $lesson->file_extension === 'pdf' ? 'bg-red-lt text-red' : 'bg-blue-lt text-blue' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        </div>
                                    @elseif($lesson->has_video)
                                        <div class="avatar avatar-xs rounded-circle bg-purple-lt text-purple">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4l15 8l-15 8z" /></svg>
                                        </div>
                                    @else
                                        <div class="avatar avatar-xs rounded-circle bg-secondary-lt text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="fw-medium d-block">{{ $lesson->title }}</span>
                                        <div class="d-flex gap-1 mt-1">
                                            @if($lesson->has_video)
                                                <span class="badge bg-purple-lt text-purple" style="font-size: 0.65rem;">Video</span>
                                            @endif
                                            @if($lesson->has_file)
                                                <span class="badge {{ $lesson->file_extension === 'pdf' ? 'bg-red-lt text-red' : 'bg-blue-lt text-blue' }}" style="font-size: 0.65rem;">{{ strtoupper($lesson->file_extension) }}</span>
                                            @endif
                                            @if($lesson->content)
                                                <span class="badge bg-secondary-lt text-secondary" style="font-size: 0.65rem;">Teks</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.academy.lessons.edit', $lesson) }}" class="btn btn-sm btn-ghost-primary p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.academy.lessons.destroy', $lesson) }}" method="POST" class="delete-form" data-name="Materi {{ $lesson->title }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost-danger p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="p-4 text-center text-muted small fst-italic">Belum ada materi. Klik "+ Materi" untuk menambahkan.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @empty
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body text-center py-5">
                        <div class="mb-3 text-muted" style="opacity: 0.3;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                        </div>
                        <h3 class="fw-bold text-muted">Belum ada modul</h3>
                        <p class="text-muted">Gunakan form di atas untuk membuat modul pertama.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Edit Module Modal --}}
    <div class="modal modal-blur fade" id="modal-edit-module" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 24px;">
                <form id="edit-module-form" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-body p-4">
                        <h3 class="fw-bold mb-4">Edit Modul</h3>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Modul</label>
                            <input type="text" name="title" id="edit-module-title" class="form-control border-2" style="border-radius: 12px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Ganti Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control border-2" accept="image/*" style="border-radius: 12px;">
                            <div id="edit-module-thumb-preview" class="mt-2 d-none">
                                <img id="edit-module-thumb-img" src="" class="rounded-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                <label class="ms-2 d-inline-flex align-items-center gap-1 cursor-pointer small text-danger">
                                    <input type="checkbox" name="remove_thumbnail" value="1" class="form-check-input"> Hapus thumbnail
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" style="border-radius: 12px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editModule(id, title, thumbUrl) {
            document.getElementById('edit-module-form').action = `/admin/academy/modules/${id}`;
            document.getElementById('edit-module-title').value = title;
            const preview = document.getElementById('edit-module-thumb-preview');
            const img = document.getElementById('edit-module-thumb-img');
            if (thumbUrl) {
                img.src = thumbUrl;
                preview.classList.remove('d-none');
            } else {
                preview.classList.add('d-none');
            }
            new bootstrap.Modal(document.getElementById('modal-edit-module')).show();
        }

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus?',
                    text: `Konfirmasi penghapusan: ${this.dataset.name}`,
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
