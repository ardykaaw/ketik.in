<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow: hidden; background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);">
                    <div class="row g-0">
                        <!-- Left: Visual/Intro -->
                        <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center bg-primary p-5 position-relative">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('https://www.transparenttextures.com/patterns/cubes.png'); opacity: 0.1;"></div>
                            <div class="text-center text-white p-4" style="z-index: 1;">
                                <div class="mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2 shadow-lg" width="100" height="100" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="background: rgba(255,255,255,0.2); border-radius: 30px; padding: 20px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" /><path d="M19 16h-12a2 2 0 0 0 -2 2" /><path d="M9 8h6" /></svg>
                                </div>
                                <h1 class="display-5 fw-bold mb-3">Penulis E-book Cerdas</h1>
                                <p class="fs-3 opacity-75">Tulis bab demi bab, buat outline otomatis, dan ekspor karya Anda dalam hitungan menit.</p>
                            </div>
                        </div>

                        <!-- Right: Form -->
                        <div class="col-md-7 p-md-5 p-4">
                            <div class="mb-5">
                                <h2 class="fw-bold fs-1 mb-2">Detail Proyek E-book</h2>
                                <p class="text-muted">Lengkapi profil buku Anda untuk memulai proses penulisan AI.</p>
                            </div>

                            <form action="{{ route('feature.ebook.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Judul Buku</label>
                                    <input type="text" name="topic" class="form-control form-control-lg border-2" placeholder="Misal: Rahasia Sukses di Era Digital" style="border-radius: 12px;" value="{{ old('topic') }}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">Ide Utama / Premis Buku</label>
                                    <textarea name="outline" class="form-control border-2" rows="4" maxlength="5000" placeholder="Ceritakan ide buku Anda secara singkat. Contoh: Panduan praktis digital marketing untuk UMKM pemula agar bisa jualan laris di TikTok..." style="border-radius: 12px;" required>{{ old('outline') }}</textarea>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Target Pembaca</label>
                                        <select name="target" class="form-select border-2" style="border-radius: 10px;">
                                            <option value="Umum" {{ old('target') == 'Umum' ? 'selected' : '' }}>Umum</option>
                                            <option value="Akademisi" {{ old('target') == 'Akademisi' ? 'selected' : '' }}>Akademisi</option>
                                            <option value="Pengusaha" {{ old('target') == 'Pengusaha' ? 'selected' : '' }}>Pengusaha</option>
                                            <option value="Anak-anak" {{ old('target') == 'Anak-anak' ? 'selected' : '' }}>Anak-anak</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold rounded-pill shadow" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                    <span id="btnText">
                                        Generate Outline & Bab 1
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
