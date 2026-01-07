<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="border-radius: 24px; background: #1a1b26; color: #a9b1d6; overflow: hidden;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Visual Side -->
                            <div class="col-md-4 bg-dark p-5 d-flex flex-column justify-content-center align-items-center text-center">
                                <div class="mb-4">
                                    <div class="avatar bg-red-lt shadow-lg" style="width: 80px; height: 80px; border-radius: 20px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="16" height="16" rx="2" /><line x1="8" y1="4" x2="8" y2="20" /><line x1="16" y1="4" x2="16" y2="20" /><line x1="4" y1="8" x2="8" y2="8" /><line x1="4" y1="16" x2="8" y2="16" /><line x1="16" y1="8" x2="20" y2="8" /><line x1="16" y1="16" x2="20" y2="16" /></svg>
                                    </div>
                                </div>
                                <h2 class="text-white fw-bold">Script Video AI</h2>
                                <p class="small opacity-75">Sempurna untuk TikTok, YouTube, Reels, atau Video Korporat.</p>
                            </div>

                            <!-- Form Side -->
                            <div class="col-md-8 p-5 bg-white text-dark">
                                <div class="mb-5">
                                    <h3 class="fw-bold mb-1">Butuh naskah video apa hari ini?</h3>
                                    <p class="text-muted">Masukkan detail video Anda dan biarkan AI merancang alurnya.</p>
                                </div>

                                <form action="{{ route('feature.script.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Topik atau Judul Video</label>
                                        <input type="text" name="topic" class="form-control form-control-lg border-2" placeholder="Misal: Review iPhone 15 Pro dalam 60 detik" style="border-radius: 12px;" value="{{ old('topic') }}" required>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Platform Video</label>
                                            <select name="platform" class="form-select border-2" style="border-radius: 10px;">
                                                <option value="TikTok/Reels" {{ old('platform') == 'TikTok/Reels' ? 'selected' : '' }}>TikTok/Reels</option>
                                                <option value="YouTube" {{ old('platform') == 'YouTube' ? 'selected' : '' }}>YouTube</option>
                                                <option value="Video Korporat" {{ old('platform') == 'Video Korporat' ? 'selected' : '' }}>Video Korporat</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Durasi Video</label>
                                            <select name="duration" class="form-select border-2" style="border-radius: 10px;">
                                                <option value="Shorts (< 1 Menit)" {{ old('duration') == 'Shorts (< 1 Menit)' ? 'selected' : '' }}>Shorts (< 1 Menit)</option>
                                                <option value="1-3 Menit" {{ old('duration') == '1-3 Menit' ? 'selected' : '' }}>1-3 Menit</option>
                                                <option value="> 5 Menit" {{ old('duration') == '5 Menit' ? 'selected' : '' }}>&gt; 5 Menit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-danger w-100 py-3 fs-3 fw-bold rounded-pill shadow-lg" id="submitBtn">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                        <span id="btnText">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 4v16l13 -8z" /></svg>
                                            Produksi Naskah Video
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
