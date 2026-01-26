<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Penyusun SOP Otomatis</h1>
                    <p class="text-secondary fs-3">Buat Standar Operasional Prosedur (SOP) yang detail dan mudah dipahami untuk setiap jabatan.</p>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 24px; overflow: hidden;">
                    <div class="card-body p-5">
                        <form action="{{ route('feature.sop.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Judul SOP</label>
                                    <input type="text" name="title" class="form-control form-control-lg border-2" placeholder="Contoh: Pengelolaan Kas Kecil" style="border-radius: 12px;" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Jabatan/Penanggung Jawab</label>
                                    <input type="text" name="role" class="form-control form-control-lg border-2" placeholder="Contoh: Staff Keuangan / Bendahara" style="border-radius: 12px;" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Tujuan SOP</label>
                                <textarea name="objective" class="form-control border-2" rows="3" placeholder="Apa tujuan prosedur ini dibuat? (Misal: Agar pengeluaran tercatat rapi)" style="border-radius: 12px;" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Ruang Lingkup</label>
                                <textarea name="scope" class="form-control border-2" rows="3" placeholder="SOP ini berlaku untuk siapa dan dalam situasi apa?" style="border-radius: 12px;" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold rounded-pill shadow" id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                <span id="btnText">
                                    Susun SOP
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /></svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="alert alert-primary bg-white border-primary shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><line x1="3" y1="6" x2="3" y2="19" /><line x1="12" y1="6" x2="12" y2="19" /><line x1="21" y1="6" x2="21" y2="19" /></svg>
                        </div>
                        <div>
                            <h4 class="alert-title text-primary mb-1">Standar SOP:</h4>
                            <div class="text-muted">AI akan otomatis membuat struktur standar: <strong>Tujuan, Ruang Lingkup, Definisi, Prosedur Kerja, dan Dokumen Terkait</strong>.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
