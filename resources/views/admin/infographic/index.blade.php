<x-admin-layout>
    <div class="container-xl py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">🎨 Generator Infografis AI</h1>
                <p class="text-muted mb-0">Buat infografis profesional dengan AI Gemini</p>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 14px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row g-4">
            {{-- Form --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0" style="border-radius: 20px; position: sticky; top: 20px;">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Buat Infografis Baru</h3>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Topik Infografis <span class="text-danger">*</span></label>
                            <input type="text" id="inp-topik" class="form-control border-2" placeholder="Contoh: 5 Tips Menulis Copywriting" style="border-radius: 12px;" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Jenis Infografis</label>
                            <select id="inp-jenis" class="form-select border-2" style="border-radius: 12px;">
                                <option value="tips">Tips & Trik</option>
                                <option value="statistik">Statistik & Data</option>
                                <option value="proses">Langkah/Proses</option>
                                <option value="perbandingan">Perbandingan</option>
                                <option value="timeline">Timeline</option>
                                <option value="fakta">Fakta Menarik</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Poin-poin (opsional, satu per baris)</label>
                            <textarea id="inp-poin" class="form-control border-2" rows="4" placeholder="Tulis poin-poin utama..." style="border-radius: 12px;"></textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small">Warna</label>
                                <select id="inp-warna" class="form-select border-2" style="border-radius: 12px;">
                                    <option value="blue">Biru</option>
                                    <option value="purple">Ungu</option>
                                    <option value="green">Hijau</option>
                                    <option value="orange">Oranye</option>
                                    <option value="red">Merah</option>
                                    <option value="dark">Gelap</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">Gaya Desain</label>
                                <select id="inp-gaya" class="form-select border-2" style="border-radius: 12px;">
                                    <option value="modern">Modern</option>
                                    <option value="bold">Bold / Tebal</option>
                                    <option value="minimal">Minimalis</option>
                                    <option value="corporate">Korporat</option>
                                </select>
                            </div>
                        </div>

                        <button type="button" id="btn-generate" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 12px;" onclick="generateInfographic()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.347a3.75 3.75 0 0 1-5.303 0l-.347-.347z"/></svg>
                            Generate Infografis
                        </button>

                        {{-- Loading --}}
                        <div id="loading-state" class="text-center py-4 d-none">
                            <div class="spinner-border text-primary mb-2" role="status"></div>
                            <p class="text-muted fw-semibold mb-0">AI sedang membuat infografis...</p>
                            <p class="text-muted small" id="loading-timer">Estimasi 15–60 detik</p>
                        </div>

                        {{-- Error --}}
                        <div id="error-state" class="alert alert-danger mt-3 d-none" style="border-radius: 14px;">
                            <strong>Gagal Generate</strong>
                            <p class="mb-0 small" id="error-msg"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Result + Gallery --}}
            <div class="col-lg-7">
                {{-- Latest Result --}}
                <div id="result-card" class="card shadow-sm border-0 mb-4 d-none" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-0">
                        <h3 class="fw-bold mb-0">Hasil Generate</h3>
                        <div class="d-flex gap-2">
                            <button onclick="generateInfographic()" class="btn btn-sm btn-outline-secondary" style="border-radius: 8px;">Regenerate</button>
                            <a id="btn-download" href="#" download="infografis.png" class="btn btn-sm btn-primary" style="border-radius: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <img id="result-img" src="" alt="Infografis" class="w-100" style="border-radius: 14px;">
                    </div>
                </div>

                {{-- Gallery --}}
                <h3 class="fw-bold mb-3">Galeri Infografis ({{ $infographics->count() }})</h3>
                @if($infographics->isEmpty())
                    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-body text-center py-5">
                            <div class="mb-3 text-muted" style="opacity: 0.3;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <h4 class="fw-bold text-muted">Belum ada infografis</h4>
                            <p class="text-muted small">Generate infografis pertama Anda menggunakan form di samping.</p>
                        </div>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($infographics as $img)
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                                <a href="{{ $img['url'] }}" target="_blank">
                                    <img src="{{ $img['url'] }}" alt="{{ $img['name'] }}" class="w-100" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold small text-truncate" style="max-width: 180px;">{{ $img['name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $img['size'] }} KB &middot; {{ $img['date'] }}</div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <a href="{{ $img['url'] }}" download class="btn btn-sm btn-ghost-primary p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            </a>
                                            <form action="{{ route('admin.infographic.destroy') }}" method="POST" class="delete-form" data-name="{{ $img['name'] }}">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="path" value="{{ $img['path'] }}">
                                                <button type="submit" class="btn btn-sm btn-ghost-danger p-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let timerInterval = null;
        let seconds = 0;

        async function generateInfographic() {
            const topik = document.getElementById('inp-topik').value.trim();
            if (!topik) { alert('Topik wajib diisi!'); return; }

            const btn = document.getElementById('btn-generate');
            const loading = document.getElementById('loading-state');
            const errorState = document.getElementById('error-state');
            const resultCard = document.getElementById('result-card');

            btn.disabled = true;
            loading.classList.remove('d-none');
            errorState.classList.add('d-none');
            resultCard.classList.add('d-none');

            seconds = 0;
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                seconds++;
                document.getElementById('loading-timer').textContent = `Sudah ${seconds} detik...`;
            }, 1000);

            try {
                const res = await fetch('{{ route("admin.infographic.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        topik: topik,
                        jenis: document.getElementById('inp-jenis').value,
                        poin: document.getElementById('inp-poin').value,
                        warna: document.getElementById('inp-warna').value,
                        gaya: document.getElementById('inp-gaya').value,
                    })
                });

                const contentType = res.headers.get('content-type') || '';
                let data;
                if (contentType.includes('application/json')) {
                    data = await res.json();
                } else {
                    const text = await res.text();
                    console.error('Server returned HTML (non-JSON):', text.substring(0, 500));
                    throw new Error('Server mengembalikan error (cek console untuk detail). Status: ' + res.status);
                }

                if (!res.ok || data.error) throw new Error(data.error || 'HTTP ' + res.status);

                document.getElementById('result-img').src = data.url;
                document.getElementById('btn-download').href = data.url;
                resultCard.classList.remove('d-none');

            } catch (e) {
                document.getElementById('error-msg').textContent = e.message;
                errorState.classList.remove('d-none');
            } finally {
                clearInterval(timerInterval);
                loading.classList.add('d-none');
                btn.disabled = false;
            }
        }

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus?',
                    text: `Hapus infografis: ${this.dataset.name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d63939',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(r => { if (r.isConfirmed) this.submit(); });
            });
        });
    </script>
    @endpush
</x-admin-layout>
