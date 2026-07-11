<x-guru-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                        </div>
                        <h2 class="fw-bold mb-3" style="color: #1A1A2E;">Sedang Dalam Perbaikan</h2>
                        <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.6;">
                            Fitur ini sedang dalam proses perbaikan dan pengembangan untuk memberikan pengalaman yang lebih baik.
                        </p>
                        <div class="alert alert-warning border-0" style="background: #FEF7E8; border-radius: 12px;">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                <span class="fw-semibold" style="color: #92400e;">Mohon coba kembali nanti</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('guru.index') }}" class="btn btn-primary px-4" style="border-radius: 10px; background: #10b981; border-color: #10b981;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    <polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                                Kembali ke Beranda Guru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guru-layout>
