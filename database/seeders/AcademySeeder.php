<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;

class AcademySeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        //  KURSUS 1: Memulai Bisnis Produk Digital
        // ==========================================
        $course1 = Course::create([
            'title' => 'Memulai Bisnis Produk Digital',
            'slug' => 'memulai-bisnis-produk-digital',
            'description' => 'Panduan praktis dari nol hingga menghasilkan lewat produk digital. Cocok untuk pemula yang ingin membangun sumber penghasilan online.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        // Module 1
        $m1 = Module::create(['course_id' => $course1->id, 'title' => 'Mindset & Pondasi', 'sort_order' => 1]);
        Lesson::create(['module_id' => $m1->id, 'title' => 'Kenapa Produk Digital?', 'sort_order' => 1, 'content' => '<h2>Mengapa Produk Digital?</h2><p>Produk digital memiliki keunggulan dibandingkan produk fisik:</p><ul><li><strong>Tanpa stok fisik</strong> — Tidak perlu gudang, tidak perlu pengiriman.</li><li><strong>Margin tinggi</strong> — Biaya produksi hampir nol setelah dibuat.</li><li><strong>Scalable</strong> — Bisa dijual ke ribuan orang tanpa effort tambahan.</li><li><strong>Passive Income</strong> — Sekali buat, bisa menghasilkan terus-menerus.</li></ul><p>Contoh produk digital: E-book, template desain, kursus online, preset foto, plugin, dan masih banyak lagi.</p>']);
        Lesson::create(['module_id' => $m1->id, 'title' => 'Mentalitas Kreator vs Konsumer', 'sort_order' => 2, 'content' => '<h2>Shifting Mindset</h2><p>Langkah pertama untuk sukses di bisnis digital adalah mengubah cara berpikir dari <strong>konsumer</strong> menjadi <strong>kreator</strong>.</p><blockquote>Konsumer bertanya: "Berapa harganya?"<br>Kreator bertanya: "Bagaimana cara membuatnya?"</blockquote><h3>Tips Membangun Mentalitas Kreator:</h3><ol><li>Mulai dari masalah yang Anda alami sendiri</li><li>Catat setiap ide, sekecil apapun</li><li>Jangan tunggu sempurna — launch dulu, perbaiki kemudian</li><li>Konsisten > inspirasi</li></ol>']);
        Lesson::create(['module_id' => $m1->id, 'title' => 'Tools yang Dibutuhkan', 'sort_order' => 3, 'content' => '<h2>Peralatan Wajib untuk Memulai</h2><p>Anda tidak perlu tools mahal untuk memulai. Berikut tools gratis dan murah yang bisa digunakan:</p><h3>Desain & Konten</h3><ul><li><strong>Canva</strong> — Desain grafis, presentasi, social media post</li><li><strong>Google Docs</strong> — Menulis naskah, ebook draft</li><li><strong>Notion</strong> — Organisasi konten dan project management</li></ul><h3>Platform Jual</h3><ul><li><strong>Lynk.id</strong> — Marketplace produk digital Indonesia</li><li><strong>Gumroad</strong> — Platform internasional yang populer</li><li><strong>Shopee Digital</strong> — Jangkauan lokal yang luas</li></ul><h3>Marketing</h3><ul><li><strong>Instagram</strong> — Konten visual + edukasi</li><li><strong>TikTok</strong> — Konten viral untuk awareness</li><li><strong>WhatsApp Business</strong> — Closing dan follow-up</li></ul>']);

        // Module 2
        $m2 = Module::create(['course_id' => $course1->id, 'title' => 'Problem Fit', 'sort_order' => 2]);
        Lesson::create(['module_id' => $m2->id, 'title' => 'Menemukan Masalah yang Layak Dijual', 'sort_order' => 1, 'content' => '<h2>Problem-First Approach</h2><p>Produk digital yang laku bukan yang paling keren, tapi yang paling <strong>menyelesaikan masalah nyata</strong>.</p><h3>Framework Menemukan Masalah:</h3><ol><li><strong>Observasi kehidupan sehari-hari</strong> — Apa yang sering Anda atau orang lain keluhkan?</li><li><strong>Browsing komunitas</strong> — Cek forum, grup Facebook, Twitter threads</li><li><strong>Analisis kompetitor</strong> — Apa yang sudah dijual? Apa yang bisa diperbaiki?</li></ol><h3>Contoh Problem → Solusi:</h3><table><tr><th>Masalah</th><th>Produk Digital</th></tr><tr><td>Bingung buat CV</td><td>Template CV Canva</td></tr><tr><td>Foto jelek di HP</td><td>Preset Lightroom</td></tr><tr><td>Tidak bisa desain</td><td>Template Social Media</td></tr></table>']);
        Lesson::create(['module_id' => $m2->id, 'title' => 'Validasi Ide dengan Cepat', 'sort_order' => 2, 'content' => '<h2>Jangan Langsung Buat — Validasi Dulu!</h2><p>Banyak pemula menghabiskan berminggu-minggu membuat produk yang tidak ada pembelinya. Validasi dulu sebelum invest waktu.</p><h3>Cara Validasi Cepat:</h3><ol><li><strong>Pre-sell</strong> — Tawarkan dulu, buat setelah ada pembeli</li><li><strong>Survey singkat</strong> — Tanya 10-20 orang target market</li><li><strong>Landing page test</strong> — Buat halaman sederhana, lihat berapa yang klik "Beli"</li><li><strong>Cek Google Trends</strong> — Apakah topiknya sedang dicari?</li></ol><blockquote><strong>Rule of thumb:</strong> Jika 3 dari 10 orang bilang "saya mau beli", maka ide-nya layak dieksekusi.</blockquote>']);

        // Module 3
        $m3 = Module::create(['course_id' => $course1->id, 'title' => 'Product Development', 'sort_order' => 3]);
        Lesson::create(['module_id' => $m3->id, 'title' => 'Membuat MVP (Minimum Viable Product)', 'sort_order' => 1, 'content' => '<h2>Start Small, Ship Fast</h2><p>MVP adalah versi paling sederhana dari produk Anda yang sudah bisa memberikan nilai kepada pembeli.</p><h3>Contoh MVP:</h3><ul><li>Ebook 20 halaman (bukan 200 halaman)</li><li>Template Canva 10 desain (bukan 100)</li><li>Kursus 5 video (bukan 50 video)</li></ul><h3>Langkah Membuat MVP:</h3><ol><li>Tentukan 1 masalah utama yang ingin diselesaikan</li><li>Buat solusi paling sederhana untuk masalah itu</li><li>Kemas dengan desain yang rapi (tidak perlu mewah)</li><li>Launch dalam 1 minggu, bukan 1 bulan</li></ol>']);
        Lesson::create(['module_id' => $m3->id, 'title' => 'Strategi Pricing yang Efektif', 'sort_order' => 2, 'content' => '<h2>Berapa Harga yang Tepat?</h2><p>Harga bukan soal murah atau mahal, tapi soal <strong>perceived value</strong>.</p><h3>Framework Pricing:</h3><ul><li><strong>Anchor pricing</strong> — Tampilkan "harga normal" yang lebih tinggi, lalu tunjukkan harga diskon</li><li><strong>Bundle</strong> — Gabungkan beberapa produk menjadi satu paket dengan harga lebih murah dari total</li><li><strong>Tiered pricing</strong> — Basic, Standard, Premium</li></ul><h3>Rule of Thumb Harga Produk Digital:</h3><table><tr><th>Tipe Produk</th><th>Range Harga</th></tr><tr><td>Template/Preset</td><td>Rp 29k - 99k</td></tr><tr><td>E-book</td><td>Rp 49k - 199k</td></tr><tr><td>Online Course</td><td>Rp 149k - 999k</td></tr></table>']);

        // Module 4
        $m4 = Module::create(['course_id' => $course1->id, 'title' => 'Marketing & Growth', 'sort_order' => 4]);
        Lesson::create(['module_id' => $m4->id, 'title' => 'Content Marketing untuk Pemula', 'sort_order' => 1, 'content' => '<h2>Jualan Tanpa Terlihat Jualan</h2><p>Content marketing adalah strategi menarik pembeli dengan memberikan konten yang bermanfaat terlebih dahulu.</p><h3>Formula Konten yang Bekerja:</h3><ol><li><strong>70% Edukasi</strong> — Tips, tutorial, insight</li><li><strong>20% Personal</strong> — Behind the scene, cerita perjalanan</li><li><strong>10% Promosi</strong> — CTA langsung, penawaran</li></ol><h3>Platform Terbaik untuk Content Marketing:</h3><ul><li><strong>Instagram Carousel</strong> — Engagement tinggi, mudah di-share</li><li><strong>TikTok</strong> — Potensi viral, jangkauan organik besar</li><li><strong>Twitter/X Thread</strong> — Cocok untuk konten edukasi mendalam</li></ul>']);
        Lesson::create(['module_id' => $m4->id, 'title' => 'Strategi Launch Day', 'sort_order' => 2, 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'content' => '<h2>Cara Launch Produk yang Membuat Antusias</h2><p>Launch day yang baik bisa menghasilkan 30-50% dari total pendapatan bulanan Anda.</p><h3>Timeline Launch:</h3><ol><li><strong>H-7: Teaser</strong> — Mulai hint di social media</li><li><strong>H-3: Countdown</strong> — Tampilkan preview produk</li><li><strong>H-1: Early Bird</strong> — Buka pre-order dengan harga spesial</li><li><strong>D-Day: Launch!</strong> — Announcement besar di semua channel</li><li><strong>H+3: Social Proof</strong> — Share testimoni pembeli pertama</li></ol><blockquote><strong>Pro tip:</strong> Siapkan minimal 10 testimoni atau review sebelum launch day.</blockquote>']);

        // Module 5 (Bonus)
        $m5 = Module::create(['course_id' => $course1->id, 'title' => 'BONUS: Tutorial Platform', 'sort_order' => 5]);
        Lesson::create(['module_id' => $m5->id, 'title' => 'Tutorial Lengkap Lynk.id', 'sort_order' => 1, 'content' => '<h2>Setup Toko di Lynk.id</h2><p>Lynk.id adalah platform Indonesia untuk menjual produk digital. Berikut langkah-langkah setup:</p><ol><li>Daftar di <strong>lynk.id</strong> menggunakan email</li><li>Lengkapi profil toko (nama, foto, bio)</li><li>Klik <strong>"Tambah Produk"</strong></li><li>Isi detail produk: judul, deskripsi, harga</li><li>Upload file produk digital Anda</li><li>Atur metode pembayaran (bank transfer, e-wallet)</li><li><strong>Publish!</strong></li></ol><h3>Tips Optimasi Toko Lynk.id:</h3><ul><li>Gunakan foto cover yang menarik</li><li>Tulis deskripsi yang menjelaskan manfaat, bukan fitur</li><li>Tambahkan FAQ di deskripsi</li><li>Aktifkan semua metode pembayaran</li></ul>']);
        Lesson::create(['module_id' => $m5->id, 'title' => 'Tutorial Canva untuk Produk Digital', 'sort_order' => 2, 'content' => '<h2>Desain Produk Digital dengan Canva</h2><p>Canva adalah tools desain gratis yang powerful untuk membuat berbagai produk digital:</p><h3>Yang Bisa Dibuat di Canva:</h3><ul><li>Cover ebook</li><li>Template social media</li><li>Mockup produk</li><li>Presentasi/slide kursus</li><li>Infografis</li></ul><h3>Tips Desain Canva:</h3><ol><li><strong>Gunakan brand kit</strong> — Set warna dan font yang konsisten</li><li><strong>Manfaatkan template</strong> — Jangan mulai dari nol, modifikasi template yang ada</li><li><strong>Simpan sebagai PDF</strong> — Untuk ebook dan dokumen</li><li><strong>Gunakan Canva Pro</strong> — Background remover dan magic resize sangat berguna</li></ol>']);


        // ==========================================
        //  KURSUS 2: Copywriting Mastery
        // ==========================================
        $course2 = Course::create([
            'title' => 'Copywriting Mastery',
            'slug' => 'copywriting-mastery',
            'description' => 'Kuasai seni menulis copy yang menjual. Dari headline, body copy, hingga CTA yang mengkonversi.',
            'status' => 'published',
            'sort_order' => 2,
        ]);

        $m6 = Module::create(['course_id' => $course2->id, 'title' => 'Dasar Copywriting', 'sort_order' => 1]);
        Lesson::create(['module_id' => $m6->id, 'title' => 'Apa itu Copywriting?', 'sort_order' => 1, 'content' => '<h2>Copywriting ≠ Copyright</h2><p>Copywriting adalah seni dan ilmu menulis teks (copy) yang bertujuan untuk membujuk pembaca melakukan tindakan tertentu — membeli, mendaftar, mengklik, atau menghubungi.</p><h3>Mengapa Copywriting Penting?</h3><ul><li>Produk bagus + copy jelek = tidak laku</li><li>Produk biasa + copy bagus = bisa laku keras</li><li>Copy yang baik adalah "salesman 24/7" Anda</li></ul><h3>Jenis-jenis Copy:</h3><table><tr><th>Jenis</th><th>Contoh Penggunaan</th></tr><tr><td>Ads Copy</td><td>Facebook Ads, Google Ads, Instagram Ads</td></tr><tr><td>Landing Page</td><td>Halaman penjualan produk</td></tr><tr><td>Email Copy</td><td>Newsletter, email promo</td></tr><tr><td>Social Media Copy</td><td>Caption Instagram, tweet</td></tr></table>']);
        Lesson::create(['module_id' => $m6->id, 'title' => 'Formula AIDA', 'sort_order' => 2, 'content' => '<h2>AIDA: Formula Copy Paling Klasik</h2><p><strong>AIDA</strong> adalah framework copywriting yang sudah terbukti selama lebih dari 100 tahun:</p><ol><li><strong>A - Attention (Perhatian)</strong><br>Hook pembaca dalam 3 detik pertama. Gunakan headline yang memicu rasa ingin tahu.</li><li><strong>I - Interest (Ketertarikan)</strong><br>Bangun minat dengan fakta, statistik, atau cerita yang relate.</li><li><strong>D - Desire (Keinginan)</strong><br>Tunjukkan manfaat dan hasil yang akan didapat. Gunakan social proof.</li><li><strong>A - Action (Tindakan)</strong><br>CTA yang jelas dan spesifik. "Beli Sekarang", "Daftar Gratis".</li></ol><h3>Contoh AIDA dalam Iklan:</h3><blockquote><strong>A:</strong> "90% freelancer gagal di tahun pertama..."<br><strong>I:</strong> "...karena mereka tidak tahu cara mendapatkan klien secara konsisten."<br><strong>D:</strong> "Dalam kursus ini, Anda akan belajar 5 strategi yang sudah dipakai 1000+ freelancer sukses."<br><strong>A:</strong> "Daftar sekarang — hanya Rp 99k (harga naik besok)"</blockquote>']);

        $m7 = Module::create(['course_id' => $course2->id, 'title' => 'Headline Mastery', 'sort_order' => 2]);
        Lesson::create(['module_id' => $m7->id, 'title' => '10 Template Headline yang Terbukti', 'sort_order' => 1, 'content' => '<h2>Headline = 80% Keberhasilan Copy</h2><p>David Ogilvy pernah berkata: <em>"Rata-rata, 5x lebih banyak orang membaca headline dibanding body copy."</em></p><h3>10 Template Headline:</h3><ol><li><strong>How To:</strong> "Cara [Hasil] Tanpa [Hambatan]"</li><li><strong>Number List:</strong> "7 Rahasia [Topik] yang Jarang Diketahui"</li><li><strong>Question:</strong> "Apakah Anda Masih [Masalah]?"</li><li><strong>Testimonial:</strong> "Bagaimana [Nama] Menghasilkan [Hasil] dalam [Waktu]"</li><li><strong>Warning:</strong> "Jangan [Tindakan] Sebelum Baca Ini"</li><li><strong>Secret:</strong> "Rahasia [Target] yang Tidak Ingin Anda Ketahui"</li><li><strong>Challenge:</strong> "[Hasil] dalam [Waktu] — Berani Coba?"</li><li><strong>Newsjacking:</strong> "[Topik Trending]: Ini yang Harus Anda Tahu"</li><li><strong>Comparison:</strong> "[A] vs [B]: Mana yang Lebih [Benefit]?"</li><li><strong>Direct:</strong> "[Produk]: [Manfaat Utama] untuk [Target Market]"</li></ol>']);

        // ==========================================
        //  KURSUS 3: Draft (belum published)
        // ==========================================
        $course3 = Course::create([
            'title' => 'Personal Branding di Era AI',
            'slug' => 'personal-branding-era-ai',
            'description' => 'Bangun personal brand yang kuat di tengah era AI. Pelajari cara menonjol dan tetap relevan.',
            'status' => 'draft',
            'sort_order' => 3,
        ]);

        $m8 = Module::create(['course_id' => $course3->id, 'title' => 'Introduksi', 'sort_order' => 1]);
        Lesson::create(['module_id' => $m8->id, 'title' => 'Mengapa Personal Branding Penting?', 'sort_order' => 1, 'content' => '<h2>Coming Soon</h2><p>Materi ini sedang dalam proses penyusunan. Stay tuned!</p>']);
    }
}
