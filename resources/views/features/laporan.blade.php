<x-admin-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Asisten Penyusun Laporan</h1>
                    <p class="text-secondary fs-3">Buat laporan kegiatan formal dan terstruktur secara otomatis dalam hitungan detik.</p>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 24px; overflow: hidden;">
                    <div class="card-body p-5">
                        <form action="{{ route('feature.laporan.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-bold">Nama Kegiatan</label>
                                    <input type="text" name="activity_name" class="form-control form-control-lg border-2" placeholder="Contoh: Rapat Koordinasi Anggaran Tahun 2024" style="border-radius: 12px;" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Tanggal & Waktu</label>
                                    <input type="text" name="date" class="form-control form-control-lg border-2" placeholder="Contoh: Senin, 20 Oktober 2024, Pukul 09.00 - Selesai" style="border-radius: 12px;" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Tempat Pelaksanaan</label>
                                    <input type="text" name="location" class="form-control form-control-lg border-2" placeholder="Contoh: Ruang Pola Kantor Gubernur" style="border-radius: 12px;" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Hasil Kegiatan (Poin-Poin Utama)</label>
                                <textarea name="results" class="form-control border-2" rows="5" placeholder="Sebutkan hasil yang dicapai, keputusan yang diambil, atau data penting yang didapat..." style="border-radius: 12px;" required></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Kendala (Opsional)</label>
                                    <textarea name="challenges" class="form-control border-2" rows="3" placeholder="Jika ada hambatan selama kegiatan, tuliskan di sini..." style="border-radius: 12px;"></textarea>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Saran / Rekomendasi (Opsional)</label>
                                    <textarea name="recommendations" class="form-control border-2" rows="3" placeholder="Tindak lanjut atau saran untuk kegiatan selanjutnya..." style="border-radius: 12px;"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold rounded-pill shadow" id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                <span id="btnText">
                                    Buat Laporan Sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /></svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="alert alert-info bg-white border-info shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-info" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -4.48 0l-7.1 12.25a2 2 0 0 0 1.9 2.75z" /></svg>
                        </div>
                        <div>
                            <h4 class="alert-title text-info mb-1">Tips Laporan Efektif:</h4>
                            <div class="text-muted">Masukkan data hasil kegiatan sedetail mungkin. AI akan menyusun kalimatnya menjadi paragraf formal yang enak dibaca.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
