<x-dashboard-layout>
    <div class="container-xl py-6">
        {{-- Breadcrumb --}}
        <div class="mb-4">
            <a href="{{ route('academy.index') }}" class="text-muted text-decoration-none d-inline-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                Kembali ke Academy
            </a>
        </div>

        {{-- Course Header --}}
        <div class="card mb-5 overflow-hidden shadow-sm" style="border-radius: 20px; border: none;">
            @if($course->cover_image)
                <div style="height: 220px; background-image: url('{{ asset('storage/' . $course->cover_image) }}'); background-size: cover; background-position: center; position: relative;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(transparent 40%, rgba(0,0,0,0.7));"></div>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 2rem;">
                        <h1 class="display-6 fw-bold text-white mb-1">{{ $course->title }}</h1>
                        <p class="text-white mb-0" style="opacity: 0.85;">{{ $course->description }}</p>
                    </div>
                </div>
            @else
                <div style="height: 200px; background: {{ Auth::user()->package_type === 'worksheet_anak' ? 'linear-gradient(135deg, #34d399 0%, #059669 100%)' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }}; position: relative; display: flex; align-items: flex-end;">
                    <div style="padding: 2rem;">
                        <h1 class="display-6 fw-bold text-white mb-1">{{ $course->title }}</h1>
                        <p class="text-white mb-0" style="opacity: 0.85;">{{ $course->description }}</p>
                    </div>
                </div>
            @endif
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex gap-4 text-muted">
                            <span class="d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l12 0" /></svg>
                                <strong>{{ $course->modules->count() }}</strong> Modul
                            </span>
                            <span class="d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                <strong>{{ $course->lessons->count() }}</strong> Materi
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-md-end align-items-center gap-2 mt-3 mt-md-0">
                            <span class="fw-bold {{ $progress == 100 ? 'text-success' : 'text-primary' }}" id="progress-text">{{ $progress }}%</span>
                            <div class="progress flex-fill" style="height: 8px; border-radius: 8px; background: #e2e8f0; max-width: 200px;">
                                <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}" id="progress-bar" style="width: {{ $progress }}%; border-radius: 8px; transition: width 0.5s ease;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Module Grid (Dark Cards with Thumbnails) --}}
        <div class="mb-5">
            <h2 class="fw-bold mb-4 d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Daftar Modul
            </h2>
            <div class="row g-3">
                @foreach($course->modules as $module)
                <div class="col-md-6">
                    <div class="module-card" data-module-id="{{ $module->id }}">
                        {{-- Thumbnail --}}
                        <div class="module-card-thumb">
                            @if($module->thumbnail)
                                <img src="{{ asset('storage/' . $module->thumbnail) }}" alt="{{ $module->title }}">
                            @else
                                <div class="module-card-thumb-fallback">
                                    <div class="module-number">{{ $loop->iteration }}</div>
                                    <div class="module-fallback-title">{{ $module->title }}</div>
                                </div>
                            @endif
                        </div>
                        {{-- Lesson list below thumbnail --}}
                        <div class="module-card-body">
                            @foreach($module->lessons as $lesson)
                            @php $isCompleted = in_array($lesson->id, $completedLessonIds); @endphp
                            <button type="button" class="module-lesson-item lesson-trigger {{ $isCompleted ? 'completed' : '' }}" data-lesson-id="{{ $lesson->id }}">
                                <div class="lesson-icon">
                                    @if($lesson->has_file)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    @elseif($lesson->has_video)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M6 4l15 8l-15 8z" /></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                    @endif
                                </div>
                                <span class="lesson-title">{{ $lesson->title }}</span>
                                @if($isCompleted)
                                    <div class="lesson-check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12l5 5l10 -10" /></svg>
                                    </div>
                                @endif
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <p class="text-center text-muted fst-italic small mb-5">(klik pada materi di bawah thumbnail untuk membuka konten)</p>
    </div>

    @push('modals')
    {{-- Lesson Modal --}}
    <div class="modal modal-blur fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                <div id="modal-thumbnail-header" class="d-none" style="position: relative; width: 100%; max-height: 280px; overflow: hidden; background: {{ Auth::user()->package_type === 'worksheet_anak' ? 'linear-gradient(135deg, #14b8a6 0%, #0d9488 100%)' : 'linear-gradient(135deg, #1e1b4b 0%, #581c87 50%, #7e22ce 100%)' }};">
                    <img id="modal-thumbnail-img" src="" alt="" style="width: 100%; height: 280px; object-fit: cover; display: none;">
                    <div id="modal-thumbnail-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; padding: 20px 24px; background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                        <h3 class="text-white fw-bold mb-0" id="modal-module-title" style="font-size: 1.1rem;"></h3>
                    </div>
                </div>
                <div class="modal-header border-0 pb-0 px-4 pt-4 d-flex justify-content-between align-items-start">
                    <h3 class="modal-title fw-bold" id="modal-lesson-title" style="font-size: 1.4rem;">Memuat materi...</h3>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-3">
                    <div id="modal-file-container" class="mb-4 d-none">
                        <div id="modal-file-embed" class="overflow-hidden" style="border-radius: 16px; border: 1px solid #e2e8f0;"></div>
                    </div>
                    <div id="modal-video-container" class="mb-4 d-none overflow-hidden" style="border-radius: 16px;"></div>
                    <div id="modal-lesson-content" class="lesson-content" style="line-height: 1.8; font-size: 1.05rem;"></div>
                </div>
                <div class="modal-footer border-0 p-4 pt-2">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <div class="text-muted small" id="modal-lesson-status"></div>
                        <button type="button" id="modal-toggle-complete" class="btn btn-primary px-4" style="border-radius: 12px;" data-lesson-id="">
                            Tandai Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lessonModal = new bootstrap.Modal(document.getElementById('lessonModal'));
            const modalTitle = document.getElementById('modal-lesson-title');
            const modalContent = document.getElementById('modal-lesson-content');
            const modalVideo = document.getElementById('modal-video-container');
            const modalFile = document.getElementById('modal-file-container');
            const modalFileEmbed = document.getElementById('modal-file-embed');
            const modalThumbHeader = document.getElementById('modal-thumbnail-header');
            const modalThumbImg = document.getElementById('modal-thumbnail-img');
            const modalModuleTitle = document.getElementById('modal-module-title');
            const completeBtn = document.getElementById('modal-toggle-complete');
            const statusText = document.getElementById('modal-lesson-status');

            document.querySelectorAll('.lesson-trigger').forEach(btn => {
                btn.addEventListener('click', function() {
                    const lessonId = this.dataset.lessonId;
                    modalTitle.textContent = 'Memuat materi...';
                    modalContent.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Sedang mengambil materi...</p></div>';
                    modalVideo.classList.add('d-none');
                    modalVideo.innerHTML = '';
                    modalFile.classList.add('d-none');
                    modalFileEmbed.innerHTML = '';
                    modalThumbHeader.classList.add('d-none');
                    modalThumbImg.style.display = 'none';
                    completeBtn.disabled = true;
                    completeBtn.dataset.lessonId = lessonId;
                    lessonModal.show();

                    fetch(`/academy/lessons/${lessonId}/data`)
                        .then(r => r.json())
                        .then(data => {
                            if (data.error) throw new Error(data.error);
                            modalThumbHeader.classList.remove('d-none');
                            if (data.module_thumbnail) {
                                modalThumbImg.src = data.module_thumbnail;
                                modalThumbImg.style.display = 'block';
                            } else {
                                modalThumbImg.style.display = 'none';
                            }
                            modalModuleTitle.textContent = data.module_title || '';
                            modalTitle.textContent = data.title;
                            if (data.has_file && data.file_url) {
                                modalFile.classList.remove('d-none');
                                if (data.file_extension === 'pdf') {
                                    modalFileEmbed.innerHTML = `<iframe src="${data.file_url}#toolbar=0&navpanes=0" style="width: 100%; height: 600px; border: none;"></iframe>`;
                                } else {
                                    const encodedUrl = encodeURIComponent(data.file_url);
                                    modalFileEmbed.innerHTML = `<iframe src="https://docs.google.com/gview?url=${encodedUrl}&embedded=true" style="width: 100%; height: 600px; border: none;"></iframe>`;
                                }
                            }
                            if (data.has_video) {
                                modalVideo.classList.remove('d-none');
                                if (data.video_type === 'embed') {
                                    modalVideo.innerHTML = `<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="${data.embed_url}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allowfullscreen></iframe></div>`;
                                } else {
                                    modalVideo.innerHTML = `<video controls playsinline class="w-100" style="border-radius: 12px;"><source src="${data.video_url}" type="video/mp4"></video>`;
                                }
                            }
                            if (data.content) {
                                modalContent.innerHTML = data.content;
                            } else if (!data.has_file && !data.has_video) {
                                modalContent.innerHTML = '<p class="text-muted text-center py-3">Belum ada konten untuk materi ini.</p>';
                            } else {
                                modalContent.innerHTML = '';
                            }
                            updateCompleteButton(data.is_completed);
                            completeBtn.disabled = false;
                        })
                        .catch(err => {
                            modalThumbHeader.classList.add('d-none');
                            modalContent.innerHTML = '<div class="alert alert-danger">Gagal memuat materi. Pastikan Anda memiliki akses.</div>';
                        });
                });
            });

            completeBtn.addEventListener('click', function() {
                const lessonId = this.dataset.lessonId;
                this.classList.add('btn-loading');
                fetch(`/academy/lessons/${lessonId}/toggle-progress`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    credentials: 'same-origin'
                })
                .then(r => r.json())
                .then(data => {
                    this.classList.remove('btn-loading');
                    if (data.success) {
                        updateCompleteButton(data.completed);
                        const listBtn = document.querySelector(`.lesson-trigger[data-lesson-id="${lessonId}"]`);
                        if (data.completed) {
                            listBtn.classList.add('completed');
                        } else {
                            listBtn.classList.remove('completed');
                        }
                        const progressText = document.getElementById('progress-text');
                        const progressBar = document.getElementById('progress-bar');
                        if (progressText) progressText.textContent = data.progress + '%';
                        if (progressBar) progressBar.style.width = data.progress + '%';
                    }
                });
            });

            function updateCompleteButton(isCompleted) {
                if (isCompleted) {
                    completeBtn.textContent = '✓ Selesai';
                    completeBtn.classList.replace('btn-primary', 'btn-success');
                    statusText.textContent = 'Materi ini sudah Anda selesaikan.';
                } else {
                    completeBtn.textContent = 'Tandai Selesai';
                    completeBtn.classList.replace('btn-success', 'btn-primary');
                    statusText.textContent = '';
                }
            }
        });
    </script>
    @endpush

    <style>
        .module-card {
            background: #1a1a2e;
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }
        .module-card-thumb {
            width: 100%;
            height: 200px;
            position: relative;
            overflow: hidden;
        }
        .module-card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .module-card:hover .module-card-thumb img {
            transform: scale(1.05);
        }
        .module-card-thumb-fallback {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            text-align: center;
        }
        .module-number {
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 800;
            color: white !important;
            margin-bottom: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
        }
        .module-fallback-title {
            color: white !important;
            font-weight: 700;
            font-size: 1.15rem;
            line-height: 1.3;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .module-card-body { padding: 12px; }
        .module-lesson-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 14px;
            border: none;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            color: rgba(255,255,255,0.85) !important;
            font-size: 0.9rem;
        }
        .module-lesson-item:hover { background: rgba(255,255,255,0.12); color: white; }
        .module-lesson-item.completed { opacity: 0.5; }
        .module-lesson-item.completed .lesson-title { text-decoration: line-through; }
        .lesson-icon {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.7);
        }
        .lesson-title { flex: 1; font-weight: 500; }
        .lesson-check {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .lesson-content h1, .lesson-content h2, .lesson-content h3 { font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1e293b; }
        .lesson-content img { max-width: 100%; border-radius: 12px; margin: 1rem 0; }
        .lesson-content p { margin-bottom: 1rem; }
        .lesson-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .lesson-content table td, .lesson-content table th { border: 1px solid #e2e8f0; padding: 8px 12px; }
        .lesson-content table th { background: #f8fafc; font-weight: 600; }

        @if(Auth::user()->package_type === 'worksheet_anak')
        /* Gaya khusus Anak-anak untuk Show Course */
        .card {
            border-radius: 32px !important;
            box-shadow: 0 8px 24px rgba(20, 184, 166, 0.1) !important;
            border: 4px solid #ccfbf1 !important;
        }
        .module-card {
            background: #ffffff !important;
            border-radius: 32px !important;
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.15) !important;
            border: 4px solid #fef3c7 !important;
        }
        .module-card:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 16px 32px rgba(245, 158, 11, 0.25) !important;
            border-color: #fcd34d !important;
        }
        .module-card-thumb-fallback {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%) !important;
        }
        .module-fallback-title {
            color: #ffffff !important;
            text-shadow: 1px 1px 0px rgba(0,0,0,0.1) !important;
        }
        .module-lesson-item {
            background: #f8fafc !important;
            color: #334155 !important;
            border: 2px solid #e2e8f0 !important;
            font-weight: 600 !important;
        }
        .module-lesson-item:hover {
            background: #f0fdf4 !important;
            border-color: #86efac !important;
            transform: scale(1.02);
            color: #166534 !important;
        }
        .lesson-icon {
            background: #fde68a !important;
            color: #d97706 !important;
        }
        .progress {
            background: #e2e8f0 !important;
            height: 12px !important;
            border-radius: 12px !important;
        }
        .progress-bar {
            background: linear-gradient(90deg, #f59e0b, #fbbf24) !important;
        }
        .modal-content {
            border-radius: 32px !important;
            border: 4px solid #ccfbf1 !important;
        }
        .btn-primary {
            background: #f59e0b !important;
            border-color: #f59e0b !important;
            border-radius: 16px !important;
            font-weight: 700 !important;
        }
        .btn-primary:hover {
            background: #d97706 !important;
            border-color: #d97706 !important;
            transform: scale(1.05);
        }
        #progress-text {
            color: #d97706 !important;
            font-size: 1.2rem !important;
        }
        @endif
    </style>
</x-dashboard-layout>
