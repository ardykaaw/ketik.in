<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Real Statistics
        $totalDocs = $user->contents()->count();
        
        // Calculate estimated word count (approximate)
        $totalWords = $user->contents()->get()->sum(function($content) {
            return str_word_count(strip_tags($content->content));
        });

        $ebookCount = $user->contents()->where('type', 'ebook')->count();
        
        // E-Kinerja Stats (Target Kinerja as a simulated progress based on RHK count)
        $ekinerjaCount = $user->contents()->where('type', 'e-kinerja')->count();
        $targetKinerja = min(100, $ekinerjaCount * 10); // Simulation: 10 docs = 100%

        // Data for Chart (last 7 days)
        $chartData = [];
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $days[] = now()->subDays($i)->format('D');
            $chartData[] = $user->contents()->whereDate('created_at', $date)->count();
        }

        // Feature Distribution
        $featureDist = [
            'story' => $user->contents()->where('type', 'story-telling')->count(),
            'ebook' => $ebookCount,
            'opini' => $user->contents()->where('type', 'opini')->count(),
            'script' => $user->contents()->where('type', 'script')->count(),
            'essay' => $user->contents()->where('type', 'essay')->count(),
            'ekinerja' => $ekinerjaCount,
        ];

        return view('dashboard', [
            'totalDocs' => $totalDocs,
            'totalWords' => $totalWords,
            'ebookCount' => $ebookCount,
            'targetKinerja' => $targetKinerja,
            'chartDays' => $days,
            'chartCounts' => $chartData,
            'featureDist' => array_values($featureDist),
        ]);
    }
}
