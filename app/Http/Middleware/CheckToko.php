<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckToko
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $currentRoute = Route::currentRouteName();

        // Pengecualian route tertentu
        $excludedRoutes = [
            'v1.toko.index',
            'v1.toko.checkUrl',
            'v1.toko.tokoBaru',
        ];

        if (in_array($currentRoute, $excludedRoutes)) {
            return $next($request);
        }

        if (!$user) {
            return redirect()->route('v1.toko.index');
        }

        if ($user->role !== 'Administrator' && !$user->tokoSaya()) {
            return redirect()->route('v1.toko.index');
        }

        return $next($request);
    }
}
