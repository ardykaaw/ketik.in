<x-dashboard-layout>
    <div class="container-xl py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <!-- Header Section -->
                <div class="mb-5 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center p-3 mb-4 bg-primary-lt rounded-pill shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-microphone text-primary" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 2m0 3a3 3 0 0 1 3 -3h0a3 3 0 0 1 3 3v5a3 3 0 0 1 -3 3h0a3 3 0 0 1 -3 -3z"></path>
                            <path d="M5 10a7 7 0 0 0 14 0"></path>
                            <path d="M8 21l8 0"></path>
                            <path d="M12 17l0 4"></path>
                        </svg>
                    </div>
                    <h1 class="display-5 fw-bold mb-2">Kata Sambutan</h1>
                    <p class="text-secondary fs-3 mx-auto" style="max-width: 600px;">
                        Tinggalkan kesan mendalam di setiap acara. AI kami menyusun teks sambutan yang berwibawa, menyentuh, dan berkelas.
                    </p>
                </div>

                <!-- Main Card -->
                <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 24px;">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('feature.speech.generate') }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fs-4 fw-bold mb-2 text-dark">Nama Acara / Kegiatan</label>
                                    <input type="text" name="event" class="form-control form-control-lg border-2" 
                                        placeholder="Contoh: Peresmian Kantor Baru atau Pernikahan..." maxlength="5000" 
                                        style="border-radius: 12px;" value="{{ old('event') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fs-4 fw-bold mb-2 text-dark">Posisi Pembicara</label>
                                    <input type="text" name="position" class="form-control form-control-lg border-2" 
                                        placeholder="Contoh: Bupati, Ketua Panitia, Kepala Desa..." maxlength="255" 
                                        style="border-radius: 12px;" value="{{ old('position') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fs-4 fw-bold mb-2 text-dark">Target Audiens</label>
                                    <input type="text" name="audience" class="form-control form-control-lg border-2" 
                                        placeholder="Contool: Karyawan Perusahaan, Warga Desa, atau Tamu Undangan..." 
                                        style="border-radius: 12px;" value="{{ old('audience') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fs-4 fw-bold mb-2 text-dark">Suasana / Nada Sambutan</label>
                                    <div class="row g-2">
                                        @php
                                            $tones = [
                                                ['id' => 'Formal', 'label' => 'Resmi / Formal', 'icon' => 'certificate'],
                                                ['id' => 'Warm', 'label' => 'Hangat / Akrab', 'icon' => 'sun'],
                                                ['id' => 'Inspiring', 'label' => 'Inspirational', 'icon' => 'bulb'],
                                                ['id' => 'Religious', 'label' => 'Religius', 'icon' => 'building-church'],
                                            ];
                                        @endphp
                                        @foreach($tones as $tone)
                                            <div class="col-6 col-md-3">
                                                <input type="radio" class="btn-check" name="tone" id="tone_{{ $tone['id'] }}" value="{{ $tone['id'] }}" {{ old('tone') == $tone['id'] ? 'checked' : ($loop->first ? 'checked' : '') }}>
                                                <label class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center gap-2" for="tone_{{ $tone['id'] }}" style="border-radius: 15px; border-width: 2px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-{{ $tone['icon'] }}" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        @if($tone['icon'] == 'certificate')<path d="M14 6l7 7l-4 4l-7 -7"></path><path d="M5.828 18.172a4 4 0 1 1 5.656 -5.656a4 4 0 0 1 -5.656 5.656z"></path><path d="M10.5 13.5l-2.5 2.5"></path><path d="M13.5 10.5l2.5 -2.5"></path>@endif
                                                        @if($tone['icon'] == 'sun')<path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path>@endif
                                                        @if($tone['icon'] == 'bulb')<path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"></path><path d="M9 16a5 5 0 1 1 6 0a3.5 3.5 0 0 0 -1 3a2 2 0 0 1 -4 0a3.5 3.5 0 0 0 -1 -3"></path><path d="M9.7 17l4.6 0"></path>@endif
                                                        @if($tone['icon'] == 'building-church')<path d="M3 21l18 0"></path><path d="M10 21v-4a2 2 0 0 1 4 0v4"></path><path d="M10 5l4 0"></path><path d="M12 3l0 5"></path><path d="M6 21v-7m-2 2l8 -8l8 8m-2 -2v7"></path>@endif
                                                    </svg>
                                                    <span class="small fw-bold">{{ $tone['label'] }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow" style="border-radius: 12px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil-share me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                            <path d="M13.5 6.5l4 4"></path>
                                            <path d="M16 22l5 -5"></path>
                                            <path d="M21 21.5v-4.5h-4.5"></path>
                                        </svg>
                                        Buat Teks Sambutan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Guidance Section -->
                <div class="mt-4 card border-0 bg-primary-lt" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-square-rounded text-primary" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 9h.01"></path>
                                <path d="M11 12h1v4h1"></path>
                                <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                            </svg>
                            <div>
                                <h4 class="fw-bold mb-1">Tips Sambutan Berkelas</h4>
                                <p class="text-secondary small mb-0">Pastikan menyebutkan nama pejabat atau tokoh penting di kolom 'Target Audiens' agar AI bisa merangkai sapaan hormat yang tepat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
