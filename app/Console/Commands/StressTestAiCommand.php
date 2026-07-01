<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\AiQueue;
use App\Jobs\ProcessAiGeneration;

class StressTestAiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:stress-test 
                            {--users=100 : Number of concurrent generations to simulate} 
                            {--feature=ekinerja : Feature type to simulate (e.g. ekinerja, ebook)}
                            {--mock : Use Mock API mode to save Gemini quota}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stress test AI features by simulating concurrent user generations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->option('users');
        $featureType = $this->option('feature');
        $isMock = $this->option('mock');

        $this->info("🚀 Starting Load Test for [{$featureType}] feature...");
        $this->info("👥 Total Simulated Requests: {$count}");
        if ($isMock) {
            $this->warn("⚠️ MOCK MODE ENABLED: Will NOT consume Gemini API Quota!");
        } else {
            $this->error("🔴 LIVE MODE: This will consume real Gemini API Quota and may hit rate limits!");
            if (!$this->confirm('Do you wish to continue?', false)) {
                return;
            }
        }

        // Get random users to assign jobs to
        $users = User::inRandomOrder()->take(min($count, 50))->get();
        if ($users->isEmpty()) {
            $this->error('No users found in the database. Please seed the database first.');
            return;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 0; $i < $count; $i++) {
            $user = $users->random();
            
            // Create a fake payload
            $payload = [
                'pegawai_nama' => 'User Load Test ' . ($i + 1),
                'pegawai_nip' => '199012' . rand(100000, 999999),
                'pegawai_golongan' => 'III/a',
                'pegawai_jabatan' => 'Guru',
                'pegawai_unit' => 'SD Negeri ' . rand(1, 10),
                'atasan_nama' => 'Atasan ' . rand(1, 5),
                'atasan_jabatan' => 'Kepala Sekolah',
                'rhk_atasan' => ['Meningkatkan Mutu Pendidikan'],
                'rhk' => ['Mengajar Matematika Kelas ' . rand(1, 6)],
                'rhk_jenis' => ['Utama'],
                'periode' => 'Juli 2026',
                // MOCK FLAG
                'is_mocked' => $isMock
            ];

            // Insert directly to queue (simulating what FeatureController does instantly)
            $queue = AiQueue::create([
                'user_id' => $user->id,
                'feature_type' => $featureType,
                'payload' => $payload,
                'status' => 'pending'
            ]);

            // Dispatch job to the queue
            ProcessAiGeneration::dispatch($queue->id);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Successfully injected {$count} jobs into the AI Queue!");
        $this->line("Please check the Super Admin Dashboard (Monitoring Antrean AI) in your browser.");
        $this->line("Make sure your queue worker is running: `php artisan queue:work`");
    }
}
