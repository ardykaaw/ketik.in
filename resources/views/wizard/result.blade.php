<x-dashboard-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="container-xl py-6">
        <div class="row align-items-center mb-5">
            <div class="col">
                <span class="badge bg-primary-lt mb-1 px-3">Hasil AI</span>
                <h1 class="display-6 fw-bold m-0">Ini Draf Sempurna Anda</h1>
                <p class="text-secondary small">Konten telah dioptimasi oleh Ketik.in AI untuk hasil terbaik.</p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <button class="btn btn-white fw-bold shadow-sm" style="border-radius: 10px;" onclick="copyToClipboard()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" /><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                        Salin Teks
                    </button>
                    <a href="{{ route('wizard.step1') }}" class="btn btn-primary fw-bold shadow-sm" style="border-radius: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        Buat Baru
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card border-0 shadow-lg mb-5" style="border-radius: 24px; background: #fff url('https://www.transparenttextures.com/patterns/clean-gray-paper.png'); overflow: hidden;">
            <div class="card-status-top bg-primary" style="height: 6px;"></div>
            <div class="card-body p-5">
                <div id="generated-content" class="prose max-w-none" style="font-size: 1.15rem; line-height: 1.8; color: #334155; white-space: pre-wrap;">{{ $content }}</div>
            </div>
            <div class="card-footer bg-light border-0 p-4 text-center">
                <div class="text-muted small">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><path d="M9 12l2 2l4 -4" /></svg>
                    Diformat secara otomatis dengan Markdown rendering.
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentDiv = document.getElementById('generated-content');
            const rawContent = contentDiv.innerText;
            contentDiv.innerHTML = marked.parse(rawContent);
        });

        function copyToClipboard() {
            const content = document.getElementById('generated-content').innerText;
            navigator.clipboard.writeText(content).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Teks berhasil disalin!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
        }
    </script>
    <style>
        .prose h1, .prose h2, .prose h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            color: #1e293b;
        }
        .prose p {
            margin-bottom: 1.25rem;
        }
        .prose ul, .prose ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #475569;
        }
    </style>
    @endpush
</x-app-layout>
