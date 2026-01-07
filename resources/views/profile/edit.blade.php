<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row items-center mb-5">
            <div class="col">
                <h1 class="display-5 fw-bold mb-1">Pengaturan Akun</h1>
                <p class="text-secondary fs-3">Kelola informasi profil, keamanan, dan akun Anda.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Profile Information -->
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3 class="fw-bold fs-2 mb-2">Informasi Profil</h3>
                                <p class="text-muted small mb-4">Perbarui informasi dasar akun dan alamat email Anda.</p>
                            </div>
                            <div class="col-lg-8">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3 class="fw-bold fs-2 mb-2">Keamanan Kata Sandi</h3>
                                <p class="text-muted small mb-4">Pastikan akun Anda menggunakan kata sandi yang kuat dan unik.</p>
                            </div>
                            <div class="col-lg-8">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="col-12">
                <div class="card border-0 shadow-sm border-danger-subtle" style="border-radius: 20px; border-left: 4px solid #d63939 !important;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3 class="fw-bold fs-2 text-danger mb-2">Hapus Akun</h3>
                                <p class="text-muted small mb-4">Setelah akun dihapus, semua data akan hilang secara permanen. Mohon berhati-hati.</p>
                            </div>
                            <div class="col-lg-8">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles to bridge Tailwind forms with Tabler dashboard -->
    <style>
        .form-control, input[type="text"], input[type="email"], input[type="password"] {
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 0.6rem 1rem !important;
        }
        .btn-primary, button[type="submit"]:not(.btn-danger) {
            background-color: #3b82f6 !important;
            border: none !important;
            padding: 0.6rem 1.5rem !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            color: white !important;
        }
        .btn-danger, button.bg-red-600 {
            background-color: #d63939 !important;
            border: none !important;
            padding: 0.6rem 1.5rem !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            color: white !important;
        }
        label, .form-label {
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
            color: #475569 !important;
        }
    </style>
</x-dashboard-layout>
