<x-admin-layout>
    <div class="container-xl py-4">
        <div class="mb-4">
            <a href="{{ route('admin.academy.courses') }}" class="text-muted text-decoration-none d-inline-flex align-items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                Kembali
            </a>
            <h1 class="fw-bold">{{ isset($course) ? 'Edit Kursus' : 'Buat Kursus Baru' }}</h1>
        </div>

        <div class="card shadow-sm" style="border-radius: 16px; border: none;">
            <div class="card-body p-4">
                <form action="{{ isset($course) ? route('admin.academy.courses.update', $course) : route('admin.academy.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($course)) @method('PUT') @endif

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Judul Kursus <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg border-2 @error('title') is-invalid @enderror"
                               style="border-radius: 12px;" placeholder="Mis: Memulai Bisnis Produk Digital"
                               value="{{ old('title', $course->title ?? '') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control border-2 @error('description') is-invalid @enderror"
                                  style="border-radius: 12px;" rows="4"
                                  placeholder="Jelaskan tentang kursus ini...">{{ old('description', $course->description ?? '') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cover Image</label>
                            <input type="file" name="cover_image" class="form-control border-2 @error('cover_image') is-invalid @enderror"
                                   style="border-radius: 12px;" accept="image/*">
                            @if(isset($course) && $course->cover_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $course->cover_image) }}" alt="Cover" class="rounded" style="height: 80px;">
                                </div>
                            @endif
                            @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select border-2" style="border-radius: 12px;">
                                <option value="draft" {{ old('status', $course->status ?? 'draft') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                <option value="published" {{ old('status', $course->status ?? '') === 'published' ? 'selected' : '' }}>✅ Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">
                            {{ isset($course) ? 'Simpan Perubahan' : 'Buat Kursus' }}
                        </button>
                        <a href="{{ route('admin.academy.courses') }}" class="btn btn-link text-muted">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
