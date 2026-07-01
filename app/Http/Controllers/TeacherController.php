<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AiService;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    protected AiService $ai;

    public function __construct(AiService $ai)
    {
        $this->ai = $ai;
    }

    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'soal'  => Content::where('user_id', $userId)->where('type', 'guru-soal')->count(),
            'modul' => Content::where('user_id', $userId)->where('type', 'guru-modul')->count(),
            'rpp'   => Content::where('user_id', $userId)->where('type', 'guru-rpp')->count(),
            'rekap' => Content::where('user_id', $userId)->where('type', 'guru-rekap')->count(),
        ];

        $recents = Content::where('user_id', $userId)
            ->whereIn('type', ['guru-soal', 'guru-modul', 'guru-rpp', 'guru-rekap'])
            ->latest()
            ->limit(5)
            ->get();

        return view('guru.index', compact('stats', 'recents'));
    }

    public function soal()
    {
        return view('guru.soal');
    }

    public function generateSoal(Request $request)
    {
        $request->validate([
            'mapel'      => 'required|string|max:100',
            'kelas'      => 'required|string|max:50',
            'topik'      => 'required|string|max:255',
            'jumlah'     => 'required|integer|min:1|max:50',
            'jenis'      => 'required|in:Pilihan Ganda,Essay,Campuran',
            'kesulitan'  => 'required|in:Mudah,Sedang,Sulit,Campuran',
        ]);

        $aiQueue = \App\Models\AiQueue::create([
            'user_id' => Auth::id(),
            'feature_type' => 'guru-soal',
            'payload' => $request->only('mapel', 'kelas', 'topik', 'jumlah', 'jenis', 'kesulitan'),
            'status' => 'pending'
        ]);

        \App\Jobs\ProcessAiGeneration::dispatch($aiQueue->id);

        return response()->json(['success' => true, 'queue_id' => $aiQueue->id]);
    }

    public function modul()
    {
        return view('guru.modul');
    }

    public function generateModul(Request $request)
    {
        $request->validate([
            'mapel'      => 'required|string|max:100',
            'fase'       => 'required|string|max:20',
            'kelas'      => 'required|string|max:50',
            'semester'   => 'required|in:Ganjil,Genap',
            'topik'      => 'required|string|max:255',
            'waktu'      => 'required|integer|min:30|max:480',
            'pertemuan'  => 'required|integer|min:1|max:20',
            'tahun_ajar' => 'nullable|string|max:20',
        ]);

        $data = $request->only('mapel', 'fase', 'kelas', 'semester', 'topik', 'waktu', 'pertemuan');
        $data['tahun_ajar'] = $request->tahun_ajar ?: date('Y') . '/' . (date('Y') + 1);

        $aiQueue = \App\Models\AiQueue::create([
            'user_id' => Auth::id(),
            'feature_type' => 'guru-modul',
            'payload' => $data,
            'status' => 'pending'
        ]);

        \App\Jobs\ProcessAiGeneration::dispatch($aiQueue->id);

        return response()->json(['success' => true, 'queue_id' => $aiQueue->id]);
    }

    public function rpp()
    {
        return view('guru.rpp');
    }

    public function generateRpp(Request $request)
    {
        $request->validate([
            'mapel'      => 'required|string|max:100',
            'kelas'      => 'required|string|max:50',
            'topik'      => 'required|string|max:255',
            'waktu'      => 'required|integer|min:30|max:480',
            'pertemuan'  => 'required|integer|min:1|max:20',
            'jp'         => 'required|integer|min:1|max:6',
            'kurikulum'  => 'required|in:Kurikulum Merdeka,Kurikulum 2013 (K-13)',
            'metode'     => 'required|string|max:100',
            'kd'         => 'required|string|max:500',
        ]);

        $aiQueue = \App\Models\AiQueue::create([
            'user_id' => Auth::id(),
            'feature_type' => 'guru-rpp',
            'payload' => $request->only('mapel', 'kelas', 'topik', 'waktu', 'pertemuan', 'jp', 'kurikulum', 'metode', 'kd'),
            'status' => 'pending'
        ]);

        \App\Jobs\ProcessAiGeneration::dispatch($aiQueue->id);

        return response()->json(['success' => true, 'queue_id' => $aiQueue->id]);
    }

    public function rekap()
    {
        return view('guru.rekap');
    }

    public function generateRekap(Request $request)
    {
        $request->validate([
            'mapel'     => 'required|string|max:100',
            'kelas'     => 'required|string|max:50',
            'periode'   => 'required|string|max:100',
            'kkm'       => 'required|integer|min:0|max:100',
            'nilai_raw' => 'required|string|max:5000',
        ]);

        $aiQueue = \App\Models\AiQueue::create([
            'user_id' => Auth::id(),
            'feature_type' => 'guru-rekap',
            'payload' => $request->only('mapel', 'kelas', 'periode', 'kkm', 'nilai_raw'),
            'status' => 'pending'
        ]);

        \App\Jobs\ProcessAiGeneration::dispatch($aiQueue->id);

        return response()->json(['success' => true, 'queue_id' => $aiQueue->id]);
    }

    public function pustaka()
    {
        $typeLabels = [
            'guru-soal'  => 'Buat Soal',
            'guru-modul' => 'Modul Ajar',
            'guru-rpp'   => 'RPP',
            'guru-rekap' => 'Rekap Nilai',
        ];

        $query = Content::where('user_id', Auth::id())
            ->whereIn('type', array_keys($typeLabels));

        if (request('type') && array_key_exists(request('type'), $typeLabels)) {
            $query->where('type', request('type'));
        }

        $contents = $query->latest()->paginate(12);

        return view('guru.pustaka', compact('contents', 'typeLabels'));
    }

    public function pustakaShow($id)
    {
        $content = Content::where('user_id', Auth::id())
            ->whereIn('type', ['guru-soal', 'guru-modul', 'guru-rpp', 'guru-rekap'])
            ->findOrFail($id);

        return view('guru.pustaka-show', compact('content'));
    }

    public function pustakaDestroy($id)
    {
        $content = Content::where('user_id', Auth::id())
            ->whereIn('type', ['guru-soal', 'guru-modul', 'guru-rpp', 'guru-rekap'])
            ->findOrFail($id);

        $content->delete();

        return redirect()->route('guru.pustaka')->with('success', 'Dokumen berhasil dihapus.');
    }
}
