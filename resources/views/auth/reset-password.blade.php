<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <div class="card-status-top bg-primary" style="height: 4px; border-radius: 24px 24px 0 0;"></div>
        <div class="card-body p-5">
            <h2 class="h1 text-center mb-2 fw-bold text-dark" style="font-size: 1.75rem;">Atur Ulang Sandi</h2>
            <p class="text-center text-secondary mb-4 small">Buat kata sandi baru untuk akun Ketik.in Anda.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email</label>
                    <input type="email" name="email" class="form-control border-2 @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required readonly style="border-radius: 10px; background-color: #f8fafc;">
                    @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Kata Sandi Baru</label>
                    <div class="input-group input-group-flat">
                        <input type="password" id="password" name="password" class="form-control border-2 @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required style="border-radius: 10px 0 0 10px;">
                        <span class="input-group-text border-2 border-start-0" style="border-radius: 0 10px 10px 0;">
                            <a href="javascript:void(0)" class="link-secondary" title="Tampilkan" onclick="togglePassword('password')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                            </a>
                        </span>
                    </div>
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control border-2" placeholder="Ulangi kata sandi baru" required style="border-radius: 10px;">
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow-sm hover-lift" style="border-radius: 12px; font-size: 1rem;">
                        {{ __('Simpan Perubahan') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
    @endpush
</x-guest-layout>
