<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Ahli Copywriting AI</h1>
                    <p class="text-secondary fs-3">Buat teks pemasaran yang menjual dengan kerangka teruji (AIDA, PAS, dll).</p>
                </div>

                <div class="card border-0 shadow-lg mb-4" style="border-radius: 24px; overflow: hidden;">
                    <div class="card-body p-5">
                        <form action="{{ route('feature.copywriting.generate') }}" method="POST" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Nama Produk / Brand</label>
                                    <input type="text" name="product_name" class="form-control form-control-lg border-2" placeholder="Contoh: Kopi Kenangan Mantan" style="border-radius: 12px;" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Target Audiens</label>
                                    <input type="text" name="target_audience" class="form-control form-control-lg border-2" placeholder="Contoh: Mahasiswa, Pekerja Kantoran" style="border-radius: 12px;" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Deskripsi Produk / Penawaran Utama</label>
                                <textarea name="description" class="form-control border-2" rows="4" placeholder="Jelaskan keunggulan produk Anda, fitur kunci, atau promo yang sedang berjalan..." style="border-radius: 12px;" required></textarea>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Platform / Format</label>
                                    <select name="platform" class="form-select border-2" style="border-radius: 10px;">
                                        <option value="Facebook/Instagram Ads">Facebook/Instagram Ads</option>
                                        <option value="TikTok Caption">TikTok Caption</option>
                                        <option value="Landing Page Headline">Landing Page Headline</option>
                                        <option value="Email Newsletter">Email Newsletter</option>
                                        <option value="Twitter/X Thread">Twitter/X Thread</option>
                                        <option value="WhatsApp Broadcast">WhatsApp Broadcast</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Kerangka Copywriting</label>
                                    <select name="framework" class="form-select border-2" style="border-radius: 10px;">
                                        <option value="AIDA">AIDA (Attention, Interest, Desire, Action)</option>
                                        <option value="PAS">PAS (Problem, Agitation, Solution)</option>
                                        <option value="FAB">FAB (Features, Advantages, Benefits)</option>
                                        <option value="4Ps">4Ps (Promise, Picture, Proof, Push)</option>
                                        <option value="StoryBrand">StoryBrand (Hero's Journey)</option>
                                    </select>
                                    <div class="form-hint small mt-1">Pilih teknik psikologi marketing yang diinginkan.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Gaya Bahasa (Tone)</label>
                                    <select name="tone" class="form-select border-2" style="border-radius: 10px;">
                                        <option value="Profesional & Terpercaya">Profesional & Terpercaya</option>
                                        <option value="Santai & Bersahabat">Santai & Bersahabat</option>
                                        <option value="Mendesak (FOMO)">Mendesak (FOMO/Urgent)</option>
                                        <option value="Humoris & Witty">Humoris & Witty</option>
                                        <option value="Empatik & Menyentuh">Empatik & Menyentuh</option>
                                        <option value="Mewah & Eksklusif">Mewah & Eksklusif</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fs-3 fw-bold rounded-pill shadow" id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                <span id="btnText">
                                    Buat Copywriting Ajaib
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /></svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="alert alert-success bg-white border-success shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex">
                        <div class="me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                        </div>
                        <div>
                            <h4 class="alert-title text-success mb-1">Tips Pro:</h4>
                            <div class="text-muted">Untuk hasil terbaik, berikan detail spesifik pada deskripsi produk. AI akan menggabungkannya dengan kerangka pilihan Anda untuk hasil yang maksimal.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
