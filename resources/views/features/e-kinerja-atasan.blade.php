<x-dashboard-layout>
    <div class="container-xl py-6">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0" style="border-radius: 24px; border-top: 6px solid #f59f00 !important; background: #fff;">
                    <div class="card-body p-5">
                        <div class="row align-items-center mb-5">
                            <div class="col">
                                <span class="badge bg-orange-lt mb-2 px-3 py-1">Mode Atasan / Penilai</span>
                                <h1 class="fw-bold mb-1" style="font-size: 2rem;">Ekspektasi & Umpan Balik</h1>
                                <p class="text-muted fs-4">Asisten AI untuk menyusun Ekspektasi Khusus Pimpinan dan Feedback berkelanjutan.</p>
                            </div>
                            <div class="col-auto">
                                <div class="avatar bg-orange-lt shadow-sm" style="width: 70px; height: 70px; border-radius: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="36" height="36" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('feature.e-kinerja-atasan.generate') }}" method="POST" id="ekinerjaAtasanForm" onsubmit="submitBtn.disabled = true; loader.classList.remove('d-none'); btnText.classList.add('d-none');">
                            @csrf
                            
                            <!-- Bagian 1: Data Atasan (Saya) -->
                            <div class="mb-5">
                                <h3 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="badge bg-orange text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">1</span>
                                    Identitas Penilai (Anda)
                                </h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap & Gelar</label>
                                        <input type="text" name="atasan_nama" class="form-control border-2" placeholder="Nama Anda" value="{{ Auth::user()->name }}" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <input type="text" name="atasan_jabatan" class="form-control border-2" placeholder="Jabatan Anda" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Unit Kerja</label>
                                        <input type="text" name="atasan_unit" class="form-control border-2" placeholder="Unit Kerja Anda" required style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5" style="opacity: 0.1;">

                            <!-- Bagian 2: Data Bawahan -->
                            <div class="mb-5">
                                <h3 class="fw-bold mb-3 d-flex align-items-center">
                                    <span class="badge bg-orange text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">2</span>
                                    Identitas Bawahan (Dinilai)
                                </h3>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Bawahan</label>
                                        <input type="text" name="bawahan_nama" class="form-control border-2" placeholder="Nama Bawahan" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan Bawahan</label>
                                        <input type="text" name="bawahan_jabatan" class="form-control border-2" placeholder="Jabatan Bawahan" required style="border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5" style="opacity: 0.1;">

                            <!-- Bagian 3: Tugas Pokok Bawahan -->
                            <div class="mb-5">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="fw-bold mb-0 d-flex align-items-center">
                                        <span class="badge bg-orange text-white me-2" style="width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">3</span>
                                        Tugas Pokok Bawahan
                                    </h3>
                                    <button type="button" class="btn btn-orange btn-sm fw-bold shadow-sm" onclick="addTask()" style="border-radius: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                        Tambah Tugas
                                    </button>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Periode Penilaian</label>
                                        <select name="periode" class="form-select border-2" style="border-radius: 10px; padding: 12px;">
                                            <option value="Tahun 2026">Tahun 2026 (SKP Tahunan)</option>
                                            <option value="Triwulan I (Jan - Mar)">Triwulan I (Jan - Mar)</option>
                                            <option value="Triwulan II (Apr - Jun)">Triwulan II (Apr - Jun)</option>
                                            <option value="Triwulan III (Jul - Sep)">Triwulan III (Jul - Sep)</option>
                                            <option value="Triwulan IV (Okt - Des)">Triwulan IV (Okt - Des)</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="task_container">
                                    <div class="task-item card p-4 border-2 mb-3 shadow-sm" style="border-radius: 16px; border-left: 5px solid #f59f00 !important; background: #f8fafc;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-orange-lt px-3">Tugas #1</span>
                                            <button type="button" class="btn btn-link text-danger p-0 d-none remove-task-btn" onclick="removeTask(this)">Hapus</button>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold">Deskripsi Tugas Pokok / RHK Bawahan</label>
                                                <textarea name="tugas_pokok[]" class="form-control border-2 bg-white" rows="2" placeholder="Apa tugas utama atau RHK yang dinilai?" style="border-radius: 10px;" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-footer pt-3">
                                <button type="submit" class="btn btn-warning w-100 py-3 fs-3 fw-bold shadow-lg hover-lift" id="submitBtn" style="border-radius: 16px; color: white;">
                                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader"></span>
                                    <span id="btnText" class="d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bulb me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12h1m8 -9v1m8 8h1m-15.4 -6.4l.7 .7m12.1 -.7l-.7 .7" /><path d="M9 16a5 5 0 1 1 6 0a3.5 3.5 0 0 0 -1 3a2 2 0 0 1 -4 0a3.5 3.5 0 0 0 -1 -3" /><path d="M9.7 17l4.6 0" /></svg>
                                        Susun Ekspektasi & Feedback
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let taskCount = 1;
        const container = document.getElementById('task_container');

        function addTask() {
            taskCount++;
            const newTask = document.createElement('div');
            newTask.className = 'task-item card p-4 border-2 mb-3 shadow-sm';
            newTask.style = 'border-radius: 16px; border-left: 5px solid #f59f00 !important; background: #f8fafc;';
            newTask.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-orange-lt px-3">Tugas #${taskCount}</span>
                    <button type="button" class="btn btn-link text-danger p-0 remove-task-btn" onclick="removeTask(this)">Hapus</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi Tugas Pokok / RHK Bawahan</label>
                        <textarea name="tugas_pokok[]" class="form-control border-2 bg-white" rows="2" placeholder="Apa tugas utama atau RHK yang dinilai?" style="border-radius: 10px;" required></textarea>
                    </div>
                </div>
            `;
            container.appendChild(newTask);
            updateRemoveButtons();
        }

        function removeTask(btn) {
            btn.closest('.task-item').remove();
            updateRemoveButtons();
            reindexTasks();
        }

        function updateRemoveButtons() {
            const btns = document.querySelectorAll('.remove-task-btn');
            const items = document.querySelectorAll('.task-item');
            btns.forEach(btn => {
                if (items.length > 1) {
                    btn.classList.remove('d-none');
                } else {
                    btn.classList.add('d-none');
                }
            });
        }

        function reindexTasks() {
            const items = document.querySelectorAll('.task-item');
            items.forEach((item, index) => {
                item.querySelector('.badge').innerText = `Tugas #${index + 1}`;
            });
            taskCount = items.length;
        }
    </script>
    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
    </style>
</x-dashboard-layout>
