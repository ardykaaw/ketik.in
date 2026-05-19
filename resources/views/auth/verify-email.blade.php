<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255,255,255,0.85); backdrop-filter: blur(10px); border: 1px solid rgba(16,185,129,0.15) !important; box-shadow: 0 25px 50px -12px rgba(16,185,129,0.12);">
        <div class="card-status-top" style="height: 4px; border-radius: 24px 24px 0 0; background: linear-gradient(90deg,#10b981,#059669);"></div>
        <div class="card-body p-5">
            <h2 class="h1 text-center mb-2 fw-bold text-dark" style="font-size: 1.75rem;">Verifikasi Email</h2>
            <p class="text-center text-secondary mb-4 small">
                {{ __('Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengeklik tautan yang baru saja kami kirimkan.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success shadow-sm mb-4" style="border-radius: 12px;">
                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
                </div>
            @endif

            <div class="d-flex flex-column gap-3 mt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn w-100 fw-bold py-3 hover-lift" style="border-radius: 12px; background: linear-gradient(135deg,#10b981,#059669); color: white; border: none; box-shadow: 0 4px 15px rgba(16,185,129,0.3);">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="btn btn-link text-secondary fw-bold small">
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
