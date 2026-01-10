<x-dashboard-layout>
    <div class="row row-cards">
        <div class="col-lg-8">
            <div class="card card-lg shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-indigo-lt p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="4" width="16" height="16" rx="4"></rect>
                                <circle cx="12" cy="12" r="3"></circle>
                                <line x1="16.5" y1="7.5" x2="16.5" y2="7.501"></line>
                            </svg>
                        </div>
                        <div>
                            <h2 class="h3 fw-bold mb-1">Social Media Generator</h2>
                            <p class="text-muted m-0">Buat konten menarik untuk Instagram, Twitter, LinkedIn, TikTok, dan Facebook.</p>
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('feature.social-media.generate') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">Platform <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-6 col-md-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="platform" value="Instagram" class="form-selectgroup-input" checked>
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="4" /><circle cx="12" cy="12" r="3" /><line x1="16.5" y1="7.5" x2="16.5" y2="7.501" /></svg>
                                            </span>
                                            <span class="flex-fill text-start">Instagram</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="platform" value="Twitter" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-azure" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" /></svg>
                                            </span>
                                            <span class="flex-fill text-start">Twitter (X)</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="platform" value="LinkedIn" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-blue" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><line x1="8" y1="11" x2="8" y2="16" /><line x1="8" y1="8" x2="8" y2="8.01" /><line x1="12" y1="16" x2="12" y2="11" /><path d="M16 16v-3a2 2 0 0 0 -4 0" /></svg>
                                            </span>
                                            <span class="flex-fill text-start">LinkedIn</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="platform" value="TikTok" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-dark" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 12a4 4 0 1 0 4 4v-12a5 5 0 0 0 5 5" /></svg>
                                            </span>
                                            <span class="flex-fill text-start">TikTok Script</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-6 col-md-4">
                                    <label class="form-selectgroup-item">
                                        <input type="radio" name="platform" value="Facebook" class="form-selectgroup-input">
                                        <span class="form-selectgroup-label d-flex align-items-center p-3">
                                            <span class="me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-blue" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                                            </span>
                                            <span class="flex-fill text-start">Facebook</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Topik atau Ide Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="topic" rows="4" maxlength="5000" placeholder="Contoh: Tips produktivitas kerja remote, Promo diskon 50%, atau Review gadget terbaru..." required></textarea>
                            <small class="form-hint">Jelaskan apa yang ingin Anda bahas secara singkat.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Gaya Bahasa (Tone)</label>
                            <select class="form-select" name="style">
                                <option value="Professional & Informatif" selected>Professional & Informatif (Cocok untuk LinkedIn)</option>
                                <option value="Santai & Humoris">Santai & Humoris (Cocok untuk Twitter/IG)</option>
                                <option value="Promo & Hard Selling">Promo & Hard Selling (Cocok untuk Iklan)</option>
                                <option value="Edukasi & Tutorial">Edukasi & Tutorial</option>
                                <option value="Inspiratif & Motivasi">Inspiratif & Motivasi</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
                                Generate Konten
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-primary-lt border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body">
                    <h3 class="h4 fw-bold mb-3 text-primary">Tips Konten Sosial Media</h3>
                    <ul class="list-unstyled space-y-3">
                        <li class="d-flex align-items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            <span><strong>Instagram:</strong> Gunakan visual yang kuat dan caption yang mengundang interaksi.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            <span><strong>LinkedIn:</strong> Fokus pada insight profesional, learning point, dan data.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            <span><strong>Twitter:</strong> Buat thread pendek, padat, dan "hook" yang kuat di tweet pertama.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
