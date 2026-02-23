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
                <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; display: flex; align-items: flex-end;">
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
                            <span class="fw-bold {{ $progress == 100 ? 'text-success' : 'text-primary' }}">{{ $progress }}%</span>
                            <div class="progress flex-fill" style="height: 8px; border-radius: 8px; background: #e2e8f0; max-width: 200px;">
                                <div class="progress-bar {{ $progress == 100 ? 'bg-success' : 'bg-primary' }}" style="width: {{ $progress }}%; border-radius: 8px; transition: width 0.5s ease;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modules Accordion --}}
        <div class="accordion" id="course-modules">
            @foreach($course->modules as $mIndex => $module)
            <div class="card mb-3 shadow-sm" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="card-header bg-transparent border-0 py-0 px-0" id="module-head-{{ $module->id }}">
                    <button class="btn w-100 text-start d-flex align-items-center gap-3 py-3 px-4 {{ $mIndex === 0 ? '' : 'collapsed' }}"
                            data-bs-toggle="collapse" data-bs-target="#module-{{ $module->id }}" style="font-size: 1rem;">
                        <div class="avatar avatar-sm rounded-circle flex-shrink-0"
                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 700; font-size: 0.85rem;">
                            {{ $mIndex + 1 }}
                        </div>
                        <div class="flex-fill">
                            <div class="fw-bold">{{ $module->title }}</div>
                            <div class="text-muted small">{{ $module->lessons->count() }} Materi</div>
                        </div>
                        {{-- Module Progress --}}
                        @php
                            $moduleLessonIds = $module->lessons->pluck('id')->toArray();
                            $completedInModule = count(array_intersect($moduleLessonIds, $completedLessonIds));
                            $totalInModule = count($moduleLessonIds);
                        @endphp
                        <span class="badge {{ $completedInModule === $totalInModule && $totalInModule > 0 ? 'bg-green-lt' : 'bg-blue-lt' }}" style="border-radius: 6px;">
                            {{ $completedInModule }}/{{ $totalInModule }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted flex-shrink-0" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                    </button>
                </div>
                <div id="module-{{ $module->id }}" class="collapse {{ $mIndex === 0 ? 'show' : '' }}" data-bs-parent="#course-modules">
                    <div class="card-body pt-0 px-4 pb-3">
                        <div class="list-group list-group-flush">
                            @foreach($module->lessons as $lesson)
                            <a href="{{ route('academy.lesson', [$course->slug, $lesson]) }}"
                               class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-3 border-0"
                               style="border-radius: 10px; transition: background 0.2s;">
                                {{-- Completion Check --}}
                                @if(in_array($lesson->id, $completedLessonIds))
                                    <div class="avatar avatar-xs rounded-circle bg-success flex-shrink-0" style="width: 28px; height: 28px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="14" height="14" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    </div>
                                @else
                                    <div class="avatar avatar-xs rounded-circle flex-shrink-0" style="width: 28px; height: 28px; border: 2px solid #e2e8f0; background: transparent;"></div>
                                @endif
                                <div class="flex-fill">
                                    <div class="fw-medium {{ in_array($lesson->id, $completedLessonIds) ? 'text-muted' : '' }}"
                                         style="{{ in_array($lesson->id, $completedLessonIds) ? 'text-decoration: line-through;' : '' }}">
                                        {{ $lesson->title }}
                                    </div>
                                </div>
                                @if($lesson->has_video)
                                    <span class="badge bg-blue-lt" style="border-radius: 6px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1"><path d="M6 4l15 8l-15 8z" /></svg>
                                        Video
                                    </span>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted flex-shrink-0" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-dashboard-layout>
