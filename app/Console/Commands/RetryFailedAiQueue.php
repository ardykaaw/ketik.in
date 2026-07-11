<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AiQueue;
use App\Jobs\ProcessAiGeneration;

class RetryFailedAiQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai-queue:retry-failed {--limit=10 : Max jobs to retry}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Retry failed AI Queue jobs and dispatch them back to queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = (int) $this->option('limit');

        // Find failed jobs
        $failedJobs = AiQueue::where('status', 'failed')
            ->limit($limit)
            ->get();

        $count = $failedJobs->count();

        if ($count === 0) {
            $this->info('✓ Tidak ada failed jobs untuk di-retry.');
            return 0;
        }

        $this->warn("⚠ Menemukan {$count} failed jobs. Akan di-dispatch ulang ke queue.");

        if (!$this->confirm('Lanjutkan retry?')) {
            $this->info('Dibatalkan.');
            return 1;
        }

        $retryCount = 0;

        foreach ($failedJobs as $job) {
            try {
                // Reset job back to pending
                $job->update([
                    'status' => 'pending',
                    'error_message' => null,
                ]);

                // Dispatch to queue
                ProcessAiGeneration::dispatch($job->id);

                $this->line("✓ Queue {$job->id} - {$job->feature_type} (User: {$job->user_id}) di-dispatch ulang");
                $retryCount++;

            } catch (\Exception $e) {
                $this->error("✗ Error retry queue {$job->id}: {$e->getMessage()}");
            }
        }

        $this->info('');
        $this->info("================================");
        $this->info("✓ Retry selesai!");
        $this->info("Total jobs di-retry: {$retryCount}");
        $this->info("================================");

        return 0;
    }
}
