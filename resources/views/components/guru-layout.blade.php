<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Mode Guru — {{ config('app.name', 'Ketik.in') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/demo.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/ketik-override.css') }}" rel="stylesheet"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --guru-primary: #10b981;
            --guru-dark:    #059669;
            --guru-bg:      #064e3b;
            --guru-sidebar: #022c22;
        }
        body {
            font-feature-settings: "cv03","cv04","cv11";
            background-color: #f0fdf4;
        }

        /* ===== Desktop Sidebar ===== */
        @media (min-width: 992px) {
            .guru-navbar {
                background: transparent;
                border: none;
                padding: 0;
                width: 272px;
                position: fixed;
                top: 0; left: 0;
                height: 100vh;
                z-index: 1030;
                overflow-y: hidden;
            }
            .guru-sidebar-wrapper { padding: 1rem; height: 100%; box-sizing: border-box; }
            .guru-sidebar-content {
                background: linear-gradient(180deg, #022c22 0%, #064e3b 100%);
                color: white;
                border-radius: 18px;
                height: 100%;
                display: flex;
                flex-direction: column;
                padding: 1.25rem;
                box-shadow: 4px 0 28px rgba(16,185,129,0.12);
                overflow-y: auto;
            }
            .guru-sidebar-content::-webkit-scrollbar { width: 4px; }
            .guru-sidebar-content::-webkit-scrollbar-thumb { background: rgba(16,185,129,0.2); border-radius: 4px; }
            .guru-page-wrapper { margin-left: 272px; padding: 1rem 1rem 1rem 0; }
            .container-xl, .container-fluid { max-width: 1400px; }
        }

        /* ===== Mobile ===== */
        @media (max-width: 991.98px) {
            .guru-navbar { width: 100%; background: transparent !important; border-bottom: none; padding: 0; z-index: 1020; position: relative; }
            .guru-sidebar-wrapper { padding: 0; height: auto; width: 100%; }
            .guru-sidebar-content {
                background: linear-gradient(180deg, #022c22 0%, #064e3b 100%);
                color: white;
                padding: 0.5rem 1rem;
                width: 100%;
                border-radius: 0;
                border-top: 1px solid rgba(16,185,129,0.2);
            }
            .guru-page-wrapper { margin-left: 0; padding: 0; }
            .guru-logo-desktop { display: none; }
        }

        /* ===== Sidebar Common ===== */
        .guru-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 0.5rem 1.25rem;
            margin-bottom: 0.25rem;
            border-bottom: 1px solid rgba(16,185,129,0.15);
        }
        .guru-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(16,185,129,0.35);
            flex-shrink: 0;
        }
        .guru-logo-text { font-size: 1.1rem; font-weight: 700; letter-spacing: -0.02em; color: white; line-height: 1.2; }
        .guru-logo-sub { font-size: 0.7rem; color: rgba(16,185,129,0.8); font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; }

        .guru-nav { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 3px; }
        .guru-nav-link {
            display: flex; align-items: center;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(167,243,208,0.75) !important;
            text-decoration: none;
            transition: all 0.18s;
            font-weight: 500;
            font-size: 0.92rem;
            gap: 10px;
        }
        .guru-nav-link:hover { background: rgba(16,185,129,0.12); color: #a7f3d0 !important; }
        .guru-nav-link.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            box-shadow: 0 4px 14px rgba(16,185,129,0.30);
        }
        .guru-nav-icon { width: 18px; height: 18px; flex-shrink: 0; stroke-width: 2; }

        .guru-section-label {
            font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase;
            color: rgba(167,243,208,0.4); font-weight: 600;
            padding: 1rem 12px 0.35rem; margin: 0;
        }

        .guru-back-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 12px; border-radius: 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            color: rgba(167,243,208,0.6) !important;
            text-decoration: none; font-size: 0.88rem; font-weight: 500;
            transition: all 0.18s;
        }
        .guru-back-btn:hover { background: rgba(255,255,255,0.08); color: white !important; }

        .guru-sidebar-footer { margin-top: auto; padding-top: 1rem; display: flex; flex-direction: column; gap: 8px; }
        @media (max-width: 991.98px) { .guru-sidebar-footer { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(16,185,129,0.15); } }

        /* ===== Result Rendered Output ===== */
        .guru-result-body { font-size: 0.92rem; line-height: 1.75; color: #1e293b; }
        .guru-result-body h1, .guru-result-body h2 { font-size: 1.1rem; font-weight: 700; margin-top: 1.25rem; margin-bottom: 0.4rem; color: #064e3b; border-bottom: 1px solid #d1fae5; padding-bottom: 0.3rem; }
        .guru-result-body h3 { font-size: 1rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.3rem; color: #047857; }
        .guru-result-body h4 { font-size: 0.95rem; font-weight: 600; margin-top: 0.8rem; margin-bottom: 0.25rem; color: #065f46; }
        .guru-result-body p { margin-bottom: 0.65rem; }
        .guru-result-body ul, .guru-result-body ol { padding-left: 1.4rem; margin-bottom: 0.65rem; }
        .guru-result-body li { margin-bottom: 0.2rem; }
        .guru-result-body strong { color: #065f46; }
        .guru-result-body table { width: 100%; border-collapse: collapse; font-size: 0.87rem; margin-bottom: 1rem; }
        .guru-result-body th { background: #d1fae5; color: #064e3b; font-weight: 600; padding: 8px 10px; text-align: left; border: 1px solid #a7f3d0; }
        .guru-result-body td { padding: 7px 10px; border: 1px solid #d1fae5; vertical-align: top; }
        .guru-result-body tr:nth-child(even) td { background: #f0fdf4; }
        .guru-result-body code { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 4px; font-size: 0.85em; }
        .guru-result-body hr { border: none; border-top: 1px solid #d1fae5; margin: 1rem 0; }
        .guru-result-body blockquote { border-left: 3px solid #10b981; padding-left: 1rem; color: #4b5563; margin: 0.75rem 0; font-style: italic; }
    </style>
</head>
<body>
<div class="page">

    {{-- Mobile Header --}}
    <header class="navbar navbar-expand-lg d-print-none d-lg-none border-bottom" style="background: linear-gradient(135deg,#022c22,#064e3b);">
        <div class="container-xl">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#guru-sidebar-menu" aria-controls="guru-sidebar-menu" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="d-flex align-items-center gap-2">
                <div class="guru-logo-icon" style="width:32px;height:32px;border-radius:9px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <span style="font-weight:700;color:white;font-size:1rem;">Mode Guru</span>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-sm ms-auto" style="background:rgba(16,185,129,0.15);color:#a7f3d0;border:1px solid rgba(16,185,129,0.25);border-radius:8px;font-size:0.8rem;">
                ← Dashboard
            </a>
        </div>
    </header>

    {{-- Sidebar --}}
    <aside class="guru-navbar navbar navbar-vertical navbar-expand-lg">
        <div class="guru-sidebar-wrapper">
            <div class="collapse navbar-collapse guru-sidebar-content" id="guru-sidebar-menu">

                {{-- Logo --}}
                <div class="guru-logo guru-logo-desktop d-none d-lg-flex">
                    <div class="guru-logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <div>
                        <div class="guru-logo-text">Mode Guru</div>
                        <div class="guru-logo-sub">Asisten Mengajar AI</div>
                    </div>
                </div>

                {{-- Nav --}}
                <ul class="guru-nav navbar-nav mt-2">
                    <li>
                        <a href="{{ route('guru.index') }}" class="guru-nav-link {{ request()->routeIs('guru.index') ? 'active' : '' }}">
                            <svg class="guru-nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            Beranda Guru
                        </a>
                    </li>

                    <p class="guru-section-label">Fitur AI</p>

                    <li>
                        <a href="{{ route('guru.soal') }}" class="guru-nav-link {{ request()->routeIs('guru.soal') ? 'active' : '' }}">
                            <svg class="guru-nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            Buat Soal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.modul') }}" class="guru-nav-link {{ request()->routeIs('guru.modul') ? 'active' : '' }}">
                            <svg class="guru-nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            Modul Ajar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('guru.rekap') }}" class="guru-nav-link {{ request()->routeIs('guru.rekap') ? 'active' : '' }}">
                            <svg class="guru-nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
                            Rekap Nilai
                        </a>
                    </li>

                    <p class="guru-section-label">Koleksi</p>

                    <li>
                        <a href="{{ route('guru.pustaka') }}" class="guru-nav-link {{ request()->routeIs('guru.pustaka') ? 'active' : '' }}">
                            <svg class="guru-nav-icon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                            Pustaka Guru
                        </a>
                    </li>
                </ul>

                {{-- Footer --}}
                <div class="guru-sidebar-footer">
                    {{-- User Info --}}
                    <div class="d-flex align-items-center gap-2 px-2 pb-2" style="border-top:1px solid rgba(16,185,129,0.15);padding-top:1rem;">
                        @if(Auth::user()->avatar)
                            <span class="avatar avatar-sm rounded-circle" style="background-image: url({{ asset('storage/' . Auth::user()->avatar) }})"></span>
                        @else
                            <span class="avatar avatar-sm rounded-circle" style="background-image: url(https://preview.tabler.io/static/avatars/000m.jpg)"></span>
                        @endif
                        <div class="overflow-hidden flex-grow-1">
                            <div class="text-truncate fw-semibold small text-white">{{ Auth::user()->name }}</div>
                            <div class="text-truncate" style="font-size:0.72rem;color:rgba(167,243,208,0.5);">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    {{-- Back Button --}}
                    <a href="{{ route('dashboard') }}" class="guru-back-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="guru-page-wrapper">
        <div class="page-body">
            {{ $slot }}
        </div>
    </div>

</div>

<script src="{{ asset('js/tabler.min.js') }}" defer></script>
<script src="{{ asset('js/demo.min.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ===== Global Guru Utilities =====

function guruToast(type, message) {
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: type === 'error' ? 5000 : 2800,
        timerProgressBar: true,
        customClass: { popup: 'swal2-toast-guru' },
    }).fire({ icon: type, title: message });
}

function guruAlert(type, title, text) {
    Swal.fire({
        icon: type,
        title: title,
        text: text,
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Mengerti',
        customClass: { popup: 'swal2-guru-popup' },
    });
}

function guruExportWord(contentId, filename) {
    const el = document.getElementById(contentId);
    if (!el) return;
    const html = el.innerHTML;
    const name = (filename || 'Dokumen Guru').replace(/[\\/:*?"<>|]/g, '').trim();
    const blob = new Blob([
        '\ufeff<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">' +
        '<head><meta charset="utf-8"><style>' +
        'body{font-family:Calibri,Arial,sans-serif;font-size:11pt;line-height:1.7;margin:2.5cm;}' +
        'h1,h2{color:#064e3b;border-bottom:1px solid #d1fae5;padding-bottom:4pt;}' +
        'h3,h4{color:#047857;}' +
        'table{border-collapse:collapse;width:100%;margin-bottom:10pt;}' +
        'th{background:#d1fae5;color:#064e3b;font-weight:bold;padding:6pt 8pt;border:1pt solid #a7f3d0;text-align:left;}' +
        'td{padding:5pt 8pt;border:1pt solid #d1fae5;vertical-align:top;}' +
        'tr:nth-child(even) td{background:#f0fdf4;}' +
        'code{background:#f0fdf4;color:#065f46;padding:1pt 4pt;}' +
        '</style></head><body>' + html + '</body></html>'
    ], { type: 'application/msword' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = name + '.doc';
    document.body.appendChild(a); a.click();
    document.body.removeChild(a); URL.revokeObjectURL(url);
    guruToast('success', 'Dokumen Word berhasil diunduh');
}

function guruExportPDF(contentId, titleText) {
    const el = document.getElementById(contentId);
    if (!el) return;
    const html = el.innerHTML;
    const title = titleText || 'Dokumen Guru';
    const win = window.open('', '_blank', 'width=900,height=700');
    win.document.write(
        '<!DOCTYPE html><html><head><title>' + title + '</title><meta charset="utf-8">' +
        '<style>' +
        'body{font-family:Calibri,Arial,sans-serif;font-size:11pt;line-height:1.7;margin:2cm;color:#1e293b;}' +
        'h1,h2{color:#064e3b;border-bottom:1px solid #d1fae5;padding-bottom:4px;margin-top:1.2em;}' +
        'h3,h4{color:#047857;margin-top:1em;}' +
        'p{margin:0 0 8px;}' +
        'ul,ol{padding-left:1.5em;margin-bottom:8px;}' +
        'li{margin-bottom:3px;}' +
        'strong{color:#065f46;}' +
        'table{border-collapse:collapse;width:100%;margin-bottom:12px;font-size:10pt;}' +
        'th{background:#d1fae5;color:#064e3b;font-weight:bold;padding:6px 10px;border:1px solid #a7f3d0;text-align:left;}' +
        'td{padding:5px 10px;border:1px solid #d1fae5;vertical-align:top;}' +
        'tr:nth-child(even) td{background:#f8fffe;}' +
        'hr{border:none;border-top:1px solid #d1fae5;margin:12px 0;}' +
        'blockquote{border-left:3px solid #10b981;padding-left:12px;color:#4b5563;font-style:italic;}' +
        '@media print{@page{margin:2cm}body{margin:0}}' +
        '</style></head><body>' + html +
        '<script>window.onload=function(){window.print();window.onafterprint=function(){window.close();}};<\/script>' +
        '</body></html>'
    );
    win.document.close();
}

function guruCopy(contentId) {
    const el = document.getElementById(contentId);
    if (!el) return;
    const text = el.innerText;
    navigator.clipboard.writeText(text).then(() => {
        guruToast('success', 'Teks berhasil disalin ke clipboard');
    }).catch(() => {
        const ta = document.createElement('textarea');
        ta.value = text;
        document.body.appendChild(ta); ta.select();
        document.execCommand('copy'); document.body.removeChild(ta);
        guruToast('success', 'Teks berhasil disalin ke clipboard');
    });
}
</script>
@stack('scripts')
</body>
</html>
