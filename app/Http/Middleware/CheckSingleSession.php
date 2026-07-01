<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Exempt admins from single session constraint (Allow multiple device login for Live Streaming/Reviews)
            if ($user->isAdmin()) {
                return $next($request);
            }

            $currentSessionId = session()->getId();

            if ($user->session_id && $user->session_id !== $currentSessionId) {
                auth()->logout();
                session()->flush();
                return redirect()->route('login')->with('error', 'Akun Anda baru saja digunakan di perangkat lain. Silakan login kembali.');
            }
        }

        return $next($request);
    }
}
