<x-guru-layout>
<div class="container-xl py-6">

    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div style="width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
            </div>
            <h1 class="display-6 fw-bold mb-0">Rekap Nilai</h1>
        </div>
        <p class="text-secondary fs-4">Input nilai siswa, AI buat rekap + analisis + rekomendasi tindak lanjut.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:20px;">
                <div class="card-body p-4">
                    <form id="rekap-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="mapel" class="form-control" placeholder="cth: Matematika, IPA..." required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-7">
                                <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <input type="text" name="kelas" class="form-control" placeholder="cth: VII A, X IPA 2..." required>
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-semibold">KKM / KKTP</label>
                                <input type="number" name="kkm" class="form-control" value="75" min="0" max="100" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Periode <span class="text-danger">*</span></label>
                            <input type="text" name="periode" class="form-control" placeholder="cth: Semester 1 2024/2025, UTS Okt 2024..." required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Data Nilai Siswa <span class="text-danger">*</span></label>
                            <p class="text-secondary small mb-2">Format: satu baris per siswa → <code>Nama Siswa, Nilai</code></p>
                            <textarea name="nilai_raw" class="form-control font-monospace" rows="12"
                                style="font-size:0.82rem;"
                                placeholder="Ahmad Fauzi, 85&#10;Budi Santoso, 72&#10;Cindy Aulia, 90&#10;Dedi Prasetyo, 68&#10;Eka Wulandari, 78"
                                required></textarea>
                        </div>
                        <button type="submit" id="btn-generate" class="btn w-100 fw-bold text-white" style="border-radius:12px;padding:.7rem;background:linear-gradient(135deg,#10b981,#059669);border:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            Analisis & Buat Rekap
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div id="result-area" class="d-none">
                <div class="card border-0 shadow-sm" style="border-radius:20px;">
                    <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <span class="fw-bold">Hasil Rekap & Analisis</span>
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
                <div class="spinner-border mb-3" style="width:2.5rem;height:2.5rem;color:#10b981;"></div>
                <div class="fw-semibold">AI sedang menganalisis nilai...</div>
                <div class="text-secondary small mt-1">Biasanya 10–25 detik</div>
            </div>
            <div id="empty-area" class="text-center py-5 text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3 opacity-25"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                <div>Input nilai siswa lalu klik <strong>Analisis & Buat Rekap</strong></div>
                <div class="small mt-1">Format: <code>Nama Siswa, Nilai</code> (satu baris per siswa)</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
let currentTitle = 'Rekap Nilai';

document.getElementById('rekap-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    document.getElementById('empty-area').classList.add('d-none');
    document.getElementById('result-area').classList.add('d-none');
    document.getElementById('loading-area').classList.remove('d-none');
    document.getElementById('btn-generate').disabled = true;

    const fd = new FormData(this);
    const mapel = this.querySelector('[name=mapel]').value;
    const kelas = this.querySelector('[name=kelas]').value;
    currentTitle = 'Rekap Nilai ' + mapel + ' ' + kelas;

    try {
        const res = await fetch('{{ route("guru.rekap.generate") }}', {
            method: 'POST', body: fd,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        });
        const data = await res.json();
        
        if (data.success && data.queue_id) {
            pollQueue(data.queue_id);
        } else {
            guruAlert('error', 'Generate Gagal', data.message || 'Terjadi kesalahan saat menganalisis nilai. Silakan coba lagi.');
            resetUI();
        }
    } catch(err) {
        guruAlert('error', 'Koneksi Berputus', 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda dan coba lagi.');
        resetUI();
    }
});

function pollQueue(queueId) {
    const checkInterval = setInterval(async () => {
        try {
            const response = await fetch(`/api/queue/${queueId}`);
            const result = await response.json();

            if (result.status === 'completed') {
                clearInterval(checkInterval);
                const decodedContent = result.is_base64 ? decodeURIComponent(escape(window.atob(result.content))) : result.content;
                document.getElementById('result-content').innerHTML = marked.parse(decodedContent);
                document.getElementById('result-area').classList.remove('d-none');
                guruToast('success', 'Rekap nilai berhasil dianalisis!');
                resetUI(true);
            } else if (result.status === 'failed') {
                clearInterval(checkInterval);
                guruAlert('error', 'Generate Gagal', result.message || 'Gagal menyusun rekap nilai. Coba lagi dengan data berbeda.');
                resetUI();
            }
        } catch (e) {
            clearInterval(checkInterval);
            guruAlert('error', 'Koneksi Error', 'Terputus dari server saat mengecek status.');
            resetUI();
        }
    }, 3000);
}

function resetUI(success = false) {
    document.getElementById('loading-area').classList.add('d-none');
    document.getElementById('btn-generate').disabled = false;
    if (!success) document.getElementById('empty-area').classList.remove('d-none');
}
</script>
</x-guru-layout>
