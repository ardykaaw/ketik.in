<?php

namespace App\Services;

use Gemini\Client;
use Gemini;

class AiService
{
    protected Client $client;

    public function __construct()
    {
        $apiKey = config('gemini.api_key');
        if (!$apiKey) {
            throw new \Exception('Gemini API Key is not configured.');
        }
        $this->client = Gemini::client($apiKey);
    }

    /**
     * Generate content based on a prompt.
     */
    public function generate(string $prompt): string
    {
        try {
            $model = config('gemini.model', 'gemini-flash-latest');
            $result = $this->client->generativeModel($model)->generateContent($prompt);
            return $result->text();
        } catch (\Exception $e) {
            \Log::error('Gemini Generation Error: ' . $e->getMessage());
            throw new \Exception('Gagal menghasilkan konten dari AI. Silakan coba lagi nanti.');
        }
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

                   ### 1. EVALUASI HASIL KERJA (TABEL SKP)
                   Buatlah SATU tabel besar yang mencakup SEMUA RHK di atas.
                   Kolom tabel: | Rencana Hasil Kerja Pimpinan yang Diintervensi | Rencana Hasil Kerja | Aspek | Indikator Kinerja Individu | Target |
                   (Pastikan setiap satu RHK memiliki 3 baris Aspek: Kuantitas, Kualitas, dan Waktu).

                   ### 2. RENCANA AKSI
                   Berikan daftar langkah strategis untuk mencapai RHK-RHK di atas. 
                   Tuliskan dalam format list sederhana agar mudah diedit pengguna:
                   - [Aksi 1]
                   - [Aksi 2]
                   ...dan seterusnya.

                   ### 3. PERILAKU KERJA (BerAKHLAK)
                   Pilih Core Value paling relevan, lalu berikan:
                   - **Ekspektasi Khusus Pimpinan**: (Berikan 2-3 kalimat formal pimpinan)

                   Gunakan Bahasa Indonesia Kedinasan yang baku. Pastikan Target angka logis sesuai periode.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate a News Article.
     */
    public function generateNews(string $topic, string $style)
    {
        $prompt = "Buatkan sebuah berita (News Article) tentang: {$topic}. 
                   Gaya Penulisan: {$style}. 
                   Struktur berita harus mencakup Headline (Judul Utama) yang menarik di baris pertama, Lead (Teras Berita) yang merangkum 5W+1H, dan Tubuh Berita yang detail serta informatif. 
                   Gunakan Bahasa Indonesia Jurnalistik yang sesuai dengan etika pers.";
        
        return $this->generate($prompt);
    }

    /**
     * Generate a Speech (Kata Sambutan).
     */
    public function generateSpeech(string $event, string $audience, string $tone)
    {
        $prompt = "Buatkan sebuah teks Kata Sambutan untuk acara: {$event}. 
                   Target Audiens: {$audience}. 
                   Nada/Vibe: {$tone}. 
                   Struktur harus mencakup Salam Pembuka, Ucapan Syukur, Isi Sambutan yang sesuai dengan tema acara, dan Penutup yang berkesan. 
                   Gunakan Bahasa Indonesia yang sopan, runtut, dan profesional.";
        
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
}
