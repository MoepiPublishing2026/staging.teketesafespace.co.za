<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>{{ $title ?? 'Tekete SafeSpace' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/school-admin-mobile.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-white font-[Montserrat] sa-app">

    {{-- Use a div root so Livewire school-admin views can own a single <main> (avoids nested <main>) --}}
    <div class="sa-layout-root min-h-screen">
        {{ $slot }}
    </div>

    @livewireScripts
    <script src="{{ asset('js/auto-logout.js') }}"></script>
</body>
</html>
