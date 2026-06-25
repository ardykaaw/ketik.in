<x-dashboard-layout>
    <div class="container-xl py-5">
        @if(Auth::user()->package_type === 'worksheet_anak')
        {{-- =============================== --}}
        {{-- WELCOMING CARD ANAK             --}}
        {{-- =============================== --}}
        <div class="card mb-5 border-0 shadow-lg overflow-hidden" style="border-radius: 32px; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);">
            <div class="card-body p-4 p-lg-5 text-center">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🌟🎓🎈</div>
                <h2 class="fw-bold text-white mb-3" style="font-size: 2rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2);">Halo Anak Hebat!</h2>
                <p class="text-white mb-0" style="opacity: 0.9; line-height: 1.8; font-size: 1.15rem; max-width: 600px; margin: 0 auto;">
                    Ayo pilih kelas seru yang ingin kamu ikuti hari ini. Kumpulkan lencana, selesaikan misi, dan jadilah juara! Semangat belajarnya ya! 🚀
                </p>
            </div>
        </div>
        @else
        {{-- =============================== --}}
        {{-- WELCOMING CARD DEWASA           --}}
        {{-- =============================== --}}
        <div class="card mb-5 border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-md-7 p-4 p-lg-5" style="background: linear-gradient(135deg, #022c22 0%, #065f46 50%, #047857 100%);">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span style="font-size: 2rem;">📚</span>
                            <h2 class="fw-bold text-white mb-0" style="font-size: 1.6rem;">Selamat Datang di Academy!</h2>
                        </div>
                        <p class="text-white mb-4" style="opacity: 0.85; line-height: 1.8; font-size: 1.05rem;">
                            Terima kasih sudah bergabung! Pelajari semua materi di bawah ini secara bertahap. 
                            Jika ada pertanyaan, jangan ragu untuk menghubungi admin kami. Semangat belajar! 🚀
                        </p>

                        <div class="d-flex flex-column gap-2">
                            <a href="https://wa.me/6282297441115" target="_blank" class="text-decoration-none d-flex align-items-center gap-3 p-3 wa-card" style="background: rgba(255,255,255,0.08); border-radius: 14px; border: 1px solid rgba(255,255,255,0.1);">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: #25d366; border-radius: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold text-white" style="font-size: 0.95rem;">Chat Admin 1</div>
                                    <div class="text-white small" style="opacity: 0.7;">+62 822-9744-1115</div>
                                </div>
                            </a>
                            <a href="https://wa.me/6285751295471" target="_blank" class="text-decoration-none d-flex align-items-center gap-3 p-3 wa-card" style="background: rgba(255,255,255,0.08); border-radius: 14px; border: 1px solid rgba(255,255,255,0.1);">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: #25d366; border-radius: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold text-white" style="font-size: 0.95rem;">Chat Admin 2</div>
                                    <div class="text-white small" style="opacity: 0.7;">0857-5129-5471</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-5 p-4 p-lg-5 d-flex flex-column justify-content-center" style="background: #f8fafc;">
                        <h4 class="fw-bold mb-3 d-flex align-items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Syarat & Ketentuan
                        </h4>
                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle bg-red-lt d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">
                                    <span class="fw-bold text-red" style="font-size: 0.75rem;">1</span>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">Seluruh konten di dalam academy ini sepenuhnya milik pengembang dan dilindungi hak cipta.</p>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle bg-red-lt d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">
                                    <span class="fw-bold text-red" style="font-size: 0.75rem;">2</span>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.6;"><strong>Dilarang keras</strong> meniru, menyebarluaskan, atau membagikan akses akun.</p>
                            </div>
                            <div class="d-flex gap-3 align-items-start">
                                <div class="rounded-circle bg-red-lt d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px;">
                                    <span class="fw-bold text-red" style="font-size: 0.75rem;">3</span>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.6;">Pelanggaran akan ditindak tegas sesuai hukum yang berlaku.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- =============================== --}}
        {{-- COURSES GRID                    --}}
        {{-- =============================== --}}
        @if($courses->isEmpty())
            <div class="card" style="border-radius: 20px; border: 2px dashed #e2e8f0;">
                <div class="card-body text-center py-5">
                    <div class="mb-3" style="opacity: 0.4;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                    </div>
                    <h3 class="fw-bold text-muted mb-1">Belum ada materi tersedia</h3>
                    <p class="text-muted">Materi pembelajaran sedang disiapkan. Harap ditunggu!</p>
                </div>
            </div>
        @else
            <h2 class="fw-bold mb-4 d-flex align-items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Daftar E-Course
            </h2>
            <div class="row g-4">
                @foreach($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('academy.show', $course->slug) }}" class="text-decoration-none">
                        <div class="course-card">
                            <div class="course-card-thumb">
                                @if($course->cover_image)
                                    <img src="{{ asset('storage/' . $course->cover_image) }}" alt="{{ $course->title }}">
                                @else
                                    <div class="course-card-thumb-fallback">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="course-card-body">
                                <h3 class="course-card-title">{{ $course->title }}</h3>
                                <p class="course-card-desc">{{ Str::limit($course->description, 80) ?: 'Mulai belajar sekarang!' }}</p>
                                <div class="d-flex gap-3 mb-3">
                                    <span class="course-card-stat">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                        {{ $course->modules_count }} modul
                                    </span>
                                    <span class="course-card-stat">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        {{ $course->lessons_count }} materi
                                    </span>
                                </div>
                                @php $progress = $courseProgress[$course->id] ?? 0; @endphp
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small text-muted fw-bold">Progress</span>
                                    <span class="small fw-bold" style="color: {{ $progress >= 100 ? '#22c55e' : '#6366f1' }};">{{ $progress }}%</span>
                                </div>
                                <div class="progress" style="height: 6px; border-radius: 6px; background: rgba(255,255,255,0.1);">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%; border-radius: 6px; background: {{ $progress >= 100 ? '#22c55e' : 'linear-gradient(90deg, #6366f1, #8b5cf6)' }};"></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .course-card {
            background: #1a1a2e;
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            height: 100%;
        }
        .course-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.3);
        }
        .course-card-thumb {
            width: 100%;
            height: 180px;
            overflow: hidden;
        }
        .course-card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .course-card:hover .course-card-thumb img {
            transform: scale(1.05);
        }
        .course-card-thumb-fallback {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .course-card-body {
            padding: 20px;
        }
        .course-card-title {
            color: white !important;
            font-weight: 800;
            font-size: 1.15rem;
            margin-bottom: 6px;
        }
        .course-card-desc {
            color: rgba(255,255,255,0.6) !important;
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 12px;
        }
        .course-card-stat {
            display: flex;
            align-items: center;
            gap: 4px;
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
        }
        .wa-card { transition: all 0.2s ease; }
        .wa-card:hover { background: rgba(255,255,255,0.15) !important; }

        @if(Auth::user()->package_type === 'worksheet_anak')
        /* Gaya khusus Anak-anak */
        .course-card {
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 8px 24px rgba(20, 184, 166, 0.15);
            border: 4px solid #ccfbf1;
        }
        .course-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 32px rgba(20, 184, 166, 0.3);
            border-color: #5eead4;
        }
        .course-card-title {
            color: #0f766e !important;
            font-size: 1.3rem;
            text-shadow: 1px 1px 0px rgba(0,0,0,0.05);
        }
        .course-card-desc {
            color: #475569 !important;
        }
        .course-card-stat {
            color: #0d9488;
            font-weight: 600;
        }
        .course-card-stat svg {
            stroke: #14b8a6;
        }
        .progress {
            background: #e2e8f0 !important;
            height: 10px !important;
            border-radius: 10px !important;
        }
        .progress-bar {
            background: linear-gradient(90deg, #f59e0b, #fbbf24) !important;
        }
        @endif
    </style>
</x-dashboard-layout>
