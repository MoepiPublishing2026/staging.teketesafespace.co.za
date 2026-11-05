<?php

namespace App\Http\Middleware;

use App\Services\AuditTrailService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonitorHttpErrors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() >= 500) {
            app(AuditTrailService::class)->record(
                action: 'HTTP_SERVER_ERROR',
                reason: 'Server error ' . $response->getStatusCode() . ' on path: ' . $request->path(),
                metadata: [
                    'status_code' => $response->getStatusCode(),
                    'method'      => $request->method(),
                ]
            );
        }

        return $response;
    }
}