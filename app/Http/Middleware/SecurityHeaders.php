<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Tambahkan berbagai header keamanan
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('Expect-CT', 'max-age=30, enforce');
        $response->headers->set(
            'Permissions-Policy',
            'autoplay=(self); camera=(); encrypted-media=(self); fullscreen=(); geolocation=(self); gyroscope=(); magnetometer=(); microphone=(); midi=(); payment=(); sync-xhr=(self); usb=(); interest-cohort=()'
        );

        // CORS Headers (batasi domain jika memungkinkan)
        $response->headers->set('Access-Control-Allow-Origin', '/');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set(
            'Access-Control-Allow-Headers',
            'Content-Type, Authorization, X-Requested-With, X-CSRF-Token'
        );


        // Generate nonce untuk CSP
        $nonce = csp_nonce();

        // Content Security Policy
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'nonce-{$nonce}' 'strict-dynamic'",
            "style-src 'self' 'nonce-{$nonce}' 'unsafe-inline'",
            "img-src 'self' data: blob: https://apiminio-staging.kalbe.co.id https://apiminio.kalbe.co.id https://apistorage.kalbe.site https://pharmafile.kalbe.co.id",
            "font-src 'self' https://fonts.gstatic.com",
            "object-src 'none'",
            "frame-src 'self' https://apiminio-staging.kalbe.co.id https://apiminio.kalbe.co.id https://apistorage.kalbe.site https://pharmafile.kalbe.co.id",
            "frame-ancestors 'self'",
            "base-uri 'self'",
        ];

        // Gabungkan semua aturan CSP dan set header
        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        return $response;
    }
}
