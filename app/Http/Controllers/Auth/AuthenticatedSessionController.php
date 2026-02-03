<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if user is active (verified)
        if (!Auth::user()->is_active && !Auth::user()->isAdmin()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Akun Anda belum diverifikasi oleh Admin. Mohon tunggu persetujuan.']);
        }

        // Single Device Login: Store current session ID
        $user = auth()->user();
        $user->session_id = session()->getId();
        $user->save();

        // --- STRICT DEVICE BINDING LOGIC (Exempt Admin) ---
        if (!$user->isAdmin()) {
            $incomingDeviceToken = $request->cookie('device_token');
            $storedDeviceToken = $user->device_token;

            // Scenario A: First Time / Tokens Cleared (Reset by Admin) 
            // -> Allow Login but set flag for modal
            if (is_null($storedDeviceToken)) {
                session(['device_needs_binding' => true]);
                // Continue to login (don't redirect or logout)
            }
            // Scenario B: Token Mismatch -> BLOCK ACCESS
            elseif ($incomingDeviceToken !== $storedDeviceToken) {
                // Logout immediately
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors(['email' => 'Akses Ditolak. Akun ini terkunci pada perangkat lain. Hubungi Admin untuk melakukan reset perangkat jika Anda ingin pindah device.']);
            }
            // Scenario C: Match -> Allow Login (no action needed)
        }

        // Scenario C: Match -> Allow Login (Proceed)

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
