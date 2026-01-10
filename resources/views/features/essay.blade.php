<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Asisten Penulisan Essay</h1>
                    <p class="text-secondary fs-3">Struktur yang logis, argumen yang kuat, dan referensi yang tepat.</p>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <form action="{{ route('feature.essay.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold fs-4">Judul atau Pertanyaan Essay</label>
                                <input type="text" name="topic" class="form-control form-control-lg border-2" placeholder="Masukkan judul essay Anda..." style="border-radius: 12px;" value="{{ old('topic') }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold fs-4">Konteks / Latar Belakang (Opsional)</label>
                                <textarea name="context" class="form-control border-2" rows="5" maxlength="5000" placeholder="Berikan sedikit latar belakang tentang topik ini..." style="border-radius: 12px;">{{ old('context') }}</textarea>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tipe Essay</label>
                                    <select name="type" class="form-select border-2 py-2" style="border-radius: 10px;">
                                        <option value="Argumentatif" {{ old('type') == 'Argumentatif' ? 'selected' : '' }}>Argumentatif</option>
                                        <option value="Deskriptif" {{ old('type') == 'Deskriptif' ? 'selected' : '' }}>Deskriptif</option>
                                        <option value="Ekspositori" {{ old('type') == 'Ekspositori' ? 'selected' : '' }}>Ekspositori</option>
                                        <option value="Naratif" {{ old('type') == 'Naratif' ? 'selected' : '' }}>Naratif</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold rounded-3 shadow-md" id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                <span id="btnText">Generate Draft Essay</span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="alert alert-info border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                        </div>
                        <div>
                            Essay yang dihasilkan adalah draft awal. Silakan tinjau kembali data dan kutipan untuk memastikan orisinalitas dan keakuratan akademik.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
