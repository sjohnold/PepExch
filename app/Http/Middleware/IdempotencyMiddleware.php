<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class IdempotencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only for state-changing requests
        if (!$request->isMethod('POST') && !$request->isMethod('PATCH') && !$request->isMethod('PUT')) {
            return $next($request);
        }

        $idempotencyKey = $request->header('X-Idempotency-Key');

        if (!$idempotencyKey) {
            return $next($request);
        }

        $cacheKey = "idempotency_{$idempotencyKey}";

        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            return response()->json($cached['content'], $cached['status']);
        }

        $response = $next($request);

        // Cache only successful responses or specific errors for 24 hours
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            Cache::put($cacheKey, [
                'content' => json_decode($response->getContent(), true),
                'status' => $response->getStatusCode()
            ], now()->addDay());
        }

        return $response;
    }
}
