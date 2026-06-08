<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Apply Montserrat font globally */
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Outline pill button used on landing page hero */
        .btn-outline-safe {
            border: 4px solid #c7da30;
            color: #38b6ff;
            border-radius: 9999px;
            transition: transform 0.2s ease;
        }

        .btn-outline-safe:hover {
            transform: scale(1.03);
        }

        /* Custom thick border and large rounding for the "Outer Square" effect */
        .outer-square {
            border: 3px solid #c7da30;
            /* Stroke weight: 3px */
            border-radius: 2.5rem;
            /* Large rounding */
        }
    </style>
</head>

<!-- Header -->
<header
    style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
    <div class="flex flex-row justify-between items-center py-2" style="width: 100%; padding-left: 2vw; padding-right: 2vw;">
        <!-- Logo -->
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" style="width: 110px; height: auto;">
        </div>

        <!-- Desktop Links (UNCHANGED) -->
        <div class="hidden md:flex gap-8" style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
            <a href="{{ route('landing-page') }}" class="transition-colors hover:!text-[#c7da30]"
                style="color: black; text-decoration: none;">
                Home
            </a>
            <a href="{{ route('about-us') }}" class="transition-colors hover:!text-[#c7da30]"
                style="color: black; text-decoration: none;">
                About Us
            </a>
            <a href="{{ route('contact-us') }}" class="transition-colors hover:!text-[#c7da30]"
                style="color: black; text-decoration: none;">
                Contact Us
            </a>
        </div>

        <!-- Mobile Hamburger Menu (NEW) -->
        <div class="md:hidden">
            <button id="mobile-menu-button"
                class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]"
                onclick="toggleMobileMenu()">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu (NEW) -->
<div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

    <!-- Menu Panel -->
    <div
        class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between p-4 border-b">
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">
            <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Links -->
        <nav class="mt-8 px-4">

            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()"
                class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                style="font-family: 'Montserrat', sans-serif; font-size: 17px;">About Us</a>
            <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()"
                class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Contact Us</a>
        </nav>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }
</script>

<body class="bg-white flex flex-col min-h-screen">
    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center pt-32 px-4">
        <div class="w-full max-w-lg mx-auto p-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-black uppercase text-center">
                Forgot Your Password
            </h2>

            <!-- Outer Square -->
            <div class="bg-white p-8 sm:p-10 shadow-2xl w-full outer-square">
                @if (session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md"
                        role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 text-left">
                            Email Address
                        </label>
                        <input id="email" type="email"
                            class="shadow appearance-none rounded-2xl w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white border-2 border-[#c7da30] @error('email') border-red-500 @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email address"
                            style="border-color: #c7da30; font-size: 13px; color: rgb(128 128 128 / 0.63);" />
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block text-left">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col space-y-4 pt-2">
                        <!-- Submit button -->
                        <button type="submit"
                            class="w-full mx-auto block shadow-md text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c7da30] btn-outline-safe"
                            style="height: 60px; font-size: 15px; display: flex; align-items: center; justify-content: center;">
                            Send Password Reset Link
                        </button>

                        <!-- Back button (KEEP as secondary option) -->
                        <a href="{{ url('/school-admin') }}"
                            class="w-full mx-auto block shadow-md text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c7da30] btn-outline-safe"
                            style="height: 60px; font-size: 15px; display: flex; align-items: center; justify-content: center;">
                            ← Back to login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer (UNCHANGED) -->
    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 4rem;">
         <div class="flex flex-col md:flex-row justify-between items-center gap-6 px-6 lg:px-8 w-full"
     style="font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4 order-2">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon"
                        style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon"
                        style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon"
                        style="width: 35.2px; height: 30px;">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon"
                        style="width: 35.2px; height: 30px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon"
                        style="width: 35.2px; height: 30px;">
                </a>
            </div>
        </div>
    </footer>
</body>

</html>
