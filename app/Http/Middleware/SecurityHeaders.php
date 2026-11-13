<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security response headers, including the Content-Security-Policy.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $headers  = $response->headers;

        if (! headers_sent()) {
            header_remove('X-Powered-By');
        }
        $headers->remove('X-Powered-By');

        $defaults = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options'        => 'SAMEORIGIN',
            'Referrer-Policy'        => 'strict-origin-when-cross-origin',
            'Permissions-Policy'     => 'camera=(), microphone=(), geolocation=(), payment=()',
        ];
        foreach ($defaults as $name => $value) {
            if (! $headers->has($name)) {
                $headers->set($name, $value);
            }
        }

        if ($request->isSecure() && ! $headers->has('Strict-Transport-Security')) {
            $headers->set('Strict-Transport-Security', 'max-age=' . (int) config('tekete.hsts_max_age', 15552000));
        }

        // Attachments (PDF/image/video) are served by their own handler; a CSP with
        // object-src 'none' stops Chrome's built-in PDF viewer, and they carry nosniff already.
        if ($request->routeIs('attachments.*') || $headers->has('Content-Security-Policy')) {
            return $response;
        }

        $mode     = config('tekete.csp_mode', 'report-only');
        $baseline = $this->baseline();

        if ($uri = config('tekete.csp_report_uri', '/csp-report')) {
            $headers->set('Reporting-Endpoints', 'csp-endpoint="' . $uri . '"');
        }

        if ($mode === 'enforce') {
            $headers->set('Content-Security-Policy', $baseline . '; ' . $this->resources());
        } else {
            $headers->set('Content-Security-Policy', $baseline);

            if ($mode !== 'off') {
                $headers->set('Content-Security-Policy-Report-Only', $this->resources() . '; ' . $this->reportDirective());
            }
        }

        return $response;
    }

    private function baseline(): string
    {
        return implode('; ', array_filter([
            "object-src 'none'",
            "base-uri 'self'",
            "frame-ancestors 'self'",
            "form-action 'self' https://www.payfast.co.za https://sandbox.payfast.co.za",
            $this->reportDirective(),
        ]));
    }

    private function reportDirective(): string
    {
        $uri = config('tekete.csp_report_uri', '/csp-report');

        return $uri ? "report-uri {$uri}; report-to csp-endpoint" : '';
    }

    /** What the pages actually load today (audited from resources/views and public/js). */
    private function resources(): string
    {
        $scripts = "'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://kit.fontawesome.com https://unpkg.com https://challenges.cloudflare.com";
        $styles  = "'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://unpkg.com https://kit.fontawesome.com https://ka-f.fontawesome.com https://fonts.cdnfonts.com";
        $fonts   = "'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ka-f.fontawesome.com https://fonts.cdnfonts.com";

        return implode('; ', [
            "default-src 'self'",
            "script-src $scripts",
            "style-src $styles",
            "font-src $fonts",
            "img-src 'self' data: blob: https://unpkg.com",   // no external images are used;
            "worker-src 'self' blob:",
            "connect-src 'self' https://ka-f.fontawesome.com https://cdn.jsdelivr.net https://challenges.cloudflare.com",
            "frame-src https://www.youtube.com https://www.youtube-nocookie.com https://challenges.cloudflare.com",
        ]);
    }
}
