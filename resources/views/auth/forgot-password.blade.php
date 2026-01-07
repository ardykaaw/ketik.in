<x-guest-layout>
    <div class="card card-md border-0 shadow-lg position-relative" style="border-radius: 24px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <div class="card-status-top bg-primary" style="height: 4px; border-radius: 24px 24px 0 0;"></div>
        <div class="card-body p-5 text-center">
            <div class="mb-4">
                <div class="avatar avatar-xl rounded-circle bg-green-lt shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp text-green" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                        <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                    </svg>
                </div>
            </div>
            <h2 class="h1 mb-2 fw-bold text-dark" style="font-size: 1.75rem;">Lupa Kata Sandi?</h2>
            <p class="text-secondary mb-4">
                Jangan khawatir! Silakan hubungi Admin melalui WhatsApp untuk memulihkan akses akun Anda secara manual.
            </p>

            <div class="mt-4">
                <a href="https://wa.me/6285751295471?text=Halo%20Admin%20Ketik.in,%20saya%20lupa%20kata%20sandi%20akun%20saya.%20Mohon%20bantuannya." 
                   target="_blank" 
                   class="btn btn-green w-100 fw-bold py-3 shadow-sm hover-lift" 
                   style="border-radius: 12px; font-size: 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                        <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                    </svg>
                    Hubungi Admin (WhatsApp)
                </a>
            </div>
        </div>
    </div>
    <div class="text-center text-secondary mt-4">
        Sudah ingat? <a href="{{ route('login') }}" class="text-primary fw-bold ms-1">Kembali Login</a>
    </div>
</x-guest-layout>
