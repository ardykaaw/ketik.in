<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <div class="card-status-top bg-primary" style="height: 4px; border-radius: 24px 24px 0 0;"></div>
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
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow-sm hover-lift" style="border-radius: 12px; font-size: 1rem;">
                        {{ __('Konfirmasi Akun') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
