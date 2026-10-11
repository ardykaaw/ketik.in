<x-admin-layout>
    <div class="row justify-content-center py-3">
        <div class="col-lg-11">
            <!-- Development Mode Alert -->
            <div class="alert alert-warning d-flex align-items-center mb-4 shadow-sm" role="alert" style="border-radius: 16px; background-color: #fffbeb; border: 1px solid #fde68a;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon text-warning me-2" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.871l-8.106 -13.534a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg>
                <div>
                    <h4 class="alert-title mb-0 fw-bold text-dark">Mode Development: Fitur E-Kinerja Harian (Admin Only)</h4>
                    <div class="text-muted small">Fitur ini khusus untuk Administrator selama proses pengujian dan penyempurnaan, belum dapat diakses oleh pengguna umum.</div>
                </div>
            </div>

            <div class="card shadow-lg border-0" style="border-radius: 24px; border-top: 6px solid #0284c7 !important; background: #fff;">
                    <div class="card-body p-5">
                        
                        <!-- Header Banner -->
                        <div class="row align-items-center mb-5">
                            <div class="col">
                                <span class="badge bg-blue-lt mb-2 px-3 py-1">Mode ASN / PNS</span>
                                <h1 class="fw-bold mb-1" style="font-size: 2rem;">Penyusunan E-Kinerja Harian</h1>
                                <p class="text-muted fs-4">Asisten AI untuk menyusun Rencana Aksi (Trajektori/Non-Trajektori) dan Log Aktivitas Harian berstandar BKN.</p>
                            </div>
                            <div class="col-auto">
                                <div class="avatar bg-blue-lt shadow-sm" style="width: 70px; height: 70px; border-radius: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 3v3m0 12v3" />
                                        <path d="M3 12h3m12 0h3" />
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                        <path d="M4 4l3 3m10 10l3 3" />
                                        <path d="M4 20l3 -3m10 -10l3 -3" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('feature.e-kinerja-harian.generate') }}" method="POST" id="ekinerjaHarianForm" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            
                            <!-- Opsi: Sambungkan dengan SKP Sebelumnya -->
                            @if(count($previousSkps) > 0)
                            <div class="mb-5">
                                <div class="card p-4 border-2" style="border-radius: 16px; background: #f0f9ff; border-color: #bae6fd !important;">
                                    <div class="d-flex align-items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary me-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                                        <h4 class="fw-bold mb-0 text-dark">Gunakan Data dari SKP Sebelumnya (Opsional)</h4>
                                    </div>
                                    <p class="text-muted small mb-3">Pilih dokumen SKP tahunan yang pernah Anda buat untuk otomatis mengisi identitas dan mengintervensi RHK/IKI yang ada.</p>
                                    <select name="skp_content_id" id="skp_selector" class="form-select border-2 bg-white" style="border-radius: 10px;" onchange="handleSkpSelection(this)">
                                        <option value="">-- Buat Mandiri / Input Manual Baru --</option>
                                        @foreach($previousSkps as $skp)
                                        <option value="{{ $skp->id }}" {{ (isset($selectedSkp) && $selectedSkp->id === $skp->id) ? 'selected' : '' }}>
                                            {{ $skp->title }} ({{ $skp->created_at->format('d M Y') }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <div id="skp-linked-notice" class="mt-2 text-primary small fw-semibold d-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                        Data pegawai & RHK telah disinkronkan dari SKP sumber.
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Bagian 1: Data Pegawai -->
                            <div class="mb-5">
                                <h3 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="badge bg-blue text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; background-color: #0284c7 !important;">1</span>
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
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Pangkat / Golongan</label>
                                        <input type="text" name="pegawai_golongan" class="form-control border-2" placeholder="Misal: Penata Muda / III.a" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <input type="text" name="pegawai_jabatan" class="form-control border-2" placeholder="Misal: Pranata Komputer Ahli Pertama" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Periode Kinerja</label>
                                        <input type="text" name="periode" class="form-control border-2" value="Tahun 2024" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Unit Kerja</label>
                                        <input type="text" name="pegawai_unit" class="form-control border-2" placeholder="Misal: Dinas Komunikasi dan Informatika" required style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5" style="opacity: 0.1;">

                            <!-- Bagian 2: Rencana Hasil Kerja (RHK) -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="fw-bold mb-0 d-flex align-items-center">
                                        <span class="badge bg-blue text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; background-color: #0284c7 !important;">2</span>
                                        Rencana Hasil Kerja (RHK) & Tugas Pokok
                                    </h3>
                                    <button type="button" class="btn btn-outline-primary btn-sm fw-bold shadow-sm" onclick="addRHK()" style="border-radius: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                        Tambah RHK
                                    </button>
                                </div>
                                <p class="text-muted fs-5 mb-4">Tuliskan tugas utama atau RHK Anda. AI akan merumuskan Indikator Kinerja Individu (IKI), Rencana Aksi (Trajektori/Non-Trajektori), waktu pelaksanaan, dan aktivitas hariannya.</p>

                                <div id="rhk_container">
                                    <div class="rhk-item card p-4 border-2 mb-3 shadow-sm" style="border-radius: 16px; border-left: 5px solid #0284c7 !important; background: #f8fafc;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-blue-lt px-3">RHK #1</span>
                                            <button type="button" class="btn btn-link text-danger p-0 remove-rhk-btn d-none" onclick="removeRHK(this)">Hapus</button>
                                        </div>
                                        <div>
                                            <label class="form-label fw-semibold">Rencana Hasil Kerja (RHK) / Tugas Pokok Anda</label>
                                            <textarea name="rhk[]" class="form-control border-2 bg-white" rows="2" placeholder="Contoh: Terkelola dan terpeliharanya sistem informasi daerah serta infrastruktur jaringan pendukung..." style="border-radius: 10px;" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Generate -->
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm hover-lift" id="submitBtn" style="border-radius: 12px; background-color: #0284c7; border-color: #0284c7;">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                    <span id="btnText">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M13 3l0 7l6 0l-8 11l0 -7l-6 0z" />
                                        </svg>
                                        Generate E-Kinerja Harian
                                    </span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @push('scripts')
    <script>
        const previousSkpsData = @json($previousSkps->keyBy('id'));
        let rhkCount = 1;
        const container = document.getElementById('rhk_container');

        function addRHK() {
            rhkCount++;
            const newRHK = document.createElement('div');
            newRHK.className = 'rhk-item card p-4 border-2 mb-3 shadow-sm';
            newRHK.style = 'border-radius: 16px; border-left: 5px solid #0284c7 !important; background: #f8fafc;';
            newRHK.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-blue-lt px-3">RHK #${rhkCount}</span>
                    <button type="button" class="btn btn-link text-danger p-0 remove-rhk-btn" onclick="removeRHK(this)">Hapus</button>
                </div>
                <div>
                    <label class="form-label fw-semibold">Rencana Hasil Kerja (RHK) / Tugas Pokok Anda</label>
                    <textarea name="rhk[]" class="form-control border-2 bg-white" rows="2" placeholder="Tuliskan tugas spesifik Anda..." style="border-radius: 10px;" required></textarea>
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

        function handleSkpSelection(selectEl) {
            const skpId = selectEl.value;
            const noticeEl = document.getElementById('skp-linked-notice');

            if (!skpId || !previousSkpsData[skpId]) {
                if (noticeEl) noticeEl.classList.add('d-none');
                return;
            }

            if (noticeEl) noticeEl.classList.remove('d-none');
            const skp = previousSkpsData[skpId];
            const params = skp.parameters || {};

            if (params.pegawai_nama) document.querySelector('input[name="pegawai_nama"]').value = params.pegawai_nama;
            if (params.pegawai_nip) document.querySelector('input[name="pegawai_nip"]').value = params.pegawai_nip;
            if (params.pegawai_golongan) document.querySelector('input[name="pegawai_golongan"]').value = params.pegawai_golongan;
            if (params.pegawai_jabatan) document.querySelector('input[name="pegawai_jabatan"]').value = params.pegawai_jabatan;
            if (params.pegawai_unit) document.querySelector('input[name="pegawai_unit"]').value = params.pegawai_unit;
            if (params.periode) document.querySelector('input[name="periode"]').value = params.periode;

            if (params.rhk && Array.isArray(params.rhk) && params.rhk.length > 0) {
                container.innerHTML = '';
                params.rhk.forEach((rhkText, idx) => {
                    const div = document.createElement('div');
                    div.className = 'rhk-item card p-4 border-2 mb-3 shadow-sm';
                    div.style = 'border-radius: 16px; border-left: 5px solid #0284c7 !important; background: #f8fafc;';
                    div.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-blue-lt px-3">RHK #${idx + 1}</span>
                            <button type="button" class="btn btn-link text-danger p-0 remove-rhk-btn ${idx === 0 ? 'd-none' : ''}" onclick="removeRHK(this)">Hapus</button>
                        </div>
                        <div>
                            <label class="form-label fw-semibold">Rencana Hasil Kerja (RHK) / Tugas Pokok Anda</label>
                            <textarea name="rhk[]" class="form-control border-2 bg-white" rows="2" style="border-radius: 10px;" required>${rhkText}</textarea>
                        </div>
                    `;
                    container.appendChild(div);
                });
                rhkCount = params.rhk.length;
                updateRemoveButtons();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selector = document.getElementById('skp_selector');
            if (selector && selector.value) {
                handleSkpSelection(selector);
            }
        });
    </script>
    @endpush

    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
    </style>
</x-admin-layout>
