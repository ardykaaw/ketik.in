<x-app-layout>
    <div class="container-xl py-4">
        <div class="row mb-5 text-center">
            <div class="col">
                <h1 class="display-6">Beritahu kami detailnya</h1>
                <p class="text-secondary">Kami butuh sedikit info lagi untuk membuat {{ $type }} Anda.</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('wizard.step2.store') }}" method="POST" class="card">
                    @csrf
                    <div class="card-body">
                        @if ($type === 'article')
                            <div class="mb-3">
                                <label class="form-label">Judul / Topik Artikel</label>
                                <input type="text" class="form-control" name="topic" placeholder="mis. Masa Depan AI dalam Jurnalisme">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Poin Penting untuk Disertakan</label>
                                <textarea class="form-control" name="points" rows="4" placeholder="- Efisiensi&#10;- Akurasi&#10;- Etika"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nada Bicara</label>
                                <select class="form-select" name="tone">
                                    <option value="professional">Profesional</option>
                                    <option value="casual">Santai</option>
                                    <option value="authoritative">Otoritatif</option>
                                    <option value="informative">Informatif</option>
                                </select>
                            </div>
                        @elseif ($type === 'social')
                            <div class="mb-3">
                                <label class="form-label">Platform</label>
                                <select class="form-select" name="platform">
                                    <option value="twitter">X (Twitter)</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Topik / Konten</label>
                                <textarea class="form-control" name="content" rows="3" placeholder="Tentang apa postingan ini?"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nada Bicara</label>
                                <select class="form-select" name="tone">
                                    <option value="engaging">Menarik</option>
                                    <option value="professional">Profesional</option>
                                    <option value="funny">Lucu</option>
                                    <option value="inspirational">Inspiratif</option>
                                </select>
                            </div>
                        @elseif ($type === 'email')
                            <div class="mb-3">
                                <label class="form-label">Penerima</label>
                                <input type="text" class="form-control" name="recipient" placeholder="mis. Calon Klien">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tujuan Utama</label>
                                <input type="text" class="form-control" name="purpose" placeholder="mis. Memperkenalkan produk baru">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Informasi Penting</label>
                                <textarea class="form-control" name="info" rows="4" placeholder="Detail untuk disertakan..."></textarea>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('wizard.step1') }}" class="btn btn-link link-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Hasilkan Konten</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
