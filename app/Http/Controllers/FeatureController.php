<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    protected $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    private function validateRequest(Request $request, array $rules)
    {
        $messages = [
            'required' => 'Kolom :attribute wajib diisi ya.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'max' => 'Waduh, :attribute terlalu panjang. Maksimal :max karakter agar AI tidak pusing.',
            'min' => ':attribute terlalu pendek, tambahkan sedikit lagi.',
        ];

        $attributes = [
            'topic' => 'topik/ide',
            'genre' => 'genre cerita',
            'target' => 'target pembaca',
            'outline' => 'outline',
            'stance' => 'posisi opini',
            'platform' => 'platform',
            'duration' => 'durasi',
            'type' => 'jenis esai',
            'style' => 'gaya bahasa',
            'event' => 'nama acara',
            'audience' => 'audiens',
            'tone' => 'nada bicara',
            'framework' => 'kerangka copywriting',
            'description' => 'deskripsi produk',
            'product_name' => 'nama produk',
            'target_audience' => 'target audiens',
        ];

        return $request->validate($rules, $messages, $attributes);
    }

    public function storyTelling()
    {
        return view('features.story-telling');
    }

    public function generateStory(Request $request)
    {
        $this->validateRequest($request, [
            'topic' => 'required|string|max:5000',
            'genre' => 'required|string',
            'target' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateStory(
                $request->topic,
                $request->genre,
                $request->target
            );

            // Save to Library
            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'story',
                'title' => 'Cerita: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => $request->topic,
                'parameters' => $request->only(['topic', 'genre', 'target']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Cerita berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function ebook()
    {
        return view('features.ebook');
    }

    public function generateEbook(Request $request)
    {
        $this->validateRequest($request, [
            'topic' => 'required|string|max:5000',
            'target' => 'required|string',
            'outline' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateEbook(
                $request->topic,
                $request->target,
                $request->outline
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'ebook',
                'title' => 'E-Book: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => "Topik: " . $request->topic . "\n\nData Outline: " . $request->outline,
                'parameters' => $request->only(['topic', 'target', 'outline']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'E-book berhasil disusun!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function opini()
    {
        return view('features.opini');
    }

    public function generateOpinion(Request $request)
    {
        $this->validateRequest($request, [
            'topic' => 'required|string|max:5000',
            'stance' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateOpinion(
                $request->topic,
                $request->stance
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'opini',
                'title' => 'Opini: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => "Topik Opini: " . $request->topic . "\n\nPosisi: " . $request->stance,
                'parameters' => $request->only(['topic', 'stance']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Opini berhasil diterbitkan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function script()
    {
        return view('features.script');
    }

    public function generateScript(Request $request)
    {
        $this->validateRequest($request, [
            'topic' => 'required|string|max:5000',
            'platform' => 'required|string',
            'duration' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateScript(
                $request->topic,
                $request->platform,
                $request->duration
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'script',
                'title' => 'Script: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => "Topik: " . $request->topic . "\n\nPlatform: " . $request->platform . "\nDurasi: " . $request->duration,
                'parameters' => $request->only(['topic', 'platform', 'duration']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Script berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function essay()
    {
        return view('features.essay');
    }

    public function generateEssay(Request $request)
    {
        $this->validateRequest($request, [
            'topic' => 'required|string|max:5000',
            'type' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateEssay(
                $request->topic,
                $request->type
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'essay',
                'title' => 'Esai: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => $request->topic,
                'parameters' => $request->only(['topic', 'type']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Essay berhasil disusun!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function eKinerja()
    {
        return view('features.e-kinerja');
    }

    public function generateEKinerja(Request $request)
    {
        $request->validate([
            'pegawai_nama' => 'required|string',
            'pegawai_nip' => 'required|string',
            'pegawai_golongan' => 'required|string',
            'pegawai_jabatan' => 'required|string',
            'pegawai_unit' => 'required|string',
            'atasan_nama' => 'required|string',
            'atasan_jabatan' => 'required|string',
            'rhk_atasan' => 'required|array',
            'rhk_atasan.*' => 'required|string',
            'rhk' => 'required|array',
            'rhk.*' => 'required|string',
            'rhk_jenis' => 'required|array',
            'rhk_jenis.*' => 'required|string',
            'periode' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateEKinerja($request->all());

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'e-kinerja',
                'title' => 'SKP ASN: ' . $request->pegawai_nama . ' - ' . $request->periode,
                'content' => $generatedText,
                'prompt' => 'Data E-Kinerja Pegawai: ' . json_encode($request->all(), JSON_PRETTY_PRINT),
                'parameters' => $request->all(),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Rincian SKP ASN berhasil disusun!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function eKinerjaAtasan()
    {
        return view('features.e-kinerja-atasan');
    }

    public function generateEKinerjaAtasan(Request $request)
    {
        $request->validate([
            'atasan_nama' => 'required|string',
            'atasan_jabatan' => 'required|string',
            'atasan_unit' => 'required|string',
            'bawahan_nama' => 'required|string',
            'bawahan_jabatan' => 'required|string',
            'tugas_pokok' => 'required|array',
            'tugas_pokok.*' => 'required|string',
            'periode' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateEKinerjaAtasan($request->all());

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'e-kinerja-atasan',
                'title' => 'Ekspektasi Pimpinan: ' . $request->bawahan_nama . ' - ' . $request->periode,
                'content' => $generatedText,
                'prompt' => 'Data E-Kinerja Atasan: ' . json_encode($request->all(), JSON_PRETTY_PRINT),
                'parameters' => $request->all(),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Ekspektasi Pimpinan berhasil disusun!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function news()
    {
        return view('features.news');
    }

    public function generateNews(Request $request)
    {
        $this->validateRequest($request, [
            'topic' => 'required|string|max:5000',
            'style' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateNews(
                $request->topic,
                $request->style
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'news',
                'title' => 'Berita: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => $request->topic,
                'parameters' => $request->only(['topic', 'style']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Berita berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function speech()
    {
        return view('features.speech');
    }

    public function generateSpeech(Request $request)
    {
        $this->validateRequest($request, [
            'event' => 'required|string|max:5000',
            'position' => 'required|string|max:255',
            'audience' => 'required|string',
            'tone' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateSpeech(
                $request->event,
                $request->position,
                $request->audience,
                $request->tone
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'speech',
                'title' => 'Sambutan: ' . \Str::words($request->event, 5, '...'),
                'content' => $generatedText,
                'prompt' => "Acara: " . $request->event . "\nPosisi: " . $request->position . "\nAudiens: " . $request->audience,
                'parameters' => $request->only(['event', 'position', 'audience', 'tone']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Kata sambutan berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function socialMedia()
    {
        return view('features.social-media');
    }

    public function generateSocialMedia(Request $request)
    {
        $this->validateRequest($request, [
            'platform' => 'required|string',
            'topic' => 'required|string|max:5000',
            'style' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateSocialMedia(
                $request->topic,
                $request->platform,
                $request->style
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'social-media',
                'title' => 'Sosmed: ' . \Str::words($request->topic, 5, '...'),
                'content' => $generatedText,
                'prompt' => $request->topic,
                'parameters' => $request->only(['topic', 'platform', 'style']),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Konten Social Media berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function copywriting()
    {
        return view('features.copywriting');
    }

    public function generateCopywriting(Request $request)
    {
        $this->validateRequest($request, [
            'product_name' => 'required|string',
            'description' => 'required|string|max:5000',
            'target_audience' => 'required|string',
            'platform' => 'required|string',
            'framework' => 'required|string',
            'tone' => 'required|string',
        ]);

        try {
            $generatedText = $this->aiService->generateCopywriting(
                $request->product_name,
                $request->description,
                $request->target_audience,
                $request->platform,
                $request->framework,
                $request->tone
            );

            $content = Content::create([
                'user_id' => Auth::id(),
                'type' => 'copywriting',
                'title' => 'Copywriting: ' . \Str::words($request->product_name, 5, '...'),
                'content' => $generatedText,
                'prompt' => "Produk: " . $request->product_name . "\n\nDeskripsi: " . $request->description,
                'parameters' => $request->all(),
            ]);

            return redirect()->route('library.show', $content)->with('success', 'Copywriting berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
