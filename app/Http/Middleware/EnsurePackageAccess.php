<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePackageAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Admins can bypass everything
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Determine which feature group is being accessed
        $isFeature = $request->routeIs('feature.*') || $request->routeIs('wizard.*');
        $isGuru = $request->routeIs('guru.*');
        $isAcademy = $request->routeIs('academy.*');

        $package = $user->package_type ?? 'utama'; // default if null

        if ($package === 'utama') {
            // Can access all
            return $next($request);
        }

        if ($package === 'guru') {
            if ($isGuru) return $next($request);
            return redirect()->route('dashboard')->with('error', 'Paket Anda (Mode Guru) tidak memiliki akses ke fitur ini.');
        }

        if ($package === 'guru_academy') {
            if ($isGuru || $isAcademy) return $next($request);
            return redirect()->route('dashboard')->with('error', 'Paket Anda (Guru + Academy) tidak memiliki akses ke fitur ini.');
        }

        if ($package === 'academy') {
            if ($isAcademy) return $next($request);
            return redirect()->route('dashboard')->with('error', 'Paket Anda (Academy) tidak memiliki akses ke fitur ini.');
        }

        if ($package === 'worksheet_anak') {
            if ($isAcademy) return $next($request);
            return redirect()->route('dashboard')->with('error', 'Paket Anda (Worksheet Anak) hanya diizinkan untuk mengakses fitur Academy tertentu.');
        }

        // Fallback
        return redirect()->route('dashboard')->with('error', 'Paket Anda tidak diizinkan mengakses fitur ini.');
    }
}
