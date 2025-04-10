<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('Authorization');

        if (empty($apiKey) || !hash_equals(config('app.api_key'), $apiKey)) {
            return ResponseFormatter::error( 'Unauthorized. Your API key is invalid', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
