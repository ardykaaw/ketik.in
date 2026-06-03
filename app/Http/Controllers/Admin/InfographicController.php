<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfographicController extends Controller
{
    public function index()
    {
        $infographics = collect();
        $disk = Storage::disk('public');
        if ($disk->exists('infographics')) {
            $files = $disk->files('infographics');
            $infographics = collect($files)->sortByDesc(fn($f) => $disk->lastModified($f))->map(fn($f) => [
                'path' => $f,
                'url' => asset('storage/' . $f),
                'name' => basename($f),
                'size' => round($disk->size($f) / 1024),
                'date' => date('d M Y H:i', $disk->lastModified($f)),
            ])->values();
        }
        return view('admin.infographic.index', compact('infographics'));
    }

    /**
     * Generate infographic content using Gemini AI.
     * Returns structured JSON data for frontend HTML/CSS rendering.
     */
    public function generate(Request $request)
    {
        try {
            $request->validate([
                'topik' => 'required|string|max:255',
                'jenis' => 'required|string|in:tips,statistik,proses,perbandingan,timeline,fakta',
                'poin' => 'nullable|string|max:2000',
                'warna' => 'required|string|in:blue,orange,green,dark,purple,red',
                'gaya' => 'required|string|in:modern,bold,minimal,corporate',
            ]);

            $aiService = app(AiService::class);
            $prompt = $this->buildPrompt($request);
            $raw = $aiService->generate($prompt);

            $json = $this->extractJson($raw);

            if (!$json) {
                \Log::error('Failed to parse AI response for infographic', ['raw' => substr($raw, 0, 500)]);
                return response()->json(['error' => 'AI gagal membuat konten terstruktur. Silakan coba lagi.'], 500);
            }

            return response()->json([
                'success' => true,
                'data' => $json,
                'warna' => $request->warna,
                'gaya' => $request->gaya,
                'jenis' => $request->jenis,
                'layout' => $json['layout'] ?? 'portrait_classic',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => collect($e->errors())->flatten()->first()], 422);
        } catch (\Exception $e) {
            \Log::error('Infographic generate error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store captured infographic image from frontend (base64 PNG via html2canvas).
     */
    public function storeImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string',
                'topik' => 'required|string|max:255',
            ]);

            $imageData = $request->image;
            if (str_contains($imageData, ',')) {
                $imageData = explode(',', $imageData)[1];
            }

            $decoded = base64_decode($imageData);
            if (!$decoded) {
                return response()->json(['error' => 'Data gambar tidak valid.'], 400);
            }

            $filename = 'infographics/' . Str::slug($request->topik) . '-' . time() . '.png';
            Storage::disk('public')->put($filename, $decoded);

            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $filename),
                'path' => $filename,
                'size' => round(strlen($decoded) / 1024),
            ]);

        } catch (\Exception $e) {
            \Log::error('Infographic store error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    // ================================
    //  HELPERS
    // ================================

    private function buildPrompt(Request $request): string
    {
        $userPoin = $request->poin
            ? "\n\nUser telah menyediakan poin-poin berikut sebagai panduan konten:\n" . $request->poin
            : '';

        $jenisGuide = match ($request->jenis) {
            'tips'        => 'Buat 5-6 tips praktis. Setiap tips punya judul singkat (2-4 kata) dan penjelasan 1 kalimat.',
            'statistik'   => 'Buat 3-4 data statistik menarik (dengan angka/persentase realistis) dan 2-3 insight.',
            'proses'      => 'Buat 4-6 langkah proses berurutan. Setiap langkah punya judul dan penjelasan singkat.',
            'perbandingan' => 'Buat perbandingan 2 hal dengan masing-masing 3-4 poin perbedaan.',
            'timeline'    => 'Buat 4-6 milestone/event kronologis dengan tahun/waktu dan deskripsi singkat.',
            'fakta'       => 'Buat 4-6 fakta menarik yang mengejutkan. Sertakan angka/data jika memungkinkan.',
            default       => 'Buat 4-6 poin utama dengan penjelasan singkat.',
        };

        $gayaGuide = match ($request->gaya) {
            'modern'    => 'Gunakan gaya desain modern yang dinamis dengan elemen-elemen visual yang variatif.',
            'bold'      => 'Gunakan gaya desain bold/tebal yang eye-catching dengan penekanan kuat.',
            'minimal'   => 'Gunakan gaya desain minimalis yang bersih dan elegan.',
            'corporate' => 'Gunakan gaya desain korporat yang profesional dan formal.',
            default     => 'Gunakan gaya desain modern.',
        };

        $layoutRule = '';
        if ($request->layout && $request->layout !== 'auto') {
            $layoutRule = "PENTING — FORCE LAYOUT:\nUser SECARA SPESIFIK meminta menggunakan layout: \"{$request->layout}\".\nKamu HARUS dan WAJIB mengembalikan properti \"layout\": \"{$request->layout}\" dalam JSON.";
        } else {
            $layoutRule = <<<LAYOUT
PENTING — PILIH LAYOUT:
Kamu HARUS memilih SATU layout yang PALING COCOK untuk topik dan jenis konten ini. Pilihan layout:

1. "portrait_classic" — Format vertikal standar (800px lebar). Cocok untuk tips umum, fakta, dan konten ringkas.
2. "landscape_grid" — Format mendatar (1200px lebar). Cocok untuk perbandingan, statistik banyak, atau data yang perlu ruang horizontal.
3. "portrait_timeline" — Format vertikal dengan alur langkah (800px lebar). Cocok untuk proses, timeline, tutorial, atau kronologis.
4. "landscape_split" — Format mendatar dua kolom (1200px lebar). Bagian kiri untuk judul hero besar, bagian kanan untuk konten poin. Cocok untuk presentasi, ringkasan eksekutif, atau konten bersifat narasi.
5. "landscape_chart" — Format mendatar (1200px lebar) dengan grafik batang. SANGAT COCOK untuk statistik yang berisi angka atau perbandingan numerik.

JANGAN selalu memilih "portrait_classic". Variasikan pilihan berdasarkan topik. Jika topik tentang proses/langkah, pilih "portrait_timeline". Jika statistik angka/data, pilih "landscape_chart". Jika perbandingan/statistik banyak, pilih "landscape_grid". Jika presentasi/ringkasan, pilih "landscape_split".
LAYOUT;
        }

        return <<<PROMPT
Kamu adalah ahli pembuat konten infografis profesional berkelas dunia.
Buatkan konten terstruktur untuk infografis dengan topik: "{$request->topik}".

Jenis infografis: {$request->jenis}
Gaya desain: {$request->gaya}
Panduan konten: {$jenisGuide}
Panduan gaya: {$gayaGuide}
{$userPoin}

{$layoutRule}

WAJIB kembalikan HANYA dalam format JSON VALID. TANPA markdown code block, TANPA backtick, TANPA penjelasan tambahan. Langsung JSON saja.

Struktur JSON yang HARUS diikuti:

{
  "layout": "portrait_classic",
  "judul": "Judul Utama (maks 6 kata, powerful & menarik)",
  "subjudul": "Kalimat pendek penjelas judul (maks 15 kata)",
  "intro": "Paragraf pengantar singkat 1-2 kalimat yang menjelaskan topik secara menarik",
  "image_prompt": "A realistic 2D digital illustration of [describe a person/object related to the topic], isolated on pure white background, flat even lighting, clean edges, professional style",
  "statistik_utama": {
    "angka": "85%",
    "label": "Deskripsi singkat angka ini (maks 8 kata)"
  },
  "statistik_tambahan": [
    {
      "angka": "10x",
      "label": "Deskripsi singkat (maks 6 kata)"
    }
  ],
  "grafik_data": {
    "satuan": "Juta / Persen / Ribu (sesuaikan)",
    "data": [
      {"label": "Kategori A", "nilai": 75, "warna": "primary"},
      {"label": "Kategori B", "nilai": 90, "warna": "secondary"},
      {"label": "Kategori C", "nilai": 45, "warna": "tertiary"}
    ]
  },
  "section_title": "Judul untuk bagian poin-poin (maks 5 kata, contoh: Pentingnya Literasi Anak)",
  "poin": [
    {
      "judul": "Judul Poin (2-4 kata)",
      "deskripsi": "Penjelasan singkat maksimal 2 kalimat",
      "asset_image": "book"
    }
  ],
  "call_to_action": "Kalimat ajakan penutup yang memotivasi (maks 8 kata)",
  "sub_cta": [
    {
      "icon": "check-circle",
      "teks": "Aksi singkat (maks 5 kata)"
    }
  ],
  "kategori_visual": "pendidikan"
}

ATURAN KETAT:
- "layout" WAJIB ada dan bernilai SALAH SATU dari: portrait_classic, landscape_grid, portrait_timeline, landscape_split, landscape_chart
- "image_prompt" WAJIB diisi dengan prompt gambar berbahasa Inggris untuk AI image generator (HARUS ada teks "isolated on pure white background").
- "grafik_data" WAJIB diisi jika layout "landscape_chart" (buat 3-5 batang). Jika layout lain, isi null atau array kosong.
- "poin" harus berisi 4-6 item
- "statistik_tambahan" berisi 2-3 item
- "sub_cta" berisi 3-4 item aksi singkat
- Angka statistik harus realistis dan relevan dengan topik
- Untuk "asset_image" pada "poin", HARUS memilih SATU dari nama berikut yang paling relevan dengan isi poin tersebut: money, chart, book, laptop, lightbulb, rocket, target, trophy, search, shield, heart, briefcase, check, warning, people, globe, education, bank, building, star, idea, time, health, food, car, home, phone, music, art, nature. Jika tidak ada yang cocok sama sekali, gunakan 'star'.
- "icon" pada "sub_cta" HARUS nama icon Lucide.
- JANGAN bungkus dengan backtick atau code block. LANGSUNG tulis JSON-nya.
PROMPT;
    }

    private function extractJson(string $raw): ?array
    {
        // Direct parse
        $data = json_decode(trim($raw), true);
        if ($data && isset($data['judul'])) return $data;

        // Extract from markdown code block
        if (preg_match('/```(?:json)?\s*\n?(.*?)\n?\s*```/s', $raw, $m)) {
            $data = json_decode(trim($m[1]), true);
            if ($data && isset($data['judul'])) return $data;
        }

        // Find JSON object in text
        if (preg_match('/\{[\s\S]*\}/m', $raw, $m)) {
            $data = json_decode($m[0], true);
            if ($data && isset($data['judul'])) return $data;
        }

        return null;
    }

    public function destroy(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        Storage::disk('public')->delete($request->path);
        return redirect()->route('admin.infographic.index')->with('success', 'Infografis berhasil dihapus!');
    }
}
