<x-guru-layout>
<div class="container-xl py-6">

    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <h1 class="display-6 fw-bold mb-0">Buat Soal</h1>
        </div>
        <p class="text-secondary fs-4">Generate soal ujian/latihan otomatis dengan kunci jawaban.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body p-4">
                    <form id="soal-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mapel" class="form-control" placeholder="cth: Matematika, Bahasa Indonesia, IPA..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas / Tingkat <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control" placeholder="cth: Kelas 7 SMP, Kelas X SMA..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Topik / Materi <span class="text-danger">*</span></label>
                            <input type="text" name="topik" class="form-control" placeholder="cth: Persamaan Linear Satu Variabel..." required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Jumlah Soal</label>
                                <input type="number" name="jumlah" class="form-control" value="10" min="1" max="50" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Tingkat Kesulitan</label>
                                <select name="kesulitan" class="form-select">
                                    <option>Mudah</option>
                                    <option selected>Sedang</option>
                                    <option>Sulit</option>
                                    <option>Campuran</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Jenis Soal</label>
                            <div class="d-flex gap-2 flex-wrap">
                                <label class="d-flex align-items-center gap-2 border rounded-3 px-3 py-2 cursor-pointer jenis-option" style="cursor:pointer;">
                                    <input type="radio" name="jenis" value="Pilihan Ganda" checked class="d-none"> Pilihan Ganda
                                </label>
                                <label class="d-flex align-items-center gap-2 border rounded-3 px-3 py-2 cursor-pointer jenis-option" style="cursor:pointer;">
                                    <input type="radio" name="jenis" value="Essay" class="d-none"> Essay
                                </label>
                                <label class="d-flex align-items-center gap-2 border rounded-3 px-3 py-2 cursor-pointer jenis-option" style="cursor:pointer;">
                                    <input type="radio" name="jenis" value="Campuran" class="d-none"> Campuran
                                </label>
                            </div>
                        </div>
                        <button type="submit" id="btn-generate" class="btn btn-warning w-100 fw-bold" style="border-radius:12px;padding:.7rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Generate Soal
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div id="result-area" class="d-none">
                <div class="card border-0 shadow-sm" style="border-radius:20px;">
                    <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="fw-bold">Hasil Soal</span>
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
                <div class="spinner-border text-warning mb-3" style="width:2.5rem;height:2.5rem;"></div>
                <div class="fw-semibold">AI sedang membuat soal...</div>
                <div class="text-secondary small mt-1">Biasanya 10–30 detik</div>
            </div>
            <div id="empty-area" class="text-center py-5 text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3 opacity-25"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <div>Isi form dan klik <strong>Generate Soal</strong></div>
            </div>
        </div>
    </div>
</div>

<style>
    .jenis-option { transition: all .15s; font-size:.9rem; user-select:none; }
    .jenis-option.active { background:#fef3c7; border-color:#f59e0b !important; color:#92400e; font-weight:600; }
</style>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
let currentTitle = 'Soal';

document.querySelectorAll('.jenis-option').forEach(label => {
    label.addEventListener('click', () => {
        document.querySelectorAll('.jenis-option').forEach(l => l.classList.remove('active'));
        label.classList.add('active');
    });
    if (label.querySelector('input').checked) label.classList.add('active');
});

document.getElementById('soal-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    document.getElementById('empty-area').classList.add('d-none');
    document.getElementById('result-area').classList.add('d-none');
    document.getElementById('loading-area').classList.remove('d-none');
    document.getElementById('btn-generate').disabled = true;

    const fd = new FormData(this);
    const mapel = this.querySelector('[name=mapel]').value;
    const jenis = this.querySelector('[name=jenis]:checked')?.value || 'Soal';
    currentTitle = jenis + ' ' + mapel;

    try {
        const res = await fetch('{{ route("guru.soal.generate") }}', {
            method: 'POST', body: fd,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('result-content').innerHTML = marked.parse(data.result);
            document.getElementById('result-area').classList.remove('d-none');
            guruToast('success', 'Soal berhasil dibuat!');
        } else {
            guruAlert('error', 'Generate Gagal', data.message || 'Terjadi kesalahan saat membuat soal. Silakan coba lagi.');
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
