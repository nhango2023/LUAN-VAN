<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiUrl = config('services.api.url');
        $apiKey = config('services.api.key');

        if (empty($apiUrl) || empty($apiKey)) {
            return redirect('/config');
        }
        return $next($request);
    }
}
