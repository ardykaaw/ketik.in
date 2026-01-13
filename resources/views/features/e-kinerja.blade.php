<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="border-radius: 24px; border-top: 6px solid #2fb344 !important; background: #fff;">
                    <div class="card-body p-5">
                        <div class="row align-items-center mb-5">
                            <div class="col">
                                <span class="badge bg-green-lt mb-2 px-3 py-1">Mode ASN / PNS</span>
                                <h1 class="fw-bold mb-1" style="font-size: 2rem;">Penyusunan e-Kinerja (SKP)</h1>
                                <p class="text-muted fs-4">Asisten AI untuk menyusun Rencana Hasil Kerja sesuai Permenpan RB No. 6 Tahun 2022.</p>
                            </div>
                            <div class="col-auto">
                                <div class="avatar bg-green-lt shadow-sm" style="width: 70px; height: 70px; border-radius: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2z" /><path d="M9 12h6" /><path d="M9 16h6" /><path d="M13 8h2" /><path d="M3 9l3 3l-3 3" /></svg>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('feature.e-kinerja.generate') }}" method="POST" id="ekinerjaForm" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            
                            <!-- Bagian 1: Data Pegawai -->
                            <div class="mb-5">
                                <h3 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="badge bg-green text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">1</span>
                                    Identitas Pegawai
                                </h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap & Gelar</label>
                                        <input type="text" name="pegawai_nama" class="form-control border-2" placeholder="Nama Anda" value="{{ Auth::user()->name }}" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">NIP</label>
                                        <input type="text" name="pegawai_nip" class="form-control border-2" placeholder="19XXXXXXXXXXXXXX" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Pangkat / Golongan</label>
                                        <input type="text" name="pegawai_golongan" class="form-control border-2" placeholder="Misal: Penata Muda / III.a" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <input type="text" name="pegawai_jabatan" class="form-control border-2" placeholder="Misal: Pranata Komputer Ahli Pertama" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Unit Kerja</label>
                                        <input type="text" name="pegawai_unit" class="form-control border-2" placeholder="Misal: Dinas Komunikasi dan Informatika" required style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5" style="opacity: 0.1;">

                            <!-- Bagian 2: Data Atasan -->
                            <div class="mb-5">
                                <h3 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="badge bg-green text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">2</span>
                                    Pejabat Penilai Performance (Atasan)
                                </h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Atasan</label>
                                        <input type="text" name="atasan_nama" class="form-control border-2" placeholder="Nama Atasan Langsung" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan Atasan</label>
                                        <input type="text" name="atasan_jabatan" class="form-control border-2" placeholder="Misal: Kepala Bidang Persandian" required style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5" style="opacity: 0.1;">

                            <!-- Bagian 3: Konten RHK -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="fw-bold mb-0 d-flex align-items-center">
                                        <span class="badge bg-green text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">3</span>
                                        Rencana Hasil Kerja (RHK)
                                    </h3>
                                    <button type="button" class="btn btn-green btn-sm fw-bold shadow-sm" onclick="addRHK()" style="border-radius: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                        Tambah RHK
                                    </button>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Periode Laporan</label>
                                        <select name="periode" class="form-select border-2" style="border-radius: 10px; padding: 12px;">
                                            <option value="Tahun 2026">Tahun 2026 (SKP Tahunan)</option>
                                            <option value="Triwulan I (Jan - Mar)">Triwulan I (Jan - Mar)</option>
                                            <option value="Triwulan II (Apr - Jun)">Triwulan II (Apr - Jun)</option>
                                            <option value="Triwulan III (Jul - Sep)">Triwulan III (Jul - Sep)</option>
                                            <option value="Triwulan IV (Okt - Des)">Triwulan IV (Okt - Des)</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="rhk_container">
                                    <div class="rhk-item card p-4 border-2 mb-3 shadow-sm" style="border-radius: 16px; border-left: 5px solid #2fb344 !important background: #f8fafc;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-green-lt px-3">RHK #1</span>
                                            <button type="button" class="btn btn-link text-danger p-0 d-none remove-rhk-btn" onclick="removeRHK(this)">Hapus</button>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold">RHK Atasan yang Diintervensi</label>
                                                <textarea name="rhk_atasan[]" class="form-control border-2 bg-white" rows="2" placeholder="Tugas besar atasan yang Anda dukung..." style="border-radius: 10px;" required></textarea>
                                            </div>
                                            <div class="col-md-9">
                                                <label class="form-label fw-semibold">Tugas Pokok dan Fungsi (Tupoksi) Anda</label>
                                                <textarea name="rhk[]" class="form-control border-2 bg-white" rows="2" maxlength="5000" placeholder="Tugas spesifik Anda..." style="border-radius: 10px;" required></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Jenis</label>
                                                <select name="rhk_jenis[]" class="form-select border-2 bg-white" style="border-radius: 10px;">
                                                    <option value="Utama">Utama</option>
                                                    <option value="Tambahan">Tambahan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-hint mt-2">Anda dapat memasukkan hingga 10 RHK sekaligus untuk hasil laporan yang lengkap seperti di PDF.</div>
                            </div>

                            <div class="form-footer pt-3">
                                <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold shadow-lg hover-lift" id="submitBtn" style="border-radius: 16px;">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                    <span id="btnText" class="d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sparkles me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6z" /></svg>
                                        Susun SKP & Indikator (IKI)
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Help -->
                <div class="mt-5 text-center">
                    <p class="text-secondary small">
                        Punya masalah dalam pengisian? Hubungi tim support Ketik.in Professional.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rhkCount = 1;
        const container = document.getElementById('rhk_container');

        function addRHK() {
            rhkCount++;
            const newRHK = document.createElement('div');
            newRHK.className = 'rhk-item card p-4 border-2 mb-3 shadow-sm';
            newRHK.style = 'border-radius: 16px; border-left: 5px solid #2fb344 !important; background: #f8fafc;';
            newRHK.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-green-lt px-3">RHK #${rhkCount}</span>
                    <button type="button" class="btn btn-link text-danger p-0 remove-rhk-btn" onclick="removeRHK(this)">Hapus</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">RHK Atasan yang Diintervensi</label>
                        <textarea name="rhk_atasan[]" class="form-control border-2 bg-white" rows="2" placeholder="Tugas besar atasan yang Anda dukung..." style="border-radius: 10px;" required></textarea>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label fw-semibold">Rencana Hasil Kerja (RHK) Anda</label>
                        <textarea name="rhk[]" class="form-control border-2 bg-white" rows="2" placeholder="Tugas spesifik Anda..." style="border-radius: 10px;" required></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis</label>
                        <select name="rhk_jenis[]" class="form-select border-2 bg-white" style="border-radius: 10px;">
                            <option value="Utama">Utama</option>
                            <option value="Tambahan">Tambahan</option>
                        </select>
                    </div>
                </div>
            `;
            container.appendChild(newRHK);
            updateRemoveButtons();
        }

        function removeRHK(btn) {
            btn.closest('.rhk-item').remove();
            updateRemoveButtons();
            reindexRHK();
        }

        function updateRemoveButtons() {
            const btns = document.querySelectorAll('.remove-rhk-btn');
            const items = document.querySelectorAll('.rhk-item');
            btns.forEach(btn => {
                if (items.length > 1) {
                    btn.classList.remove('d-none');
                } else {
                    btn.classList.add('d-none');
                }
            });
        }

        function reindexRHK() {
            const items = document.querySelectorAll('.rhk-item');
            items.forEach((item, index) => {
                item.querySelector('.badge').innerText = `RHK #${index + 1}`;
            });
            rhkCount = items.length;
        }
    </script>
    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
    </style>
</x-dashboard-layout>
