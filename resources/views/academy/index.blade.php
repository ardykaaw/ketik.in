<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="mb-5">
            <h1 class="display-5 fw-bold mb-2">📚 Academy</h1>
            <p class="text-secondary fs-3">Kursus dan materi pembelajaran untuk meningkatkan skill Anda</p>
        </div>

        @if($courses->isEmpty())
            <div class="card" style="border-radius: 20px; border: 2px dashed #e2e8f0;">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-muted" width="64" height="64" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                    </div>
                    <h3 class="fw-bold text-muted mb-1">Belum ada kursus tersedia</h3>
                    <p class="text-muted">Kursus baru akan segera hadir. Tetap pantau ya!</p>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('academy.show', $course->slug) }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm" style="border-radius: 20px; border: none; overflow: hidden; transition: all 0.3s ease;" onmouseenter="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 20px 60px rgba(0,0,0,0.12)'" onmouseleave="this.style.transform=''; this.style.boxShadow=''">
                            @if($course->cover_image)
                                <div style="height: 180px; background-image: url('{{ asset('storage/' . $course->cover_image) }}'); background-size: cover; background-position: center; position: relative;">
                                    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(transparent, rgba(0,0,0,0.4));"></div>
                                </div>
                            @else
                                <div style="height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; position: relative;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="56" height="56" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" style="opacity: 0.6;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                                </div>
                            @endif
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-2 text-dark">{{ $course->title }}</h3>
                                <p class="text-muted small mb-3">{{ Str::limit($course->description, 100) }}</p>
                                <div class="d-flex gap-3 text-muted small mb-3">
                                    <span class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l12 0" /></svg>
                                        {{ $course->modules_count }} Modul
                                    </span>
                                    <span class="d-flex align-items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                                        {{ $course->lessons_count }} Materi
                                    </span>
                                </div>
                                {{-- Progress Bar --}}
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="small text-muted fw-medium">Progress</span>
                                        <span class="small fw-bold {{ $course->progress == 100 ? 'text-success' : 'text-primary' }}">{{ $course->progress }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius: 6px; background: #e2e8f0;">
                                        <div class="progress-bar {{ $course->progress == 100 ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="width: {{ $course->progress }}%; border-radius: 6px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-dashboard-layout>
