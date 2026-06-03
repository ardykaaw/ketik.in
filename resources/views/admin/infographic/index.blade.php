<x-admin-layout>
    {{-- Google Font for Infographic --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <div class="container-xl py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">🎨 Generator Infografis AI</h1>
                <p class="text-muted mb-0">Buat infografis profesional dengan AI Gemini — 4 layout dinamis berkualitas tinggi</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 14px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row g-4">
            {{-- Form --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius: 20px; position: sticky; top: 20px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Buat Infografis Baru</h3>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Topik Infografis <span class="text-danger">*</span></label>
                            <input type="text" id="inp-topik" class="form-control border-2" placeholder="Contoh: Pentingnya Literasi Anak" style="border-radius: 12px;" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Jenis Infografis</label>
                            <select id="inp-jenis" class="form-select border-2" style="border-radius: 12px;">
                                <option value="tips">Tips & Trik</option>
                                <option value="statistik">Statistik & Data</option>
                                <option value="proses">Langkah/Proses</option>
                                <option value="perbandingan">Perbandingan</option>
                                <option value="timeline">Timeline</option>
                                <option value="fakta">Fakta Menarik</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Poin-poin (opsional, satu per baris)</label>
                            <textarea id="inp-poin" class="form-control border-2" rows="3" placeholder="Kosongkan agar AI yang membuatkan..." style="border-radius: 12px;"></textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small">Warna</label>
                                <select id="inp-warna" class="form-select border-2" style="border-radius: 12px;">
                                    <option value="orange">🟠 Oranye</option>
                                    <option value="blue">🔵 Biru</option>
                                    <option value="purple">🟣 Ungu</option>
                                    <option value="green">🟢 Hijau</option>
                                    <option value="red">🔴 Merah</option>
                                    <option value="dark">⚫ Gelap</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">Gaya Desain</label>
                                <select id="inp-gaya" class="form-select border-2" style="border-radius: 12px;">
                                    <option value="modern">Modern</option>
                                    <option value="bold">Bold / Tebal</option>
                                    <option value="minimal">Minimalis</option>
                                    <option value="corporate">Korporat</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Layout (Orientasi)</label>
                            <select id="inp-layout" class="form-select border-2" style="border-radius: 12px;">
                                <option value="auto">✨ Auto (Biarkan AI yang memilih)</option>
                                <option value="portrait_classic">📐 Portrait Classic (Vertikal Standar)</option>
                                <option value="portrait_timeline">📊 Portrait Timeline (Vertikal Alur)</option>
                                <option value="landscape_grid">🖼️ Landscape Grid (Mendatar Lebar)</option>
                                <option value="landscape_split">🎯 Landscape Split (Mendatar Terbelah)</option>
                                <option value="landscape_chart">📈 Landscape Chart (Katadata Style)</option>
                            </select>
                        </div>

                        <button type="button" id="btn-generate" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 12px;" onclick="generateInfographic()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.347a3.75 3.75 0 0 1-5.303 0l-.347-.347z"/></svg>
                            Generate Infografis
                        </button>

                        {{-- Loading --}}
                        <div id="loading-state" class="text-center py-4 d-none">
                            <div class="spinner-border text-primary mb-2" role="status"></div>
                            <p class="text-muted fw-semibold mb-0">AI sedang menyusun konten...</p>
                            <p class="text-muted small" id="loading-timer">Estimasi 10–30 detik</p>
                        </div>

                        {{-- Error --}}
                        <div id="error-state" class="alert alert-danger mt-3 d-none" style="border-radius: 14px;">
                            <strong>Gagal Generate</strong>
                            <p class="mb-0 small" id="error-msg"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Result + Gallery --}}
            <div class="col-lg-8">
                {{-- Latest Result --}}
                <div id="result-card" class="card shadow-sm border-0 mb-4 d-none" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-0">
                        <div>
                            <h3 class="fw-bold mb-0">✨ Hasil Infografis</h3>
                            <small class="text-muted" id="layout-badge"></small>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="generateInfographic()" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">🔄 Regenerate</button>
                            <button onclick="saveToGallery()" id="btn-save" class="btn btn-sm btn-success" style="border-radius: 8px;">
                                💾 Simpan ke Galeri
                            </button>
                            <button onclick="downloadInfographic()" class="btn btn-sm btn-primary" style="border-radius: 8px;">
                                ⬇️ Download PNG
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div id="result-preview" style="border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden;"></div>
                    </div>
                </div>

                {{-- Gallery --}}
                <h3 class="fw-bold mb-3">Galeri Infografis ({{ $infographics->count() }})</h3>
                @if($infographics->isEmpty())
                    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 text-muted" style="opacity: 0.3;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <h4 class="fw-bold text-muted">Belum ada infografis</h4>
                            <p class="text-muted small">Generate infografis pertama Anda menggunakan form di samping.</p>
                        </div>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($infographics as $img)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                                <a href="{{ $img['url'] }}" target="_blank">
                                    <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}" class="w-100" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold small text-truncate" style="max-width: 180px;">{{ $img['name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $img['size'] }} KB &middot; {{ $img['date'] }}</div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="{{ $img['url'] }}" download class="btn btn-sm btn-ghost-primary p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                            <form action="{{ route('admin.infographic.destroy') }}" method="POST" class="delete-form" data-name="{{ $img['name'] }}">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="path" value="{{ $img['path'] }}">
                                                <button type="submit" class="btn btn-sm btn-ghost-danger p-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- HIDDEN INFOGRAPHIC RENDER AREA             --}}
    {{-- ========================================== --}}
    <div id="ig-render-area" style="position:fixed; left:-9999px; top:0; z-index:-1;">
        <div id="ig-canvas"></div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- ========================================== --}}
    {{-- INFOGRAPHIC TEMPLATE CSS (ALL LAYOUTS)     --}}
    {{-- ========================================== --}}
    <style>
        /* ===== BASE CANVAS ===== */
        .ig-canvas {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            overflow: hidden;
            position: relative;
        }
        .ig-canvas.layout-portrait { width: 800px; }
        .ig-canvas.layout-landscape { width: 1200px; }

        /* ===== BACKGROUND MESH ===== */
        .ig-canvas::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(var(--ig-lighter) 2px, transparent 2px);
            background-size: 30px 30px;
            opacity: 0.6;
            z-index: 0;
        }

        /* ===== COLOR THEMES ===== */
        .ig-canvas.theme-orange {
            --ig-primary: #f97316; --ig-primary-dark: #c2410c; --ig-primary-darker: #7c2d12;
            --ig-accent: #fb923c; --ig-light: #fff7ed; --ig-lighter: #ffedd5;
            --ig-grad-start: #f97316; --ig-grad-end: #ea580c;
            --ig-header-bg: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #c2410c 100%);
            --ig-cta-bg: linear-gradient(135deg, #f97316 0%, #dc2626 100%);
            --ig-text-on-primary: #fff; --ig-bg-canvas: #fff7ed;
        }
        .ig-canvas.theme-blue {
            --ig-primary: #3b82f6; --ig-primary-dark: #1e40af; --ig-primary-darker: #1e3a5f;
            --ig-accent: #60a5fa; --ig-light: #eff6ff; --ig-lighter: #dbeafe;
            --ig-grad-start: #3b82f6; --ig-grad-end: #1d4ed8;
            --ig-header-bg: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            --ig-cta-bg: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            --ig-text-on-primary: #fff; --ig-bg-canvas: #eff6ff;
        }
        .ig-canvas.theme-green {
            --ig-primary: #22c55e; --ig-primary-dark: #15803d; --ig-primary-darker: #14532d;
            --ig-accent: #4ade80; --ig-light: #f0fdf4; --ig-lighter: #dcfce7;
            --ig-grad-start: #22c55e; --ig-grad-end: #16a34a;
            --ig-header-bg: linear-gradient(135deg, #22c55e 0%, #16a34a 50%, #15803d 100%);
            --ig-cta-bg: linear-gradient(135deg, #22c55e 0%, #0d9488 100%);
            --ig-text-on-primary: #fff; --ig-bg-canvas: #f0fdf4;
        }
        .ig-canvas.theme-purple {
            --ig-primary: #a855f7; --ig-primary-dark: #7c3aed; --ig-primary-darker: #4c1d95;
            --ig-accent: #c084fc; --ig-light: #faf5ff; --ig-lighter: #f3e8ff;
            --ig-grad-start: #a855f7; --ig-grad-end: #7c3aed;
            --ig-header-bg: linear-gradient(135deg, #a855f7 0%, #7c3aed 50%, #6d28d9 100%);
            --ig-cta-bg: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            --ig-text-on-primary: #fff; --ig-bg-canvas: #faf5ff;
        }
        .ig-canvas.theme-red {
            --ig-primary: #ef4444; --ig-primary-dark: #b91c1c; --ig-primary-darker: #7f1d1d;
            --ig-accent: #f87171; --ig-light: #fef2f2; --ig-lighter: #fee2e2;
            --ig-grad-start: #ef4444; --ig-grad-end: #dc2626;
            --ig-header-bg: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
            --ig-cta-bg: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            --ig-text-on-primary: #fff; --ig-bg-canvas: #fef2f2;
        }
        .ig-canvas.theme-dark {
            --ig-primary: #475569; --ig-primary-dark: #1e293b; --ig-primary-darker: #0f172a;
            --ig-accent: #64748b; --ig-light: #f8fafc; --ig-lighter: #f1f5f9;
            --ig-grad-start: #334155; --ig-grad-end: #1e293b;
            --ig-header-bg: linear-gradient(135deg, #334155 0%, #1e293b 50%, #0f172a 100%);
            --ig-cta-bg: linear-gradient(135deg, #475569 0%, #1e293b 100%);
            --ig-text-on-primary: #fff; --ig-bg-canvas: #f8fafc;
        }

        /* ===== SHARED COMPONENTS ===== */
        .ig-footer {
            background: var(--ig-primary-darker);
            padding: 16px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ig-footer-brand { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.7); }
        .ig-footer-logo { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: 0.5px; }

        /* ================================================================ */
        /* LAYOUT 1: PORTRAIT CLASSIC                                       */
        /* ================================================================ */
        .ig-pc-header {
            position: relative;
            background: var(--ig-header-bg);
            padding: 50px 50px 70px 50px;
            overflow: hidden;
            min-height: 260px;
        }
        .ig-pc-header-decor { position: absolute; border-radius: 50%; opacity: 0.12; background: #fff; }
        .ig-pc-header-decor-1 { width: 200px; height: 200px; top: -60px; right: -40px; }
        .ig-pc-header-decor-2 { width: 120px; height: 120px; top: 30px; right: 100px; opacity: 0.08; }
        .ig-pc-header-decor-3 { width: 80px; height: 80px; bottom: 30px; left: 40px; opacity: 0.1; }
        .ig-pc-header-content { position: relative; z-index: 2; max-width: 520px; }
        .ig-pc-title { font-size: 36px; font-weight: 900; color: #fff; line-height: 1.15; margin-bottom: 6px; text-transform: uppercase; letter-spacing: -0.5px; text-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .ig-pc-subtitle { font-size: 16px; font-weight: 600; color: rgba(255,255,255,0.92); line-height: 1.4; }
        .ig-pc-char { position: absolute; right: 30px; bottom: 15px; z-index: 3; width: 180px; height: 200px; }
        .ig-pc-intro { padding: 25px 50px 10px 50px; position: relative; z-index: 1; }
        .ig-pc-intro-box { background: rgba(255,255,255,0.85); border-radius: 16px; padding: 20px 24px; border-left: 6px solid var(--ig-primary); box-shadow: 0 10px 30px rgba(0,0,0,0.04); display: flex; align-items: center; gap: 20px; }
        .ig-pc-intro-title { font-size: 14px; font-weight: 800; color: var(--ig-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
        .ig-pc-intro-text { font-size: 14px; font-weight: 500; color: #334155; line-height: 1.6; margin: 0; }
        .ig-pc-stats { display: flex; justify-content: center; gap: 20px; padding: 30px 50px; flex-wrap: wrap; position: relative; z-index: 1; }
        .ig-pc-stat { text-align: center; background: rgba(255,255,255,0.9); border-radius: 20px; padding: 24px 16px; min-width: 140px; flex: 1; max-width: 200px; box-shadow: 0 12px 30px rgba(0,0,0,0.05); border-bottom: 4px solid var(--ig-primary); }
        .ig-pc-stat-val { font-size: 42px; font-weight: 900; color: var(--ig-primary-darker); line-height: 1; margin-bottom: 8px; }
        .ig-pc-stat-lbl { font-size: 12px; font-weight: 600; color: #6b7280; line-height: 1.3; }
        .ig-pc-banner { padding: 10px 50px 20px 50px; text-align: center; position: relative; z-index: 1; }
        .ig-pc-ribbon { display: inline-block; background: var(--ig-header-bg); color: #fff; font-size: 20px; font-weight: 800; padding: 14px 44px; text-transform: uppercase; letter-spacing: 1px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .ig-pc-points { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 10px 50px 40px 50px; position: relative; z-index: 1; }
        .ig-pc-point { background: rgba(255,255,255,0.85); border-radius: 20px; padding: 24px; display: flex; align-items: flex-start; gap: 18px; box-shadow: 0 8px 24px rgba(0,0,0,0.04); position: relative; overflow: hidden; }
        .ig-pc-point::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--ig-grad-start); }
        .ig-pc-icon-box { width: 64px; height: 64px; min-width: 64px; background: var(--ig-lighter); color: var(--ig-primary-dark); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .ig-pc-icon-box svg { width: 24px; height: 24px; stroke-width: 2.5; }
        .ig-pc-point-title { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 6px; }
        .ig-pc-point-desc { font-size: 13px; font-weight: 500; color: #64748b; line-height: 1.5; margin: 0; }
        .ig-pc-cta { background: var(--ig-cta-bg); padding: 35px 50px; text-align: center; position: relative; overflow: hidden; }
        .ig-pc-cta-decor { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.08); }
        .ig-pc-cta-decor-1 { width: 150px; height: 150px; top: -50px; left: -30px; }
        .ig-pc-cta-decor-2 { width: 100px; height: 100px; bottom: -30px; right: -20px; }
        .ig-pc-cta-text { font-size: 28px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 1px; text-shadow: 0 2px 8px rgba(0,0,0,0.15); position: relative; z-index: 2; margin-bottom: 20px; }
        .ig-pc-cta-items { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; position: relative; z-index: 2; }
        .ig-pc-cta-item { background: rgba(255,255,255,0.15); border-radius: 16px; padding: 16px; text-align: center; min-width: 140px; flex: 1; max-width: 170px; border: 1px solid rgba(255,255,255,0.3); }
        .ig-pc-cta-item-icon { display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 42px; background: rgba(255,255,255,0.2); border-radius: 50%; margin-bottom: 10px; color: #fff; }
        .ig-pc-cta-item-text { font-size: 13px; font-weight: 700; color: #fff; }

        /* ================================================================ */
        /* LAYOUT 2: LANDSCAPE GRID                                         */
        /* ================================================================ */
        .ig-lg-wrapper { display: grid; grid-template-columns: 380px 1fr; min-height: 600px; }
        .ig-lg-sidebar { background: var(--ig-header-bg); padding: 50px 40px; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; }
        .ig-lg-sidebar-decor { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.08); }
        .ig-lg-sidebar-decor-1 { width: 200px; height: 200px; bottom: -80px; right: -60px; }
        .ig-lg-sidebar-decor-2 { width: 100px; height: 100px; top: 20px; right: 20px; opacity: 0.1; }
        .ig-lg-title { font-size: 32px; font-weight: 900; color: #fff; line-height: 1.15; text-transform: uppercase; letter-spacing: -0.5px; text-shadow: 0 2px 8px rgba(0,0,0,0.15); margin-bottom: 10px; position: relative; z-index: 2; }
        .ig-lg-subtitle { font-size: 14px; font-weight: 600; color: rgba(255,255,255,0.88); line-height: 1.5; position: relative; z-index: 2; margin-bottom: 20px; }
        .ig-lg-char { width: 200px; height: 200px; position: relative; z-index: 2; margin: 0 auto; }
        .ig-lg-main { background: var(--ig-bg-canvas, #f8fafc); padding: 40px; display: flex; flex-direction: column; gap: 24px; }
        .ig-lg-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .ig-lg-stat { text-align: center; background: #fff; border-radius: 16px; padding: 20px 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.05); border-bottom: 3px solid var(--ig-primary); }
        .ig-lg-stat-val { font-size: 32px; font-weight: 900; color: var(--ig-primary-darker); line-height: 1; margin-bottom: 4px; }
        .ig-lg-stat-lbl { font-size: 11px; font-weight: 600; color: #6b7280; }
        .ig-lg-section-title { font-size: 18px; font-weight: 800; color: var(--ig-primary-darker); text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 8px; border-bottom: 3px solid var(--ig-primary); display: inline-block; }
        .ig-lg-points { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .ig-lg-point { background: #fff; border-radius: 16px; padding: 20px; display: flex; gap: 14px; align-items: flex-start; box-shadow: 0 4px 14px rgba(0,0,0,0.04); border-left: 4px solid var(--ig-primary); }
        .ig-lg-icon-box { width: 64px; height: 64px; min-width: 64px; background: var(--ig-lighter); color: var(--ig-primary-dark); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .ig-lg-icon-box svg { width: 24px; height: 24px; stroke-width: 2.5; }
        .ig-lg-point-title { font-size: 14px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
        .ig-lg-point-desc { font-size: 12px; font-weight: 500; color: #64748b; line-height: 1.5; margin: 0; }
        .ig-lg-cta { background: var(--ig-cta-bg); border-radius: 16px; padding: 24px 30px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .ig-lg-cta-text { font-size: 20px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; text-shadow: 0 2px 6px rgba(0,0,0,0.12); }
        .ig-lg-cta-items { display: flex; gap: 12px; }
        .ig-lg-cta-item { background: rgba(255,255,255,0.15); border-radius: 12px; padding: 10px 16px; text-align: center; border: 1px solid rgba(255,255,255,0.25); }
        .ig-lg-cta-item-icon { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 50%; margin-bottom: 6px; color: #fff; }
        .ig-lg-cta-item-text { font-size: 11px; font-weight: 700; color: #fff; }

        /* ================================================================ */
        /* LAYOUT 3: PORTRAIT TIMELINE                                      */
        /* ================================================================ */
        .ig-pt-header { position: relative; background: var(--ig-header-bg); padding: 50px 50px 50px 50px; overflow: hidden; text-align: center; }
        .ig-pt-header-decor { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.1); }
        .ig-pt-header-decor-1 { width: 160px; height: 160px; top: -40px; left: -40px; }
        .ig-pt-header-decor-2 { width: 100px; height: 100px; bottom: -20px; right: 30px; opacity: 0.08; }
        .ig-pt-title { font-size: 34px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: -0.5px; text-shadow: 0 2px 8px rgba(0,0,0,0.15); position: relative; z-index: 2; margin-bottom: 8px; }
        .ig-pt-subtitle { font-size: 15px; font-weight: 600; color: rgba(255,255,255,0.9); position: relative; z-index: 2; }
        .ig-pt-intro { padding: 30px 50px 10px 50px; position: relative; z-index: 1; }
        .ig-pt-intro-box { background: rgba(255,255,255,0.9); border-radius: 16px; padding: 20px 24px; border-left: 6px solid var(--ig-primary); box-shadow: 0 8px 24px rgba(0,0,0,0.04); }
        .ig-pt-intro-text { font-size: 14px; font-weight: 500; color: #334155; line-height: 1.6; margin: 0; }
        .ig-pt-stats { display: flex; justify-content: center; gap: 20px; padding: 25px 50px; position: relative; z-index: 1; }
        .ig-pt-stat { text-align: center; background: #fff; border-radius: 16px; padding: 20px 14px; min-width: 120px; flex: 1; max-width: 180px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); border-bottom: 3px solid var(--ig-primary); }
        .ig-pt-stat-val { font-size: 36px; font-weight: 900; color: var(--ig-primary-darker); line-height: 1; margin-bottom: 6px; }
        .ig-pt-stat-lbl { font-size: 11px; font-weight: 600; color: #6b7280; }
        .ig-pt-timeline { padding: 10px 50px 40px 50px; position: relative; z-index: 1; }
        .ig-pt-timeline-track { position: relative; padding-left: 40px; }
        .ig-pt-timeline-track::before { content: ''; position: absolute; left: 16px; top: 0; bottom: 0; width: 4px; background: linear-gradient(180deg, var(--ig-primary), var(--ig-accent)); border-radius: 4px; }
        .ig-pt-step { position: relative; margin-bottom: 28px; }
        .ig-pt-step:last-child { margin-bottom: 0; }
        .ig-pt-step-dot { position: absolute; left: -40px; top: 6px; width: 32px; height: 32px; background: var(--ig-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 900; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 2; border: 3px solid #fff; }
        .ig-pt-step-card { background: #fff; border-radius: 16px; padding: 22px; box-shadow: 0 6px 20px rgba(0,0,0,0.05); border-left: 4px solid var(--ig-primary); display: flex; align-items: flex-start; gap: 16px; }
        .ig-pt-step-icon { width: 48px; height: 48px; min-width: 48px; background: var(--ig-lighter); color: var(--ig-primary-dark); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .ig-pt-step-icon svg { width: 24px; height: 24px; stroke-width: 2.5; }
        .ig-pt-step-title { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
        .ig-pt-step-desc { font-size: 13px; font-weight: 500; color: #64748b; line-height: 1.5; margin: 0; }
        .ig-pt-cta { background: var(--ig-cta-bg); padding: 35px 50px; text-align: center; position: relative; overflow: hidden; }
        .ig-pt-cta-text { font-size: 26px; font-weight: 900; color: #fff; text-transform: uppercase; text-shadow: 0 2px 6px rgba(0,0,0,0.12); position: relative; z-index: 2; margin-bottom: 16px; }
        .ig-pt-cta-items { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; position: relative; z-index: 2; }
        .ig-pt-cta-item { background: rgba(255,255,255,0.15); border-radius: 14px; padding: 14px; text-align: center; min-width: 120px; flex: 1; max-width: 160px; border: 1px solid rgba(255,255,255,0.25); }
        .ig-pt-cta-item-icon { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 50%; margin-bottom: 8px; color: #fff; }
        .ig-pt-cta-item-text { font-size: 12px; font-weight: 700; color: #fff; }

        /* ================================================================ */
        .ig-ls-hero-decor-2 { width: 150px; height: 150px; bottom: -50px; left: -40px; }
        .ig-ls-hero-decor-3 { width: 80px; height: 80px; top: 50%; left: 10%; opacity: 0.1; }
        .ig-ls-title { font-size: 36px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: -0.5px; text-shadow: 0 2px 10px rgba(0,0,0,0.2); position: relative; z-index: 2; margin-bottom: 12px; line-height: 1.15; }
        .ig-ls-subtitle { font-size: 15px; font-weight: 600; color: rgba(255,255,255,0.88); position: relative; z-index: 2; line-height: 1.5; margin-bottom: 30px; max-width: 340px; }
        .ig-ls-char { width: 220px; height: 240px; position: relative; z-index: 2; }
        .ig-ls-main { background: var(--ig-bg-canvas, #f8fafc); padding: 40px 40px; display: flex; flex-direction: column; gap: 20px; overflow: hidden; }
        .ig-ls-intro { background: #fff; border-radius: 16px; padding: 18px 22px; border-left: 5px solid var(--ig-primary); box-shadow: 0 4px 14px rgba(0,0,0,0.04); }
        .ig-ls-intro-label { font-size: 11px; font-weight: 800; color: var(--ig-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .ig-ls-intro-text { font-size: 13px; font-weight: 500; color: #334155; line-height: 1.6; margin: 0; }
        .ig-ls-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .ig-ls-stat { text-align: center; background: #fff; border-radius: 14px; padding: 16px 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.04); border-bottom: 3px solid var(--ig-primary); }
        .ig-ls-stat-val { font-size: 28px; font-weight: 900; color: var(--ig-primary-darker); line-height: 1; margin-bottom: 4px; }
        .ig-ls-stat-lbl { font-size: 10px; font-weight: 600; color: #6b7280; }
        .ig-ls-section-title { font-size: 16px; font-weight: 800; color: var(--ig-primary-darker); text-transform: uppercase; letter-spacing: 0.5px; margin: 0; }
        .ig-ls-points { display: flex; flex-direction: column; gap: 12px; }
        .ig-ls-point { background: #fff; border-radius: 14px; padding: 18px; display: flex; gap: 14px; align-items: flex-start; box-shadow: 0 3px 12px rgba(0,0,0,0.04); border-left: 4px solid var(--ig-primary); }
        .ig-ls-icon-box { width: 64px; height: 64px; min-width: 64px; background: var(--ig-lighter); color: var(--ig-primary-dark); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .ig-ls-icon-box svg { width: 24px; height: 24px; stroke-width: 2.5; }
        .ig-ls-point-title { font-size: 14px; font-weight: 800; color: #1e293b; margin-bottom: 3px; }
        .ig-ls-point-desc { font-size: 12px; font-weight: 500; color: #64748b; line-height: 1.4; margin: 0; }
        .ig-ls-cta { background: var(--ig-cta-bg); border-radius: 14px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; }
        .ig-ls-cta-text { font-size: 18px; font-weight: 900; color: #fff; text-transform: uppercase; flex: 1; text-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .ig-ls-cta-items { display: flex; gap: 10px; }
        .ig-ls-cta-item { background: rgba(255,255,255,0.15); border-radius: 10px; padding: 8px 14px; text-align: center; border: 1px solid rgba(255,255,255,0.2); }
        .ig-ls-cta-item-icon { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; background: rgba(255,255,255,0.2); border-radius: 50%; margin-bottom: 4px; color: #fff; }
        .ig-ls-cta-item-text { font-size: 10px; font-weight: 700; color: #fff; }
        .ig-lc-icon-box { width: 64px; height: 64px; min-width: 64px; background: #fff; color: var(--ig-primary-dark); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .ig-lc-icon-box svg { width: 24px; height: 24px; stroke-width: 2.5; }

        /* ===== RESPONSIVE PREVIEW ===== */
        #result-preview .ig-canvas { transform-origin: top left; }
    </style>

    {{-- ========================================== --}}
    {{-- JAVASCRIPT                                 --}}
    {{-- ========================================== --}}
    <script>
        let timerInterval = null;
        let seconds = 0;
        let lastGeneratedData = null;
        let currentCanvasWidth = 800;

        // ===== COLOR PALETTE MAP =====
        const colorMap = {
            orange: { primary: '#f97316', gradStart: '#f97316', gradEnd: '#ea580c' },
            blue:   { primary: '#3b82f6', gradStart: '#3b82f6', gradEnd: '#1d4ed8' },
            green:  { primary: '#22c55e', gradStart: '#22c55e', gradEnd: '#16a34a' },
            purple: { primary: '#a855f7', gradStart: '#a855f7', gradEnd: '#7c3aed' },
            red:    { primary: '#ef4444', gradStart: '#ef4444', gradEnd: '#dc2626' },
            dark:   { primary: '#475569', gradStart: '#334155', gradEnd: '#1e293b' },
        };

        // Layout name map for badge display
        const layoutNames = {
            portrait_classic: '📐 Portrait Classic',
            landscape_grid: '🖼️ Landscape Grid',
            portrait_timeline: '📊 Portrait Timeline',
            landscape_split: '🎯 Landscape Split',
        };

        // ===== SVG CHARACTER FETCHER =====
        const charNames = [
            'Alex', 'Ava', 'Eli', 'Emma', 'Finn', 'Jude', 'Leo', 'Lily', 'Maya', 'Mia', 'Noah', 'Nora', 'Ruby', 'Sam', 'Zoe',
            'emoji_Buddy', 'emoji_Charlie', 'emoji_Max', 'emoji_Rocky',
            'robot_Alpha', 'robot_Beta', 'robot_Delta', 'robot_Gamma',
        ];

        const shapeNames = ['shape_One', 'shape_Two', 'shape_Three', 'shape_Four'];

        async function fetchRandomCharacter() {
            const randomName = charNames[Math.floor(Math.random() * charNames.length)];
            try {
                const response = await fetch(`/assets/infographic/chars/${randomName}.svg`);
                let svgText = await response.text();
                svgText = svgText.replace(/<\x3Fxml.*?\x3F>/gi, '');
                return `<div style="width:100%; height:100%; display:flex; align-items:flex-end; justify-content:center; filter: drop-shadow(0 15px 15px rgba(0,0,0,0.15));">${svgText}</div>`;
            } catch (e) {
                return '';
            }
        }

        async function fetchRandomShape() {
            try {
                const res = await fetch('/assets/infographic/shapes/shape-' + (Math.floor(Math.random() * 5) + 1) + '.svg');
                const svgText = await res.text();
                return svgText.replace(/<\?xml.*?\?>/gi, '');
            } catch (e) {
                return '';
            }
        }

        async function getDynamicCharacterImage(d, cssClass = '') {
            if (d.image_prompt) {
                const cleanPrompt = d.image_prompt.replace(/isolated on pure white background/ig, '');
                const finalPrompt = cleanPrompt + ", highly detailed realistic 2D digital illustration, flat even lighting, clean edges, professional infographic style";
                const encodedPrompt = encodeURIComponent(finalPrompt);
                const imgUrl = `https://image.pollinations.ai/prompt/${encodedPrompt}?width=600&height=800&nologo=true&enhance=false`;
                
                if (cssClass === 'ig-lc-hero-img') {
                    // For landscape chart, use a large rounded card style
                    return `<div class="${cssClass}" style="width:100%; height:100%; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); border: 4px solid rgba(255,255,255,0.5);">
                                <img src="${imgUrl}" crossorigin="anonymous" alt="Illustration" style="width:100%; height:100%; object-fit:cover; object-position:center;">
                            </div>`;
                } else if (cssClass) {
                    return `<img src="${imgUrl}" class="${cssClass}" crossorigin="anonymous" alt="Character">`;
                }
                
                // For default portrait layouts, use a circular/rounded avatar style
                return `<div style="width:100%; height:100%; border-radius: 50%; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); border: 4px solid #fff; background: #fff; display: flex; align-items: center; justify-content: center;">
                            <img src="${imgUrl}" crossorigin="anonymous" alt="Illustration" style="width:100%; height:100%; object-fit:cover; object-position:center;">
                        </div>`;
            }
            return await fetchRandomCharacter();
        }

        function escHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        // ===================================================================
        // LAYOUT BUILDER ROUTER
        // ===================================================================
        async function buildInfographicHTML(data, warna, layout) {
            const validLayouts = ['portrait_classic', 'landscape_grid', 'portrait_timeline', 'landscape_split', 'landscape_chart'];
            if (!validLayouts.includes(layout)) layout = 'portrait_classic';

            switch (layout) {
                case 'landscape_grid':    return await buildLandscapeGrid(data, warna);
                case 'portrait_timeline': return await buildPortraitTimeline(data, warna);
                case 'landscape_split':   return await buildLandscapeSplit(data, warna);
                case 'landscape_chart':   return await buildLandscapeChart(data, warna);
                default:                  return await buildPortraitClassic(data, warna);
            }
        }

        // ===================================================================
        // LAYOUT 1: PORTRAIT CLASSIC
        // ===================================================================
        async function buildPortraitClassic(d, warna) {
            currentCanvasWidth = 800;
            const theme = `theme-${warna}`;

            const [charHeader, charIntro, shape1, shape2] = await Promise.all([
                getDynamicCharacterImage(d), fetchRandomCharacter(),
                fetchRandomShape(), fetchRandomShape()
            ]);

            let statsHTML = '';
            if (d.statistik_utama) {
                statsHTML += `<div class="ig-pc-stat"><div class="ig-pc-stat-val">${escHtml(d.statistik_utama.angka)}</div><div class="ig-pc-stat-lbl">${escHtml(d.statistik_utama.label)}</div></div>`;
            }
            if (d.statistik_tambahan && d.statistik_tambahan.length) {
                d.statistik_tambahan.forEach(s => {
                    statsHTML += `<div class="ig-pc-stat"><div class="ig-pc-stat-val">${escHtml(s.angka)}</div><div class="ig-pc-stat-lbl">${escHtml(s.label)}</div></div>`;
                });
            }

            let pointsHTML = '';
            if (d.poin && d.poin.length) {
                d.poin.forEach(p => {
                    const iconHtml = p.asset_image 
                        ? `<img src="/assets/infographic/points/${escHtml(p.asset_image)}.png" style="width: 75%; height: 75%; object-fit: contain;">`
                        : `<i data-lucide="${escHtml(p.icon || 'check-circle')}"></i>`;
                    pointsHTML += `
                        <div class="ig-pc-point">
                            <div class="ig-pc-icon-box">${iconHtml}</div>
                            <div>
                                <div class="ig-pc-point-title">${escHtml(p.judul)}</div>
                                <p class="ig-pc-point-desc">${escHtml(p.deskripsi)}</p>
                            </div>
                        </div>`;
                });
            }

            let ctaItemsHTML = '';
            if (d.sub_cta && d.sub_cta.length) {
                d.sub_cta.forEach(c => {
                    ctaItemsHTML += `
                        <div class="ig-pc-cta-item">
                            <div class="ig-pc-cta-item-icon"><i data-lucide="${escHtml(c.icon || 'arrow-right')}"></i></div>
                            <div class="ig-pc-cta-item-text">${escHtml(c.teks)}</div>
                        </div>`;
                });
            }

            return `
                <div class="ig-canvas layout-portrait ${theme}">
                    <div style="position:absolute; top: 18%; left: -30px; width: 130px; height: 130px; z-index: 0; pointer-events: none; transform: rotate(15deg);">${shape1}</div>
                    <div style="position:absolute; top: 55%; right: -40px; width: 160px; height: 160px; z-index: 0; pointer-events: none; transform: rotate(-10deg);">${shape2}</div>

                    <div class="ig-pc-header">
                        <div class="ig-pc-header-decor ig-pc-header-decor-1"></div>
                        <div class="ig-pc-header-decor ig-pc-header-decor-2"></div>
                        <div class="ig-pc-header-decor ig-pc-header-decor-3"></div>
                        <div class="ig-pc-header-content">
                            <div class="ig-pc-title">${escHtml(d.judul || 'INFOGRAFIS')}</div>
                            <div class="ig-pc-subtitle">${escHtml(d.subjudul || '')}</div>
                        </div>
                        <div class="ig-pc-char">${charHeader}</div>
                    </div>

                    <div class="ig-pc-intro">
                        <div class="ig-pc-intro-box">
                            <div style="flex: 1;">
                                <div class="ig-pc-intro-title"><i data-lucide="info" style="width: 14px; height: 14px; margin-bottom: -2px;"></i> PENGANTAR</div>
                                <p class="ig-pc-intro-text">${escHtml(d.intro || '')}</p>
                            </div>
                            <div style="width: 80px; height: 80px; flex-shrink: 0; background: var(--ig-lighter); border-radius: 50%; display: flex; justify-content: center; overflow: hidden; align-items: flex-end;">
                                <div style="width: 70%; height: 70%;">${charIntro}</div>
                            </div>
                        </div>
                    </div>

                    <div class="ig-pc-stats">${statsHTML}</div>

                    <div class="ig-pc-banner">
                        <div class="ig-pc-ribbon">${escHtml(d.section_title || 'POIN PENTING')}</div>
                    </div>

                    <div class="ig-pc-points">${pointsHTML}</div>

                    <div class="ig-pc-cta">
                        <div class="ig-pc-cta-decor ig-pc-cta-decor-1"></div>
                        <div class="ig-pc-cta-decor ig-pc-cta-decor-2"></div>
                        <div class="ig-pc-cta-text">${escHtml(d.call_to_action || 'AYO MULAI SEKARANG!')}</div>
                        ${ctaItemsHTML ? `<div class="ig-pc-cta-items">${ctaItemsHTML}</div>` : ''}
                    </div>

                    <div class="ig-footer">
                        <span class="ig-footer-brand">Dibuat dengan AI &bull; ${new Date().getFullYear()}</span>
                        <span class="ig-footer-logo">Ketik.in</span>
                    </div>
                </div>`;
        }

        // ===================================================================
        // LAYOUT 2: LANDSCAPE GRID
        // ===================================================================
        async function buildLandscapeGrid(d, warna) {
            currentCanvasWidth = 1200;
            const theme = `theme-${warna}`;

            const [charHeader, shape1] = await Promise.all([
                getDynamicCharacterImage(d), fetchRandomShape()
            ]);

            let statsHTML = '';
            if (d.statistik_utama) {
                statsHTML += `<div class="ig-lg-stat"><div class="ig-lg-stat-val">${escHtml(d.statistik_utama.angka)}</div><div class="ig-lg-stat-lbl">${escHtml(d.statistik_utama.label)}</div></div>`;
            }
            if (d.statistik_tambahan && d.statistik_tambahan.length) {
                d.statistik_tambahan.forEach(s => {
                    statsHTML += `<div class="ig-lg-stat"><div class="ig-lg-stat-val">${escHtml(s.angka)}</div><div class="ig-lg-stat-lbl">${escHtml(s.label)}</div></div>`;
                });
            }

            let pointsHTML = '';
            if (d.poin && d.poin.length) {
                d.poin.forEach(p => {
                    const iconHtml = p.asset_image 
                        ? `<img src="/assets/infographic/points/${escHtml(p.asset_image)}.png" style="width: 75%; height: 75%; object-fit: contain;">`
                        : `<i data-lucide="${escHtml(p.icon || 'check-circle')}"></i>`;
                    pointsHTML += `
                        <div class="ig-lg-point">
                            <div class="ig-lg-icon-box">${iconHtml}</div>
                            <div>
                                <div class="ig-lg-point-title">${escHtml(p.judul)}</div>
                                <p class="ig-lg-point-desc">${escHtml(p.deskripsi)}</p>
                            </div>
                        </div>`;
                });
            }

            let ctaItemsHTML = '';
            if (d.sub_cta && d.sub_cta.length) {
                d.sub_cta.forEach(c => {
                    ctaItemsHTML += `
                        <div class="ig-lg-cta-item">
                            <div class="ig-lg-cta-item-icon"><i data-lucide="${escHtml(c.icon || 'arrow-right')}"></i></div>
                            <div class="ig-lg-cta-item-text">${escHtml(c.teks)}</div>
                        </div>`;
                });
            }

            return `
                <div class="ig-canvas layout-landscape ${theme}">
                    <div class="ig-lg-wrapper">
                        <div class="ig-lg-sidebar">
                            <div class="ig-lg-sidebar-decor ig-lg-sidebar-decor-1"></div>
                            <div class="ig-lg-sidebar-decor ig-lg-sidebar-decor-2"></div>
                            <div>
                                <div class="ig-lg-title">${escHtml(d.judul || 'INFOGRAFIS')}</div>
                                <div class="ig-lg-subtitle">${escHtml(d.subjudul || '')}</div>
                                <p style="font-size: 13px; color: rgba(255,255,255,0.75); line-height: 1.6; position: relative; z-index: 2;">${escHtml(d.intro || '')}</p>
                            </div>
                            <div class="ig-lg-char">${charHeader}</div>
                        </div>
                        <div class="ig-lg-main">
                            <div style="position: absolute; top: 10px; right: -30px; width: 120px; height: 120px; pointer-events: none; z-index: 0;">${shape1}</div>
                            <div class="ig-lg-stats">${statsHTML}</div>
                            <div class="ig-lg-section-title">${escHtml(d.section_title || 'POIN PENTING')}</div>
                            <div class="ig-lg-points">${pointsHTML}</div>
                            <div class="ig-lg-cta">
                                <div class="ig-lg-cta-text">${escHtml(d.call_to_action || 'AYO MULAI!')}</div>
                                ${ctaItemsHTML ? `<div class="ig-lg-cta-items">${ctaItemsHTML}</div>` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="ig-footer">
                        <span class="ig-footer-brand">Dibuat dengan AI &bull; ${new Date().getFullYear()}</span>
                        <span class="ig-footer-logo">Ketik.in</span>
                    </div>
                </div>`;
        }

        // ===================================================================
        // LAYOUT 3: PORTRAIT TIMELINE
        // ===================================================================
        async function buildPortraitTimeline(d, warna) {
            currentCanvasWidth = 800;
            const theme = `theme-${warna}`;

            const [charTop, shape1, shape2] = await Promise.all([
                getDynamicCharacterImage(d), fetchRandomShape(), fetchRandomShape()
            ]);

            let statsHTML = '';
            if (d.statistik_utama) {
                statsHTML += `<div class="ig-pt-stat"><div class="ig-pt-stat-val">${escHtml(d.statistik_utama.angka)}</div><div class="ig-pt-stat-lbl">${escHtml(d.statistik_utama.label)}</div></div>`;
            }
            if (d.statistik_tambahan && d.statistik_tambahan.length) {
                d.statistik_tambahan.forEach(s => {
                    statsHTML += `<div class="ig-pt-stat"><div class="ig-pt-stat-val">${escHtml(s.angka)}</div><div class="ig-pt-stat-lbl">${escHtml(s.label)}</div></div>`;
                });
            }

            let stepsHTML = '';
            if (d.poin && d.poin.length) {
                d.poin.forEach((p, i) => {
                    const iconHtml = p.asset_image 
                        ? `<img src="/assets/infographic/points/${escHtml(p.asset_image)}.png" style="width: 75%; height: 75%; object-fit: contain;">`
                        : `<i data-lucide="${escHtml(p.icon || 'check-circle')}"></i>`;
                    stepsHTML += `
                        <div class="ig-pt-step">
                            <div class="ig-pt-step-dot">${i + 1}</div>
                            <div class="ig-pt-step-card">
                                <div class="ig-pt-step-icon">${iconHtml}</div>
                                <div>
                                    <div class="ig-pt-step-title">${escHtml(p.judul)}</div>
                                    <p class="ig-pt-step-desc">${escHtml(p.deskripsi)}</p>
                                </div>
                            </div>
                        </div>`;
                });
            }

            let ctaItemsHTML = '';
            if (d.sub_cta && d.sub_cta.length) {
                d.sub_cta.forEach(c => {
                    ctaItemsHTML += `
                        <div class="ig-pt-cta-item">
                            <div class="ig-pt-cta-item-icon"><i data-lucide="${escHtml(c.icon || 'arrow-right')}"></i></div>
                            <div class="ig-pt-cta-item-text">${escHtml(c.teks)}</div>
                        </div>`;
                });
            }

            return `
                <div class="ig-canvas layout-portrait ${theme}">
                    <div style="position:absolute; top: 30%; right: -20px; width: 140px; height: 140px; z-index: 0; pointer-events: none; transform: rotate(20deg);">${shape1}</div>
                    <div style="position:absolute; bottom: 15%; left: -30px; width: 120px; height: 120px; z-index: 0; pointer-events: none; transform: rotate(-15deg);">${shape2}</div>

                    <div class="ig-pt-header">
                        <div class="ig-pt-header-decor ig-pt-header-decor-1"></div>
                        <div class="ig-pt-header-decor ig-pt-header-decor-2"></div>
                        <div style="position: absolute; right: 30px; top: 15px; width: 120px; height: 130px; z-index: 2; opacity: 0.6;">${charTop}</div>
                        <div class="ig-pt-title">${escHtml(d.judul || 'INFOGRAFIS')}</div>
                        <div class="ig-pt-subtitle">${escHtml(d.subjudul || '')}</div>
                    </div>

                    <div class="ig-pt-intro">
                        <div class="ig-pt-intro-box">
                            <p class="ig-pt-intro-text">${escHtml(d.intro || '')}</p>
                        </div>
                    </div>

                    <div class="ig-pt-stats">${statsHTML}</div>

                    <div class="ig-pt-timeline">
                        <div style="text-align: center; margin-bottom: 20px;">
                            <span style="display: inline-block; background: var(--ig-header-bg); color: #fff; font-size: 16px; font-weight: 800; padding: 10px 30px; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 10px; box-shadow: 0 6px 18px rgba(0,0,0,0.12);">${escHtml(d.section_title || 'LANGKAH-LANGKAH')}</span>
                        </div>
                        <div class="ig-pt-timeline-track">
                            ${stepsHTML}
                        </div>
                    </div>

                    <div class="ig-pt-cta">
                        <div class="ig-pt-cta-text">${escHtml(d.call_to_action || 'AYO MULAI SEKARANG!')}</div>
                        ${ctaItemsHTML ? `<div class="ig-pt-cta-items">${ctaItemsHTML}</div>` : ''}
                    </div>

                    <div class="ig-footer">
                        <span class="ig-footer-brand">Dibuat dengan AI &bull; ${new Date().getFullYear()}</span>
                        <span class="ig-footer-logo">Ketik.in</span>
                    </div>
                </div>`;
        }

        // ===================================================================
        // LAYOUT 4: LANDSCAPE SPLIT
        // ===================================================================
        async function buildLandscapeSplit(d, warna) {
            currentCanvasWidth = 1200;
            const theme = `theme-${warna}`;

            const [charHero, shape1] = await Promise.all([
                getDynamicCharacterImage(d), fetchRandomShape()
            ]);

            let statsHTML = '';
            if (d.statistik_utama) {
                statsHTML += `<div class="ig-ls-stat"><div class="ig-ls-stat-val">${escHtml(d.statistik_utama.angka)}</div><div class="ig-ls-stat-lbl">${escHtml(d.statistik_utama.label)}</div></div>`;
            }
            if (d.statistik_tambahan && d.statistik_tambahan.length) {
                d.statistik_tambahan.forEach(s => {
                    statsHTML += `<div class="ig-ls-stat"><div class="ig-ls-stat-val">${escHtml(s.angka)}</div><div class="ig-ls-stat-lbl">${escHtml(s.label)}</div></div>`;
                });
            }

            let pointsHTML = '';
            if (d.poin && d.poin.length) {
                d.poin.forEach(p => {
                    const iconHtml = p.asset_image 
                        ? `<img src="/assets/infographic/points/${escHtml(p.asset_image)}.png" style="width: 75%; height: 75%; object-fit: contain;">`
                        : `<i data-lucide="${escHtml(p.icon || 'check-circle')}"></i>`;
                    pointsHTML += `
                        <div class="ig-ls-point">
                            <div class="ig-ls-icon-box">${iconHtml}</div>
                            <div>
                                <div class="ig-ls-point-title">${escHtml(p.judul)}</div>
                                <p class="ig-ls-point-desc">${escHtml(p.deskripsi)}</p>
                            </div>
                        </div>`;
                });
            }

            let ctaItemsHTML = '';
            if (d.sub_cta && d.sub_cta.length) {
                d.sub_cta.forEach(c => {
                    ctaItemsHTML += `
                        <div class="ig-ls-cta-item">
                            <div class="ig-ls-cta-item-icon"><i data-lucide="${escHtml(c.icon || 'arrow-right')}"></i></div>
                            <div class="ig-ls-cta-item-text">${escHtml(c.teks)}</div>
                        </div>`;
                });
            }

            return `
                <div class="ig-canvas layout-landscape ${theme}">
                    <div class="ig-ls-wrapper">
                        <div class="ig-ls-hero">
                            <div class="ig-ls-hero-decor ig-ls-hero-decor-1"></div>
                            <div class="ig-ls-hero-decor ig-ls-hero-decor-2"></div>
                            <div class="ig-ls-hero-decor ig-ls-hero-decor-3"></div>
                            <div class="ig-ls-title">${escHtml(d.judul || 'INFOGRAFIS')}</div>
                            <div class="ig-ls-subtitle">${escHtml(d.subjudul || '')}</div>
                            <div class="ig-ls-char">${charHero}</div>
                        </div>
                        <div class="ig-ls-main">
                            <div style="position: absolute; bottom: 5px; right: -20px; width: 100px; height: 100px; pointer-events: none; z-index: 0;">${shape1}</div>
                            <div class="ig-ls-intro">
                                <div class="ig-ls-intro-label">Pengantar</div>
                                <p class="ig-ls-intro-text">${escHtml(d.intro || '')}</p>
                            </div>
                            <div class="ig-ls-stats">${statsHTML}</div>
                            <div class="ig-ls-section-title">${escHtml(d.section_title || 'POIN PENTING')}</div>
                            <div class="ig-ls-points">${pointsHTML}</div>
                            <div class="ig-ls-cta">
                                <div class="ig-ls-cta-text">${escHtml(d.call_to_action || 'AYO MULAI!')}</div>
                                ${ctaItemsHTML ? `<div class="ig-ls-cta-items">${ctaItemsHTML}</div>` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="ig-footer">
                        <span class="ig-footer-brand">Dibuat dengan AI &bull; ${new Date().getFullYear()}</span>
                        <span class="ig-footer-logo">Ketik.in</span>
                    </div>
                </div>`;
        }

        // ===================================================================
        // LAYOUT 5: LANDSCAPE CHART (KATADATA STYLE)
        // ===================================================================
        async function buildLandscapeChart(d, warna) {
            currentCanvasWidth = 1200;
            const theme = `theme-${warna}`;
            
            // Generate Pollinations image if prompt exists
            const imgHtml = await getDynamicCharacterImage(d, 'ig-lc-hero-img');

            // Build Bar Chart
            let chartHTML = '';
            let chartMax = 100;
            if (d.grafik_data && d.grafik_data.data && d.grafik_data.data.length > 0) {
                // Find max value for relative height (add 20% headroom)
                chartMax = Math.max(...d.grafik_data.data.map(item => item.nilai)) * 1.2;
                if (chartMax === 0) chartMax = 100;

                const bars = d.grafik_data.data.map((item, index) => {
                    const heightPercent = (item.nilai / chartMax) * 100;
                    // Cycle colors
                    const colorClasses = ['ig-bar-primary', 'ig-bar-secondary', 'ig-bar-tertiary', 'ig-bar-accent'];
                    const barColor = colorClasses[index % colorClasses.length];
                    
                    return `
                        <div class="ig-lc-bar-col">
                            <div class="ig-lc-bar-val">${item.nilai}</div>
                            <div class="ig-lc-bar-track">
                                <div class="ig-lc-bar-fill ${barColor}" style="height: ${heightPercent}%"></div>
                            </div>
                            <div class="ig-lc-bar-label">${escHtml(item.label)}</div>
                        </div>
                    `;
                }).join('');

                chartHTML = `
                    <div class="ig-lc-chart-container">
                        <div class="ig-lc-chart-y-axis">${escHtml(d.grafik_data.satuan || 'Nilai Data')}</div>
                        <div class="ig-lc-chart-wrapper">
                            ${bars}
                        </div>
                    </div>
                `;
            }

            return `
                <div class="ig-canvas layout-landscape ${theme}">
                    <div class="ig-lc-header">
                        <div class="ig-lc-badge">${escHtml(d.kategori_visual || 'Infografis').toUpperCase()}</div>
                        <h1 class="ig-lc-title">${escHtml(d.judul)}</h1>
                        <p class="ig-lc-sub">${escHtml(d.subjudul || '')}</p>
                    </div>
                    
                    <div class="ig-lc-body">
                        <div class="ig-lc-content-col">
                            ${d.intro ? `<p class="ig-lc-intro">${escHtml(d.intro)}</p>` : ''}
                            ${chartHTML}
                        </div>
                        <div class="ig-lc-hero-col">
                            ${imgHtml}
                        </div>
                    </div>
                    
                    <div class="ig-footer">
                        <span class="ig-footer-brand">Dibuat dengan AI &bull; ${new Date().getFullYear()}</span>
                        <span class="ig-footer-logo">Ketik.in</span>
                    </div>
                </div>`;
        }

        // ===== GENERATE INFOGRAPHIC =====
        async function generateInfographic() {
            const topik = document.getElementById('inp-topik').value.trim();
            if (!topik) { Swal.fire('Oops!', 'Topik wajib diisi!', 'warning'); return; }

            const btn = document.getElementById('btn-generate');
            const loading = document.getElementById('loading-state');
            const errorState = document.getElementById('error-state');
            const resultCard = document.getElementById('result-card');

            btn.disabled = true;
            loading.classList.remove('d-none');
            errorState.classList.add('d-none');
            resultCard.classList.add('d-none');

            seconds = 0;
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                seconds++;
                document.getElementById('loading-timer').textContent = `Sudah ${seconds} detik...`;
            }, 1000);

            try {
                const res = await fetch('{{ route("admin.infographic.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        topik: topik,
                        jenis: document.getElementById('inp-jenis').value,
                        poin: document.getElementById('inp-poin').value,
                        warna: document.getElementById('inp-warna').value,
                        gaya: document.getElementById('inp-gaya').value,
                        layout: document.getElementById('inp-layout').value,
                    })
                });

                const contentType = res.headers.get('content-type') || '';
                let result;
                if (contentType.includes('application/json')) {
                    result = await res.json();
                } else {
                    const text = await res.text();
                    console.error('Non-JSON response:', text.substring(0, 500));
                    throw new Error('Server mengembalikan error. Status: ' + res.status);
                }

                if (!res.ok || result.error) {
                    throw new Error(result.error || 'HTTP ' + res.status);
                }

                const chosenLayout = result.layout || result.data.layout || 'portrait_classic';

                // Store for later use
                lastGeneratedData = {
                    data: result.data,
                    warna: result.warna,
                    jenis: result.jenis,
                    layout: chosenLayout,
                    topik: topik,
                };

                // Show layout badge
                document.getElementById('layout-badge').textContent = layoutNames[chosenLayout] || chosenLayout;

                // Build and display infographic
                const html = await buildInfographicHTML(result.data, result.warna, chosenLayout);

                // Render in hidden area
                document.getElementById('ig-canvas').innerHTML = html;

                // Render Lucide Icons inside the canvas
                lucide.createIcons({ root: document.getElementById('ig-canvas') });

                // Wait for fonts & icons
                await document.fonts.ready;
                await new Promise(r => setTimeout(r, 600));

                // Create preview
                const previewContainer = document.getElementById('result-preview');
                previewContainer.innerHTML = html;

                // Render icons in preview too
                lucide.createIcons({ root: previewContainer });

                // Unhide the result card
                resultCard.classList.remove('d-none');

                // Scale preview to fit container
                const previewCanvas = previewContainer.querySelector('.ig-canvas');
                if (previewCanvas) {
                    const containerWidth = previewContainer.offsetWidth - 4;
                    const scale = containerWidth > 0 ? containerWidth / currentCanvasWidth : 1;
                    previewCanvas.style.transform = `scale(${scale})`;
                    previewCanvas.style.transformOrigin = 'top left';
                    // Wait a tick for browser to compute scrollHeight properly
                    await new Promise(r => setTimeout(r, 100));
                    previewContainer.style.height = (previewCanvas.scrollHeight * scale) + 'px';
                    previewContainer.style.overflow = 'hidden';
                }

                resultCard.scrollIntoView({ behavior: 'smooth', block: 'start' });

            } catch (e) {
                document.getElementById('error-msg').textContent = e.message;
                errorState.classList.remove('d-none');
            } finally {
                clearInterval(timerInterval);
                loading.classList.add('d-none');
                btn.disabled = false;
            }
        }

        // ===== CAPTURE WITH HTML2CANVAS =====
        async function captureInfographic() {
            const canvas = document.getElementById('ig-canvas');
            const target = canvas.querySelector('.ig-canvas');
            if (!target) throw new Error('No infographic to capture');

            // Re-render Lucide icons in the hidden canvas before capture
            lucide.createIcons({ root: canvas });
            await document.fonts.ready;
            await new Promise(r => setTimeout(r, 300));

            const result = await html2canvas(target, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                width: currentCanvasWidth,
                height: target.scrollHeight,
                logging: false,
            });

            return result.toDataURL('image/png');
        }

        // ===== DOWNLOAD PNG =====
        async function downloadInfographic() {
            try {
                Swal.fire({ title: 'Membuat gambar...', text: 'Tunggu sebentar...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                const dataUrl = await captureInfographic();
                const link = document.createElement('a');
                link.download = `infografis-${Date.now()}.png`;
                link.href = dataUrl;
                link.click();
                Swal.close();
                Swal.fire('Berhasil!', 'Infografis telah didownload.', 'success');
            } catch (e) {
                Swal.close();
                Swal.fire('Error', 'Gagal membuat gambar: ' + e.message, 'error');
            }
        }

        // ===== SAVE TO GALLERY =====
        async function saveToGallery() {
            if (!lastGeneratedData) return;

            try {
                Swal.fire({ title: 'Menyimpan...', text: 'Mengonversi dan menyimpan infografis...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                const dataUrl = await captureInfographic();

                const res = await fetch('{{ route("admin.infographic.store-image") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        image: dataUrl,
                        topik: lastGeneratedData.topik,
                    }),
                });

                const result = await res.json();

                if (!res.ok || result.error) {
                    throw new Error(result.error || 'Gagal menyimpan');
                }

                Swal.close();
                Swal.fire({
                    title: 'Tersimpan! 🎉',
                    text: 'Infografis berhasil disimpan ke galeri.',
                    icon: 'success',
                    confirmButtonText: 'Muat Ulang Galeri',
                }).then(() => {
                    window.location.reload();
                });

            } catch (e) {
                Swal.close();
                Swal.fire('Error', 'Gagal menyimpan: ' + e.message, 'error');
            }
        }

        // ===== DELETE CONFIRMATION =====
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus?',
                    text: `Hapus infografis: ${this.dataset.name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d63939',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(r => { if (r.isConfirmed) this.submit(); });
            });
        });
    </script>
    @endpush
</x-admin-layout>
