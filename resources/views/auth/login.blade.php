<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<title>Masuk — Ketik.in</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --bg:#011a12;
    --surface:rgba(2,22,14,0.65);
    --border:rgba(16,185,129,0.12);
    --border-focus:rgba(16,185,129,0.5);
    --accent:#10b981;
    --accent2:#059669;
    --accent-glow:rgba(16,185,129,0.15);
    --text:#e6faf4;
    --text-dim:#6cb89a;
    --text-muted:#3d7a60;
    --danger:#f87171;
    --success:#34d399;
    --radius:16px;
    --font:'Inter',system-ui,-apple-system,sans-serif
}
html,body{height:100%;font-family:var(--font);background:var(--bg);color:var(--text);overflow-x:hidden}

.login-page{position:relative;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:1.5rem}

/* === MESH BG === */
.mesh-bg{position:fixed;inset:0;z-index:0;overflow:hidden}
.mesh-blob{position:absolute;border-radius:50%;filter:blur(110px);opacity:.3;animation:blobMove 20s ease-in-out infinite alternate}
.mesh-blob.b1{width:650px;height:650px;background:#022c22;top:-15%;left:-15%;animation-duration:26s}
.mesh-blob.b2{width:500px;height:500px;background:#064e3b;bottom:-20%;right:-10%;animation-duration:20s;animation-delay:-5s}
.mesh-blob.b3{width:420px;height:420px;background:#10b981;top:35%;left:45%;opacity:.12;animation-duration:32s;animation-delay:-10s}
.mesh-blob.b4{width:320px;height:320px;background:#059669;top:5%;right:15%;animation-duration:22s;animation-delay:-8s;opacity:.15}
@keyframes blobMove{0%{transform:translate(0,0) scale(1)}25%{transform:translate(40px,-30px) scale(1.1)}50%{transform:translate(-20px,50px) scale(.95)}75%{transform:translate(30px,20px) scale(1.05)}100%{transform:translate(-40px,-40px) scale(1)}}

#particles{position:fixed;inset:0;z-index:1;pointer-events:none}
.grid-overlay{position:fixed;inset:0;z-index:1;background-image:linear-gradient(rgba(16,185,129,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(16,185,129,.02) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}

/* === CONTAINER === */
.login-container{position:relative;z-index:10;display:flex;width:100%;max-width:1000px;min-height:580px;border-radius:24px;overflow:hidden;border:1px solid var(--border);background:var(--surface);backdrop-filter:blur(40px);-webkit-backdrop-filter:blur(40px);box-shadow:0 0 80px rgba(16,185,129,.08),0 40px 80px rgba(0,0,0,.5);animation:containerIn .8s cubic-bezier(.16,1,.3,1) forwards;opacity:0;transform:translateY(30px)}
@keyframes containerIn{to{opacity:1;transform:translateY(0)}}

/* === LEFT BRAND PANEL === */
.brand-panel{flex:1;position:relative;display:flex;flex-direction:column;justify-content:center;padding:3rem;background:linear-gradient(160deg,rgba(2,44,34,0.9),rgba(6,78,59,0.7));border-right:1px solid rgba(16,185,129,.12);overflow:hidden}
.brand-panel::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 25% 65%,rgba(16,185,129,.14),transparent 65%)}

/* Icon guru */
.brand-icon{width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;box-shadow:0 6px 24px rgba(16,185,129,.35);position:relative;z-index:2}

.brand-logo{display:flex;align-items:baseline;gap:0;margin-bottom:.5rem;position:relative;z-index:2}
.brand-logo .logo-k{font-size:3.2rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-.04em}
.brand-logo .logo-rest{font-size:1.7rem;font-weight:700;color:rgba(255,255,255,.85);margin-left:-2px;overflow:hidden}
.brand-logo .logo-rest span{display:inline-block;animation:typeIn 2s steps(8) forwards;max-width:0;overflow:hidden;white-space:nowrap}
.brand-logo .logo-cursor{color:var(--accent);animation:cursorBlink 1s step-end infinite;margin-left:1px;font-weight:300}
@keyframes typeIn{0%{max-width:0}100%{max-width:120px}}
@keyframes cursorBlink{0%,100%{opacity:0}50%{opacity:1}}

.brand-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.2);border-radius:20px;padding:4px 12px;font-size:.72rem;font-weight:600;color:#6ee7b7;letter-spacing:.06em;text-transform:uppercase;margin-bottom:1.5rem;position:relative;z-index:2}

.brand-tagline{font-size:1.6rem;font-weight:800;line-height:1.3;color:#fff;margin-bottom:.75rem;position:relative;z-index:2}
.brand-tagline .highlight{background:linear-gradient(135deg,#10b981,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.brand-desc{font-size:.87rem;color:var(--text-dim);line-height:1.75;margin-bottom:2rem;position:relative;z-index:2}

.stats-row{display:flex;gap:1.5rem;position:relative;z-index:2}
.stat-item{text-align:center}
.stat-num{font-size:1.45rem;font-weight:800;background:linear-gradient(135deg,#10b981,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.stat-label{font-size:.68rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-top:2px}

/* Feature pills */
.feature-pills{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:1.75rem;position:relative;z-index:2}
.pill{display:flex;align-items:center;gap:5px;padding:5px 10px;background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.14);border-radius:20px;font-size:.72rem;color:#6ee7b7}

.float-badge{position:absolute;display:flex;align-items:center;gap:8px;padding:8px 14px;background:rgba(2,22,14,.7);border:1px solid rgba(16,185,129,.15);border-radius:12px;font-size:.72rem;color:var(--text-dim);backdrop-filter:blur(12px);z-index:2}
.float-badge.fb1{bottom:2.5rem;right:1.5rem;animation:floatBadge 6s ease-in-out infinite}
.float-badge.fb2{top:2rem;right:2rem;animation:floatBadge 8s ease-in-out infinite 2s}
.float-badge .dot{width:6px;height:6px;border-radius:50%;background:#10b981;box-shadow:0 0 8px #10b981}
@keyframes floatBadge{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}

/* === RIGHT FORM PANEL === */
.form-panel{flex:1;display:flex;flex-direction:column;justify-content:center;padding:3rem;position:relative;background:rgba(1,12,8,.3)}

.form-header{margin-bottom:2rem}
.form-header h1{font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:.35rem}
.form-header p{font-size:.85rem;color:var(--text-dim)}

.input-group-k{position:relative;margin-bottom:1.25rem}
.input-group-k label{display:block;font-size:.75rem;font-weight:600;color:var(--text-dim);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;transition:color .3s}
.input-group-k:focus-within label{color:var(--accent)}
.input-wrap{position:relative;display:flex;align-items:center}
.input-wrap .icon-left{position:absolute;left:14px;color:var(--text-muted);transition:color .3s;pointer-events:none;z-index:2}
.input-wrap:focus-within .icon-left{color:var(--accent)}
.input-wrap input{width:100%;height:52px;padding:0 14px 0 44px;background:rgba(16,185,129,.04);border:1.5px solid rgba(16,185,129,.12);border-radius:var(--radius);color:var(--text);font-size:.9rem;font-family:var(--font);outline:none;transition:all .3s cubic-bezier(.4,0,.2,1)}
.input-wrap input:focus{border-color:var(--border-focus);background:rgba(16,185,129,.06);box-shadow:0 0 0 4px var(--accent-glow),0 0 20px rgba(16,185,129,.06)}
.input-wrap input::placeholder{color:var(--text-muted)}
.input-wrap input.has-error{border-color:var(--danger)}
.input-wrap .toggle-pw{position:absolute;right:12px;background:none;border:none;color:var(--text-muted);cursor:pointer;padding:6px;border-radius:8px;transition:all .2s;z-index:2}
.input-wrap .toggle-pw:hover{color:var(--accent);background:rgba(16,185,129,.08)}
.field-error{font-size:.75rem;color:var(--danger);margin-top:.4rem}

.options-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:1.75rem}
.check-label{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.82rem;color:var(--text-dim)}
.check-label input[type=checkbox]{width:16px;height:16px;accent-color:var(--accent);cursor:pointer;border-radius:4px}
.forgot-link{font-size:.82rem;color:var(--accent);text-decoration:none;font-weight:600;transition:all .2s}
.forgot-link:hover{color:#6ee7b7;text-shadow:0 0 12px rgba(16,185,129,.4)}

.btn-submit{position:relative;width:100%;height:52px;border:none;border-radius:var(--radius);background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:.95rem;font-weight:700;font-family:var(--font);cursor:pointer;overflow:hidden;transition:all .3s cubic-bezier(.4,0,.2,1);box-shadow:0 4px 20px rgba(16,185,129,.3)}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 8px 32px rgba(16,185,129,.42)}
.btn-submit:active{transform:translateY(0)}
.btn-submit .shimmer{position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.15),transparent);transition:left .6s}
.btn-submit:hover .shimmer{left:100%}
.btn-submit:disabled{opacity:.6;cursor:not-allowed;transform:none}
.btn-submit .spinner{display:none;width:20px;height:20px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite}
.btn-submit.loading .btn-label{display:none}
.btn-submit.loading .spinner{display:inline-block}
@keyframes spin{to{transform:rotate(360deg)}}

.register-row{text-align:center;margin-top:1.75rem;font-size:.85rem;color:var(--text-dim)}
.register-row a{color:var(--accent);font-weight:700;text-decoration:none;transition:all .2s}
.register-row a:hover{color:#6ee7b7;text-shadow:0 0 12px rgba(16,185,129,.4)}

.alert-toast{padding:12px 16px;border-radius:12px;font-size:.82rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:10px;animation:alertIn .4s ease}
.alert-toast.success{background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.2);color:var(--success)}
.alert-toast.danger{background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.2);color:var(--danger)}
@keyframes alertIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}

.s1{animation:fadeUp .6s ease forwards;opacity:0}
.s2{animation:fadeUp .6s ease .08s forwards;opacity:0}
.s3{animation:fadeUp .6s ease .16s forwards;opacity:0}
.s4{animation:fadeUp .6s ease .24s forwards;opacity:0}
.s5{animation:fadeUp .6s ease .32s forwards;opacity:0}
.s6{animation:fadeUp .6s ease .40s forwards;opacity:0}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

@media(max-width:768px){
.login-container{flex-direction:column;max-width:440px;min-height:auto}
.brand-panel{display:none}
.form-panel{padding:2rem 1.5rem}
}
::-webkit-scrollbar{width:6px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:rgba(16,185,129,.15);border-radius:3px}
</style>
</head>
<body>
<div class="login-page">
    <!-- BG Effects -->
    <div class="mesh-bg">
        <div class="mesh-blob b1"></div>
        <div class="mesh-blob b2"></div>
        <div class="mesh-blob b3"></div>
        <div class="mesh-blob b4"></div>
    </div>
    <canvas id="particles"></canvas>
    <div class="grid-overlay"></div>

    <!-- Main Container -->
    <div class="login-container">
        <!-- Left: Brand -->
        <div class="brand-panel">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <div class="brand-logo">
                <span class="logo-k">K</span>
                <span class="logo-rest"><span>etik.in</span></span>
                <span class="logo-cursor">|</span>
            </div>
            <div class="brand-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Platform AI Terlengkap
            </div>
            <div class="brand-tagline">Buat Konten Lebih Cepat.<br><span class="highlight">Lebih Profesional.</span></div>
            <p class="brand-desc">Platform AI serba bisa — tulis esai, e-book, story, laporan, surat dinas, SOP, copywriting, dan banyak lagi. Semua dalam satu tempat.</p>
            <div class="feature-pills">
                <div class="pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Story Telling
                </div>
                <div class="pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    E-book
                </div>
                <div class="pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Essay & Laporan
                </div>
                <div class="pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M16 3l-4 4-4-4"/></svg>
                    Copywriting
                </div>
                <div class="pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/><path d="M3 7l9 6 9-6"/></svg>
                    Surat & SOP
                </div>
                <div class="pill">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg>
                    AI Wizard
                </div>
            </div>
            <div class="stats-row">
                <div class="stat-item"><div class="stat-num">15+</div><div class="stat-label">Fitur AI</div></div>
                <div class="stat-item"><div class="stat-num">5+</div><div class="stat-label">Kategori</div></div>
                <div class="stat-item"><div class="stat-num">10K+</div><div class="stat-label">Konten Dibuat</div></div>
                <div class="stat-item"><div class="stat-num">99%</div><div class="stat-label">Kepuasan</div></div>
            </div>
            <div class="float-badge fb1"><span class="dot"></span> AI sedang aktif</div>
            <div class="float-badge fb2">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="#10b981" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Respon &lt; 3 detik
            </div>
        </div>

        <!-- Right: Form -->
        <div class="form-panel">
            <div class="form-header s1">
                <h1>Selamat Datang Kembali</h1>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            @if (session('status'))
            <div class="alert-toast success s2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                {{ session('status') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert-toast danger s2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate id="loginForm">
                @csrf
                <div class="input-group-k s2">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <svg class="icon-left" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="M22 7l-10 6L2 7"/></svg>
                        <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'has-error' : '' }}" required autofocus>
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="input-group-k s3">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <svg class="icon-left" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" class="{{ $errors->has('password') ? 'has-error' : '' }}" required>
                        <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Toggle password">
                            <svg id="eyeIco" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="options-row s4">
                    <label class="check-label"><input type="checkbox" name="remember"> Ingat saya</label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa sandi?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit s5" id="btnSubmit">
                    <span class="shimmer"></span>
                    <span class="btn-label">Masuk Sekarang →</span>
                    <span class="spinner"></span>
                </button>
            </form>

            <div class="register-row s6">Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></div>
        </div>
    </div>
</div>

<script>
// Toggle password
function togglePw(){
    const p=document.getElementById('password'),e=document.getElementById('eyeIco');
    const show=p.type==='password';
    p.type=show?'text':'password';
    e.innerHTML=show
        ?'<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        :'<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}

// Submit loading
document.getElementById('loginForm').addEventListener('submit',function(){
    const b=document.getElementById('btnSubmit');
    b.classList.add('loading');b.disabled=true;
});

// Particles
(function(){
    const c=document.getElementById('particles'),x=c.getContext('2d');
    let w,h,dots=[];
    function resize(){w=c.width=innerWidth;h=c.height=innerHeight}
    function init(){dots=[];for(let i=0;i<60;i++)dots.push({x:Math.random()*w,y:Math.random()*h,r:Math.random()*1.5+.5,dx:(Math.random()-.5)*.3,dy:(Math.random()-.5)*.3,o:Math.random()*.4+.15})}
    function draw(){x.clearRect(0,0,w,h);dots.forEach((d,i)=>{d.x+=d.dx;d.y+=d.dy;if(d.x<0||d.x>w)d.dx*=-1;if(d.y<0||d.y>h)d.dy*=-1;x.beginPath();x.arc(d.x,d.y,d.r,0,Math.PI*2);x.fillStyle=`rgba(16,185,129,${d.o})`;x.fill();for(let j=i+1;j<dots.length;j++){const e=dots[j],dist=Math.hypot(d.x-e.x,d.y-e.y);if(dist<120){x.beginPath();x.moveTo(d.x,d.y);x.lineTo(e.x,e.y);x.strokeStyle=`rgba(16,185,129,${.07*(1-dist/120)})`;x.stroke()}}});requestAnimationFrame(draw)}
    resize();init();draw();
    addEventListener('resize',()=>{resize();init()});
})();

// SweetAlert for errors
@if($errors->has('email'))
document.addEventListener('DOMContentLoaded',function(){
    Swal.fire({
        icon:'warning',
        title:'Perhatian',
        html:'<p style="margin:0">{{ $errors->first("email") }}</p>',
        confirmButtonText:'Mengerti',
        confirmButtonColor:'#10b981',
        allowOutsideClick:false,
        background:'#021a11',
        color:'#e6faf4'
    });
});
@endif
</script>
</body>
</html>
