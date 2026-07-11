<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AiQueue;
use Carbon\Carbon;

class CleanupStuckAiQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai-queue:cleanup-stuck {--minutes=30 : Minutes to consider a job as stuck}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Cleanup stuck AI Queue jobs (pending/processing longer than threshold) and mark them as failed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minutes = (int) $this->option('minutes');
        $threshold = Carbon::now()->subMinutes($minutes);

        // Find stuck jobs
        $stuckJobs = AiQueue::whereIn('status', ['pending', 'processing', 'retrying'])
            ->where('created_at', '<', $threshold)
            ->get();

        $count = $stuckJobs->count();

        if ($count === 0) {
            $this->info('✓ Tidak ada jobs yang stuck.');
            return 0;
        }

        $this->warn("⚠ Menemukan {$count} jobs yang stuck (lebih dari {$minutes} menit).");
        $this->info('Job akan ditandai sebagai failed dan error message akan dicatat.');

        if (!$this->confirm('Lanjutkan cleanup?')) {
            $this->info('Dibatalkan.');
            return 1;
        }

        $failedCount = 0;

        foreach ($stuckJobs as $job) {
            try {
                $waitTime = $job->created_at->diffInMinutes(now());
                
                $job->update([
                    'status' => 'failed',
                    'error_message' => "Auto-cleanup: Job stuck in {$job->status} status for {$waitTime} minutes (timeout threshold: {$minutes} minutes). Marked as failed at " . now()->toDateTimeString(),
                ]);

                $this->line("✓ Queue {$job->id} - {$job->feature_type} (User: {$job->user_id}) ditandai FAILED");
                $failedCount++;

            } catch (\Exception $e) {
                $this->error("✗ Error cleanup queue {$job->id}: {$e->getMessage()}");
            }
        }

        $this->info('');
        $this->info("================================");
        $this->info("✓ Cleanup selesai!");
        $this->info("Total jobs dibersihkan: {$failedCount}");
        $this->info("================================");

        return 0;
    }
}
