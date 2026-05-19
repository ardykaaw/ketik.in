<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

            $lebar = 800;
        $tinggi = 1200;
        $canvas = imagecreatetruecolor($lebar, $tinggi);

        // 1. Generate background dari AI (Pollinations.ai gratis)
        $bgPrompt = 'Minimalist abstract geometric infographic background, flat vector style, ' . $request->warna . ' color palette, copy space, clean, no text, no words, ultra detailed, soft gradient';
        $bgUrl = 'https://image.pollinations.ai/prompt/' . urlencode($bgPrompt) . '?width=800&height=1200&seed=' . rand(1, 9999) . '&nologo=true';

        $bgLoaded = false;
        try {
            $resp = Http::timeout(60)->get($bgUrl);
            if ($resp->successful()) {
                $bg = @imagecreatefromstring($resp->body());
                if ($bg) {
                    imagecopyresampled($canvas, $bg, 0, 0, 0, 0, $lebar, $tinggi, imagesx($bg), imagesy($bg));
                    imagedestroy($bg);
                    $bgLoaded = true;
                }
            }
        } catch (\Exception $e) {
            \Log::warning('BG load failed: ' . $e->getMessage());
        }

        if (!$bgLoaded) {
            $this->drawFallbackBackground($canvas, $lebar, $tinggi, $request->warna);
        }

        // 2. Overlay semi-transparan agar teks lebih terbaca
        $this->drawOverlay($canvas, $lebar, $tinggi);

        // 3. Parse poin-poin
        $poinList = array_values(array_filter(array_map('trim', explode("\n", $request->poin ?? ''))));
        if (empty($poinList)) {
            $poinList = ['Poin utama 1', 'Poin utama 2', 'Poin utama 3'];
        }

        $pal = $this->colorPalette($request->warna);
        $fonts = $this->fontPaths();

        // Judul besar
        $judul = strtoupper($request->topik);
        $this->ttfCenter($canvas, $judul, $lebar / 2, 130, 34, $pal['dark'], $fonts['bold']);

        // Sub-judul / jenis
        $sub = $this->jenisLabel($request->jenis);
        $this->ttfCenter($canvas, $sub, $lebar / 2, 178, 18, $pal['dark'], $fonts['regular']);

        // Garis pembatas
        $this->drawLine($canvas, $lebar / 2 - 80, 215, $lebar / 2 + 80, 215, $pal['primary'], 4);

        // Angka statistik (poin pertama dianggap statistik)
        $stat = $this->extractStat($poinList[0]);
        $this->drawCircleAlpha($canvas, $lebar / 2, 380, 105, $pal['primary'], 18);
        $this->ttfCenter($canvas, $stat, $lebar / 2, 405, 84, $pal['primary'], $fonts['black']);

        // Label statistik
        $this->ttfWrapCenter($canvas, $poinList[0], $lebar / 2, 530, 540, 24, $pal['dark'], $fonts['bold']);

        // Poin-poin sebagai card
        $y = 640;
        foreach (array_slice($poinList, 1) as $poin) {
            $this->drawRoundedRect($canvas, 90, $y, 620, 90, 14, array_merge($pal['light'], [40]));
            $this->ttfWrap($canvas, $poin, 120, $y + 32, 560, 20, $pal['dark'], $fonts['regular']);
            $y += 115;
        }

        // Simpan
        $filename = 'infographics/' . Str::slug($request->topik) . '-' . time() . '.png';
        $fullPath = storage_path('app/public/' . $filename);
        if (!is_dir(dirname($fullPath))) mkdir(dirname($fullPath), 0755, true);
        imagepng($canvas, $fullPath, 6);
        imagedestroy($canvas);

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $filename),
            'path' => $filename,
            'size' => round(filesize($fullPath) / 1024),
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => collect($e->errors())->flatten()->first()], 422);
        } catch (\Exception $e) {
            \Log::error('Infographic generate error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // ================================
    //  HELPERS
    // ================================

    private function fontPaths()
    {
        $candidates = [
            '/System/Library/Fonts/Supplemental/Arial Bold.ttf',
            '/System/Library/Fonts/Supplemental/Arial.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
        ];
        $bold = collect($candidates)->first(fn($p) => file_exists($p)) ?: null;
        $regular = str_replace('Bold', '', $bold);
        if ($regular && !file_exists($regular)) {
            $regular = collect($candidates)->reject(fn($p) => str_contains($p, 'Bold'))->first(fn($p) => file_exists($p)) ?: null;
        }
        return ['bold' => $bold, 'regular' => $regular ?: $bold, 'black' => $bold];
    }

    private function colorPalette($warna)
    {
        $p = [
            'blue'   => ['primary' => [59,130,246], 'dark' => [15,23,42], 'light' => [239,246,255]],
            'green'  => ['primary' => [34,197,94],  'dark' => [20,83,45],  'light' => [240,253,244]],
            'orange' => ['primary' => [249,115,22], 'dark' => [124,45,18], 'light' => [255,247,237]],
            'purple' => ['primary' => [139,92,246], 'dark' => [76,29,149],  'light' => [245,243,255]],
            'red'    => ['primary' => [239,68,68],  'dark' => [127,29,29],  'light' => [254,242,242]],
            'dark'   => ['primary' => [148,163,184], 'dark' => [248,250,252], 'light' => [30,41,59]],
        ];
        return $p[$warna] ?? $p['blue'];
    }

    private function jenisLabel($jenis)
    {
        return match($jenis) {
            'tips' => 'Tips & Trik', 'statistik' => 'Statistik & Data',
            'proses' => 'Langkah-langkah', 'perbandingan' => 'Perbandingan',
            'timeline' => 'Timeline', 'fakta' => 'Fakta Menarik',
            default => 'Infografis',
        };
    }

    private function extractStat($text)
    {
        if (preg_match('/(\d{1,3}%)/', $text, $m)) return $m[1];
        if (preg_match('/(\d+[.,]?\d*)\s*(juta|miliar|rb|ratus|ribu)/i', $text, $m)) return $m[1];
        if (preg_match('/(\d{1,3})/', $text, $m)) return $m[1];
        return '01';
    }

    private function drawFallbackBackground($img, $w, $h, $warna)
    {
        $grad = $this->colorPalette($warna);
        for ($y = 0; $y < $h; $y++) {
            $r = $grad['light'][0] + ($grad['primary'][0] - $grad['light'][0]) * ($y / $h);
            $g = $grad['light'][1] + ($grad['primary'][1] - $grad['light'][1]) * ($y / $h);
            $b = $grad['light'][2] + ($grad['primary'][2] - $grad['light'][2]) * ($y / $h);
            imageline($img, 0, $y, $w, $y, imagecolorallocate($img, (int)$r, (int)$g, (int)$b));
        }
    }

    private function drawOverlay($img, $w, $h)
    {
        $white = imagecolorallocatealpha($img, 255, 255, 255, min(127, 110));
        imagefilledrectangle($img, 0, 0, $w, $h, $white);
    }

    private function drawLine($img, $x1, $y1, $x2, $y2, $rgb, $thickness)
    {
        $c = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        imagesetthickness($img, $thickness);
        imageline($img, $x1, $y1, $x2, $y2, $c);
        imagesetthickness($img, 1);
    }

    private function drawCircleAlpha($img, $cx, $cy, $r, $rgb, $alpha)
    {
        $alpha = max(0, min(127, $alpha));
        $c = imagecolorallocatealpha($img, $rgb[0], $rgb[1], $rgb[2], $alpha);
        imagefilledellipse($img, $cx, $cy, $r * 2, $r * 2, $c);
    }

    private function drawRoundedRect($img, $x, $y, $w, $h, $r, $rgba)
    {
        $alpha = max(0, min(127, $rgba[3] ?? 0));
        $c = imagecolorallocatealpha($img, $rgba[0], $rgba[1], $rgba[2], $alpha);
        if ($c === false) $c = imagecolorallocate($img, $rgba[0], $rgba[1], $rgba[2]);
        imagefilledrectangle($img, $x + $r, $y, $x + $w - $r, $y + $h, $c);
        imagefilledrectangle($img, $x, $y + $r, $x + $w, $y + $h - $r, $c);
        imagefilledellipse($img, $x + $r, $y + $r, $r * 2, $r * 2, $c);
        imagefilledellipse($img, $x + $w - $r, $y + $r, $r * 2, $r * 2, $c);
        imagefilledellipse($img, $x + $r, $y + $h - $r, $r * 2, $r * 2, $c);
        imagefilledellipse($img, $x + $w - $r, $y + $h - $r, $r * 2, $r * 2, $c);
    }

    private function ttfCenter($img, $text, $x, $y, $size, $rgb, $font)
    {
        if (!$font) return;
        $c = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        $box = imagettfbbox($size, 0, $font, $text);
        $tw = $box[2] - $box[0];
        imagettftext($img, $size, 0, (int)($x - $tw / 2), $y, $c, $font, $text);
    }

    private function ttfWrap($img, $text, $x, $y, $maxW, $lineH, $rgb, $font)
    {
        if (!$font) return;
        $c = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        $words = explode(' ', $text);
        $line = '';
        $yy = $y;
        foreach ($words as $word) {
            $test = $line . ' ' . $word;
            $box = imagettfbbox($lineH, 0, $font, ltrim($test));
            if ($box[2] > $maxW && $line !== '') {
                imagettftext($img, $lineH, 0, $x, $yy, $c, $font, ltrim($line));
                $line = $word;
                $yy += $lineH + 4;
            } else {
                $line = $test;
            }
        }
        imagettftext($img, $lineH, 0, $x, $yy, $c, $font, ltrim($line));
    }

    private function ttfWrapCenter($img, $text, $cx, $y, $maxW, $lineH, $rgb, $font)
    {
        if (!$font) return;
        $c = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        $words = explode(' ', $text);
        $line = '';
        $yy = $y;
        foreach ($words as $word) {
            $test = $line . ' ' . $word;
            $box = imagettfbbox($lineH, 0, $font, ltrim($test));
            if ($box[2] > $maxW && $line !== '') {
                $boxLine = imagettfbbox($lineH, 0, $font, ltrim($line));
                $x = $cx - ($boxLine[2] - $boxLine[0]) / 2;
                imagettftext($img, $lineH, 0, (int)$x, $yy, $c, $font, ltrim($line));
                $line = $word;
                $yy += $lineH + 6;
            } else {
                $line = $test;
            }
        }
        $boxLine = imagettfbbox($lineH, 0, $font, ltrim($line));
        $x = $cx - ($boxLine[2] - $boxLine[0]) / 2;
        imagettftext($img, $lineH, 0, (int)$x, $yy, $c, $font, ltrim($line));
    }

    public function destroy(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        Storage::disk('public')->delete($request->path);
        return redirect()->route('admin.infographic.index')->with('success', 'Infografis berhasil dihapus!');
    }
}
