<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border: 1px solid rgba(16,185,129,0.15) !important; box-shadow: 0 25px 50px -12px rgba(16,185,129,0.12);">
        <div class="card-status-top" style="height: 4px; border-radius: 24px 24px 0 0; background: linear-gradient(90deg, #10b981, #059669);"></div>
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <div class="avatar avatar-xl rounded-circle bg-green-lt shadow-sm mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"></path>
                    </svg>
                </div>
                <h2 class="h1 mb-2 fw-bold text-dark" style="font-size: 1.75rem;">Lupa Kata Sandi?</h2>
                <p class="text-secondary mb-4 small">Masukkan email Anda dan kami akan mengirimkan link untuk mereset kata sandi.</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat Email</label>
                    <input type="email" name="email" class="form-control border-2 @error('email') is-invalid @enderror" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus style="border-radius: 10px;">
                    @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-3" style="border-radius: 10px;">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="form-footer">
                    <button type="submit" class="btn w-100 fw-bold py-3 hover-lift" style="border-radius: 12px; font-size: 1rem; background: linear-gradient(135deg,#10b981,#059669); color: white; border: none; box-shadow: 0 4px 15px rgba(16,185,129,0.3);">
                        Kirim Link Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-secondary mt-4">
        Sudah ingat? <a href="{{ route('login') }}" style="color:#059669;" class="fw-bold ms-1">Kembali Login</a>
    </div>
</x-guest-layout>
