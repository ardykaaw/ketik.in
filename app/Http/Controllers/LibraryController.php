<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Services\AiService;
use Barryvdh\DomPDF\Facade\Pdf;
use Parsedown;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    protected $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        $contents = auth()->user()->contents()->latest()->paginate(12);
        return view('library.index', compact('contents'));
    }

    public function show(Content $content)
    {
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }
        return view('library.show', compact('content'));
    }

    public function refine(Request $request, Content $content)
    {
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'instruction' => 'required|string|max:500',
        ]);

        try {
            $updatedContent = $this->aiService->refineContent($content->content, $request->instruction);
            
            $content->update([
                'content' => $updatedContent
            ]);

            return back()->with('success', 'Karya berhasil diperbarui oleh AI!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function exportPdf(Content $content)
    {
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }

        $parsedown = new Parsedown();
        $htmlContent = $parsedown->text($content->content);

        if ($content->type === 'e-kinerja') {
            $pdf = Pdf::loadView('exports.e-kinerja', [
                'content' => $content,
                'html' => $htmlContent
            ])->setPaper('a4', 'portrait');
        } else {
            $pdf = Pdf::loadView('exports.generic', [
                'content' => $content,
                'html' => $htmlContent
            ])->setPaper('a4', 'portrait');
        }

        return $pdf->download($content->title . '.pdf');
    }

    public function destroy(Content $content)
    {
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }
        $content->delete();
        return redirect()->route('library.index')->with('success', 'Karya berhasil dihapus.');
    }

    public function uploadAttachment(Request $request, Content $content)
    {
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx',
            'action_item_index' => 'required|integer|min:0',
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti-dukung', $filename, 'public');

            Attachment::create([
                'user_id' => auth()->id(),
                'content_id' => $content->id,
                'action_item_index' => $request->action_item_index,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            return back()->with('success', 'Bukti dukung berhasil diunggah!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
        }
    }

    public function deleteAttachment(Attachment $attachment)
    {
        if ($attachment->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();

            return back()->with('success', 'Bukti dukung berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus file: ' . $e->getMessage());
        }
    }
}
