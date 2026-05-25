<x-guru-layout>

@php
    $totalDocs = array_sum($stats);
    $typeLabels = [
        'guru-soal'  => ['label' => 'Buat Soal',   'color' => '#f59e0b'],
        'guru-modul' => ['label' => 'Modul Ajar',  'color' => '#34d399'],
        'guru-rpp'   => ['label' => 'Modul Ajar',  'color' => '#059669'],
        'guru-rekap' => ['label' => 'Rekap Nilai', 'color' => '#10b981'],
    ];
@endphp

<style>
.guru-hero {
    background: linear-gradient(135deg, #022c22 0%, #065f46 60%, #047857 100%);
    border-radius: 24px;
    padding: 2.5rem 2rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.75rem;
}
.guru-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 260px; height: 260px;
    background: radial-gradient(circle, rgba(16,185,129,0.18) 0%, transparent 70%);
    border-radius: 50%;
}
.guru-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: 30%;
    width: 320px; height: 200px;
    background: radial-gradient(circle, rgba(16,185,129,0.10) 0%, transparent 70%);
    border-radius: 50%;
}
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .16s, box-shadow .16s;
    border-left: 4px solid transparent;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(0,0,0,.09); }
.feature-action-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    transition: transform .18s, box-shadow .18s;
    text-decoration: none !important;
    display: block;
    height: 100%;
}
.feature-action-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,.10); }
.feature-action-card .card-top {
    padding: 1.75rem 1.75rem 1.25rem;
}
.feature-action-card .card-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 1.75rem;
    border-top: 1px solid #f3f4f6;
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}
.recent-row {
    display: flex;
    align-items: center;
    padding: 0.85rem 1.25rem;
    border-radius: 12px;
    transition: background .15s;
    text-decoration: none;
    color: inherit;
}
.recent-row:hover { background: #f0fdf4; }
</style>

<div class="container-xl" style="padding: 1.5rem 1.5rem 2.5rem;">

    {{-- ===== HERO ===== --}}
    <div class="guru-hero">
        <div class="row align-items-center position-relative" style="z-index:1;">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span style="background:rgba(16,185,129,0.2);color:#6ee7b7;border:1px solid rgba(16,185,129,0.3);border-radius:99px;font-size:0.72rem;font-weight:700;letter-spacing:0.08em;padding:4px 12px;">🎓 MODE GURU</span>
                </div>
                <h1 class="fw-bold mb-2" style="color:white;font-size:2rem;line-height:1.2;">Selamat datang,<br>{{ Auth::user()->name }}!</h1>
                <p style="color:rgba(167,243,208,0.8);font-size:0.95rem;margin-bottom:1.5rem;max-width:480px;">
                    Asisten mengajar AI yang membantu Anda menyusun perangkat pembelajaran profesional dalam hitungan detik.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('guru.soal') }}" class="btn fw-semibold px-4" style="background:#10b981;color:white;border-radius:10px;border:none;box-shadow:0 4px 14px rgba(16,185,129,0.35);">
                        Mulai Generate
                    </a>
                    <a href="{{ route('guru.pustaka') }}" class="btn fw-semibold px-4" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);border-radius:10px;backdrop-filter:blur(4px);">
                        Pustaka Saya
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                <div class="d-flex gap-3">
                    @php
                        $heroStats = [
                            ['val' => $stats['soal'],  'label' => 'Soal Dibuat'],
                            ['val' => $stats['rpp'],   'label' => 'RPP (Lama)'],
                            ['val' => $stats['modul'], 'label' => 'Modul Ajar'],
                        ];
                    @endphp
                    @foreach($heroStats as $hs)
                    <div style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:16px;padding:1.25rem 1rem;text-align:center;min-width:90px;backdrop-filter:blur(8px);">
                        <div style="font-size:1.75rem;font-weight:800;color:white;line-height:1;">{{ $hs['val'] }}</div>
                        <div style="font-size:0.72rem;color:rgba(167,243,208,0.7);margin-top:4px;font-weight:500;">{{ $hs['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STAT STRIP ===== --}}
    <div class="row g-3 mb-4">
        @php
            $statItems = [
                ['key'=>'soal',  'label'=>'Total Soal',       'icon'=>'M9 11l3 3L22 4 M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11', 'color'=>'#f59e0b', 'bg'=>'#fef3c7'],
                ['key'=>'modul', 'label'=>'Modul Ajar',       'icon'=>'M4 19.5A2.5 2.5 0 0 1 6.5 17H20 M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z', 'color'=>'#059669', 'bg'=>'#d1fae5'],
                ['key'=>'rpp',   'label'=>'RPP (Lama)',       'icon'=>'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z M14 2l0 6 6 0 M16 13H8 M16 17H8', 'color'=>'#6b7280', 'bg'=>'#f3f4f6'],
                ['key'=>'rekap', 'label'=>'Rekap Nilai',      'icon'=>'M3 3h18v18H3z M3 9h18 M3 15h18 M9 3v18', 'color'=>'#10b981', 'bg'=>'#d1fae5'],
            ];
        @endphp
        @foreach($statItems as $s)
        <div class="col-6 col-lg-3">
            <div class="stat-card" style="border-left-color:{{ $s['color'] }};">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div style="font-size:1.65rem;font-weight:800;color:#111827;line-height:1;">{{ $stats[$s['key']] }}</div>
                        <div class="text-secondary mt-1" style="font-size:0.8rem;font-weight:500;">{{ $s['label'] }}</div>
                    </div>
                    <div style="width:40px;height:40px;border-radius:10px;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="{{ $s['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            @foreach(explode(' M', $s['icon']) as $i => $path)
                                <path d="{{ ($i === 0 ? '' : 'M') . $path }}"/>
                            @endforeach
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ===== FITUR + RECENT ===== --}}
    <div class="row g-4">

        {{-- Fitur AI (kiri) --}}
        <div class="col-lg-7">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">Fitur AI</h5>
                <span class="text-secondary small">Pilih fitur untuk mulai generate</span>
            </div>
            <div class="row g-3">

                {{-- Buat Soal --}}
                <div class="col-sm-6">
                    <a href="{{ route('guru.soal') }}" class="feature-action-card">
                        <div class="card-top">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:0.98rem;">Buat Soal</div>
                                    <div class="text-secondary" style="font-size:0.78rem;">{{ $stats['soal'] }} dokumen dibuat</div>
                                </div>
                            </div>
                            <p class="text-secondary mb-0" style="font-size:0.83rem;line-height:1.5;">Generate soal PG, Essay, atau campuran lengkap dengan kunci jawaban.</p>
                        </div>
                        <div class="card-cta" style="color:#d97706;">
                            <span>Generate Soal</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                </div>

                {{-- Modul Ajar --}}
                <div class="col-sm-6">
                    <a href="{{ route('guru.modul') }}" class="feature-action-card">
                        <div class="card-top">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#059669,#047857);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:0.98rem;">Modul Ajar</div>
                                    <div class="text-secondary" style="font-size:0.78rem;">{{ $stats['modul'] }} dokumen dibuat</div>
                                </div>
                            </div>
                            <p class="text-secondary mb-0" style="font-size:0.83rem;line-height:1.5;">Format Deep Learning lengkap: Identitas, CP, Lintas Disiplin, Tujuan, Kegiatan, Asesmen & LKPD.</p>
                        </div>
                        <div class="card-cta" style="color:#059669;">
                            <span>Buat Modul</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                </div>

                {{-- Modul Ajar Deep Learning Info --}}
                <div class="col-sm-6">
                    <a href="{{ route('guru.modul') }}" class="feature-action-card" style="border:1.5px solid #a7f3d0;">
                        <div class="card-top">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#059669,#047857);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:0.98rem;">Modul Ajar Deep Learning</div>
                                    <div style="font-size:0.72rem;color:#059669;font-weight:600;">✨ Format Terbaru Kurikulum Merdeka</div>
                                </div>
                            </div>
                            <p class="text-secondary mb-0" style="font-size:0.83rem;line-height:1.5;">Dengan LKPD terintegrasi, asesmen 3 tahap, diferensiasi produk, dan kegiatan Meaningful · Joyful · Mindful Learning.</p>
                        </div>
                        <div class="card-cta" style="color:#059669;">
                            <span>Buat Modul Ajar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                </div>

                {{-- Rekap Nilai --}}
                <div class="col-sm-6">
                    <a href="{{ route('guru.rekap') }}" class="feature-action-card">
                        <div class="card-top">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:46px;height:46px;border-radius:13px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size:0.98rem;">Rekap Nilai</div>
                                    <div class="text-secondary" style="font-size:0.78rem;">{{ $stats['rekap'] }} dokumen dibuat</div>
                                </div>
                            </div>
                            <p class="text-secondary mb-0" style="font-size:0.83rem;line-height:1.5;">Input nilai siswa, AI buat rekap + analisis statistik + rekomendasi tindak lanjut.</p>
                        </div>
                        <div class="card-cta" style="color:#059669;">
                            <span>Buat Rekap</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </a>
                </div>

            </div>
        </div>

        {{-- Dokumen Terbaru (kanan) --}}
        <div class="col-lg-5">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">Dokumen Terbaru</h5>
                <a href="{{ route('guru.pustaka') }}" class="text-success small fw-semibold text-decoration-none">Lihat semua →</a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:18px;">
                <div class="card-body p-2">
                    @if($recents->isEmpty())
                        <div class="text-center py-5 text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#d1fae5" stroke-width="1.5" viewBox="0 0 24 24" class="mb-3"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                            <div class="fw-semibold" style="font-size:0.88rem;">Belum ada dokumen</div>
                            <div style="font-size:0.8rem;">Mulai generate untuk mengisi pustaka</div>
                        </div>
                    @else
                        @foreach($recents as $doc)
                        @php
                            $typeColor = [
                                'guru-soal'  => '#f59e0b',
                                'guru-modul' => '#059669',
                                'guru-rpp'   => '#8b5cf6',
                                'guru-rekap' => '#10b981',
                            ][$doc->type] ?? '#6b7280';
                            $typeIcon = [
                                'guru-soal'  => 'M9 11l3 3L22 4 M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11',
                                'guru-modul' => 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20 M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z',
                                'guru-rpp'   => 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z M14 2l6 6 M16 13H8 M16 17H8',
                                'guru-rekap' => 'M3 3h18v18H3z M3 9h18 M3 15h18 M9 3v18',
                            ][$doc->type] ?? '';
                        @endphp
                        <a href="{{ route('guru.pustaka.show', $doc->id) }}" class="recent-row">
                            <div style="width:36px;height:36px;border-radius:9px;background:{{ $typeColor }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="{{ $typeColor }}" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                                    @foreach(explode(' M', $typeIcon) as $i => $path)
                                        <path d="{{ ($i === 0 ? '' : 'M') . $path }}"/>
                                    @endforeach
                                </svg>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="fw-semibold text-truncate" style="font-size:0.88rem;">{{ Str::limit($doc->title, 52) }}</div>
                                <div class="text-secondary" style="font-size:0.75rem;">{{ $doc->created_at->diffForHumans() }}</div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#9ca3af" stroke-width="2" viewBox="0 0 24 24" class="flex-shrink-0 ms-2"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                        @if(!$loop->last)<div style="height:1px;background:#f3f4f6;margin:0 1.25rem;"></div>@endif
                        @endforeach
                    @endif
                </div>
                @if($recents->isNotEmpty())
                <div class="card-footer bg-transparent border-0 px-3 pb-3 pt-1">
                    <a href="{{ route('guru.pustaka') }}" class="btn btn-sm w-100 fw-semibold" style="border-radius:10px;background:#f0fdf4;color:#059669;border:1px solid #d1fae5;">
                        Lihat Semua Dokumen
                    </a>
                </div>
                @endif
            </div>

            {{-- Tips Card --}}
            <div class="card border-0 mt-3" style="border-radius:16px;background:linear-gradient(135deg,#022c22,#065f46);">
                <div class="card-body p-3 d-flex gap-3 align-items-start">
                    <div style="font-size:1.4rem;line-height:1;">💡</div>
                    <div>
                        <div class="fw-semibold mb-1" style="color:#a7f3d0;font-size:0.85rem;">Tips Hasil Akurat</div>
                        <p class="mb-0" style="color:rgba(167,243,208,0.65);font-size:0.78rem;line-height:1.5;">Semakin spesifik Kompetensi Dasar dan topik yang diisi, semakin relevan hasil generate AI.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</x-guru-layout>
