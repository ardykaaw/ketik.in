<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-5 d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="display-5 fw-bold mb-1">Editor Opini & Artikel</h1>
                        <p class="text-secondary fs-3">Sampaikan pemikiran Anda dengan tajam dan persuasif.</p>
                    </div>
                    <div class="d-none d-sm-block">
                        <span class="badge bg-purple-lt p-2 px-3 fs-4" style="border-radius: 10px;">Opini Mode</span>
                    </div>
                </div>

                <div class="card shadow-lg border-0" style="border-radius: 20px;">
                    <div class="card-body p-5">
                        <form action="{{ route('feature.opini.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-bold fs-4">Topik yang Ingin Dibahas</label>
                                <input type="text" name="topic" class="form-control form-control-lg border-2 py-3" placeholder="Misal: Dampak Artificial Intelligence pada Pendidikan di Indonesia" style="border-radius: 12px;" value="{{ old('topic') }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold fs-4">Argumen Utama / Poin Kunci (Opsional)</label>
                                <textarea name="stance" class="form-control border-2 p-3" rows="5" placeholder="Sebutkan posisi Anda atau beberapa poin yang ingin Anda tekankan..." style="border-radius: 12px;">{{ old('stance') }}</textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-purple btn-pill px-5 py-3 fs-3 fw-bold shadow-lg" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                    <span id="btnText">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-plus me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path><path d="M13.5 6.5l4 4"></path><path d="M16 19h6"></path><path d="M19 16v6"></path></svg>
                                        Draft Opini Saya
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-purple {
            background: #7c3aed;
            color: white;
        }
        .btn-purple:hover {
            background: #6d28d9;
            color: white;
        }
    </style>
</x-dashboard-layout>
