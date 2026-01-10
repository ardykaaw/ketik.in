<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Branding & Intro -->
                <div class="text-center mb-6">
                    <span class="badge bg-primary-lt mb-3 px-3 py-2 fs-5 rounded-pill">AI Story Teller</span>
                    <h1 class="display-3 fw-bold mb-3">Ubah Ide Menjadi Cerita Ajaib</h1>
                    <p class="text-secondary fs-2 mx-auto" style="max-width: 700px;">
                        Gunakan kekuatan AI untuk menyusun narasi yang memikat, membangun karakter yang hidup, dan menciptakan dunia yang tak terlupakan.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Writing Input -->
                    <div class="col-md-8">
                        <form action="{{ route('feature.story-telling.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="card shadow-lg border-0 bg-white" style="border-radius: 20px;">
                                <div class="card-body p-5">
                                    <div class="mb-4">
                                        <label class="form-label fs-3 fw-bold mb-3">Topik atau Premis Cerita</label>
                                        <textarea name="topic" class="form-control border-2 bg-light p-4" rows="6" maxlength="5000" placeholder="Misal: Seorang penjelajah waktu yang terjebak di era Kerajaan Majapahit..." style="border-radius: 12px; font-size: 1.1rem;" required>{{ old('topic') }}</textarea>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Genre</label>
                                            <select name="genre" class="form-select border-2 bg-light p-3" style="border-radius: 10px;">
                                                <option value="Fantasi" {{ old('genre') == 'Fantasi' ? 'selected' : '' }}>Fantasi</option>
                                                <option value="Sci-Fi" {{ old('genre') == 'Sci-Fi' ? 'selected' : '' }}>Sci-Fi</option>
                                                <option value="Misteri" {{ old('genre') == 'Misteri' ? 'selected' : '' }}>Misteri</option>
                                                <option value="Romansa" {{ old('genre') == 'Romansa' ? 'selected' : '' }}>Romansa</option>
                                                <option value="Horor" {{ old('genre') == 'Horor' ? 'selected' : '' }}>Horor</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Target Pembaca</label>
                                            <select name="target" class="form-select border-2 bg-light p-3" style="border-radius: 10px;">
                                                <option value="Anak-anak" {{ old('target') == 'Anak-anak' ? 'selected' : '' }}>Anak-anak</option>
                                                <option value="Remaja" {{ old('target') == 'Remaja' ? 'selected' : '' }}>Remaja</option>
                                                <option value="Dewasa" {{ old('target') == 'Dewasa' ? 'selected' : '' }}>Dewasa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold shadow" id="submitBtn" style="border-radius: 12px;">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                            <span id="btnText">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wand me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 21l15 -15l-3 -3l-15 15l3 3"></path><path d="M15 6l3 3"></path><path d="M9 3a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2"></path><path d="M19 13a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2"></path></svg>
                                                Tulis Cerita Sekarang
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="col-md-4">
                        <div class="card bg-primary-lt border-0 mb-4" style="border-radius: 20px;">
                            <div class="card-body p-4 text-center">
                                <div class="avatar bg-white text-primary mb-3 shadow-sm" style="width: 4rem; height: 4rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                                </div>
                                <h4 class="fw-bold mb-2">Tips Penulisan</h4>
                                <p class="text-secondary small mb-0">Masukkan detail lingkungan atau emosi karakter untuk hasil yang lebih realistis dan mendalam.</p>
                            </div>
                        </div>
                        <div class="card shadow-sm border-0" style="border-radius: 20px;">
                            <div class="card-body p-4 text-center">
                                <h4 class="fw-bold mb-3">Model AI Terbaru</h4>
                                <div class="badge bg-blue text-white mb-2">Google Gemini 2.0 Flash</div>
                                <p class="text-muted small">Ketik.in menggunakan model bahasa tercanggih untuk memahami konteks budaya dan narasi Indonesia.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
