<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255,255,255,0.85); backdrop-filter: blur(10px); border: 1px solid rgba(16,185,129,0.15) !important; box-shadow: 0 25px 50px -12px rgba(16,185,129,0.12);">
        <div class="card-status-top" style="height: 4px; border-radius: 24px 24px 0 0; background: linear-gradient(90deg,#10b981,#059669);"></div>
        <div class="card-body p-5">
            <h2 class="h1 text-center mb-2 fw-bold text-dark" style="font-size: 1.75rem;">Konfirmasi Sandi</h2>
            <p class="text-center text-secondary mb-4 small">
                {{ __('Ini adalah area aman aplikasi. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.') }}
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control border-2 @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi Anda" required autocomplete="current-password" style="border-radius: 10px;">
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer mt-4">
                    <button type="submit" class="btn w-100 fw-bold py-3 hover-lift" style="border-radius: 12px; font-size: 1rem; background: linear-gradient(135deg,#10b981,#059669); color: white; border: none; box-shadow: 0 4px 15px rgba(16,185,129,0.3);">
                        {{ __('Konfirmasi Akun') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
