@php
    $adminRoutePatterns = [
        'admin/*',
        'national-admin/*',
        'provincial-admin/*',
        'provincial/*',
        'district-admin/*',
        'district/*',
        'email-verification',
    ];
    $isAdminArea = auth()->check() && request()->is(...$adminRoutePatterns);
@endphp

@if($isAdminArea)
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.AdminAutoLogout = {
            timeoutMinutes: {{ (int) config('admin.inactivity_timeout_minutes', 30) }},
            logoutUrl: @json(route('logout')),
            loginUrl: @json(route('school-admin')),
            csrfToken: @json(csrf_token()),
        };
    </script>
    <script src="{{ asset('js/auto-logout.js') }}" defer></script>
@endif
