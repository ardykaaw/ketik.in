<x-dashboard-layout>
    <div class="container-xl py-5">
        @if(!$course)
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

            {{-- =============================== --}}
            {{-- WELCOMING CARD                  --}}
            {{-- =============================== --}}
            <div class="card mb-5 border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-7 p-4 p-lg-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);">
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
                            <div class="mt-auto p-3 bg-white rounded-3 shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold small">Progress Belajar</span>
                                    <span class="fw-bold text-primary" id="progress-text">{{ $progress }}%</span>
                                </div>
                                <div class="progress" style="height: 8px; border-radius: 8px; background: #e2e8f0;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%; border-radius: 8px;" id="progress-bar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =============================== --}}
            {{-- MODULE GRID (Dark Cards)        --}}
            {{-- =============================== --}}
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

            {{-- Instruction --}}
            <p class="text-center text-muted fst-italic small mb-5">(klik pada materi di bawah thumbnail untuk membuka konten)</p>

        @endif
    </div>

    {{-- =============================== --}}
    {{-- LESSON MODAL (Enhanced)         --}}
    {{-- =============================== --}}
    <div class="modal modal-blur fade" id="lessonModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                {{-- Thumbnail Header --}}
                <div id="modal-thumbnail-header" class="d-none" style="position: relative; width: 100%; max-height: 280px; overflow: hidden; background: linear-gradient(135deg, #1e1b4b 0%, #581c87 50%, #7e22ce 100%);">
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
                    {{-- Document Viewer (Inline) --}}
                    <div id="modal-file-container" class="mb-4 d-none">
                        <div id="modal-file-embed" class="overflow-hidden" style="border-radius: 16px; border: 1px solid #e2e8f0;"></div>
                    </div>

                    {{-- Video Container --}}
                    <div id="modal-video-container" class="mb-4 d-none overflow-hidden" style="border-radius: 16px;"></div>

                    {{-- Content --}}
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
            const modalThumbOverlay = document.getElementById('modal-thumbnail-overlay');
            const completeBtn = document.getElementById('modal-toggle-complete');
            const statusText = document.getElementById('modal-lesson-status');

            document.querySelectorAll('.lesson-trigger').forEach(btn => {
                btn.addEventListener('click', function() {
                    const lessonId = this.dataset.lessonId;
                    
                    // Reset
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

                            // Show Module Thumbnail in header
                            modalThumbHeader.classList.remove('d-none');
                            if (data.module_thumbnail) {
                                modalThumbImg.src = data.module_thumbnail;
                                modalThumbImg.style.display = 'block';
                            } else {
                                modalThumbImg.style.display = 'none';
                            }
                            modalModuleTitle.textContent = data.module_title || '';

                            modalTitle.textContent = data.title;

                            // Document Handling (PDF/Word — inline viewing)
                            if (data.has_file && data.file_url) {
                                modalFile.classList.remove('d-none');
                                if (data.file_extension === 'pdf') {
                                    modalFileEmbed.innerHTML = `<iframe src="${data.file_url}#toolbar=0&navpanes=0" style="width: 100%; height: 600px; border: none;"></iframe>`;
                                } else {
                                    // Word docs: use Google Docs Viewer for inline viewing
                                    const encodedUrl = encodeURIComponent(data.file_url);
                                    modalFileEmbed.innerHTML = `<iframe src="https://docs.google.com/gview?url=${encodedUrl}&embedded=true" style="width: 100%; height: 600px; border: none;"></iframe>`;
                                }
                            }

                            // Video Handling
                            if (data.has_video) {
                                modalVideo.classList.remove('d-none');
                                if (data.video_type === 'embed') {
                                    modalVideo.innerHTML = `<div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="${data.embed_url}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allowfullscreen></iframe></div>`;
                                } else {
                                    modalVideo.innerHTML = `<video controls playsinline class="w-100" style="border-radius: 12px;"><source src="${data.video_url}" type="video/mp4"></video>`;
                                }
                            }

                            // Text Content
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

            // Toggle Complete
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

                        // Update progress
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
        /* ===== Module Cards (Dark Theme) ===== */
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
            color: white;
            margin-bottom: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
        }
        .module-fallback-title {
            color: white;
            font-weight: 700;
            font-size: 1.15rem;
            line-height: 1.3;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .module-card-body {
            padding: 12px;
        }

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
            color: rgba(255,255,255,0.85);
            font-size: 0.9rem;
        }
        .module-lesson-item:hover {
            background: rgba(255,255,255,0.12);
            color: white;
        }
        .module-lesson-item.completed {
            opacity: 0.5;
        }
        .module-lesson-item.completed .lesson-title {
            text-decoration: line-through;
        }

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

        .lesson-title {
            flex: 1;
            font-weight: 500;
        }

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

        /* ===== WA Cards ===== */
        .wa-card { transition: all 0.2s ease; }
        .wa-card:hover { background: rgba(255,255,255,0.15) !important; }

        /* ===== Lesson Content in Modal ===== */
        .lesson-content h1, .lesson-content h2, .lesson-content h3 { font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1e293b; }
        .lesson-content img { max-width: 100%; border-radius: 12px; margin: 1rem 0; }
        .lesson-content p { margin-bottom: 1rem; }
        .lesson-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        .lesson-content table td, .lesson-content table th { border: 1px solid #e2e8f0; padding: 8px 12px; }
        .lesson-content table th { background: #f8fafc; font-weight: 600; }
    </style>
</x-dashboard-layout>
