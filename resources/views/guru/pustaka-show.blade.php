<x-guru-layout>
<div class="container-xl py-6">

    <div class="mb-4 d-flex align-items-center justify-content-between gap-3 flex-wrap">
        <div>
            <a href="{{ route('guru.pustaka') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Pustaka Guru
            </a>
            <h2 class="fw-bold mb-0 lh-sm">{{ $content->title }}</h2>
            <div class="text-secondary small mt-1">{{ $content->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button onclick="guruCopy('doc-content')" class="btn fw-semibold" style="border-radius:10px;background:#f0fdf4;color:#059669;border:1px solid #d1fae5;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                Salin
            </button>
            <button onclick="guruExportWord('doc-content', '{{ addslashes($content->title) }}')" class="btn fw-semibold" style="border-radius:10px;background:#e8f5e9;color:#2e7d32;border:1px solid #c8e6c9;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Word
            </button>
            <button onclick="guruExportPDF('doc-content', '{{ addslashes($content->title) }}')" class="btn btn-outline-secondary fw-semibold" style="border-radius:10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                PDF
            </button>
            <button onclick="confirmHapus()" class="btn btn-outline-danger fw-semibold" style="border-radius:10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="me-1"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Hapus
            </button>
            <form id="delete-form" method="POST" action="{{ route('guru.pustaka.destroy', $content->id) }}" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:20px;">
        <div class="card-body p-4 p-lg-5">
            <div id="doc-content" class="guru-result-body"></div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    const raw = @json($content->content);
    document.getElementById('doc-content').innerHTML = marked.parse(raw);

    function confirmHapus() {
        Swal.fire({
            title: 'Hapus Dokumen?',
            text: 'Dokumen yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>

<style>
@media print {
    .guru-navbar, header, .d-flex.mb-4 { display: none !important; }
    .guru-page-wrapper { margin-left: 0 !important; }
    .card { box-shadow: none !important; border: none !important; }
}
</style>
</x-guru-layout>
