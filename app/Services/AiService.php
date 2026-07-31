<?php

namespace App\Services;

use Gemini\Client;
use Gemini;

class AiService
{
    protected array $apiKeys;
    protected bool $isAdmin = false;

    public function __construct()
    {
        $this->apiKeys = config('gemini.api_keys', []);
        
        if (empty($this->apiKeys)) {
            throw new \Exception('Gemini API Keys are not configured.');
        }
    }

    /**
     * Set context if the request is from an admin
     */
    public function setForAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * Generate content based on a prompt with Multi-Key Rotation.
     */
    public function generate(string $prompt): string
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $model = config('gemini.model', 'gemini-flash-latest');
        $errors = [];

        // Shuffle keys once to distribute load, then iterate (Round-Robin style for this request)
        // If one fails, we fall back to the next one in the list.
        $keys = $this->apiKeys;
        shuffle($keys); 

        $adminKey = config('gemini.api_key_admin');
        if ($this->isAdmin && !empty($adminKey)) {
            // Jalur VIP: Taruh admin key di urutan pertama. 
            // Jika limit, dia otomatis fallback ke keys reguler di bawahnya.
            $keys = array_filter($keys, fn($k) => $k !== $adminKey);
            array_unshift($keys, $adminKey);
        }

        foreach ($keys as $apiKey) {
            try {
                // Initialize client with the current key and extended timeout (10 minutes)
                $httpClient = new \GuzzleHttp\Client([
                    'timeout' => 600,
                    'connect_timeout' => 60,
                ]);
                
                $client = \Gemini::factory()
                    ->withApiKey($apiKey)
                    ->withHttpClient($httpClient)
                    ->make();
                
                $result = $client->generativeModel($model)->generateContent($prompt);
                
                // Robust response extraction
                // Check if response has candidates
                if (!isset($result->candidates) || empty($result->candidates)) {
                    throw new \Exception('AI tidak memberikan respons. Coba lagi atau ubah permintaan Anda.');
                }

                $candidate = $result->candidates[0];

                // Check finish reason
                if (isset($candidate->finishReason)) {
                    $finishReason = $candidate->finishReason;
                    
                    if ($finishReason === 'SAFETY') {
                        throw new \Exception('Konten diblokir oleh filter keamanan AI. Coba ubah topik atau kata-kata Anda agar lebih netral.');
                    }
                    
                    if ($finishReason === 'RECITATION') {
                        throw new \Exception('Konten terlalu mirip dengan materi berhak cipta. Coba ubah permintaan Anda dengan kata-kata berbeda.');
                    }
                    
                    if ($finishReason === 'MAX_TOKENS') {
                        throw new \Exception('Respons terlalu panjang dan terpotong. Coba permintaan yang lebih spesifik atau singkat.');
                    }
                }

                // Extract text from parts
                if (!isset($candidate->content->parts) || empty($candidate->content->parts)) {
                    throw new \Exception('AI memberikan respons kosong. Coba lagi atau ubah permintaan Anda.');
                }

                // Get text from first part
                $text = $candidate->content->parts[0]->text ?? null;
                
                if (empty($text)) {
                    throw new \Exception('AI memberikan respons kosong. Coba lagi atau ubah permintaan Anda.');
                }

                return $text; // Success! Return immediately.

            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                // Log the error for this specific key but don't fail yet
                \Log::warning("Gemini Key Rotation Error: " . $errorMessage);
                $errors[] = $errorMessage;

                // Jika error adalah High Demand atau Quota Exceeded (429), kita tunggu sebentar
                if (str_contains(strtolower($errorMessage), 'high demand') || str_contains(strtolower($errorMessage), 'quota exceeded') || str_contains(strtolower($errorMessage), '429')) {
                    sleep(10); // Tunggu 10 detik sebelum mencoba key berikutnya agar server Google sempat bernapas
                    continue;
                }

                // If it's a user-facing error (our custom messages), don't retry with other keys
                if (str_contains($errorMessage, 'diblokir') || 
                    str_contains($errorMessage, 'berhak cipta') ||
                    str_contains($errorMessage, 'terpotong') ||
                    str_contains($errorMessage, 'respons kosong')) {
                    throw $e; // Re-throw immediately
                }
                
                continue; // Try next key for network errors
            }
        }

        // If we reach here, ALL keys failed.
        \Log::error('All Gemini Keys Failed. Errors: ' . implode(', ', $errors));
        throw new \Exception('Sistem AI sedang sibuk. Mohon tunggu beberapa saat dan coba lagi.');
    }

    /**
     * Generate a Story based on specific parameters.
     */
    public function generateStory(string $topic, string $genre, $target)
    {
        $prompt = "Buatkan sebuah cerita pendek (Story) dengan tema: {$topic}. 
                   Genre: {$genre}. 
                   Target Pembaca: {$target}. 
                   Format tulisan harus menarik, memiliki alur yang jelas (awal, tengah, akhir), dan berikan judul yang menggugah di baris pertama. 
                   Gunakan Bahasa Indonesia yang baik dan mengalir.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate an E-book content.
     */
    public function generateEbook(string $topic, string $target, string $outline)
    {
        $prompt = "Buatkan konten draf E-book untuk topik: {$topic}. 
                   Target Pembaca: {$target}. 
                   Outline/Kerangka: {$outline}. 
                   Berikan judul E-book di baris pertama, diikuti dengan pendahuluan yang kuat, dan jabarkan poin-poin outline tersebut dengan penjelasan yang mendalam dan profesional. 
                   Gunakan Bahasa Indonesia.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate an Opinion piece.
     */
    public function generateOpinion(string $topic, string $stance)
    {
        $prompt = "Buatkan sebuah tulisan opini/artikel opini tentang: {$topic}. 
                   Sudut Pandang/Posisi: {$stance}. 
                   Tulisan harus berisi argumen yang kuat, data pendukung (jika relevan secara umum), dan kesimpulan yang tegas. 
                   Berikan judul opini di baris pertama. Gunakan Bahasa Indonesia.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate a Video Script.
     */
    public function generateScript(string $topic, string $platform, string $duration)
    {
        $prompt = "Buatkan sebuah Script Video untuk platform: {$platform}. 
                   Topik: {$topic}. 
                   Estimasi Durasi: {$duration}. 
                   Format skrip harus mencakup: Hook di awal, pesan utama, dan Call to Action (CTA) di akhir. 
                   Sertakan panduan visual sederhana di dalam kurung [ ]. Gunakan Bahasa Indonesia.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate an Essay.
     */
    public function generateEssay(string $topic, string $type)
    {
        $prompt = "Buatkan sebuah Essay dengan tema: {$topic}. 
                   Jenis Essay: {$type}. 
                   Struktur harus mencakup Pendahuluan (Thesis Statement), Pembahasan (Body Paragraphs), dan Kesimpulan. 
                   Berikan judul essay di baris pertama. Gunakan Bahasa Indonesia yang akademis namun tetap nyaman dibaca.";
        
        return $this->generate($prompt);
    }
    /**
     * Generate structured ASN e-Kinerja (SKP) details.
     */
    public function generateEKinerja(array $data)
    {
        $pegawai = "Nama: {$data['pegawai_nama']}, NIP: {$data['pegawai_nip']}, Jabatan: {$data['pegawai_jabatan']}, Unit: {$data['pegawai_unit']}";
        $atasan = "Nama: {$data['atasan_nama']}, Jabatan: {$data['atasan_jabatan']}";
        $periode = $data['periode'];

        $rhk_list = "";
        foreach ($data['rhk'] as $index => $pegawai_rhk) {
            $atasan_rhk = $data['rhk_atasan'][$index];
            $jenis = $data['rhk_jenis'][$index];
            $rhk_list .= "RHK #".($index + 1).":\n";
            $rhk_list .= "- RHK Atasan: \"{$atasan_rhk}\"\n";
            $rhk_list .= "- RHK Pegawai: \"{$pegawai_rhk}\" (Jenis: {$jenis})\n\n";
        }

        $prompt = "Anda adalah asisten ahli penyusunan SKP ASN berstandar BKN (Permenpan RB No. 6 Tahun 2022).
                   Tugas Anda: Menghasilkan rincian tabel SKP yang sangat akurat dan formal seperti contoh dokumen resmi untuk BEBERAPA RHK sekaligus.

                   CONTEXT:
                   - PEGAWAI: {$pegawai}
                   - ATASAN PENILAI: {$atasan}
                   - PERIODE: {$periode}
                   
                   LIST RHK YANG HARUS DISUSUN:
                   {$rhk_list}

                   OUTPUT FORMAT (WAJIB):
                   Gunakan format Markdown.

                   Tampilkan data pegawai dan atasan penilai dalam bentuk tabel kecil di bagian paling atas.

                   ### 1. EVALUASI HASIL KERJA (TABEL SKP)
                   Buatlah SATU tabel besar yang mencakup SEMUA RHK di atas.
                   Kolom tabel: | No | Rencana Hasil Kerja Pimpinan yang Diintervensi | Rencana Hasil Kerja | Aspek | Indikator Kinerja Individu | Target |
                   Pastikan setiap satu RHK memiliki 3 baris Aspek: Kuantitas, Kualitas, dan Waktu.

                   ### 2. RENCANA AKSI
                   Buat tabel Rencana Aksi dengan kolom: | No RHK | Rencana Aksi | Target Output | Target Waktu |
                   - Setiap RHK WAJIB memiliki MINIMAL 5 Rencana Aksi.
                   - Target Output maksimal 45 karakter (singkat & padat).
                   - Target Waktu jelas (misal: Jan 2024, Mingguan).

                   ### 3. PERILAKU KERJA (BerAKHLAK)
                   Buat tabel Perilaku Kerja dengan kolom: | No | Core Value | Panduan Perilaku (Kode Etik) | Ekspektasi Khusus Pimpinan |
                   Isi untuk semua 7 Core Value ASN (Berorientasi Pelayanan, Akuntabel, Kompeten, Harmonis, Loyal, Adaptif, Kolaboratif).
                   - Kolom Panduan Perilaku: Berikan panduan kode etik yang relevan dengan tugas pegawai.
                   - Kolom Ekspektasi Khusus Pimpinan: Berikan 2-3 kalimat ekspektasi formal dari atasan untuk setiap core value, relevan dengan konteks tugas pegawai.

                   Gunakan Bahasa Indonesia Kedinasan yang baku. Pastikan Target angka logis sesuai periode.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate a News Article.
     */
    public function generateNews(string $topic, string $style)
    {
        $prompt = "Tolong buatkan berita (Straight News/Feature/Brief) dalam Bahasa Indonesia sesuai kaidah jurnalistik media nasional.
                   
                   DATA MENTAH (5W+1H) & TOPIK: 
                   {$topic}
                   
                   GAYA PENULISAN: {$style}

                   KETENTUAN WAJIB:
                   1. Judul: Singkat, padat, dan faktual.
                   2. Lead (Teras Berita): 1 paragraf (2-3 kalimat) yang merangkum poin utama (What, Who, When, Where).
                   3. Body (Isi Berita): 3-5 paragraf. Gunakan sudut pandang yang relevan (Ekonomi/Kemanusiaan/Investigatif/Pemerintah) sesuai konteks data.
                   4. Gaya Bahasa: Lugas, formal, objektif, hindari opini pribadi AI.
                   5. ANTI-HALUSINASI: Jangan menambahkan fakta baru di luar data yang diberikan. Jika data kurang, rangkai yang ada saja.

                   Pelajari pola data input pengguna untuk hasil masa depan yang lebih konsisten.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate a Speech (Kata Sambutan).
     */
    public function generateSpeech(string $event, string $position, string $audience, string $tone)
    {
        $prompt = "Bertindaklah sebagai penulis pidato profesional untuk pejabat publik.
                   Buatkan TEKS KATA SAMBUTAN RESMI LENGKAP berbahasa Indonesia.
                   
                   CONTEXT ACARA:
                   - Nama Acara: {$event}
                   - Posisi Pembicara: {$position} (Sesuaikan gaya bicara dengan jabatan ini)
                   - Target Audiens: {$audience}
                   - Gaya Bahasa/Nada: {$tone}, sangat formal, sopan, namun tetap hangat dan dekat dengan masyarakat.
                   - Durasi: 5-7 Menit (Sekitar 600-800 Kata).

                   STRUKTUR WAJIB (JANGAN DIUBAH):
                   1. Salam Pembuka Lengkap:
                      - Mulai dengan salam lintas agama (Assalamualaikum, Shalom, Om Swastiastu, Namo Buddhaya, Salam Kebajikan).
                      - Sapaan penghormatan kepada tamu penting (gunakan placeholder [Sebutkan Nama Tokoh] jika perlu).
                   2. Ucapan Puji Syukur & Terima Kasih:
                      - Puji syukur kepada Tuhan YME.
                      - Apresiasi kepada panitia dan pihak yang terlibat.
                   3. Isi Utama (Core Message):
                      - Tujuan dan makna penting acara ini.
                      - Manfaat bagi masyarakat/organisasi (sosial, budaya, pendidikan, dll).
                      - Harapan ke depan.
                   4. Pesan Kepada Masyarakat/Audiens:
                      - Ajakan untuk menjaga/memanfaatkan momentum ini dengan baik.
                   5. Penutup Kuat:
                      - Kesimpulan singkat penuh optimisme.
                      - Permohonan maaf jika ada kekurangan.
                      - Diakhiri doa singkat dan salam penutup resmi.

                   KETENTUAN LAIN:
                   - Gunakan Bahasa Indonesia baku yang baik dan benar (EYD).
                   - JANGAN sebutkan tanggal, hari, atau nama orang secara spesifik (biarkan sebagai placeholder [Hari/Tanggal] atau [Nama]).
                   - Hindari pengulangan kata yang membosankan.
                   - Buat narasi yang mengalir, berwibawa, namun menyentuh hati.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate Social Media Content.
     */
    public function generateSocialMedia(string $topic, string $platform, string $style)
    {
        $prompt = "Buatkan konten Social Media untuk platform: {$platform}. 
                   Topik: {$topic}. 
                   Gaya Bahasa: {$style}. 
                   
                   Panduan per Platform:
                   - Instagram: Sertakan Caption menarik, paragraf pendek, dan 10-15 #Hashtag relevan.
                   - Twitter (X): Buat dalam bentuk Thread (Utas) pendek atau satu tweet punchline yang viral.
                   - LinkedIn: Gunakan nada profesional, paragraf pembuka yang kuat (hook), insight bisnis/karir, dan penutup diskusi.
                   - TikTok/Reels: Buat naskah video pendek (Hook, Isi, CTA).
                   - Facebook: Tulisan storytelling yang engaging.
                   
                   Gunakan Bahasa Indonesia yang sesuai dengan platform tersebut.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate Supervisor Perspective for e-Kinerja.
     */
    public function generateEKinerjaAtasan(array $data)
    {
        $atasan = "Nama: {$data['atasan_nama']}, Jabatan: {$data['atasan_jabatan']}, Unit: {$data['atasan_unit']}";
        $bawahan = "Nama: {$data['bawahan_nama']}, Jabatan: {$data['bawahan_jabatan']}";
        $periode = $data['periode'];

        $tugas_list = "";
        foreach ($data['tugas_pokok'] as $index => $tugas) {
            $tugas_list .= "- Tugas " . ($index + 1) . ": \"{$tugas}\"\n";
        }

        $prompt = "Anda adalah asisten ahli kepegawaian (HR) untuk instansi pemerintah.
                   Tugas Anda: Membantu ATASAN menyusun 'Ekspektasi Khusus Pimpinan' dan 'Umpan Balik' untuk SKP bawahannya.

                   CONTEXT:
                   - ATASAN (Penilai): {$atasan}
                   - BAWAHAN (Dinilai): {$bawahan}
                   - PERIODE: {$periode}

                   TUGAS POKOK BAWAHAN:
                   {$tugas_list}

                   OUTPUT FORMAT (Markdown):
                   
                   ### 1. EKSPEKTASI KHUSUS PIMPINAN
                   (Berikan 3-5 poin ekspektasi spesifik dari atasan kepada bawahan terkait perilaku kerja BerAKHLAK dan pencapaian target di atas. Gunakan bahasa motivasi namun tegas).

                   ### 2. UMPAN BALIK BERKELANJUTAN
                   (Berikan narasi feedback konstruktif untuk pengembangan bawahan kedepan berdasarkan tugas pokoknya).

                   Gunakan Bahasa Indonesia Kedinasan yang profesional.";
        
        return $this->generate($prompt);
    }

    /**
     * Refine existing content based on user instructions.
     */
    public function refineContent(string $originalContent, string $instruction): string
    {
        $prompt = "Berikut adalah konten yang sudah ada:\n\n" .
                   "\"\"\"\n" . $originalContent . "\n\"\"\"\n\n" .
                   "Instruksi Perubahan: \"{$instruction}\"\n\n" .
                   "Tugas Anda: Perbarui konten di atas berdasarkan instruksi tersebut. " .
                   "Pertahankan gaya penulisan yang sudah ada namun terapkan perubahan yang diminta. " .
                   "Kembalikan hanya konten hasil pembaruan tanpa basa-basi. Gunakan Bahasa Indonesia.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate Copywriting (Marketing Text).
     */
    public function generateCopywriting(string $productName, string $description, string $targetAudience, string $platform, string $framework, string $tone)
    {
        $prompt = "Bertindaklah sebagai Senior Copywriter profesional kelas dunia dengan pengalaman 20 tahun.
                   Tugas Anda: Membuat teks copywriting yang persuasif dan menjual (High-Converting Copy).

                   PARAMETER:
                   - Produk/Brand: {$productName}
                   - Deskripsi Produk: {$description}
                   - Target Audiens: {$targetAudience}
                   - Platform/Media: {$platform}
                   - Kerangka (Framework): {$framework}
                   - Nada (Tone): {$tone}

                   INSTRUKSI:
                   1. Terapkan kerangka {$framework} secara ketat dan jelas dalam struktur tulisan.
                   2. Sesuaikan gaya bahasa untuk platform {$platform} (misal: gunakan hashtag untuk Instagram, headline kuat untuk Landing Page, subjek menarik untuk Email).
                   3. Gunakan bahasa yang {$tone}, hipnotik, dan memancing emosi pembaca untuk bertindak (Action).
                   4. Gunakan Bahasa Indonesia yang natural, mengalir, dan powerful (boleh sedikit slang sopan jika target audiens anak muda).
                   
                   OUTPUT:
                   Berikan langsung hasil copywriting-nya. Jika platform membutuhkan pernak-pernik (seperti Subject Line untuk Email atau Headline untuk Ads), sertakan juga.";
        
        return $this->generate($prompt);
    }

    // --- New Features (Phase 2) ---

    /**
     * Generate Official Activity Report (Laporan Kegiatan).
     */
    public function generateReport(array $data)
    {
        $prompt = "Bertindaklah sebagai ASN/Pegawai Profesional yang ahli dalam administrasi.
                   Buatkan LAPORAN KEGIATAN RESMI yang lengkap dan rapi.

                   DATA KEGIATAN:
                   - Nama Kegiatan: {$data['activity_name']}
                   - Waktu: {$data['date']}
                   - Tempat: {$data['location']}
                   - Hasil Utama: {$data['results']}
                   - Kendala: " . ($data['challenges'] ?? 'Tidak ada') . "
                   - Saran/Rekomendasi: " . ($data['recommendations'] ?? '-') . "

                   STRUKTUR LAPORAN (WAJIB):
                   
                   I. PENDAHULUAN
                      - Latar Belakang (Buat narasi singkat mengapa kegiatan ini penting).
                      - Maksud dan Tujuan.

                   II. PELAKSANAAN KEGIATAN
                      - Waktu dan Tempat (Gunakan data di atas).
                      - Peserta (Asumsikan peserta yang relevan dengan nama kegiatan).
                      - Uraian Jalannya Acara (Buat narasi kronologis singkat).

                   III. HASIL KEGIATAN
                      - Jabarkan 'Hasil Utama' menjadi poin-poin detail dan substantif.
                      - Gunakan bahasa birokrasi yang formal dan objektif.

                   IV. PERMASALAHAN DAN PEMECAHAN (Jika ada kendala)
                      - Uraikan kendala dan solusi yang diambil/disarankan.

                   V. PENUTUP DAN SARAN
                      - Kesimpulan singkat.
                      - Rekomendasi untuk kegiatan selanjutnya.

                   Gunakan Bahasa Indonesia baku (EYD) dengan nada resmi pemerintahan.";

        return $this->generate($prompt);
    }

    /**
     * Generate Standard Operating Procedure (SOP).
     */
    public function generateSop(array $data)
    {
        $prompt = "Bertindaklah sebagai Ahli Tata Laksana dan Organisasi (Ortala).
                   Buatkan Dokumen STANDAR OPERASIONAL PROSEDUR (SOP) yang detail.

                   PARAMETER:
                   - Judul SOP: {$data['title']}
                   - Pelaksana Utama: {$data['role']}
                   - Tujuan: {$data['objective']}
                   - Ruang Lingkup: {$data['scope']}

                   FORMAT OUTPUT (Markdown):
                   
                   # SOP: {$data['title']}
                   
                   **1. Tujuan:**
                   (Perjelas tujuan di atas dengan kalimat formal).

                   **2. Ruang Lingkup:**
                   (Jelaskan batasan prosedur ini).

                   **3. Referensi/Dasar Hukum:**
                   - (Berikan placeholder contoh peraturan yang relevan, misal: Peraturan Menteri terkait).

                   **4. Kualifikasi Pelaksana:**
                   - (Sebutkan skill/syarat yang dibutuhkan oleh {$data['role']} untuk melakukan ini).

                   **5. Peralatan dan Perlengkapan:**
                   - (Daftar alat kerja, misal: PC, ATK, Aplikasi Khusus, dll).

                   **6. Uraian Prosedur (Flowchart Naratif):**
                   Buat langkah-langkah detail, logis, dan berurutan (1, 2, 3...) dari awal sampai akhir.
                   - Gunakan kalimat perintah aktif (Contoh: 'Terima dokumen...', 'Verifikasi data...', 'Arsipkan...').
                   - Pastikan ada langkah pengambilan keputusan jika diperlukan (Jika OK lanjut ke..., Jika Tidak kembalikan ke...).
                   
                   Gunakan gaya bahasa SOP yang tegas, jelas, dan tidak ambigu.";

        return $this->generate($prompt);
    }

    // ===== MODE GURU =====

    /**
     * Generate soal ujian/latihan.
     */
    public function generateSoal(array $data): string
    {
        $prompt = "Kamu adalah guru berpengalaman yang ahli membuat soal berkualitas.
Buatkan soal {$data['jenis']} sebanyak {$data['jumlah']} soal untuk:

- Mata Pelajaran : {$data['mapel']}
- Kelas/Tingkat  : {$data['kelas']}
- Topik/Materi   : {$data['topik']}
- Tingkat Kesulitan: {$data['kesulitan']}

ATURAN PENULISAN RUMUS DAN SIMBOL (WAJIB DIIKUTI):
- DILARANG KERAS menggunakan notasi LaTeX apapun. Jangan pernah pakai: $ ... $, $$ ... $$, \\frac{}{}, \\sqrt{}, \\sum, \\int, \\bar{x}, \\text{}, atau backslash apapun.
- Tulis rumus dan simbol dalam teks biasa yang bisa dibaca manusia:
  - Pecahan: tulis \"a/b\" bukan \"\\frac{a}{b}\"
  - Pangkat: tulis \"x²\" atau \"x^2\" bukan \"x^{2}\"
  - Akar: tulis \"√3\" atau \"akar(3)\" bukan \"\\sqrt{3}\"
  - Rata-rata: tulis \"x̄\" atau \"rata-rata x\" bukan \"\\bar{x}\"
  - Sigma: tulis \"Σ\" bukan \"\\sum\"
  - Integral: tulis \"∫\" bukan \"\\int\"
  - Derajat: tulis \"90°\" bukan \"90^\\circ\"
  - Perkalian: tulis \"×\" bukan \"\\times\" atau \"\\cdot\"
  - Subskrip: tulis \"S₁\", \"S₂\", \"aₙ\" atau \"S1\", \"S2\", \"an\" bukan \"S_{1}\", \"S_{n}\"
  - Superskrip: tulis \"a²\", \"x³\" bukan \"a^{2}\", \"x^{3}\"
  - Pi: tulis \"π\" langsung
  - Tak hingga: tulis \"∞\" langsung

KETENTUAN OUTPUT:
" . ($data['jenis'] === 'Pilihan Ganda' ? "- Setiap soal wajib memiliki 5 opsi jawaban (A, B, C, D, E).
- Di akhir seluruh soal, tampilkan KUNCI JAWABAN dalam format tabel: | No | Jawaban |" : "") . "
" . ($data['jenis'] === 'Essay' ? "- Setiap soal diikuti panduan kunci jawaban singkat di bawahnya (cetak miring)." : "") . "
" . ($data['jenis'] === 'Campuran' ? "- Buat " . intdiv((int)$data['jumlah'], 2) . " soal Pilihan Ganda (dengan 5 opsi + kunci) dan " . ((int)$data['jumlah'] - intdiv((int)$data['jumlah'], 2)) . " soal Essay (dengan panduan kunci)." : "") . "
- Nomor soal berurutan dari 1.
- Gunakan bahasa Indonesia yang baku dan sesuai tingkat kelas.
- Soal harus relevan dengan topik dan mengukur pemahaman yang bervariasi (C1 - C4 Bloom).";

        return $this->generate($prompt);
    }

    /**
     * Generate Modul Ajar Deep Learning — Kurikulum Merdeka.
     */
    public function generateModulAjar(array $data): string
    {
        // BAGIAN 1: Modul Utama
        $prompt1 = "Kamu adalah pengembang kurikulum profesional berpengalaman yang ahli dalam Kurikulum Merdeka dan pendekatan Deep Learning.
Buatkan MODUL AJAR DEEP LEARNING (BAGIAN UTAMA) yang lengkap, profesional, dan siap pakai berdasarkan data berikut:

ATURAN PENULISAN RUMUS DAN SIMBOL (WAJIB DIIKUTI):
- DILARANG KERAS menggunakan notasi LaTeX apapun. Jangan gunakan: dollar sign, \\frac, \\sqrt, \\sum, \\int, \\bar, atau backslash apapun.
- Tulis semua rumus dalam teks biasa: pecahan → a/b, pangkat → x² atau x^2, akar → √3, derajat → 90°, pi → π, perkalian → ×, rata-rata → x̄.

DATA MODUL:
- Mata Pelajaran    : {$data['mapel']}
- Fase              : {$data['fase']}
- Kelas / Semester  : {$data['kelas']} / {$data['semester']}
- Topik / Materi    : {$data['topik']}
- Alokasi Waktu     : {$data['waktu']} menit per pertemuan
- Jumlah Pertemuan  : {$data['pertemuan']} pertemuan
- Tahun Pelajaran   : {$data['tahun_ajar']}

INSTRUKSI UTAMA — PENDEKATAN DEEP LEARNING:
Setiap pertemuan wajib menggunakan tiga fase kegiatan:
1. MEMAHAMI (Meaningful Learning) — guru membangun pemahaman konseptual bermakna, sertakan pertanyaan pemantik
2. MENGAPLIKASI (Joyful Learning) — siswa mengaplikasikan dengan aktivitas berdiferensiasi produk:
   - Produk Visual (poster, infografis, peta konsep)
   - Produk Audio (rekaman, presentasi lisan, diskusi)
   - Produk Naratif (esai, jurnal, laporan tertulis)
3. MEREFLEKSI (Mindful Learning) — siswa & guru merefleksi proses dan hasil belajar bersama

FORMAT OUTPUT WAJIB (Markdown):

# MODUL AJAR DEEP LEARNING
## {$data['mapel']} — {$data['topik']}

---

## A. IDENTITAS MODUL
| Komponen | Keterangan |
|---|---|
| Nama Sekolah | ................................................... |
| Nama Penyusun | ................................................... |
| Mata Pelajaran | {$data['mapel']} |
| Fase / Kelas / Semester | {$data['fase']} / {$data['kelas']} / {$data['semester']} |
| Alokasi Waktu | {$data['waktu']} menit × {$data['pertemuan']} pertemuan |
| Tahun Pelajaran | {$data['tahun_ajar']} |

---

## B. IDENTIFIKASI KESIAPAN PESERTA DIDIK
(Uraikan pengetahuan dan keterampilan awal yang sudah dimiliki peserta didik sebelum mempelajari topik ini. Sertakan variasi kesiapan: siswa yang sudah mahir, siswa rata-rata, dan siswa yang membutuhkan pendampingan ekstra.)

---

## C. KARAKTERISTIK MATERI PELAJARAN
(Uraikan jenis pengetahuan: konseptual, prosedural, dan/atau afektif. Jelaskan tingkat kesulitan, relevansi langsung dengan kehidupan nyata peserta didik, struktur materi, serta integrasi nilai-nilai karakter yang akan ditanamkan.)

---

## D. DIMENSI LULUSAN PEMBELAJARAN
(Uraikan 4–5 dimensi profil lulusan yang dikembangkan, misalnya: Keimanan & Ketakwaan, Penalaran Kritis, Kemandirian, Kolaborasi, Komunikasi, Kreativitas, Kewargaan. Untuk setiap dimensi, tuliskan deskripsi konkret bagaimana dimensi itu dikembangkan dalam pembelajaran ini.)

---

## E. DESAIN PEMBELAJARAN
### A. Capaian Pembelajaran (CP)
(Tuliskan Capaian Pembelajaran resmi untuk {$data['mapel']} {$data['fase']} sesuai Kurikulum Merdeka, sertakan nomor Permendikbudristek yang relevan.)

### B. Lintas Disiplin Ilmu
(Sebutkan 3–4 mata pelajaran lain yang berkaitan dengan topik ini, beserta aspek keterkaitan yang konkret dan bermakna bagi peserta didik.)

### C. Tujuan Pembelajaran
(Rumuskan tujuan pembelajaran per pertemuan, masing-masing 3 TP terukur menggunakan kata kerja operasional HOTS. Format: **Pertemuan N: [Subtopik]** diikuti daftar TP bernomor.)

### D. Topik Pembelajaran Kontekstual
(Sajikan 4–5 topik atau pertanyaan kontekstual yang mengaitkan materi dengan kehidupan nyata peserta didik. Buat menarik dan relevan bagi usia mereka.)

### E. Kerangka Pembelajaran

**Praktik Pedagogik:**
- **Eksplorasi Lapangan:** (Kegiatan pengamatan langsung/lapangan yang relevan dengan topik)
- **Wawancara:** (Kegiatan wawancara narasumber yang sesuai)
- **Presentasi:** (Kegiatan berbagi hasil pembelajaran kepada teman/kelas)
- **Diskusi Kelompok:** (Topik diskusi yang mendorong berpikir kritis dan kolaboratif)

**Mitra Pembelajaran:**
- *Lingkungan Sekolah:* (Pihak di sekolah yang bisa dilibatkan)
- *Lingkungan Luar Sekolah:* (Pihak di luar sekolah yang bisa dilibatkan)

---

## F. KEGIATAN PEMBELAJARAN

### Pertemuan 1: [Subtopik Pertemuan 1]

#### 🔵 Memahami (Meaningful Learning)
(Uraikan langkah membangun pemahaman bermakna: apersepsi kontekstual, penyampaian relevansi materi, penjelasan konsep utama, tanya jawab eksplorasi, dan pertanyaan pemantik yang memancing rasa ingin tahu. Rinci dan operasional.)

#### 🟢 Mengaplikasi (Joyful Learning)

**Aktivitas Berdiferensiasi Produk:**
- 🖼️ **Produk Visual:** (Deskripsikan kegiatan konkret untuk siswa yang belajar visual)
- 🎙️ **Produk Audio:** (Deskripsikan kegiatan konkret untuk siswa yang belajar auditori)
- ✍️ **Produk Naratif:** (Deskripsikan kegiatan konkret untuk siswa yang belajar dengan menulis/kinestetik)

#### 🔴 Merefleksi (Mindful Learning)
(Pertanyaan refleksi guru kepada siswa, refleksi mandiri siswa, umpan balik formatif, dan tindak lanjut ke pertemuan berikutnya.)

[Ulangi struktur yang sama untuk setiap pertemuan berikutnya dengan subtopik dan konten yang berbeda]

---

## KEGIATAN PENUTUP (Berlaku untuk Semua Pertemuan)

**Umpan Balik Konstruktif (Meaningful Learning & Mindful Learning):**
(Cara guru memberikan umpan balik positif dan membangun terhadap partisipasi dan hasil belajar siswa)

**Menyimpulkan Pembelajaran (Meaningful Learning):**
(Cara guru dan siswa bersama-sama menyimpulkan inti dan hikmah pembelajaran)

**Perencanaan Pembelajaran Selanjutnya (Joyful Learning & Mindful Learning):**
(Cara guru menginformasikan topik berikutnya dan mengaitkannya dengan materi yang baru dipelajari)

---

## G. ASESMEN PEMBELAJARAN
### Asesmen Awal Pembelajaran
**Tujuan:** Mengidentifikasi pengetahuan awal dan kesiapan belajar peserta didik.
**Bentuk Asesmen:**
- *Kuesioner Singkat:* (Tuliskan 4–5 pertanyaan diagnostik konkret dan spesifik untuk topik ini)
- *Tes Diagnostik:* (Deskripsi tes kemampuan awal yang relevan)

### Asesmen Proses Pembelajaran
**Tujuan:** Memantau pemahaman dan perkembangan peserta didik selama proses belajar.
**Bentuk Asesmen:**
- *Tugas Harian / Portofolio:* (Tuliskan 3–4 tugas konkret yang dapat dinilai selama proses)
- *Diskusi Kelompok:* (Kriteria penilaian partisipasi, argumen, dan kerja sama)
- *Observasi:* (Aspek-aspek yang diobservasi guru selama kegiatan berlangsung)

### Asesmen Akhir Pembelajaran
**Tujuan:** Mengukur pencapaian kompetensi peserta didik secara menyeluruh.
**Bentuk Asesmen:**
- *Jurnal Reflektif:* (Panduan penulisan jurnal reflektif siswa tentang topik ini)
- *Tes Tertulis:* (Tuliskan 3–4 soal esai/analisis HOTS yang konkret dan spesifik)
- **Proyek:** [Nama Proyek yang Relevan dan Kreatif]
  - *Deskripsi:* (Deskripsikan proyek kelompok yang menantang dan bermakna)
  - *Kriteria Penilaian:* (Sebutkan 4–5 aspek penilaian yang jelas)

Gunakan bahasa Indonesia yang profesional, hangat, dan sesuai kaidah pengembangan perangkat ajar Kurikulum Merdeka.
Pastikan SETIAP bagian diisi secara substantif dan spesifik untuk topik **{$data['topik']}** — jangan gunakan placeholder kosong atau kalimat generik.
Output harus langsung bisa digunakan guru tanpa perlu banyak revisi.";

        $hasilUtama = $this->generate($prompt1);

        // BAGIAN 2: Lampiran (LKPD dll)
        $prompt2 = "Kamu adalah pengembang kurikulum profesional. Lanjutkan pembuatan Modul Ajar untuk:
- Mata Pelajaran: {$data['mapel']}
- Kelas: {$data['kelas']}
- Topik: {$data['topik']}
- Jumlah Pertemuan: {$data['pertemuan']} pertemuan

Tugasmu SEKARANG HANYA membuat BAGIAN LAMPIRAN (Bagian H). JANGAN mengulang bagian A sampai G.
Gunakan aturan penulisan rumus matematika biasa tanpa LaTeX.

FORMAT OUTPUT WAJIB (Markdown):

---
## H. LAMPIRAN

### LKPD — Lembar Kerja Peserta Didik

#### LKPD Pertemuan 1: [Judul yang Menarik]

**Kompetensi yang Dilatih:** (Tujuan pembelajaran yang dilatih dalam LKPD ini)
**Petunjuk Pengerjaan:** (Instruksi yang jelas, ramah, dan memotivasi siswa)

**Kegiatan:**
1. (Aktivitas eksplorasi/pengamatan dengan instruksi detail)
2. (Aktivitas analisis/diskusi dengan pertanyaan pengarah)
3. (Aktivitas refleksi/kesimpulan mandiri)

**Pertanyaan Pemandu:**
1. (Pertanyaan yang menuntun siswa berpikir kritis)
2. (Pertanyaan analitik tentang materi)
3. (Pertanyaan reflektif tentang penerapan dalam kehidupan nyata)

[Ulangi LKPD untuk setiap pertemuan berikutnya]

---
### Bahan Bacaan Guru
(Ringkasan materi dari sudut pandang pedagogi: konsep kunci yang harus dikuasai guru, potensi miskonsepsi siswa yang perlu diwaspadai, dan tips mengajar yang efektif untuk topik ini)

### Bahan Bacaan Peserta Didik
(Ringkasan materi yang ramah dan menarik bagi siswa: pengantar kontekstual yang mengaitkan dengan kehidupan mereka, poin-poin utama yang mudah dipahami, dan contoh nyata yang relevan)

### Glosarium
(Daftar 6–8 istilah kunci beserta definisi yang jelas, sederhana, dan mudah dipahami siswa)

### Daftar Pustaka
(3–5 referensi akademik/resmi yang relevan, format APA sederhana)

---
Gunakan bahasa Indonesia yang profesional, hangat, dan sesuai kaidah pengembangan perangkat ajar Kurikulum Merdeka.
Pastikan SETIAP bagian diisi secara substantif dan spesifik untuk topik **{$data['topik']}** — jangan gunakan placeholder kosong atau kalimat generik.
Output harus langsung bisa digunakan guru tanpa perlu banyak revisi.";

        $hasilLampiran = $this->generate($prompt2);

        return $hasilUtama . "\n\n" . $hasilLampiran;
    }

    /**
     * Generate RPP (Rencana Pelaksanaan Pembelajaran).
     */
    public function generateRPP(array $data): string
    {
        $prompt = "Kamu adalah guru profesional berpengalaman. Buatkan RPP (Rencana Pelaksanaan Pembelajaran) yang lengkap dan siap pakai.

ATURAN PENULISAN RUMUS DAN SIMBOL (WAJIB DIIKUTI):
- DILARANG KERAS menggunakan notasi LaTeX apapun. Jangan gunakan: dollar sign, \\frac, \\sqrt, \\sum, \\int, \\bar, atau backslash apapun.
- Tulis semua rumus dalam teks biasa: pecahan → a/b, pangkat → x² atau x^2, akar → √3, derajat → 90°, pi → π, perkalian → ×, rata-rata → x̄.

DATA RPP:
- Mata Pelajaran    : {$data['mapel']}
- Kelas/Semester    : {$data['kelas']}
- Topik/Materi      : {$data['topik']}
- Alokasi Waktu     : {$data['waktu']} menit ({$data['pertemuan']} pertemuan × {$data['jp']} JP)
- Kurikulum         : {$data['kurikulum']}
- Metode Pembelajaran: {$data['metode']}
- Kompetensi Dasar  : {$data['kd']}

FORMAT OUTPUT WAJIB (Markdown):

# RENCANA PELAKSANAAN PEMBELAJARAN (RPP)

**Mata Pelajaran:** {$data['mapel']}  
**Kelas/Semester:** {$data['kelas']}  
**Topik:** {$data['topik']}  
**Alokasi Waktu:** {$data['waktu']} menit  
**Kurikulum:** {$data['kurikulum']}  

---

## I. KOMPETENSI INTI (KI)
(Tuliskan KI 1-4 yang sesuai jenjang)

## II. KOMPETENSI DASAR & INDIKATOR
| KD | Indikator Pencapaian Kompetensi |
|---|---|
| {$data['kd']} | (Jabarkan minimal 3 IPK dari KD ini) |

## III. TUJUAN PEMBELAJARAN
(Rumuskan tujuan dengan format: Melalui kegiatan..., peserta didik mampu... dengan... secara...)

## IV. MATERI PEMBELAJARAN
- **Materi Faktual:** ...
- **Materi Konseptual:** ...
- **Materi Prosedural:** ...

## V. METODE PEMBELAJARAN
- Pendekatan : Saintifik / TPACK
- Model      : {$data['metode']}
- Metode     : Diskusi, Tanya Jawab, Penugasan

## VI. MEDIA, ALAT, & SUMBER BELAJAR
(Daftar media dan sumber yang relevan)

## VII. LANGKAH-LANGKAH PEMBELAJARAN

### Pertemuan 1
| Kegiatan | Deskripsi | Alokasi Waktu |
|---|---|---|
| Pendahuluan | (Apersepsi, motivasi, presensi) | 10 menit |
| Inti | (Uraikan langkah {$data['metode']} secara detail — 5M jika Saintifik) | ... menit |
| Penutup | (Kesimpulan, refleksi, PR/tindak lanjut) | 10 menit |

## VIII. PENILAIAN
| Aspek | Teknik | Instrumen |
|---|---|---|
| Sikap | Observasi | Lembar observasi |
| Pengetahuan | Tes tertulis | Soal PG/Essay |
| Keterampilan | Unjuk kerja | Rubrik penilaian |

---
Mengetahui,  
Kepala Sekolah        [Kota], [Tanggal]  
                      Guru Mata Pelajaran  

[Nama Kepala Sekolah] [Nama Guru]  
NIP. ...              NIP. ...  

Gunakan Bahasa Indonesia baku. Output harus langsung bisa digunakan guru tanpa banyak editing.";

        return $this->generate($prompt);
    }

    /**
     * Generate Rekap Nilai dengan analisis AI.
     */
    public function generateRekapNilai(array $data): string
    {
        $prompt = "Kamu adalah wali kelas / guru yang berpengalaman dalam analisis penilaian siswa.
Buatkan REKAP DAN ANALISIS NILAI berdasarkan data berikut:

ATURAN PENULISAN RUMUS DAN SIMBOL (WAJIB DIIKUTI):
- DILARANG KERAS menggunakan notasi LaTeX apapun. Jangan gunakan: dollar sign, \\frac, \\sqrt, \\sum, \\int, \\bar, atau backslash apapun.
- Tulis semua angka dan simbol dalam teks biasa: pecahan → a/b, pangkat → x², akar → √, rata-rata → x̄ atau tulis rata-rata, derajat → 90°, perkalian → ×.

IDENTITAS:
- Mata Pelajaran : {$data['mapel']}
- Kelas          : {$data['kelas']}
- Periode        : {$data['periode']}
- KKM/KKTP       : {$data['kkm']}

DATA NILAI SISWA:
{$data['nilai_raw']}

FORMAT OUTPUT WAJIB (Markdown):

## REKAP NILAI — {$data['mapel']} Kelas {$data['kelas']}
**Periode:** {$data['periode']} | **KKM/KKTP:** {$data['kkm']}

### A. TABEL REKAP NILAI
(Buat tabel lengkap dari data yang diberikan dengan kolom: No | Nama Siswa | Nilai | Keterangan (Tuntas/Belum Tuntas))

### B. STATISTIK KELAS
| Keterangan | Nilai |
|---|---|
| Nilai Tertinggi | ... |
| Nilai Terendah | ... |
| Rata-rata Kelas | ... |
| Jumlah Tuntas | ... siswa (...%) |
| Jumlah Belum Tuntas | ... siswa (...%) |

### C. ANALISIS & NARASI
(Buat 2-3 paragraf narasi analisis kondisi kelas: bagaimana distribusi nilai, pola yang terlihat, dan apa yang mungkin perlu diperhatikan guru)

### D. REKOMENDASI TINDAK LANJUT
**Untuk Siswa Belum Tuntas:**
- (Daftar nama dan rekomendasi remedial/pendekatan personal)

**Untuk Siswa Tuntas:**
- (Rekomendasi pengayaan)

**Untuk Pembelajaran Selanjutnya:**
- (Saran perbaikan strategi mengajar berdasarkan data ini)

Gunakan Bahasa Indonesia yang profesional namun mudah dipahami guru.";

        return $this->generate($prompt);
    }

    /**
     * Generate Official Letter (Surat Dinas).
     */
    public function generateLetter(array $data)
    {
        $prompt = "Bertindaklah sebagai Sekretaris Instansi Pemerintah yang berpengalaman dalam Tata Naskah Dinas.
                   Buatkan Draf SURAT DINAS RESMI.

                   DATA SURAT:
                   - Jenis Surat: {$data['type']}
                   - Penerima (Yth.): {$data['recipient']}
                   - Pengirim/Penanda Tangan: {$data['sender']}
                   - Perihal: {$data['subject']}
                   - Isi Pokok: {$data['content_summary']}

                   FORMAT (Sesuai Tata Naskah Dinas):

                   [KOP SURAT INSTANSI]
                   (Placeholder Alamat & Kontak)
                   _______________________________________________________

                   Nomor   : .../ABCD/.../2024
                   Sifat   : Biasa/Penting
                   Lampiran: -
                   Hal     : {$data['subject']}

                   Yth. {$data['recipient']}
                   di
                       Tempat

                   Dengan hormat,

                   **1. Pembuka:**
                   (Buat kalimat pembuka standar surat dinas yang sopan, merujuk pada dasar surat jika perlu).

                   **2. Isi Surat:**
                   (Kembangkan 'Isi Pokok' menjadi narasi surat yang lengkap, jelas, dan formal. Jika berupa undangan, sertakan Hari, Tanggal, Pukul, Tempat).

                   **3. Penutup:**
                   (Kalimat penutup formal, ucapan terima kasih).

                   
                   {$data['sender']}
                   
                   (Tanda Tangan)

                   (Nama Terang)
                   NIP. ...........................

                   
                   Gunakan Bahasa Indonesia baku, ejaan yang disempurnakan (EYD), dan format surat dinas yang presisi.";

        return $this->generate($prompt);
    }
}
