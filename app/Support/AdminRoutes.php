<?php

namespace App\Support;

use Illuminate\Http\Request;

class AdminRoutes
{
    public static function pathPatterns(): array
    {
        return [
            'school-admin',
            'school-district',
            'email-verification',
            'admin/*',
            'national-admin/*',
            'provincial-admin/*',
            'provincial/*',
            'district-admin/*',
            'district/*',
            'reports/*',
            'admin/newsletter/*',
        ];
    }

    public static function matches(Request $request): bool
    {
        if ($request->is(...self::pathPatterns())) {
            return true;
        }

        $referer = $request->headers->get('referer', '');
        if ($referer !== '') {
            $path = parse_url($referer, PHP_URL_PATH) ?? '';
            if ($path !== '' && Request::create($path)->is(...self::pathPatterns())) {
                return true;
            }
        }

        if (session()->has('admin_role')) {
            return true;
        }

        $user = auth()->user();
        if ($user && in_array($user->role ?? '', ['school', 'district', 'provincial', 'national'], true)) {
            return true;
        }

        return false;
    }

    public static function fallbackUrl(Request $request): string
    {
        if (auth()->check()) {
            $role = session('admin_role') ?? auth()->user()->role ?? 'school';

            return match ($role) {
                'district' => route('district.admin.dashboard'),
                'provincial' => route('provincial.admin.dashboard'),
                'national' => route('national.admin.dashboard'),
                default => route('admin.dashboard'),
            };
        }

        return route('school-admin');
    }
}
