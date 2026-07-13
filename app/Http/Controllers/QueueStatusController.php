<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AiQueue;

class QueueStatusController extends Controller
{
    public function checkStatus($id)
    {
        $queue = AiQueue::with('content')->find($id);

        if (!$queue) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Antrean tidak ditemukan'
            ], 404);
        }

        // Return current status
        $response = [
            'status' => $queue->status,
        ];

        // If completed, return the content HTML or ID so frontend can render it
        if ($queue->status === 'completed' && $queue->content) {
            // Encode content to Base64 to bypass ModSecurity / WAF
            $response['content'] = base64_encode($queue->content->content); 
            $response['is_base64'] = true;
            $response['content_id'] = $queue->content->id;
        }

        // If failed, return error
        if ($queue->status === 'failed') {
            $response['message'] = $queue->error_message ?? 'Terjadi kesalahan sistem.';
        }

        return response()->json($response);
    }

    public function cancelStatus($id, Request $request)
    {
        $queue = AiQueue::find($id);

        if (!$queue) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Antrean tidak ditemukan'
            ], 404);
        }

        // Only allow the job owner or admins to cancel
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($user->id !== $queue->user_id && !in_array($user->role, ['superadmin', 'admin'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Allow cancelling if it's still pending, retrying or processing.
        if (in_array($queue->status, ['pending', 'retrying', 'processing'])) {
            $queue->update([
                'status' => 'cancelled',
                'error_message' => 'Job dibatalkan oleh pengguna saat halaman direfresh atau ditutup sebelum selesai.'
            ]);

            return response()->json([
                'status' => 'cancelled',
                'message' => 'Job berhasil dibatalkan.'
            ]);
        }

        return response()->json([
            'status' => $queue->status,
            'message' => 'Job tidak dapat dibatalkan karena sudah selesai atau gagal.'
        ], 400);
    }
}
