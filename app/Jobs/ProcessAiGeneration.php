<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AiQueue;
use App\Models\Content;
use App\Models\AiUsageLog;
use App\Services\AiService;
use Illuminate\Support\Str;
use App\Notifications\AiGenerationCompleted;
use App\Models\User;

class ProcessAiGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120; // 2 minutes max execution

    protected $queueId;

    /**
     * Create a new job instance.
     */
    public function __construct($queueId)
    {
        $this->queueId = $queueId;

        // Cek apakah user yang request adalah admin (Jalur VIP)
        $aiQueue = AiQueue::find($queueId);
        if ($aiQueue) {
            $user = \App\Models\User::find($aiQueue->user_id);
            if ($user && in_array($user->role, ['superadmin', 'admin'])) {
                $this->onQueue('high');
            }
        }
    }

    /**
     * Execute the job.
     */
    public function handle(AiService $aiService): void
    {
        $aiQueue = AiQueue::find($this->queueId);

        if (!$aiQueue || $aiQueue->status !== 'pending') {
            return; // Already processed or not found
        }

        // Mark as processing
        $aiQueue->update(['status' => 'processing']);

        // Tandai AiService jika user adalah admin
        $user = \App\Models\User::find($aiQueue->user_id);
        $isAdmin = $user && in_array($user->role, ['superadmin', 'admin']);
        $aiService->setForAdmin($isAdmin);

        try {
            $payload = $aiQueue->payload;
            $generatedText = '';
            $contentTitle = '';

            // Check for Mock API mode
            if (isset($payload['is_mocked']) && $payload['is_mocked'] === true) {
                // Simulate processing time 2-5 seconds
                sleep(rand(2, 5));
                $generatedText = "<h2>Ini adalah hasil uji coba performa (Mock API)</h2>\n<p>AI Queue System berjalan dengan sempurna pada beban berat. Tidak ada kuota Gemini yang terpakai untuk generasi ini.</p>";
                $contentTitle = '[MOCK TEST] ' . strtoupper(str_replace('_', ' ', $aiQueue->feature_type)) . ' - ' . Str::random(5);
            } else {
                // Handle based on feature type
                switch ($aiQueue->feature_type) {
                    case 'ekinerja':
                        $generatedText = $aiService->generateEKinerja($payload);
                        $contentTitle = 'SKP: ' . Str::words($payload['pegawai_nama'] ?? 'Pegawai', 3, '...');
                        break;
                    case 'ekinerja_atasan':
                        $generatedText = $aiService->generateEKinerjaAtasan($payload);
                        $contentTitle = 'SKP Atasan: ' . Str::words($payload['pegawai_nama'] ?? 'Pegawai', 3, '...');
                        break;
                    case 'story':
                        $generatedText = $aiService->generateStory($payload['topic'], $payload['genre'], $payload['target']);
                        $contentTitle = 'Cerita: ' . Str::words($payload['topic'], 5, '...');
                        break;
                    case 'ebook':
                        $generatedText = $aiService->generateEbook($payload['topic'], $payload['target'], $payload['outline']);
                        $contentTitle = 'E-book: ' . Str::words($payload['topic'], 5, '...');
                        break;
                    case 'opinion':
                        $generatedText = $aiService->generateOpinion($payload['topic'], $payload['stance']);
                        $contentTitle = 'Opini: ' . Str::words($payload['topic'], 5, '...');
                        break;
                    case 'script':
                        $generatedText = $aiService->generateScript($payload['topic'], $payload['platform'], $payload['duration']);
                        $contentTitle = 'Script: ' . Str::words($payload['topic'], 5, '...');
                        break;
                    case 'essay':
                        $generatedText = $aiService->generateEssay($payload['topic'], $payload['type']);
                        $contentTitle = 'Essay: ' . Str::words($payload['topic'], 5, '...');
                        break;
                    case 'sop':
                        $generatedText = $aiService->generateSop($payload);
                        $contentTitle = 'SOP: ' . Str::words($payload['title'] ?? 'SOP', 5, '...');
                        break;
                    case 'surat':
                        $generatedText = $aiService->generateSurat($payload);
                        $contentTitle = 'Surat: ' . Str::words($payload['subject'] ?? 'Penting', 5, '...');
                        break;
                    case 'guru-soal':
                        $generatedText = $aiService->generateSoal($payload);
                        $contentTitle = "Soal {$payload['jenis']} — {$payload['mapel']} {$payload['kelas']}: {$payload['topik']}";
                        break;
                    case 'guru-modul':
                        $generatedText = $aiService->generateModulAjar($payload);
                        $contentTitle = "Modul Ajar — {$payload['mapel']} {$payload['fase']} {$payload['kelas']}: {$payload['topik']}";
                        break;
                    case 'guru-rpp':
                        $generatedText = $aiService->generateRPP($payload);
                        $contentTitle = "RPP — {$payload['mapel']} {$payload['kelas']}: {$payload['topik']}";
                        break;
                    case 'guru-rekap':
                        $generatedText = $aiService->generateRekapNilai($payload);
                        $contentTitle = "Rekap Nilai — {$payload['mapel']} {$payload['kelas']} ({$payload['periode']})";
                        break;
                    default:
                        throw new \Exception("Tipe fitur tidak dikenal: {$aiQueue->feature_type}");
                }
            }

            // Save the generated content
            $content = Content::create([
                'user_id' => $aiQueue->user_id,
                'type' => $aiQueue->feature_type, // Maintain the original type string
                'title' => $contentTitle,
                'content' => $generatedText,
            ]);

            // Log AI Usage success
            AiUsageLog::create([
                'user_id' => $aiQueue->user_id,
                'feature_type' => $aiQueue->feature_type,
                'model' => config('gemini.model', 'gemini-flash-latest'),
                'is_success' => true
            ]);

            // Update queue to completed
            $aiQueue->update([
                'status' => 'completed',
                'content_id' => $content->id,
            ]);

            // Send Push Notification
            $user = User::find($aiQueue->user_id);
            if ($user) {
                $user->notify(new AiGenerationCompleted($aiQueue->id, $aiQueue->feature_type, $content->id));
            }

        } catch (\Exception $e) {
            // Update queue to failed
            $aiQueue->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            // Log AI Usage failure
            AiUsageLog::create([
                'user_id' => $aiQueue->user_id,
                'feature_type' => $aiQueue->feature_type,
                'model' => config('gemini.model', 'gemini-flash-latest'),
                'is_success' => false
            ]);

            // We can rethrow if we want Laravel to handle retries based on maxTries, 
            // but we are using custom error logging in SuperAdmin, so failing gracefully is fine.
        }
    }
}
