<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-5">
                    <h1 class="display-5 fw-bold mb-1">Langganan & Pembayaran</h1>
                    <p class="text-secondary fs-3">Kelola paket Anda dan pantau riwayat transaksi.</p>
                </div>

                <!-- Current Plan -->
                <div class="card border-0 shadow-lg text-white mb-5" style="border-radius: 24px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); overflow: hidden;">
                    <div class="card-body p-4 p-md-5 position-relative">
                        <div class="position-absolute top-0 end-0 p-5 mt-n4 me-n4 opacity-10 d-none d-sm-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="200" height="200" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg>
                        </div>
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-md">
                                <span class="badge {{ $user->isPremium() ? 'bg-green' : 'bg-danger' }} text-white mb-3 p-2 px-3 fw-bold" style="border-radius: 10px;">
                                    {{ $user->isPremium() ? 'PAKET AKTIF' : 'MASA AKTIF HABIS' }}
                                </span>
                                <h1 class="h1 h-md-display-3 fw-bold mb-1 text-light" style="word-break: break-word;">{{ $user->plan_name ?? 'Free Plan' }}</h1>
                                <p class="fs-3 opacity-75 mb-0">
                                    @if($user->isPremium())
                                        Akses tak terbatas ke semua fitur AI hingga <strong>{{ $user->premium_until->format('d M Y') }}</strong>.
                                    @else
                                        Masa langganan Anda telah berakhir. Perbarui sekarang untuk lanjut berkarya.
                                    @endif
                                </p>
                            </div>
                            <div class="col-12 col-md-auto text-md-end border-top border-white-1 pt-3 pt-md-0 border-md-0">
                                <div class="mb-0">
                                    <div class="h2 fw-bold mb-0 text-light">Rp 99.000</div>
                                    <div class="small opacity-50 mb-2">Per 30 Hari (E-Wallet)</div>
                                </div>
                                <div class="bg-white-1 opacity-75 small p-2 rounded border border-white-1 px-3 d-inline-block">
                                    Hubungi Admin untuk Perpanjangan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-7">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-3">Keuntungan Premium</h3>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                            Semua Fitur AI
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                            Tanpa Batas Kata
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                            Ekspor PDF Premium
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                            Prioritas Support
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-3">Metode Pembayaran</h3>
                                <div class="d-flex gap-2 flex-wrap align-items-center">
                                    <div class="px-2 py-1 border rounded bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 32px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="px-2 py-1 border rounded bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 70px; height: 32px;">
                                        <img src="{{ asset('img/Dana_logo.png') }}" alt="DANA" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="px-2 py-1 border rounded bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 32px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg" alt="OVO" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                    <div class="px-2 py-1 border rounded bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 70px; height: 32px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                    </div>
                                </div>
                                <p class="text-muted small mt-3 m-0">Gunakan QRIS atau E-Wallet pilihan Anda untuk pembayaran instan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Riwayat Transaksi</h3>
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Paket</th>
                                        <th>Metode</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $historyCount = $user->isPremium() ? 1 : 0;
                                    @endphp
                                    @if($historyCount > 0)
                                    <tr>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>Ketik.in Premium - 30 Hari</td>
                                        <td>E-Wallet</td>
                                        <td class="fw-bold">Rp 99.000</td>
                                        <td><span class="badge bg-green-lt fw-bold">Berhasil</span></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
