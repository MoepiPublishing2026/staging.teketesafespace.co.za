<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Only enforce for school admins
        if ($user && $user->role === 'school') {
            if (!$user->hasActiveSubscription()) {
                return redirect()->route('admin.subscribe')
                    ->with('warning', 'Please choose a subscription plan to access the dashboard.');
            }
        }

        return $next($request);
    }
}
