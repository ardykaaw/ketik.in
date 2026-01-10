<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative mx-auto" style="border-radius: 28px; background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.6); box-shadow: 0 25px 50px -12px rgba(35, 79, 112, 0.15); max-width: 450px;">
        <div class="card-status-top bg-primary" style="height: 4px; border-radius: 24px 24px 0 0;"></div>
        <div class="card-body p-4">
            <h2 class="h1 text-center mb-2 fw-bold text-dark" style="font-size: 1.75rem;">Mulai Sekarang</h2>
            <p class="text-center text-secondary mb-4 small">Daftar sekarang dan nikmati asisten menulis berbasis AI.</p>
            
            <form action="{{ route('register') }}" method="POST" autocomplete="off" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                        </span>
                        <input type="text" name="name" class="form-control border-2 @error('name') is-invalid @enderror" placeholder="Nama Anda" value="{{ old('name') }}" required autofocus style="border-radius: 10px;">
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Username Lynk.id (Untuk Verifikasi)</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-.5 .5" /><path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l.5 -.5" /></svg>
                        </span>
                        <input type="text" name="lynk_id" class="form-control border-2 @error('lynk_id') is-invalid @enderror" placeholder="Username Lynk.id Pembelian" value="{{ old('lynk_id') }}" required style="border-radius: 10px;">
                    </div>
                    <div class="form-text small text-muted">Isi dengan username Lynk.id yang Anda gunakan saat membeli akses Premium. Admin akan mencocokkan data ini.</div>
                    @error('lynk_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email</label>
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
                        </span>
                        <input type="email" name="email" class="form-control border-2 @error('email') is-invalid @enderror" placeholder="email@contoh.com" value="{{ old('email') }}" required style="border-radius: 10px;">
                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kata Sandi</label>
                    <div class="input-group input-group-flat">
                        <input type="password" id="password" name="password" class="form-control border-2 @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" autocomplete="off" required style="border-radius: 10px 0 0 10px;">
                        <span class="input-group-text border-2 border-start-0" style="border-radius: 0 10px 10px 0;">
                            <a href="javascript:void(0)" class="link-secondary" title="Tampilkan" onclick="togglePassword('password')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                            </a>
                        </span>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control border-2" placeholder="Ulangi kata sandi" autocomplete="off" required style="border-radius: 10px;">
                </div>

                <div class="mb-4">
                    <label class="form-check custom-checkbox">
                        <input type="checkbox" class="form-check-input" required />
                        <span class="form-check-label text-secondary small">Saya setuju dengan <a href="#" class="text-primary fw-bold">Syarat & Ketentuan</a>.</span>
                    </label>
                </div>

                <div class="form-footer mt-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow-sm hover-lift" style="border-radius: 12px; font-size: 1rem;">
                        Daftar Akun Baru
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus ms-2" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-secondary mt-4">
        Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary fw-bold ms-1">Masuk Saja</a>
    </div>

    @push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
    <style>
        .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1) !important;
        }
    </style>
    @endpush
</x-guest-layout>
