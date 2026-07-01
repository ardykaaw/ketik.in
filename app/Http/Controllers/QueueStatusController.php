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
            $response['content'] = $queue->content->content; 
            $response['content_id'] = $queue->content->id;
        }

        // If failed, return error
        if ($queue->status === 'failed') {
            $response['message'] = $queue->error_message ?? 'Terjadi kesalahan sistem.';
        }

        return response()->json($response);
    }
}
