<x-admin-layout>
    {{-- Summernote CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <div class="container-xl py-4">
        <div class="mb-4">
            <a href="{{ route('admin.academy.modules', $module->course) }}" class="text-muted text-decoration-none d-inline-flex align-items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                Kembali ke Modul
            </a>
            <h1 class="fw-bold">{{ isset($lesson) ? 'Edit Materi' : 'Tambah Materi Baru' }}</h1>
            <p class="text-muted">Modul: <strong>{{ $module->title }}</strong></p>
        </div>

        <div class="card shadow-sm" style="border-radius: 16px; border: none;">
            <div class="card-body p-4">
                <form action="{{ isset($lesson) ? route('admin.academy.lessons.update', $lesson) : route('admin.academy.lessons.store', $module) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($lesson)) @method('PUT') @endif

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Judul Materi <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg border-2 @error('title') is-invalid @enderror"
                               style="border-radius: 12px;" placeholder="Mis: Pengenalan Produk Digital"
                               value="{{ old('title', $lesson->title ?? '') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Video Section --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Video (Opsional)</label>

                        @if(isset($lesson) && ($lesson->video_path || $lesson->video_url))
                        <div class="alert alert-info d-flex align-items-center gap-2 mb-3" style="border-radius: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4l15 8l-15 8z" /></svg>
                            <span>
                                @if($lesson->video_path)
                                    Video terupload: <strong>{{ basename($lesson->video_path) }}</strong>
                                @else
                                    URL Video: <strong>{{ Str::limit($lesson->video_url, 50) }}</strong>
                                @endif
                            </span>
                            <label class="ms-auto mb-0 d-flex align-items-center gap-1 cursor-pointer">
                                <input type="checkbox" name="remove_video" value="1" class="form-check-input">
                                <span class="small text-danger">Hapus video</span>
                            </label>
                        </div>
                        @endif

                        <div class="d-flex gap-2 mb-3">
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="video_source" id="src-upload" value="upload" checked onclick="document.getElementById('panel-upload').style.display='block'; document.getElementById('panel-url').style.display='none';">
                                <label class="btn btn-outline-primary" for="src-upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                                    Upload File Video
                                </label>
                                <input type="radio" class="btn-check" name="video_source" id="src-url" value="url" onclick="document.getElementById('panel-upload').style.display='none'; document.getElementById('panel-url').style.display='block';">
                                <label class="btn btn-outline-primary" for="src-url">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                    URL YouTube / Vimeo
                                </label>
                            </div>
                        </div>

                        <div id="panel-upload">
                            <input type="file" name="video_file" class="form-control border-2 @error('video_file') is-invalid @enderror"
                                   style="border-radius: 12px;" accept="video/mp4,video/webm,video/ogg,video/quicktime">
                            <small class="text-muted">Format: MP4, WebM, OGG, MOV. Maksimal 100MB.</small>
                            @error('video_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div id="panel-url" style="display: none;">
                            <input type="url" name="video_url" class="form-control border-2 @error('video_url') is-invalid @enderror"
                                   style="border-radius: 12px;" placeholder="https://www.youtube.com/watch?v=..."
                                   value="{{ old('video_url', $lesson->video_url ?? '') }}">
                            <small class="text-muted">Mendukung YouTube dan Vimeo. Masukkan URL lengkap.</small>
                            @error('video_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Konten Materi</label>
                        <textarea name="content" id="lesson-content" class="form-control">{{ old('content', $lesson->content ?? '') }}</textarea>
                        @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 10px;">
                            {{ isset($lesson) ? 'Simpan Perubahan' : 'Tambah Materi' }}
                        </button>
                        <a href="{{ route('admin.academy.modules', $module->course) }}" class="btn btn-link text-muted">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#lesson-content').summernote({
                height: 400,
                placeholder: 'Tulis konten materi di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'blockquote', 'pre'],
                callbacks: {
                    onImageUpload: function(files) {
                        // Convert image to base64 inline
                        for (let i = 0; i < files.length; i++) {
                            const reader = new FileReader();
                            reader.onloadend = function() {
                                const img = $('<img>').attr('src', reader.result).css('max-width', '100%');
                                $('#lesson-content').summernote('insertNode', img[0]);
                            };
                            reader.readAsDataURL(files[i]);
                        }
                    }
                }
            });
        });
    </script>
    @endpush

    <style>
        /* Summernote theme adjustments */
        .note-editor.note-frame {
            border: 2px solid #e2e8f0 !important;
            border-radius: 12px !important;
            overflow: hidden;
        }
        .note-editor .note-toolbar {
            background: #f8f9fa !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 8px !important;
        }
        .note-editor .note-editing-area .note-editable {
            padding: 20px !important;
            font-size: 1rem;
            line-height: 1.8;
            font-family: 'Inter', -apple-system, sans-serif;
        }
        .note-editor .note-editing-area .note-editable h1,
        .note-editor .note-editing-area .note-editable h2,
        .note-editor .note-editing-area .note-editable h3 {
            font-weight: 700;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .note-editor .note-editing-area .note-editable table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        .note-editor .note-editing-area .note-editable table td,
        .note-editor .note-editing-area .note-editable table th {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
        }
        .note-editor .note-editing-area .note-editable table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .note-editor .note-editing-area .note-editable blockquote {
            border-left: 4px solid #3b82f6;
            padding: 1rem 1.5rem;
            background: #f0f9ff;
            border-radius: 0 8px 8px 0;
            margin: 1rem 0;
        }
        .note-btn {
            border-radius: 6px !important;
        }
        .note-modal .modal-dialog {
            z-index: 9999;
        }
        .note-status-output {
            display: none !important;
        }
    </style>
</x-admin-layout>
