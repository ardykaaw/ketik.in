<x-dashboard-layout>
    <div class="container-xl py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <!-- Header Section -->
                <div class="mb-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center p-3 mb-4 bg-primary-lt rounded-pill shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-news text-primary" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11"></path>
                            <path d="M8 8l4 0"></path>
                            <path d="M8 12l4 0"></path>
                            <path d="M8 16l4 0"></path>
                        </svg>
                    </div>
                    <h1 class="display-5 fw-bold mb-2">Berita AI</h1>
                    <p class="text-secondary fs-3 mx-auto" style="max-width: 600px;">
                        Tulis berita profesional dalam hitungan detik. Biarkan AI menyusun narasi yang akurat dan berbobot.
                    </p>
                </div>

                <!-- Main Card -->
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('feature.news.generate') }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fs-4 fw-bold mb-2 text-dark">Topik Berita</label>
                                    <textarea name="topic" rows="4" class="form-control form-control-lg border-2" 
                                        placeholder="Contoh: Peresmian gedung baru Ketik.in di Jakarta Pusat..." maxlength="5000"
                                        style="border-radius: 12px; resize: none;">{{ old('topic') }}</textarea>
                                    <div class="form-hint mt-2">Uraikan kejadian, subjek, dan lokasi dengan jelas untuk hasil maksimal.</div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fs-4 fw-bold mb-2 text-dark">Gaya Penulisan</label>
                                    <div class="row g-2">
                                        @php
                                            $styles = [
                                                ['id' => 'Formal', 'label' => 'Formal & Kaku', 'icon' => 'building'],
                                                ['id' => 'Casual', 'label' => 'Santai & Populer', 'icon' => 'coffee'],
                                                ['id' => 'Investigative', 'label' => 'Investigatif', 'icon' => 'search'],
                                                ['id' => 'Viral', 'label' => 'Clickbait / Viral', 'icon' => 'flame'],
                                            ];
                                        @endphp
                                        @foreach($styles as $style)
                                            <div class="col-6 col-md-3">
                                                <input type="radio" class="btn-check" name="style" id="style_{{ $style['id'] }}" value="{{ $style['id'] }}" {{ old('style') == $style['id'] ? 'checked' : ($loop->first ? 'checked' : '') }}>
                                                <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2" for="style_{{ $style['id'] }}" style="border-radius: 15px; border-width: 2px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-{{ $style['icon'] }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        @if($style['icon'] == 'building')<path d="M3 21l18 0"></path><path d="M9 8l1 0"></path><path d="M9 12l1 0"></path><path d="M9 16l1 0"></path><path d="M14 8l1 0"></path><path d="M14 12l1 0"></path><path d="M14 16l1 0"></path><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>@endif
                                                        @if($style['icon'] == 'coffee')<path d="M3 14c.83 .642 2.077 1.017 3.5 1c1.423 .017 2.67 -.358 3.5 -1c.83 -.642 2.077 -1.017 3.5 -1c1.423 -.017 2.67 .358 3.5 1"></path><path d="M8 3v3h2v-3h-2z"></path><path d="M12 3v3h2v-3h-2z"></path><path d="M3 10h14v8a3 3 0 0 1-3 3h-8a3 3 0 0 1-3-3v-8z"></path><path d="M17 11h1a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2h-1"></path>@endif
                                                        @if($style['icon'] == 'search')<path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path>@endif
                                                        @if($style['icon'] == 'flame')<path d="M12 12c2 -2.96 0 -7 -1 -8c0 3.038 -1.773 4.741 -3 6c-1.226 1.26 -2 3.24 -2 5a6 6 0 1 0 12 0c0 -4.273 -2.574 -7.152 -5 -9c0 2.983 -1.5 4.547 -1 6z"></path>@endif
                                                    </svg>
                                                    <span class="small fw-bold">{{ $style['label'] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow" style="border-radius: 12px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sparkles me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6z"></path>
                                        </svg>
                                        Mulai Menulis Berita
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="mt-4 row g-3 text-center">
                    <div class="col-md-4">
                        <div class="p-3">
                            <h4 class="fw-bold mb-1">Cepat</h4>
                            <p class="text-muted small">Draf selesai dalam hitungan detik.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border-start border-end">
                            <h4 class="fw-bold mb-1">Berbobot</h4>
                            <p class="text-muted small">Analisis data 5W+1H yang tajam.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <h4 class="fw-bold mb-1">Kreatif</h4>
                            <p class="text-muted small">Headline yang menggugah & viral.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
