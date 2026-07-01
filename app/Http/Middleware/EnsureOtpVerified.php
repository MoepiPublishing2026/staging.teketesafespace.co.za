<?php

namespace App\Http\Middleware;

use App\Support\OtpSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! OtpSession::isVerified()) {
            return redirect()->route('email.verification');
        }

        return $next($request);
    }
}
