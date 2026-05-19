<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<title>Daftar — Ketik.in</title>
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

.reg-page{position:relative;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:1.5rem}

.mesh-bg{position:fixed;inset:0;z-index:0;overflow:hidden}
.mesh-blob{position:absolute;border-radius:50%;filter:blur(110px);opacity:.3;animation:blobMove 20s ease-in-out infinite alternate}
.mesh-blob.b1{width:650px;height:650px;background:#022c22;top:-15%;left:-15%;animation-duration:26s}
.mesh-blob.b2{width:500px;height:500px;background:#064e3b;bottom:-20%;right:-10%;animation-duration:20s;animation-delay:-5s}
.mesh-blob.b3{width:420px;height:420px;background:#10b981;top:35%;left:45%;opacity:.12;animation-duration:32s;animation-delay:-10s}
.mesh-blob.b4{width:320px;height:320px;background:#059669;top:5%;right:15%;animation-duration:22s;animation-delay:-8s;opacity:.15}
@keyframes blobMove{0%{transform:translate(0,0) scale(1)}25%{transform:translate(40px,-30px) scale(1.1)}50%{transform:translate(-20px,50px) scale(.95)}75%{transform:translate(30px,20px) scale(1.05)}100%{transform:translate(-40px,-40px) scale(1)}}

#particles{position:fixed;inset:0;z-index:1;pointer-events:none}
.grid-overlay{position:fixed;inset:0;z-index:1;background-image:linear-gradient(rgba(16,185,129,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(16,185,129,.02) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}

.reg-container{position:relative;z-index:10;display:flex;width:100%;max-width:1060px;min-height:600px;border-radius:24px;overflow:hidden;border:1px solid var(--border);background:var(--surface);backdrop-filter:blur(40px);-webkit-backdrop-filter:blur(40px);box-shadow:0 0 80px rgba(16,185,129,.08),0 40px 80px rgba(0,0,0,.5);animation:containerIn .8s cubic-bezier(.16,1,.3,1) forwards;opacity:0;transform:translateY(30px)}
@keyframes containerIn{to{opacity:1;transform:translateY(0)}}

/* Brand Panel */
.brand-panel{flex:0 0 340px;position:relative;display:flex;flex-direction:column;justify-content:center;padding:2.5rem 2rem;background:linear-gradient(160deg,rgba(2,44,34,0.9),rgba(6,78,59,0.7));border-right:1px solid rgba(16,185,129,.12);overflow:hidden}
.brand-panel::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 25% 65%,rgba(16,185,129,.14),transparent 65%)}
.brand-icon{width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;box-shadow:0 6px 24px rgba(16,185,129,.35);position:relative;z-index:2}
.brand-logo{display:flex;align-items:baseline;gap:0;margin-bottom:.4rem;position:relative;z-index:2}
.brand-logo .logo-k{font-size:2.8rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-.04em}
.brand-logo .logo-rest{font-size:1.5rem;font-weight:700;color:rgba(255,255,255,.85);margin-left:-2px;overflow:hidden}
.brand-logo .logo-rest span{display:inline-block;animation:typeIn 2s steps(8) forwards;max-width:0;overflow:hidden;white-space:nowrap}
.brand-logo .logo-cursor{color:var(--accent);animation:cursorBlink 1s step-end infinite;margin-left:1px;font-weight:300}
@keyframes typeIn{0%{max-width:0}100%{max-width:120px}}
@keyframes cursorBlink{0%,100%{opacity:0}50%{opacity:1}}
.brand-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.2);border-radius:20px;padding:4px 12px;font-size:.72rem;font-weight:600;color:#6ee7b7;letter-spacing:.06em;text-transform:uppercase;margin-bottom:1.25rem;position:relative;z-index:2}
.brand-tagline{font-size:1.35rem;font-weight:800;line-height:1.3;color:#fff;margin-bottom:.6rem;position:relative;z-index:2}
.brand-tagline .highlight{background:linear-gradient(135deg,#10b981,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.brand-desc{font-size:.82rem;color:var(--text-dim);line-height:1.7;margin-bottom:1.5rem;position:relative;z-index:2}
.feature-pills{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:1.5rem;position:relative;z-index:2}
.pill{display:flex;align-items:center;gap:5px;padding:4px 9px;background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.14);border-radius:20px;font-size:.7rem;color:#6ee7b7}
.stats-row{display:flex;gap:1.25rem;position:relative;z-index:2}
.stat-item{text-align:center}
.stat-num{font-size:1.25rem;font-weight:800;background:linear-gradient(135deg,#10b981,#6ee7b7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.stat-label{font-size:.62rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-top:2px}
.float-badge{position:absolute;display:flex;align-items:center;gap:8px;padding:7px 12px;background:rgba(2,22,14,.7);border:1px solid rgba(16,185,129,.15);border-radius:12px;font-size:.7rem;color:var(--text-dim);backdrop-filter:blur(12px);z-index:2}
.float-badge.fb1{bottom:2rem;right:1rem;animation:floatBadge 6s ease-in-out infinite}
.float-badge .dot{width:6px;height:6px;border-radius:50%;background:#10b981;box-shadow:0 0 8px #10b981}
@keyframes floatBadge{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}

/* Form Panel */
.form-panel{flex:1;display:flex;flex-direction:column;justify-content:center;padding:2.5rem 2.25rem;position:relative;background:rgba(1,12,8,.3);overflow-y:auto}
.form-header{margin-bottom:1.5rem}
.form-header h1{font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:.3rem}
.form-header p{font-size:.83rem;color:var(--text-dim)}

.input-group-k{position:relative;margin-bottom:1rem}
.input-group-k label{display:block;font-size:.72rem;font-weight:600;color:var(--text-dim);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.4rem;transition:color .3s}
.input-group-k:focus-within label{color:var(--accent)}
.input-hint{font-size:.68rem;color:var(--text-muted);margin-top:.3rem}
.input-wrap{position:relative;display:flex;align-items:center}
.input-wrap .icon-left{position:absolute;left:13px;color:var(--text-muted);transition:color .3s;pointer-events:none;z-index:2}
.input-wrap:focus-within .icon-left{color:var(--accent)}
.input-wrap input{width:100%;height:48px;padding:0 13px 0 42px;background:rgba(16,185,129,.04);border:1.5px solid rgba(16,185,129,.12);border-radius:var(--radius);color:var(--text);font-size:.875rem;font-family:var(--font);outline:none;transition:all .3s cubic-bezier(.4,0,.2,1)}
.input-wrap input:focus{border-color:var(--border-focus);background:rgba(16,185,129,.06);box-shadow:0 0 0 4px var(--accent-glow)}
.input-wrap input::placeholder{color:var(--text-muted)}
.input-wrap input.has-error{border-color:var(--danger)}
.input-wrap .toggle-pw{position:absolute;right:12px;background:none;border:none;color:var(--text-muted);cursor:pointer;padding:5px;border-radius:8px;transition:all .2s;z-index:2}
.input-wrap .toggle-pw:hover{color:var(--accent);background:rgba(16,185,129,.08)}
.field-error{font-size:.72rem;color:var(--danger);margin-top:.35rem}

.check-label{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.8rem;color:var(--text-dim);margin-bottom:1.25rem}
.check-label input[type=checkbox]{width:15px;height:15px;accent-color:var(--accent);cursor:pointer}
.check-label a{color:var(--accent);font-weight:600;text-decoration:none}

.btn-submit{position:relative;width:100%;height:50px;border:none;border-radius:var(--radius);background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:.92rem;font-weight:700;font-family:var(--font);cursor:pointer;overflow:hidden;transition:all .3s cubic-bezier(.4,0,.2,1);box-shadow:0 4px 20px rgba(16,185,129,.3)}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 8px 32px rgba(16,185,129,.42)}
.btn-submit:active{transform:translateY(0)}
.btn-submit .shimmer{position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.15),transparent);transition:left .6s}
.btn-submit:hover .shimmer{left:100%}
.btn-submit:disabled{opacity:.6;cursor:not-allowed;transform:none}
.btn-submit .spinner{display:none;width:20px;height:20px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite}
.btn-submit.loading .btn-label{display:none}
.btn-submit.loading .spinner{display:inline-block}
@keyframes spin{to{transform:rotate(360deg)}}

.login-row{text-align:center;margin-top:1.25rem;font-size:.83rem;color:var(--text-dim)}
.login-row a{color:var(--accent);font-weight:700;text-decoration:none;transition:all .2s}
.login-row a:hover{color:#6ee7b7}

.two-col{display:grid;grid-template-columns:1fr 1fr;gap:0 1rem}

.s1{animation:fadeUp .5s ease forwards;opacity:0}
.s2{animation:fadeUp .5s ease .06s forwards;opacity:0}
.s3{animation:fadeUp .5s ease .12s forwards;opacity:0}
.s4{animation:fadeUp .5s ease .18s forwards;opacity:0}
.s5{animation:fadeUp .5s ease .24s forwards;opacity:0}
.s6{animation:fadeUp .5s ease .30s forwards;opacity:0}
.s7{animation:fadeUp .5s ease .36s forwards;opacity:0}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}

@media(max-width:900px){
.reg-container{flex-direction:column;max-width:480px;min-height:auto}
.brand-panel{display:none}
.form-panel{padding:2rem 1.5rem}
.two-col{grid-template-columns:1fr}
}
::-webkit-scrollbar{width:5px}
::-webkit-scrollbar-thumb{background:rgba(16,185,129,.15);border-radius:3px}
</style>
</head>
<body>
<div class="reg-page">
    <div class="mesh-bg">
        <div class="mesh-blob b1"></div>
        <div class="mesh-blob b2"></div>
        <div class="mesh-blob b3"></div>
        <div class="mesh-blob b4"></div>
    </div>
    <canvas id="particles"></canvas>
    <div class="grid-overlay"></div>

    <div class="reg-container">
        <!-- Left: Brand -->
        <div class="brand-panel">
            <div class="brand-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <div class="brand-logo">
                <span class="logo-k">K</span>
                <span class="logo-rest"><span>etik.in</span></span>
                <span class="logo-cursor">|</span>
            </div>
            <div class="brand-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Platform AI Terlengkap
            </div>
            <div class="brand-tagline">Buat Konten Lebih Cepat.<br><span class="highlight">Lebih Profesional.</span></div>
            <p class="brand-desc">Platform AI serba bisa — tulis esai, e-book, story, laporan, surat dinas, SOP, copywriting, dan banyak lagi.</p>
            <div class="feature-pills">
                <div class="pill"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg> Story Telling</div>
                <div class="pill"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg> E-book</div>
                <div class="pill"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16"/><polyline points="14 2 14 8 20 8"/></svg> Essay & Laporan</div>
                <div class="pill"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"/><path d="M3 7l9 6 9-6"/></svg> Surat & SOP</div>
                <div class="pill"><svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg> AI Wizard</div>
            </div>
            <div class="stats-row">
                <div class="stat-item"><div class="stat-num">15+</div><div class="stat-label">Fitur AI</div></div>
                <div class="stat-item"><div class="stat-num">10K+</div><div class="stat-label">Konten Dibuat</div></div>
                <div class="stat-item"><div class="stat-num">99%</div><div class="stat-label">Kepuasan</div></div>
            </div>
            <div class="float-badge fb1"><span class="dot"></span> Daftar gratis sekarang</div>
        </div>

        <!-- Right: Form -->
        <div class="form-panel">
            <div class="form-header s1">
                <h1>Buat Akun Baru ✨</h1>
                <p>Daftar dan mulai buat konten AI berkualitas dalam hitungan detik.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" autocomplete="off" novalidate id="regForm">
                @csrf
                <div class="two-col">
                    <div class="input-group-k s2">
                        <label>Nama Lengkap</label>
                        <div class="input-wrap">
                            <svg class="icon-left" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>
                            <input type="text" name="name" placeholder="Nama sesuai Lynk.id" value="{{ old('name') }}" class="{{ $errors->has('name') ? 'has-error' : '' }}" required autofocus>
                        </div>
                        <div class="input-hint">Sesuai akun Lynk.id Anda</div>
                        @error('name')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="input-group-k s2">
                        <label>No. Telepon</label>
                        <div class="input-wrap">
                            <svg class="icon-left" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2"/></svg>
                            <input type="tel" name="phone" id="phone" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" class="{{ $errors->has('phone') ? 'has-error' : '' }}" required pattern="[0-9+]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9+]/g,'')">
                        </div>
                        <div class="input-hint">Sesuai akun Lynk.id</div>
                        @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="input-group-k s3">
                    <label>Email</label>
                    <div class="input-wrap">
                        <svg class="icon-left" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="M22 7l-10 6L2 7"/></svg>
                        <input type="email" name="email" placeholder="Email sesuai akun Lynk.id" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'has-error' : '' }}" required>
                    </div>
                    <div class="input-hint">Gunakan email yang terdaftar di Lynk.id</div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="two-col">
                    <div class="input-group-k s4">
                        <label>Kata Sandi</label>
                        <div class="input-wrap">
                            <svg class="icon-left" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input type="password" id="password" name="password" placeholder="Min. 8 karakter" class="{{ $errors->has('password') ? 'has-error' : '' }}" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('password','eyePw')" aria-label="Toggle">
                                <svg id="eyePw" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="input-group-k s4">
                        <label>Konfirmasi Sandi</label>
                        <div class="input-wrap">
                            <svg class="icon-left" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','eyeCnf')" aria-label="Toggle">
                                <svg id="eyeCnf" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <label class="check-label s5">
                    <input type="checkbox" required>
                    Saya setuju dengan <a href="#">Syarat & Ketentuan</a> Ketik.in
                </label>

                <button type="submit" class="btn-submit s6" id="btnReg">
                    <span class="shimmer"></span>
                    <span class="btn-label">Buat Akun Sekarang →</span>
                    <span class="spinner"></span>
                </button>
            </form>

            <div class="login-row s7">Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a></div>
        </div>
    </div>
</div>

<script>
function togglePw(id, iconId) {
    const p = document.getElementById(id), e = document.getElementById(iconId);
    const show = p.type === 'password';
    p.type = show ? 'text' : 'password';
    e.innerHTML = show
        ? '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
        : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
}

document.getElementById('regForm').addEventListener('submit', function() {
    const b = document.getElementById('btnReg');
    b.classList.add('loading'); b.disabled = true;
});

(function(){
    const c=document.getElementById('particles'),x=c.getContext('2d');
    let w,h,dots=[];
    function resize(){w=c.width=innerWidth;h=c.height=innerHeight}
    function init(){dots=[];for(let i=0;i<60;i++)dots.push({x:Math.random()*w,y:Math.random()*h,r:Math.random()*1.5+.5,dx:(Math.random()-.5)*.3,dy:(Math.random()-.5)*.3,o:Math.random()*.4+.15})}
    function draw(){x.clearRect(0,0,w,h);dots.forEach((d,i)=>{d.x+=d.dx;d.y+=d.dy;if(d.x<0||d.x>w)d.dx*=-1;if(d.y<0||d.y>h)d.dy*=-1;x.beginPath();x.arc(d.x,d.y,d.r,0,Math.PI*2);x.fillStyle=`rgba(16,185,129,${d.o})`;x.fill();for(let j=i+1;j<dots.length;j++){const e=dots[j],dist=Math.hypot(d.x-e.x,d.y-e.y);if(dist<120){x.beginPath();x.moveTo(d.x,d.y);x.lineTo(e.x,e.y);x.strokeStyle=`rgba(16,185,129,${.07*(1-dist/120)})`;x.stroke()}}});requestAnimationFrame(draw)}
    resize();init();draw();
    addEventListener('resize',()=>{resize();init()});
})();

@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Periksa Form',
        html: '<p style="margin:0">{{ $errors->first() }}</p>',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#10b981',
        background: '#021a11',
        color: '#e6faf4'
    });
});
@endif
</script>
</body>
</html>
