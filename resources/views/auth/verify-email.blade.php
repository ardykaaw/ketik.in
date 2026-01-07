<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <div class="card-status-top bg-primary" style="height: 4px; border-radius: 24px 24px 0 0;"></div>
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
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow-sm hover-lift" style="border-radius: 12px;">
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
