<?php

namespace App\Services;

use Gemini\Client;
use Gemini;

class AiService
{
    protected array $apiKeys;

    public function __construct()
    {
        $this->apiKeys = config('gemini.api_keys', []);
        
        if (empty($this->apiKeys)) {
            throw new \Exception('Gemini API Keys are not configured.');
        }
    }

    /**
     * Generate content based on a prompt with Multi-Key Rotation.
     */
    public function generate(string $prompt): string
    {
        $model = config('gemini.model', 'gemini-flash-latest');
        $errors = [];

        // Shuffle keys once to distribute load, then iterate (Round-Robin style for this request)
        // If one fails, we fall back to the next one in the list.
        $keys = $this->apiKeys;
        shuffle($keys); 

        foreach ($keys as $apiKey) {
            try {
                // Initialize client with the current key
                $client = Gemini::client($apiKey);
                
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
                // Log the error for this specific key but don't fail yet
                \Log::warning("Gemini Key Rotation Error: " . $e->getMessage());
                $errors[] = $e->getMessage();

                // If it's a user-facing error (our custom messages), don't retry with other keys
                if (str_contains($e->getMessage(), 'diblokir') || 
                    str_contains($e->getMessage(), 'berhak cipta') ||
                    str_contains($e->getMessage(), 'terpotong') ||
                    str_contains($e->getMessage(), 'respons kosong')) {
                    throw $e; // Re-throw immediately
                }
                
                continue; // Try next key for quota/network errors
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

        $prompt = "Anda adalah asisten ahli penyusunan SKP ASN.
                   Tugas: Buat dokumen SKP lengkap dalam 3 TABEL TERPISAH berdasarkan data berikut.

                   CONTEXT:
                   - PEGAWAI: {$pegawai}
                   - ATASAN: {$atasan}
                   - PERIODE: {$periode}
                   
                   DATA RHK:
                   {$rhk_list}

                   INSTRUKSI OUTPUT (WAJIB FORMAT MARKDOWN):

                   ### Tabel 1: Rencana Hasil Kinerja (RHK)
                   Buat tabel dengan kolom: | No | Rencana Hasil Kerja | Indikator Kinerja | Target |
                   - Bariskan setiap RHK.
                   - Pada kolom Indikator Kinerja, sebutkan aspek (Kuantitas, Kualitas, Waktu).
                   - Pada kolom Target, tentukan angka/deskripsi target yang relevan (misal: 1 Dokumen, 100%, 1 Bulan).

                   ### Tabel 2: Rencana Aksi
                   Buat tabel dengan kolom: | No RHK | Rencana Aksi | Target Output | Target Waktu |
                   - Setiap RHK WAJIB memiliki MINIMAL 5 Rencana Aksi.
                   - Target Output maksimal 45 karakter (singkat & padat).
                   - Target Waktu jelas (misal: Jan 2024, Mingguan).

                   ### Tabel 3: Perilaku Kerja Individu
                   Buat tabel Perilaku Kerja berdasarkan Core Value ASN (BerAKHLAK) yang disesuaikan dengan aktivitas RHK di atas.
                   Kolom: | No | Core Value | Panduan Perilaku (Kode Etik) |
                   Isi untuk 7 nilai:
                   1. Berorientasi Pelayanan
                   2. Akuntabel
                   3. Kompeten
                   4. Harmonis
                   5. Loyal
                   6. Adaptif
                   7. Kolaboratif
                   
                   Gunakan Bahasa Indonesia formal & baku.";
        
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

        $prompt = "Anda adalah asisten ahli kepegawaian (HR) instansi pemerintah.
                   Tugas: Buat dokumen Penilaian Atasan (Ekspektasi & Umpan Balik) dalam 2 TABEL TERPISAH.

                   CONTEXT:
                   - ATASAN (Penilai): {$atasan}
                   - BAWAHAN (Dinilai): {$bawahan}
                   - PERIODE: {$periode}
                   - TUGAS POKOK BAWAHAN: \n{$tugas_list}

                   INSTRUKSI OUTPUT (WAJIB FORMAT MARKDOWN):

                   ### Tabel 1: Ekspektasi Pimpinan (Perilaku Kerja BerAKHLAK)
                   Kolom: | No | Core Value ASN | Ekspektasi Pimpinan |
                   Isi untuk 7 nilai (Berorientasi Pelayanan, Akuntabel, Kompeten, Harmonis, Loyal, Adaptif, Kolaboratif).
                   - Kolom Ekspektasi: Deskripsikan harapan spesifik pimpinan terhadap bawahan untuk setiap value.

                   ### Tabel 2: Umpan Balik (Perilaku Kerja & Pengembangan)
                   Kolom: | No | Core Value ASN | Deskripsi Umpan Balik (Positif & Konstruktif) |
                   Isi untuk 7 nilai tersebut.
                   - Berikan feedback seimbang: apresiasi positif dan saran perbaikan/pengembangan (konstruktif).

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
