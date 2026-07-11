# BETA TESTING DATA - AI Queue Performance Fix

Gunakan data berikut untuk beta testing ke-3 fitur yang bermasalah.

---

## 📚 Test 1: Generate Modul Ajar (Heaviest)

**URL**: `/guru/modul` (Teacher Dashboard)

### Test Case 1A: Mathematics - Algebra (SMA)

```
Mata Pelajaran     : Matematika
Fase               : F (Fase F - SMA)
Kelas              : 10 (SMA Kelas 10)
Semester           : Ganjil
Topik              : Fungsi Kuadrat dan Aplikasinya dalam Kehidupan Sehari-hari
Alokasi Waktu      : 90 (menit per pertemuan)
Jumlah Pertemuan   : 4
Tahun Pelajaran    : 2024/2025
```

**Expected Output**: 
- Modul Ajar lengkap dengan:
  - Identitas Modul
  - Identifikasi Kesiapan Peserta Didik
  - Desain Pembelajaran (CP, Tujuan, Konteks)
  - 4 Pertemuan dengan fase: Memahami, Mengaplikasi, Merefleksi
  - LKPD untuk setiap pertemuan
  - Asesmen (Awal, Proses, Akhir)
  - Lampiran (Bahan Bacaan, Glosarium)

**Expected Duration**: 8-10 minutes

---

### Test Case 1B: Biology - Genetics (SMP)

```
Mata Pelajaran     : Ilmu Pengetahuan Alam (Biologi)
Fase               : D (Fase D - SMP)
Kelas              : 9 (SMP Kelas 9)
Semester           : Ganjil
Topik              : Mekanisme Hereditas dan Pola Pewarisan Sifat pada Manusia
Alokasi Waktu      : 120 (menit per pertemuan)
Jumlah Pertemuan   : 5
Tahun Pelajaran    : 2024/2025
```

**Expected Output**: 
- 5 Pertemuan pembelajaran mendalam dengan aktivitas praktis
- Integrasi kurikulum merdeka dengan pendekatan deep learning
- LKPD yang komprehensif

**Expected Duration**: 9-11 minutes

---

### Test Case 1C: Indonesian Language - Literature (SD)

```
Mata Pelajaran     : Bahasa Indonesia
Fase               : C (Fase C - SD Kelas 5-6)
Kelas              : 6
Semester           : Genap
Topik              : Memahami dan Menuliskan Cerita Fiksi Berdasarkan Pengalaman Pribadi
Alokasi Waktu      : 60 (menit per pertemuan)
Jumlah Pertemuan   : 3
Tahun Pelajaran    : 2024/2025
```

**Expected Output**: 
- Modul sesuai tingkat SD dengan bahasa yang sederhana
- Aktivitas pembelajaran yang menyenangkan untuk anak
- Asesmen yang sesuai usia

**Expected Duration**: 6-8 minutes

---

## 👔 Test 2: Generate E-Kinerja (SKP ASN)

**URL**: `/features/ekinerja` (Employee/ASN Dashboard)

### Test Case 2A: Guru ASN - Performance Evaluation

```
Nama Pegawai       : Siti Nurhaliza, S.Pd
NIP                : 197805152003122006
Golongan           : III/d
Jabatan            : Guru Mapel Matematika
Unit               : SMA Negeri 1 Jakarta
Nama Atasan        : Drs. Budi Santoso, M.Pd
Jabatan Atasan     : Kepala Sekolah
Periode            : Semester 1 Tahun Pelajaran 2024/2025

RHK (Rencana Hasil Kerja):
1. Melaksanakan pembelajaran matematika kurikulum merdeka 
2. Membuat 12 rencana pelaksanaan pembelajaran berkualitas tinggi
3. Mengadakan remedial untuk siswa yang nilainya di bawah KKM
4. Memfasilitasi ekstrakurikuler matematika (olimpiade)
5. Melakukan penilaian berkelanjutan sesuai kurikulum

Jenis RHK: Masalah, Output, Target
Jenis RHK untuk setiap item: Masalah (5x)

RHK Atasan (diisi sesuai urutan di atas):
1. Meningkatkan kualitas pembelajaran matematika dengan pendekatan inovatif
2. Menyiapkan bahan ajar yang sesuai kebutuhan siswa
3. Memberikan dukungan kepada siswa yang kesulitan belajar
4. Meningkatkan prestasi siswa dalam kompetisi akademik
5. Menggunakan instrumen penilaian yang valid dan andal
```

**Expected Output**:
- Tabel 1: Rencana Hasil Kinerja (RHK) dengan Indikator dan Target
- Tabel 2: Rencana Aksi minimal 5 aksi per RHK dengan Target Output dan Target Waktu
- Tabel 3: Perilaku Kerja Individu berdasarkan Core Value BerAKHLAK (7 nilai)
- Seluruh tabel dalam format Markdown yang rapi

**Expected Duration**: 6-8 minutes

---

### Test Case 2B: Aparatur Sipil - Bureaucrat Performance

```
Nama Pegawai       : Ahmad Wijaya, S.E
NIP                : 198702032009011003
Golongan           : III/b
Jabatan            : Kepala Bagian Administrasi
Unit               : Dinas Pendidikan Provinsi Jawa Barat
Nama Atasan        : Ir. Eka Sutrisna, M.Si
Jabatan Atasan     : Kepala Dinas Pendidikan
Periode            : Tahun 2024

RHK (Rencana Hasil Kerja):
1. Mengelola administrasi kepegawaian dengan sistem online terintegrasi
2. Memproses dokumen kepegawaian dalam waktu maksimal 3 hari kerja
3. Melaksanakan program pengembangan kompetensi pegawai
4. Membangun database kepegawaian yang akurat dan terdokumentasi
5. Meningkatkan ketepatan waktu pengiriman laporan ke pusat

Jenis RHK: Masalah (semuanya)

RHK Atasan:
1. Mengoptimalkan sistem administrasi kepegawaian
2. Meningkatkan efisiensi administratif di lingkungan Dinas
3. Memastikan pegawai memiliki kompetensi yang sesuai jabatan
4. Menjaga integritas data kepegawaian dan kepatuhan regulasi
5. Meningkatkan responsivitas administrasi terhadap kebutuhan
```

**Expected Output**: 
- 3 tabel lengkap SKP format resmi ASN
- Format professional untuk dokumen kedinasan

**Expected Duration**: 7-9 minutes

---

## 👨‍💼 Test 3: Generate E-Kinerja Atasan (Supervisor Feedback)

**URL**: `/features/ekinerja-atasan` (Supervisor Dashboard)

### Test Case 3A: Supervisor Feedback for Teacher

```
Nama Atasan        : Drs. Budi Santoso, M.Pd
Jabatan Atasan     : Kepala Sekolah
Unit Atasan        : SMA Negeri 1 Jakarta

Nama Bawahan       : Siti Nurhaliza, S.Pd
Jabatan Bawahan    : Guru Mapel Matematika

Periode            : Semester 1 Tahun Pelajaran 2024/2025

Tugas Pokok Bawahan:
1. Merencanakan dan melaksanakan pembelajaran matematika sesuai kurikulum
2. Mengevaluasi hasil belajar siswa secara berkelanjutan
3. Memberikan bimbingan dan remedial kepada siswa yang tertinggal
4. Mengembangkan materi pembelajaran yang inovatif dan kontekstual
5. Berkolaborasi dengan guru lain dalam pengembangan kurikulum
```

**Expected Output**:
- Tabel 1: Ekspektasi Pimpinan untuk setiap Core Value BerAKHLAK
- Tabel 2: Umpan Balik dengan feedback positif dan konstruktif
- Format: Markdown dua tabel terpisah

**Expected Duration**: 5-7 minutes

---

### Test Case 3B: Supervisor Feedback for Administrative Staff

```
Nama Atasan        : Ir. Eka Sutrisna, M.Si
Jabatan Atasan     : Kepala Dinas Pendidikan
Unit Atasan        : Dinas Pendidikan Provinsi Jawa Barat

Nama Bawahan       : Ahmad Wijaya, S.E
Jabatan Bawahan    : Kepala Bagian Administrasi

Periode            : Tahun 2024

Tugas Pokok Bawahan:
1. Mengelola sistem administrasi kepegawaian terintegrasi
2. Memastikan keakuratan data kepegawaian dan kepatuhan regulasi
3. Memproses dokumen kepegawaian dengan cepat dan tepat
4. Melaksanakan program pengembangan kompetensi pegawai
5. Mengkoordinasikan dengan bagian lain untuk kelancaran administratif
```

**Expected Output**:
- Feedback komprehensif dari perspektif pimpinan
- Fokus pada kompetensi, loyalitas, dan adaptabilitas

**Expected Duration**: 5-7 minutes

---

## ✅ Testing Checklist

### Before Testing:

- [ ] Start 3-5 queue workers:
  ```bash
  # Terminal 1: High Priority Queue
  php artisan queue:work database --queue=high --sleep=3 --tries=3 --timeout=600
  
  # Terminal 2-3: Default Queue (2 workers)
  php artisan queue:work database --queue=default --sleep=3 --tries=3 --timeout=600
  
  # Terminal 4-5: Default Queue (2 more workers)
  php artisan queue:work database --queue=default --sleep=3 --tries=3 --timeout=600
  ```

- [ ] Monitor logs in separate terminal:
  ```bash
  tail -f storage/logs/laravel.log
  ```

- [ ] Open Super Admin Dashboard in browser for monitoring

### During Testing:

- [ ] Test 1: Modul Ajar (Test Cases 1A, 1B, 1C)
  - [ ] 1A: Mathematics - Should take ~8-10 min
  - [ ] 1B: Biology - Should take ~9-11 min
  - [ ] 1C: Indonesian Language - Should take ~6-8 min
  - [ ] Verify in Super Admin Queue Monitoring dashboard

- [ ] Test 2: E-Kinerja (Test Cases 2A, 2B)
  - [ ] 2A: Guru ASN - Should take ~6-8 min
  - [ ] 2B: Aparatur Sipil - Should take ~7-9 min
  - [ ] Check that all 3 tables generate correctly

- [ ] Test 3: E-Kinerja Atasan (Test Cases 3A, 3B)
  - [ ] 3A: Teacher Feedback - Should take ~5-7 min
  - [ ] 3B: Administrative Feedback - Should take ~5-7 min

### Monitor Queue:

- [ ] Watch Super Admin Dashboard:
  - Total Queue counter increases with each submit
  - Jobs move from "Pending" → "Processing" → "Completed"
  - No jobs stuck in "Processing" after timeout period
  - Error messages clear (if any)

- [ ] Watch Terminal Logs:
  - No "Timeout" errors
  - Queue workers show: "Working on [high/default] queue..."
  - Jobs complete successfully

### After Each Test:

- [ ] Verify generated content in Library:
  - Go to teacher/user library
  - Check last generated item
  - Content should be complete, formatted properly
  - All tables/sections visible

- [ ] Check for Error Messages:
  - No "Timeout" errors in queue
  - No "Maximum execution time" errors
  - No infinite loop/loading

---

## 🎯 Success Criteria

| Criteria | Pass | Fail |
|----------|------|------|
| Modul Ajar completes in <12 min | ✓ | If hangs >15 min |
| E-Kinerja completes in <10 min | ✓ | If hangs >12 min |
| E-Kinerja Atasan completes in <10 min | ✓ | If hangs >12 min |
| No jobs stuck in monitoring | ✓ | If jobs stuck >10 min |
| Generated content is complete | ✓ | If content truncated/blank |
| Queue workers process parallel | ✓ | If only 1 job at a time |
| No timeout errors in logs | ✓ | If timeout errors appear |
| Content saved to library | ✓ | If content not saved |

---

## 📝 Test Report Template

Copy and fill out for each test:

```
Test Case: [1A/1B/1C/2A/2B/3A/3B]
Feature: [Modul Ajar/E-Kinerja/E-Kinerja Atasan]
Date: 2026-07-11
Tester: [Name]

Submitted at: [Time]
Completed at: [Time]
Duration: [Minutes]

Status: [Completed/Failed/Timeout/Error]
Error Message (if any): [Error text]

Content Generated:
- [ ] Visible in Library
- [ ] All sections complete
- [ ] Formatting correct
- [ ] No truncation

Queue Status:
- [ ] Queue ID visible to user
- [ ] Dashboard shows job status
- [ ] No stuck jobs
- [ ] Notification received

Issues Found:
[List any issues]

Notes:
[Additional observations]

PASS / FAIL
```

---

## 🚀 Ready for Production?

After successful beta testing:
- [ ] All 3 features tested multiple times
- [ ] No timeout errors in 24 hours
- [ ] Jobs complete consistently
- [ ] Generated content quality is good
- [ ] Queue workers stable
- [ ] Super Admin monitoring dashboard works
- [ ] Ready to push to production!

---

**Created**: 2026-07-11  
**Version**: 1.0  
**Status**: Ready for Beta Testing
