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

    {{-- Tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>
<body class="bg-white font-[Montserrat] sa-app">

    {{-- Toast container --}}
    <div
        x-data="{
            toasts: [],
            icons: { success: 'ti-circle-check', warning: 'ti-alert-triangle', danger: 'ti-ban', info: 'ti-info-circle' },
            add(e) {
                const id = Date.now();
                this.toasts.push({ id, type: e.detail.type ?? 'info', message: e.detail.message });
                setTimeout(() => this.remove(id), 4500);
            },
            remove(id) { this.toasts = this.toasts.filter(t => t.id !== id); }
        }"
        @toast.window="add($event)"
        class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"
    >
        <template x-for="t in toasts" :key="t.id">
            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                :class="{
                    'border-green-400 text-green-800 bg-green-50': t.type === 'success',
                    'border-yellow-400 text-yellow-800 bg-yellow-50': t.type === 'warning',
                    'border-red-400 text-red-800 bg-red-50': t.type === 'danger',
                    'border-blue-400 text-blue-800 bg-blue-50': t.type === 'info',
                }"
                class="flex items-center gap-3 border rounded-xl px-4 py-3 text-sm shadow max-w-sm w-full"
            >
                <i class="ti text-lg" :class="icons[t.type] ?? 'ti-info-circle'" aria-hidden="true"></i>
                <span x-text="t.message" class="flex-1"></span>
                <button @click="remove(t.id)" class="text-current opacity-50 hover:opacity-100">
                    <i class="ti ti-x text-base"></i>
                </button>
            </div>
        </template>
    </div>

    <div class="sa-layout-root min-h-screen">
        {{ $slot }}
    </div>

    {{-- Session flash bridge --}}
    @if(session('success_message') || session('error_message') || session('warning_message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success_message'))
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: @js(session('success_message')) } }));
            @endif
            @if(session('error_message'))
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'danger', message: @js(session('error_message')) } }));
            @endif
            @if(session('warning_message'))
                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'warning', message: @js(session('warning_message')) } }));
            @endif
        });
    </script>
    @endif

    @livewireScripts
    <script src="{{ asset('js/auto-logout.js') }}"></script>
</body>
</html>