<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDeviceIsBound
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Exempt Admin
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Check if device is bound
        if ($user && is_null($user->device_token)) {
            return redirect()->route('dashboard')->with('error', 'Anda harus mengikat perangkat terlebih dahulu untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
