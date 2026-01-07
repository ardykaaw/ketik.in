<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class WizardController extends Controller
{
    public function step1()
    {
        return view('wizard.step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:article,social,email',
        ]);

        $request->session()->put('wizard.type', $validated['type']);

        return redirect()->route('wizard.step2');
    }

    public function step2(Request $request)
    {
        $type = $request->session()->get('wizard.type');
        
        if (!$type) {
            return redirect()->route('wizard.step1');
        }

        return view('wizard.step2', compact('type'));
    }

    public function storeStep2(Request $request)
    {
        $type = $request->session()->get('wizard.type');
        
        // Mock Generation Logic
        $content_text = "Berikut adalah " . ucfirst($type) . " yang dihasilkan berdasarkan input Anda:\n\n";
        $content_text .= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\n";
        
        if ($type === 'article') {
            $content_text .= "Topik: " . $request->input('topic') . "\n";
            $content_text .= "Poin Penting: " . $request->input('points') . "\n";
        } elseif ($type === 'social') {
            $content_text .= "Platform: " . $request->input('platform') . "\n";
            $content_text .= "Konten: " . $request->input('content') . "\n";
        } elseif ($type === 'email') {
            $content_text .= "Penerima: " . $request->input('recipient') . "\n";
            $content_text .= "Tujuan: " . $request->input('purpose') . "\n";
        }

        $content = Content::create([
            'user_id' => Auth::id(),
            'type' => 'wizard',
            'title' => 'Wizard AI: ' . ucfirst($type),
            'content' => $content_text,
            'parameters' => $request->all(),
        ]);

        return redirect()->route('library.show', $content)->with('success', 'Karya berhasil dibuat lewat Wizard!');
    }
}
