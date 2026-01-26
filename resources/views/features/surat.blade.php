<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Generator Surat Dinas</h1>
                    <p class="text-secondary fs-3">Buat surat resmi instansi dengan tata bahasa baku dan format standar.</p>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 24px; overflow: hidden;">
                    <div class="card-body p-5">
                        <form action="{{ route('feature.surat.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold">Jenis Surat</label>
                                    <select name="type" class="form-select border-2" style="border-radius: 12px; height: 50px;">
                                        <option value="Surat Undangan">Surat Undangan</option>
                                        <option value="Surat Permohonan">Surat Permohonan</option>
                                        <option value="Surat Pemberitahuan">Surat Pemberitahuan</option>
                                        <option value="Surat Tugas">Surat Tugas</option>
                                        <option value="Surat Rekomendasi">Surat Rekomendasi</option>
                                        <option value="Surat Edaran">Surat Edaran</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold">Penerima Surat (Yth.)</label>
                                    <input type="text" name="recipient" class="form-control form-control-lg border-2" placeholder="Contoh: Kepala Dinas Pendidikan" style="border-radius: 12px;" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label fw-bold">Pengirim (Penanda Tangan)</label>
                                    <input type="text" name="sender" class="form-control form-control-lg border-2" placeholder="Contoh: Kepala Biro Umum" style="border-radius: 12px;" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Perihal / Hal</label>
                                <input type="text" name="subject" class="form-control form-control-lg border-2" placeholder="Contoh: Undangan Rapat Koordinasi Bulanan" style="border-radius: 12px;" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Isi Pokok Surat</label>
                                <textarea name="content_summary" class="form-control border-2" rows="4" placeholder="Jelaskan inti surat, waktu/tempat (jika ada), dan tujuan surat ini dibuat..." style="border-radius: 12px;" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold rounded-pill shadow" id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                <span id="btnText">
                                    Buat Surat Dinas
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /></svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="alert alert-warning bg-white border-warning shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-warning" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -4.48 0l-7.1 12.25a2 2 0 0 0 1.9 2.75z" /></svg>
                        </div>
                        <div>
                            <h4 class="alert-title text-warning mb-1">Catatan Penting:</h4>
                            <div class="text-muted">AI menyusun badan surat sesuai kaidah PUEBI dan Tata Naskah Dinas. Kop surat dan Nomor Surat akan diberi placeholder [....] untuk Anda isi sesuai nomor registrasi.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
