<x-dashboard-layout>
    <div class="container-xl py-6">
        {{-- Breadcrumb --}}
        <div class="mb-4">
            <nav class="d-flex align-items-center gap-2 text-muted small">
                <a href="{{ route('academy.index') }}" class="text-muted text-decoration-none">Academy</a>
                <span>/</span>
                <a href="{{ route('academy.show', $course->slug) }}" class="text-muted text-decoration-none">{{ Str::limit($course->title, 30) }}</a>
                <span>/</span>
                <span class="fw-medium text-dark">{{ Str::limit($lesson->title, 40) }}</span>
            </nav>
        </div>

        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8">
                {{-- Video Player --}}
                @if($lesson->has_video)
                <div class="card mb-4 shadow-sm overflow-hidden" style="border-radius: 16px; border: none;">
                    @if($lesson->video_type === 'upload')
                        {{-- Uploaded Video --}}
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; background: #000;">
                            <video controls playsinline
                                   style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                   preload="metadata">
                                <source src="{{ $lesson->video_file_url }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>
                    @elseif($lesson->video_type === 'embed')
                        {{-- YouTube/Vimeo Embed --}}
                        <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                            <iframe src="{{ $lesson->embed_url }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                    allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                        </div>
                    @endif
                </div>
                @endif

                {{-- Lesson Header --}}
                <div class="card shadow-sm" style="border-radius: 16px; border: none;">
                    <div class="card-body p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <h1 class="fw-bold mb-0" style="font-size: 1.75rem;">{{ $lesson->title }}</h1>
                            {{-- Complete Toggle Button --}}
                            <button id="toggle-complete" class="btn {{ $isCompleted ? 'btn-success' : 'btn-outline-primary' }} px-3 flex-shrink-0"
                                    style="border-radius: 10px; transition: all 0.3s;"
                                    data-lesson-id="{{ $lesson->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                <span id="toggle-text">{{ $isCompleted ? 'Selesai ✓' : 'Tandai Selesai' }}</span>
                            </button>
                        </div>

                        {{-- Lesson Content --}}
                        <div class="lesson-content" style="line-height: 1.8; font-size: 1.05rem;">
                            {!! $lesson->content !!}
                        </div>
                    </div>
                </div>

                {{-- Prev/Next Navigation --}}
                <div class="d-flex justify-content-between mt-4">
                    @if($prevLesson)
                        <a href="{{ route('academy.lesson', [$course->slug, $prevLesson]) }}" class="btn btn-outline-secondary px-3" style="border-radius: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                            Sebelumnya
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('academy.lesson', [$course->slug, $nextLesson]) }}" class="btn btn-primary px-3 shadow-sm" style="border-radius: 10px;">
                            Selanjutnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                        </a>
                    @else
                        <a href="{{ route('academy.show', $course->slug) }}" class="btn btn-success px-3 shadow-sm" style="border-radius: 10px;">
                            🎉 Kembali ke Kursus
                        </a>
                    @endif
                </div>
            </div>

            {{-- Sidebar: Course Outline --}}
            <div class="col-lg-4">
                <div class="card shadow-sm" style="border-radius: 16px; border: none; position: sticky; top: 1rem;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="fw-bold mb-0">Daftar Materi</h3>
                            <span class="badge bg-primary-lt" style="border-radius: 6px;" id="progress-badge">{{ $progress }}%</span>
                        </div>
                        <div class="progress mb-4" style="height: 6px; border-radius: 6px; background: #e2e8f0;">
                            <div class="progress-bar bg-primary" id="progress-bar" style="width: {{ $progress }}%; border-radius: 6px; transition: width 0.5s;"></div>
                        </div>

                        @foreach($course->modules as $module)
                        <div class="mb-3">
                            <div class="fw-semibold text-muted small text-uppercase mb-2" style="letter-spacing: 0.05em;">{{ $module->title }}</div>
                            @foreach($module->lessons as $l)
                            <a href="{{ route('academy.lesson', [$course->slug, $l]) }}"
                               class="d-flex align-items-center gap-2 py-2 px-2 text-decoration-none rounded-2 mb-1 {{ $l->id === $lesson->id ? 'bg-primary-lt' : '' }}"
                               style="transition: background 0.2s;">
                                @if(in_array($l->id, $completedLessonIds))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success flex-shrink-0" width="16" height="16" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                @else
                                    <div class="flex-shrink-0" style="width: 16px; height: 16px; border: 2px solid #cbd5e1; border-radius: 50%;"></div>
                                @endif
                                <span class="small {{ $l->id === $lesson->id ? 'fw-bold text-primary' : 'text-dark' }}">{{ Str::limit($l->title, 30) }}</span>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('toggle-complete').addEventListener('click', function() {
            const btn = this;
            const lessonId = btn.dataset.lessonId;

            fetch(`/academy/lessons/${lessonId}/toggle-progress`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const textEl = document.getElementById('toggle-text');
                    if (data.completed) {
                        btn.classList.remove('btn-outline-primary');
                        btn.classList.add('btn-success');
                        textEl.textContent = 'Selesai ✓';
                    } else {
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-outline-primary');
                        textEl.textContent = 'Tandai Selesai';
                    }
                    // Update progress bar
                    document.getElementById('progress-bar').style.width = data.progress + '%';
                    document.getElementById('progress-badge').textContent = data.progress + '%';
                }
            });
        });
    </script>
    @endpush

    <style>
        .lesson-content h1, .lesson-content h2, .lesson-content h3 { margin-top: 1.5rem; margin-bottom: 0.75rem; font-weight: 700; }
        .lesson-content p { margin-bottom: 1rem; }
        .lesson-content ul, .lesson-content ol { padding-left: 1.5rem; margin-bottom: 1rem; }
        .lesson-content img { max-width: 100%; border-radius: 12px; margin: 1rem 0; }
        .lesson-content blockquote { border-left: 4px solid #3b82f6; padding: 1rem 1.5rem; background: #f8fafc; border-radius: 0 12px 12px 0; margin: 1rem 0; }
        .lesson-content code { background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
        .lesson-content pre { background: #1e293b; color: #e2e8f0; padding: 1.25rem; border-radius: 12px; overflow-x: auto; margin: 1rem 0; }
        .lesson-content pre code { background: none; padding: 0; color: inherit; }
    </style>
</x-dashboard-layout>
