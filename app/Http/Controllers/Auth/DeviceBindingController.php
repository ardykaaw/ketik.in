<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DeviceBindingController extends Controller
{
    /**
     * Confirm device binding from dashboard (AJAX or Form POST).
     */
    public function confirmFromDashboard(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        // Exempt Admin
        if ($user->isAdmin()) {
            return response()->json(['success' => true, 'message' => 'Admin tidak perlu mengikat perangkat.']);
        }

        // Generate new Device Token
        $deviceToken = Str::uuid()->toString();
        $user->device_token = $deviceToken;
        $user->save();

        // Set Long-Lived Cookie (10 Years)
        $cookie = cookie('device_token', $deviceToken, 5256000); // 10 years in minutes

        // Clear Session Flag
        session()->forget('device_needs_binding');

        return response()->json([
            'success' => true,
            'message' => 'Perangkat berhasil diikat. Anda sekarang dapat mengakses semua fitur.'
        ])->cookie($cookie);
    }
}
