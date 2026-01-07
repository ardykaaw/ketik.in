<x-app-layout>
    <div class="container-xl py-4">
        <div class="row text-center mb-5">
            <div class="col">
                <h1 class="display-6">Apa yang ingin Anda tulis hari ini?</h1>
                <p class="text-secondary">Pilih jenis konten yang ingin Anda hasilkan.</p>
            </div>
        </div>
        
        <form action="{{ route('wizard.step1.store') }}" method="POST">
            @csrf
            <div class="row row-cards justify-content-center">
                <div class="col-md-6 col-lg-3">
                    <label class="form-selectgroup-item flex-fill">
                        <input type="radio" name="type" value="article" class="form-selectgroup-input" checked>
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div>
                                <span class="selection-type mb-1 d-block fw-bold">Artikel / Blog</span>
                                <span class="text-secondary small">Konten panjang, berita, atau opini.</span>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-selectgroup-item flex-fill">
                        <input type="radio" name="type" value="social" class="form-selectgroup-input">
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div>
                                <span class="selection-type mb-1 d-block fw-bold">Media Sosial</span>
                                <span class="text-secondary small">Postingan untuk X, LinkedIn, Facebook, dll.</span>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-selectgroup-item flex-fill">
                        <input type="radio" name="type" value="email" class="form-selectgroup-input">
                        <div class="form-selectgroup-label d-flex align-items-center p-3">
                            <div class="me-3">
                                <span class="form-selectgroup-check"></span>
                            </div>
                            <div>
                                <span class="selection-type mb-1 d-block fw-bold">Email</span>
                                <span class="text-secondary small">Buletin, penawaran dingin, atau pembaruan.</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-6">
                        Selanjutnya: Berikan Detail
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
