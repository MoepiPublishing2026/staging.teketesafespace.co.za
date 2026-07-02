<?php

namespace App\Http\Middleware;

use App\Support\AdminRoutes;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleAdminGracefully
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! AdminRoutes::matches($request)) {
            return $next($request);
        }

        config(['app.debug' => false]);
        ini_set('default_socket_timeout', '10');

        return $next($request);
    }
}
