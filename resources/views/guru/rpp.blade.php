<x-guru-layout>
<div class="container-xl py-6">

    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#8b5cf6,#7c3aed);display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <h1 class="display-6 fw-bold mb-0">Buat RPP</h1>
        </div>
        <p class="text-secondary fs-4">Generate Rencana Pelaksanaan Pembelajaran lengkap, siap cetak.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body p-4">
                    <form id="rpp-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mapel" class="form-control" placeholder="cth: Matematika, Fisika, PKn..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas / Semester <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control" placeholder="cth: X / Ganjil, VII / Genap..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Topik / Materi <span class="text-danger">*</span></label>
                            <input type="text" name="topik" class="form-control" placeholder="cth: Hukum Newton tentang Gerak..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kompetensi Dasar (KD) <span class="text-danger">*</span></label>
                            <textarea name="kd" class="form-control" rows="2" placeholder="cth: 3.4 Menganalisis hubungan antara gaya, massa, dan percepatan benda..." required></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-4">
                                <label class="form-label fw-semibold">Waktu (menit)</label>
                                <input type="number" name="waktu" class="form-control" value="90" min="30" max="480" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold">Pertemuan</label>
                                <input type="number" name="pertemuan" class="form-control" value="2" min="1" max="20" required>
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-semibold">JP/Pertemuan</label>
                                <input type="number" name="jp" class="form-control" value="2" min="1" max="6" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kurikulum</label>
                            <select name="kurikulum" class="form-select">
                                <option>Kurikulum Merdeka</option>
                                <option>Kurikulum 2013 (K-13)</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Metode / Model Pembelajaran</label>
                            <select name="metode" class="form-select">
                                <option>Problem Based Learning (PBL)</option>
                                <option>Project Based Learning (PjBL)</option>
                                <option>Discovery Learning</option>
                                <option>Inquiry Learning</option>
                                <option>Cooperative Learning</option>
                                <option>Saintifik (5M)</option>
                                <option>Direct Instruction</option>
                            </select>
                        </div>
                        <button type="submit" id="btn-generate" class="btn w-100 fw-bold text-white" style="border-radius:12px;padding:.7rem;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Generate RPP
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div id="result-area" class="d-none">
                <div class="card border-0 shadow-sm" style="border-radius:20px;">
                    <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="fw-bold">Hasil RPP</span>
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
                        <div id="result-content" class="guru-result-body" style="max-height:70vh;overflow-y:auto;"></div>
                    </div>
                </div>
            </div>
            <div id="loading-area" class="d-none text-center py-5">
                <div class="spinner-border mb-3" style="width:2.5rem;height:2.5rem;color:#8b5cf6;"></div>
                <div class="fw-semibold">AI sedang menyusun RPP...</div>
                <div class="text-secondary small mt-1">Biasanya 15–40 detik</div>
            </div>
            <div id="empty-area" class="text-center py-5 text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3 opacity-25"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <div>Isi form dan klik <strong>Generate RPP</strong></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
let currentTitle = 'RPP';

document.getElementById('rpp-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    document.getElementById('empty-area').classList.add('d-none');
    document.getElementById('result-area').classList.add('d-none');
    document.getElementById('loading-area').classList.remove('d-none');
    document.getElementById('btn-generate').disabled = true;

    const fd = new FormData(this);
    currentTitle = 'RPP ' + this.querySelector('[name=mapel]').value + ' ' + this.querySelector('[name=kelas]').value;

    try {
        const res = await fetch('{{ route("guru.rpp.generate") }}', {
            method: 'POST', body: fd,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('result-content').innerHTML = marked.parse(data.result);
            document.getElementById('result-area').classList.remove('d-none');
            guruToast('success', 'RPP berhasil dibuat!');
        } else {
            guruAlert('error', 'Generate Gagal', data.message || 'Terjadi kesalahan saat membuat RPP. Silakan coba lagi.');
            document.getElementById('empty-area').classList.remove('d-none');
        }
    } catch(err) {
        guruAlert('error', 'Koneksi Berputus', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda dan coba lagi.');
        document.getElementById('empty-area').classList.remove('d-none');
    } finally {
        document.getElementById('loading-area').classList.add('d-none');
        document.getElementById('btn-generate').disabled = false;
    }
});
</script>
</x-guru-layout>
