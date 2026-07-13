<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Content;
use App\Models\AiQueue;
use App\Models\AiUsageLog;
use App\Models\SystemLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function index(Request $request)
    {
        // 1. Overview Stats
        $stats = [
            'total_users' => User::count(),
            'online_users' => User::where('last_seen_at', '>=', now()->subMinutes(5))->count(),
            'daily_ai_content' => AiUsageLog::whereDate('created_at', today())->count(),
            'api_success_rate' => $this->getApiSuccessRate(),
        ];

        // 2. Daily Content Production (Last 7 Days)
        $dailyContent = AiUsageLog::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 3. Top AI Users
        $topUsers = User::withCount('contents')
            ->orderBy('contents_count', 'desc')
            ->limit(5)
            ->get();

        // 4. API Error Logs (Recent)
        $errorLogs = AiUsageLog::where('is_success', false)
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();

        // 5. Queues
        $query = \App\Models\AiQueue::with('user')->latest();
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $queues = $query->paginate(20);

        $queueStats = [
            'total' => \App\Models\AiQueue::count(),
            'pending' => \App\Models\AiQueue::where('status', 'pending')->count(),
            'processing' => \App\Models\AiQueue::where('status', 'processing')->count(),
            'completed' => \App\Models\AiQueue::where('status', 'completed')->count(),
            'failed' => \App\Models\AiQueue::where('status', 'failed')->count(),
        ];

        return view('admin.super.dashboard', compact('stats', 'dailyContent', 'topUsers', 'errorLogs', 'queues', 'queueStats'));
    }

    public function queueData(Request $request)
    {
        $query = \App\Models\AiQueue::with('user')->latest();
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        $queues = $query->paginate(20);

        $queueStats = [
            'total' => \App\Models\AiQueue::count(),
            'pending' => \App\Models\AiQueue::where('status', 'pending')->count(),
            'processing' => \App\Models\AiQueue::where('status', 'processing')->count(),
            'completed' => \App\Models\AiQueue::where('status', 'completed')->count(),
            'failed' => \App\Models\AiQueue::where('status', 'failed')->count(),
        ];

        return view('admin.super.partials.queue_table', compact('queues', 'queueStats'));
    }

    public function traffic()
    {
        $logs = SystemLog::with('user')->latest()->paginate(50);
        return view('admin.super.traffic', compact('logs'));
    }

    private function getApiSuccessRate()
    {
        $total = AiUsageLog::whereDate('created_at', today())->count();
        if ($total === 0) return 100;
        
        $success = AiUsageLog::whereDate('created_at', today())->where('is_success', true)->count();
        return round(($success / $total) * 100);
    }

    public function getAnalyticsData()
    {
        $dates = [];
        $contentCounts = [];
        $trafficCounts = [];
        $apiSuccess = [];
        $apiErrors = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = now()->subDays($i)->format('d M');
            
            $contentCounts[] = AiUsageLog::whereDate('created_at', $date)->count();
            $trafficCounts[] = SystemLog::whereDate('created_at', $date)->count();
            
            $apiSuccess[] = AiUsageLog::whereDate('created_at', $date)->where('is_success', true)->count();
            $apiErrors[] = AiUsageLog::whereDate('created_at', $date)->where('is_success', false)->count();
        }

        return response()->json([
            'dates' => $dates,
            'content' => $contentCounts,
            'traffic' => $trafficCounts,
            'api_success' => $apiSuccess,
            'api_errors' => $apiErrors,
        ]);
    }


    public function retryQueue($id)
    {
        $queue = AiQueue::findOrFail($id);
        
        if ($queue->status === 'completed') {
            return back()->with('error', 'Antrean sudah selesai, tidak perlu diulang.');
        }

        $queue->update([
            'status' => 'pending',
            'error_message' => null,
        ]);

        \App\Jobs\ProcessAiGeneration::dispatch($queue->id);

        return back()->with('success', 'Antrean berhasil dikembalikan ke status Pending dan akan diproses ulang.');
    }

    public function deleteQueue($id)
    {
        $queue = AiQueue::findOrFail($id);

        if ($queue->status !== 'pending') {
            return back()->with('error', 'Hanya antrean dengan status Pending yang dapat dihapus.');
        }

        $queue->delete();

        return back()->with('success', 'Antrean Pending berhasil dihapus.');
    }
}
