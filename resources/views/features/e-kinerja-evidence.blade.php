<x-admin-layout>
    <div class="row justify-content-center py-3">
        <div class="col-lg-11">
            <!-- Development Mode Alert -->
            <div class="alert alert-warning d-flex align-items-center mb-4 shadow-sm" role="alert" style="border-radius: 16px; background-color: #fffbeb; border: 1px solid #fde68a;">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon text-warning me-2" width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.871l-8.106 -13.534a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg>
                <div>
                    <h4 class="alert-title mb-0 fw-bold text-dark">Mode Development: Evidence Laporan Harian e-Kinerja (Admin Only)</h4>
                    <div class="text-muted small">Fitur penyusunan dokumen evidence harian ASN ini saat ini dalam tahap uji coba oleh Administrator sebelum dirilis ke pengguna umum.</div>
                </div>
            </div>

            <div class="card shadow-lg border-0" style="border-radius: 24px; border-top: 6px solid #059669 !important; background: #fff;">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header Banner -->
                    <div class="row align-items-center mb-5">
                        <div class="col">
                            <span class="badge bg-green-lt mb-2 px-3 py-1 fw-bold">E-Kinerja BKN • Bukti Dukung Harian</span>
                            <h1 class="fw-bold mb-1" style="font-size: 2rem;">Penyusunan Evidence Laporan Harian</h1>
                            <p class="text-muted fs-4">Susun laporan formal pelaksanaan tugas harian ASN sebagai dokumen bukti dukung fisik/digital yang sah pada aplikasi e-Kinerja.</p>
                        </div>
                        <div class="col-auto">
                            <div class="avatar bg-green-lt shadow-sm" style="width: 70px; height: 70px; border-radius: 20px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M9 15l2 2l4 -4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('feature.e-kinerja-evidence.generate') }}" method="POST" id="evidenceForm" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                        @csrf
                        
                        <!-- Opsi: Sambungkan dengan Dokumen E-Kinerja / SKP Sebelumnya -->
                        @if(count($previousDocs) > 0)
                        <div class="mb-5">
                            <div class="card p-4 border-2" style="border-radius: 16px; background: #ecfdf5; border-color: #a7f3d0 !important;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success me-2" width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                                    <h4 class="fw-bold mb-0 text-dark">Ambil Data dari E-Kinerja / SKP Sebelumnya (Opsional)</h4>
                                </div>
                                <p class="text-muted small mb-3">Pilih dokumen SKP atau E-Kinerja Harian Anda untuk otomatis mengisi data identitas pegawai.</p>
                                <select name="source_content_id" id="doc_selector" class="form-select border-2 bg-white" style="border-radius: 10px;" onchange="handleDocSelection(this)">
                                    <option value="">-- Input Manual / Tanpa Dokumen Sumber --</option>
                                    @foreach($previousDocs as $doc)
                                    <option value="{{ $doc->id }}" {{ (isset($selectedDoc) && $selectedDoc->id === $doc->id) ? 'selected' : '' }}>
                                        [{{ strtoupper($doc->type) }}] {{ $doc->title }} ({{ $doc->created_at->format('d M Y') }})
                                    </option>
                                    @endforeach
                                </select>
                                <div id="doc-linked-notice" class="mt-2 text-success small fw-semibold d-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline me-1" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                    Data pegawai berhasil disinkronkan dari dokumen sumber.
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- BAGIAN A: IDENTITAS LAPORAN -->
                        <div class="mb-5">
                            <h3 class="fw-bold mb-3 d-flex align-items-center">
                                <span class="badge text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; background-color: #059669 !important;">A</span>
                                Identitas Laporan & Pegawai
                            </h3>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Judul Laporan <span class="text-danger">*</span></label>
                                    <input type="text" name="judul_laporan" id="judul_laporan" class="form-control border-2" placeholder="Contoh: Laporan Pelaksanaan Pemeliharaan Infrastruktur Jaringan dan Server Daerah" required style="border-radius: 10px;" value="{{ old('judul_laporan') }}">
                                    <div class="form-hint">Buat judul yang spesifik, formal, dan mencerminkan tugas utama yang dilaksanakan.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                    <input type="text" name="pegawai_nama" id="pegawai_nama" class="form-control border-2" placeholder="Nama Lengkap Pegawai" value="{{ Auth::user()->name }}" required style="border-radius: 10px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">NIP <span class="text-danger">*</span></label>
                                    <input type="text" name="pegawai_nip" id="pegawai_nip" class="form-control border-2" placeholder="19XXXXXXXXXXXXXX" required style="border-radius: 10px;" value="{{ old('pegawai_nip') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" name="pegawai_jabatan" id="pegawai_jabatan" class="form-control border-2" placeholder="Misal: Pranata Komputer Ahli Pertama" required style="border-radius: 10px;" value="{{ old('pegawai_jabatan') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Unit Kerja <span class="text-danger">*</span></label>
                                    <input type="text" name="pegawai_unit" id="pegawai_unit" class="form-control border-2" placeholder="Misal: Dinas Komunikasi dan Informatika" required style="border-radius: 10px;" value="{{ old('pegawai_unit') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Hari & Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="form-control border-2" placeholder="Contoh: Senin, 14 Oktober 2026" required style="border-radius: 10px;" value="{{ old('tanggal_pelaksanaan', date('l, d F Y')) }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-5" style="opacity: 0.1;">

                        <!-- BAGIAN B: INFORMASI KEGIATAN -->
                        <div class="mb-5">
                            <h3 class="fw-bold mb-3 d-flex align-items-center">
                                <span class="badge text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; background-color: #059669 !important;">B</span>
                                Informasi Kegiatan
                            </h3>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Nama Kegiatan <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control border-2" placeholder="Contoh: Pemeriksaan dan Konfigurasi Router Core Jaringan Diskominfo" required style="border-radius: 10px;" value="{{ old('nama_kegiatan') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Uraian Pelaksanaan Kegiatan <span class="text-danger">*</span></label>
                                    <textarea name="uraian_kegiatan" id="uraian_kegiatan" class="form-control border-2" rows="3" placeholder="Jelaskan secara ringkas atau detail pekerjaan yang Anda lakukan (AI akan mengembangkannya secara terstruktur dan formal)..." required style="border-radius: 10px;">{{ old('uraian_kegiatan') }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Tahapan Pelaksanaan (Opsional)</label>
                                    <textarea name="tahapan_pelaksanaan" id="tahapan_pelaksanaan" class="form-control border-2" rows="2" placeholder="Contoh: 1. Persiapan alat dan login sistem. 2. Pengecekan log lalu lintas. 3. Penyesuaian bandwidth rule." style="border-radius: 10px;">{{ old('tahapan_pelaksanaan') }}</textarea>
                                    <div class="form-hint">Jika dikosongkan, AI akan merumuskan tahapan logis berdasarkan uraian kegiatan Anda.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Objek atau Sasaran Kegiatan <span class="text-danger">*</span></label>
                                    <input type="text" name="objek_kegiatan" id="objek_kegiatan" class="form-control border-2" placeholder="Contoh: Perangkat Router Core CCR-1036 dan Jaringan LAN Gedung A" required style="border-radius: 10px;" value="{{ old('objek_kegiatan') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Hasil Pelaksanaan Kegiatan <span class="text-danger">*</span></label>
                                    <input type="text" name="hasil_kegiatan" id="hasil_kegiatan" class="form-control border-2" placeholder="Contoh: Konfigurasi berhasil diperbarui, koneksi antar gedung stabil tanpa packet loss" required style="border-radius: 10px;" value="{{ old('hasil_kegiatan') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Bentuk Output Pekerjaan <span class="text-danger">*</span></label>
                                    <select name="output_pekerjaan" id="output_pekerjaan" class="form-select border-2" style="border-radius: 10px;">
                                        <option value="Laporan Tertulis Pelaksanaan Tugas">Laporan Tertulis Pelaksanaan Tugas</option>
                                        <option value="Tabel Rekapitulasi Data / Pemantauan">Tabel Rekapitulasi Data / Pemantauan</option>
                                        <option value="Daftar Hasil Identifikasi dan Verifikasi">Daftar Hasil Identifikasi dan Verifikasi</option>
                                        <option value="Dokumentasi Digital dan Log Sistem">Dokumentasi Digital dan Log Sistem</option>
                                        <option value="Berita Acara / Notula Pelaksanaan Kegiatan">Berita Acara / Notula Pelaksanaan Kegiatan</option>
                                        <option value="Draft Dokumen Kebijakan / SOP">Draft Dokumen Kebijakan / SOP</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Status Penyelesaian <span class="text-danger">*</span></label>
                                    <select name="status_penyelesaian" id="status_penyelesaian" class="form-select border-2" style="border-radius: 10px;">
                                        <option value="Selesai (100%)">Selesai (100%)</option>
                                        <option value="Dalam Proses (On Progress)">Dalam Proses (On Progress)</option>
                                        <option value="Menunggu Tindak Lanjut / Persetujuan">Menunggu Tindak Lanjut / Persetujuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Bukti Pendukung (Evidence Fisik) <span class="text-danger">*</span></label>
                                    <input type="text" name="bukti_pendukung" id="bukti_pendukung" class="form-control border-2" placeholder="Contoh: Tangkapan layar status router & lembar verifikasi" required style="border-radius: 10px;" value="{{ old('bukti_pendukung') }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-5" style="opacity: 0.1;">

                        <!-- BAGIAN C: INFORMASI TAMBAHAN (OPSIONAL) -->
                        <div class="mb-5">
                            <h3 class="fw-bold mb-3 d-flex align-items-center">
                                <span class="badge text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; background-color: #059669 !important;">C</span>
                                Informasi Tambahan (Opsional)
                            </h3>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Arahan Atasan (Jika Ada)</label>
                                    <textarea name="arahan_atasan" class="form-control border-2" rows="2" placeholder="Misal: Prioritaskan stabilitas jaringan selama jam pelayanan publik" style="border-radius: 10px;">{{ old('arahan_atasan') }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kendala yang Dihadapi (Jika Ada)</label>
                                    <textarea name="kendala" class="form-control border-2" rows="2" placeholder="Misal: Fluktuasi tegangan listrik sempat terjadi selama 5 menit" style="border-radius: 10px;">{{ old('kendala') }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tindak Lanjut yang Diperlukan (Jika Ada)</label>
                                    <textarea name="tindak_lanjut" class="form-control border-2" rows="2" placeholder="Misal: Koordinasi dengan penyedia UPS untuk penggantian baterai cadangan" style="border-radius: 10px;">{{ old('tindak_lanjut') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Generate Full-Width Premier -->
                        <div class="form-footer pt-3 mt-4">
                            <button type="submit" class="btn w-100 py-3 fs-3 fw-bold text-white shadow-lg hover-lift" id="submitBtn" style="border-radius: 16px; background: linear-gradient(135deg, #10b981, #059669); border: none; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.45);">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                <span id="btnText" class="d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sparkles me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6z" /></svg>
                                    Generate Dokumen Evidence Harian
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
        const previousDocsData = @json($previousDocs->keyBy('id'));

        function handleDocSelection(selectEl) {
            const docId = selectEl.value;
            const noticeEl = document.getElementById('doc-linked-notice');

            if (!docId || !previousDocsData[docId]) {
                if (noticeEl) noticeEl.classList.add('d-none');
                return;
            }

            if (noticeEl) noticeEl.classList.remove('d-none');
            const doc = previousDocsData[docId];
            const params = doc.parameters || {};

            if (params.pegawai_nama) document.getElementById('pegawai_nama').value = params.pegawai_nama;
            if (params.pegawai_nip) document.getElementById('pegawai_nip').value = params.pegawai_nip;
            if (params.pegawai_jabatan) document.getElementById('pegawai_jabatan').value = params.pegawai_jabatan;
            if (params.pegawai_unit) document.getElementById('pegawai_unit').value = params.pegawai_unit;

            // If the document has a specific title or activity, prefill suggestions
            if (!document.getElementById('judul_laporan').value) {
                document.getElementById('judul_laporan').value = "Laporan Pelaksanaan Tugas: " + (doc.title.replace(/^SKP:\s*|^E-Kinerja Harian:\s*/i, ''));
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selector = document.getElementById('doc_selector');
            if (selector && selector.value) {
                handleDocSelection(selector);
            }
        });
    </script>
    @endpush

    <style>
        .hover-lift {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -4px rgba(16, 185, 129, 0.5) !important;
        }
    </style>
</x-admin-layout>
