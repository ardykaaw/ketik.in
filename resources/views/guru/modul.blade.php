<x-guru-layout>
<div class="container-xl py-6">

    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#059669,#047857);display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div>
                <h1 class="display-6 fw-bold mb-0">Modul Ajar</h1>
            </div>
        </div>
        <p class="text-secondary mb-0">Format <strong>Deep Learning</strong> — lengkap dengan LKPD, asesmen diagnostik, dan diferensiasi produk sesuai Kurikulum Merdeka.</p>
        <div class="d-flex flex-wrap gap-2 mt-2">
            <span class="badge" style="background:#d1fae5;color:#065f46;font-weight:600;border-radius:8px;padding:4px 10px;">🔵 Meaningful Learning</span>
            <span class="badge" style="background:#d1fae5;color:#065f46;font-weight:600;border-radius:8px;padding:4px 10px;">🟢 Joyful Learning</span>
            <span class="badge" style="background:#d1fae5;color:#065f46;font-weight:600;border-radius:8px;padding:4px 10px;">🔴 Mindful Learning</span>
            <span class="badge" style="background:#ecfdf5;color:#047857;font-weight:600;border-radius:8px;padding:4px 10px;">📋 LKPD Terintegrasi</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body p-4">
                    <form id="modul-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mapel" class="form-control" placeholder="cth: Matematika, PAI, Bahasa Indonesia, IPA..." required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Fase <span class="text-danger">*</span></label>
                                <select name="fase" class="form-select" required>
                                    <option value="">Pilih Fase</option>
                                    <option value="Fase A">Fase A (Kelas 1–2 SD)</option>
                                    <option value="Fase B">Fase B (Kelas 3–4 SD)</option>
                                    <option value="Fase C">Fase C (Kelas 5–6 SD)</option>
                                    <option value="Fase D" selected>Fase D (Kelas 7–9 SMP)</option>
                                    <option value="Fase E">Fase E (Kelas 10 SMA)</option>
                                    <option value="Fase F">Fase F (Kelas 11–12 SMA)</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                                <select name="semester" class="form-select" required>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control" placeholder="cth: VII, VIII, X, XI..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Topik / Materi <span class="text-danger">*</span></label>
                            <input type="text" name="topik" class="form-control" placeholder="cth: Bilangan Bulat, Fotosintesis, Puasa Ramadan..." required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Waktu/Pertemuan (menit) <span class="text-danger">*</span></label>
                                <input type="number" name="waktu" class="form-control" value="80" min="30" max="480" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Jumlah Pertemuan <span class="text-danger">*</span></label>
                                <input type="number" name="pertemuan" class="form-control" value="4" min="1" max="20" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tahun Pelajaran</label>
                            <input type="text" name="tahun_ajar" class="form-control" placeholder="cth: 2024/2025" value="{{ date('n') < 7 ? (date('Y')-1).'/'.date('Y') : date('Y').'/'.(date('Y')+1) }}">
                        </div>

                        <button type="submit" id="btn-generate" class="btn btn-primary w-100 fw-bold" style="border-radius:12px;padding:.75rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Generate Modul Ajar Deep Learning
                        </button>

                        <div class="text-center mt-2">
                            <small class="text-secondary">Proses 30–60 detik — output lengkap + LKPD</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div id="result-area" class="d-none">
                <div class="card border-0 shadow-sm" style="border-radius:20px;">
                    <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <span class="fw-bold">Hasil Modul Ajar</span>
                            <span class="badge ms-2" style="background:#d1fae5;color:#065f46;font-size:.7rem;border-radius:6px;">Deep Learning</span>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button onclick="guruCopy('result-content')" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                Salin
                            </button>
                            <button onclick="guruExportWord('result-content', currentTitle)" class="btn btn-sm" style="border-radius:8px;background:#e8f5e9;color:#2e7d32;border:1px solid #c8e6c9;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                Word
                            </button>
                            <button onclick="guruExportPDF('result-content', currentTitle)" class="btn btn-sm" style="border-radius:8px;background:#fce4ec;color:#c62828;border:1px solid #f8bbd0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                PDF
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div id="result-content" class="guru-result-body" style="max-height:75vh;overflow-y:auto;"></div>
                    </div>
                </div>
            </div>
            <div id="loading-area" class="d-none text-center py-5">
                <div class="spinner-border mb-3" style="width:2.5rem;height:2.5rem;color:#059669;"></div>
                <div class="fw-semibold">AI sedang menyusun Modul Ajar Deep Learning...</div>
                <div class="text-secondary small mt-1">Menyusun identitas, kegiatan pembelajaran, asesmen, dan LKPD — biasanya 30–60 detik</div>
            </div>
            <div id="empty-area" class="text-center py-5 text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" class="mb-3 opacity-20"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <div class="fw-semibold mb-1">Modul Ajar Anda akan muncul di sini</div>
                <div class="small">Isi form di sebelah kiri, lalu klik <strong>Generate</strong></div>
                <div class="small mt-2 text-muted">Output mencakup: Identitas Modul · Kesiapan Peserta Didik · Karakteristik Materi · Dimensi Lulusan · Capaian Pembelajaran · Lintas Disiplin · Tujuan Pembelajaran · Topik Kontekstual · Kegiatan Deep Learning (Meaningful · Joyful · Mindful) · Asesmen Lengkap · LKPD · Glosarium</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
let currentTitle = 'Modul Ajar';

document.getElementById('modul-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    document.getElementById('empty-area').classList.add('d-none');
    document.getElementById('result-area').classList.add('d-none');
    document.getElementById('loading-area').classList.remove('d-none');
    document.getElementById('btn-generate').disabled = true;

    const fd = new FormData(this);
    const mapel = this.querySelector('[name=mapel]').value;
    const fase  = this.querySelector('[name=fase]').value;
    const topik = this.querySelector('[name=topik]').value;
    currentTitle = `Modul Ajar ${mapel} ${fase} — ${topik}`;

    try {
        const res = await fetch('{{ route("guru.modul.generate") }}', {
            method: 'POST', body: fd,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('result-content').innerHTML = marked.parse(data.result);
            document.getElementById('result-area').classList.remove('d-none');
            document.getElementById('result-content').scrollTop = 0;
            guruToast('success', 'Modul Ajar Deep Learning berhasil dibuat!');
        } else {
            guruAlert('error', 'Generate Gagal', data.message || 'Terjadi kesalahan. Silakan coba lagi.');
            document.getElementById('empty-area').classList.remove('d-none');
        }
    } catch(err) {
        guruAlert('error', 'Koneksi Berputus', 'Tidak dapat terhubung ke server. Periksa koneksi internet dan coba lagi.');
        document.getElementById('empty-area').classList.remove('d-none');
    } finally {
        document.getElementById('loading-area').classList.add('d-none');
        document.getElementById('btn-generate').disabled = false;
    }
});
</script>
</x-guru-layout>
