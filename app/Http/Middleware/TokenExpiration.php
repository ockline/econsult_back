<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $lastActivity = Cache::get('user-last-activity-' . $user->id);

            if ($lastActivity && now()->diffInMinutes($lastActivity) >= 5) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json(['message' => 'Token expired due to inactivity'], 401);
            }

            Cache::put('user-last-activity-' . $user->id, now());
        }

        return $next($request);
    }
}
