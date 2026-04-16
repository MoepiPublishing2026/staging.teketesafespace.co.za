<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Settings | Tekete SafeSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-gray-100 antialiased">

<div class="flex min-h-screen" style="background: white";">
     <!-- Sidebar -->
<aside class="w-64 bg-white shadow-lg flex flex-col justify-between" style="background-color: #fffbf7">
    <div>
        <nav style="margin-top: 205px">
            <ul class="space-y-2">

                <!-- Dashboard -->
                <li class="flex justify-center">
                    <a href="/admin/dashboard"
                        class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                        {{ Request::is('admin/dashboard') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}"
                        style="width: 188px; height: 41px; color: black; font-size: 15px; padding-left: 17px;">
                        <i></i>Dashboard
                    </a>
                </li>

                <!-- Reports -->
                <li class="flex justify-center">
                    <a href="/admin/reports"
                        class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                        {{ Request::is('admin/reports') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}"
                        style="width: 188px; height: 41px; color: black; font-size: 15px; padding-left: 17px;">
                        <i></i>Reports
                    </a>
                </li>

                <!-- My Profile -->
                <li class="flex justify-center">
                    <a href="/admin/settings"
                        class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                        {{ Request::is('admin/settings') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}"
                        style="width: 188px; height: 41px; color: black; font-size: 15px; padding-left: 17px;">
                        <i></i>My Profile
                    </a>
                </li>
                <!-- Sign Out -->
                <li class="flex justify-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full rounded flex items-center font-montserrat-black rounded-lg transition-all
                            hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]"
                            style="width: 188px; height: 41px; color: black; font-size: 15px; padding-left: 17px;">
                            Sign Out
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>

    <!-- Main Content (Livewire component inserted here) -->
    <main class="flex-1 flex items-center justify-center p-8" style="background: white;">
        @livewire('admin-settings')
    </main>
</div>

@livewireScripts
</body>
</html>
