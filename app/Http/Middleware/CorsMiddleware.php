<?php
// app/Http/Middleware/CorsMiddleware.php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
{
    if ($request->isMethod('OPTIONS')) {
        return response('', 200)
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization');
    }

    $response = $next($request);

    // Set CORS headers
    $origin = $request->header('Origin');
    $allowedOrigins = ['http://localhost:5173', 'http://localhost:3000', 'http://127.0.0.1:5173', 'http://127.0.0.1:3000', 'https://socratepre.socrate.co.tz'];

    if (in_array($origin, $allowedOrigins)) {
        $response->header('Access-Control-Allow-Origin', $origin);
        $response->header('Access-Control-Allow-Credentials', 'true');
    } else {
        $response->header('Access-Control-Allow-Origin', '*');
    }

    $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization');

    return $response;
}

}
