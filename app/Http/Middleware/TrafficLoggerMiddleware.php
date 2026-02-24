<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemLog;
use Illuminate\Support\Facades\Auth;

class TrafficLoggerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000);

        // Update last_seen_at for authenticated user
        if (Auth::check()) {
            Auth::user()->updateQuietly(['last_seen_at' => now()]);
        }

        // Log the request (excluding some paths to avoid bloat)
        $excludePaths = ['/admin/super/traffic', '/debugbar', '/_debugbar'];
        $isExcluded = false;
        foreach ($excludePaths as $path) {
            if (str_contains($request->path(), $path)) {
                $isExcluded = true;
                break;
            }
        }

        if (!$isExcluded) {
            try {
                \App\Models\SystemLog::create([
                    'user_id' => Auth::id(),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'response_time_ms' => $duration,
                ]);
            } catch (\Exception $e) {
                // Silently fail to not break the app
                \Illuminate\Support\Facades\Log::error('Traffic logger failed: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
