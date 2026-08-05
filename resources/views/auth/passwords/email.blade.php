<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>    <style>
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

       

        /* Custom thick border and large rounding for the "Outer Square" effect */
        .outer-square {
            border: 3px solid #c7da30;
            /* Stroke weight: 3px */
            border-radius: 1.5rem;
            /* Large rounding */
        }
    </style>
</head>

<header
    class="fixed top-0 left-0 w-full bg-white z-50 ">

    <div class="flex justify-between items-center w-full px-6 lg:px-8 py-2">

        <!-- Logo -->
        <div class="flex items-center">
    <img
        src="{{ asset('images/logo.png') }}"
        alt="Safe Space Logo"
        class="
            w-[120px]
            sm:w-[140px]
            md:w-[170px]
            lg:w-[190px]
            xl:w-[200px]
            2xl:w-[300px]
            h-auto
            object-contain
            flex-shrink-0">
</div>

        <!-- Top Right Links -->
        <div class="flex items-center gap-4">

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6 lg:gap-8 xl:gap-10
            font-[Montserrat]
            text-[18px]
            lg:text-[18px]
            xl:text-[20px]
            ">

                 <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
                        Back
                    </a>

                <a href="{{ route('landing-page') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Home
                </a>

                <a href="{{ route('about-us') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    About Us
                </a>
                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"  class="text-black transition-colors hover:!text-[#c7da30]">
                        Workshops
                    </a>

                 <a href="{{ route('news') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    News
                </a>

                <a href="{{ route('contact-us') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Contact Us
                </a>

            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
              <button id="mobile-menu-button"
                        onclick="toggleMobileMenu()"
                        class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">

                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                </button>
            </div>

        </div>

    </div>
</header>

    <div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
    
  <div id="mobile-menu-slide"
    class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-in-out">    
        <div class="flex items-center justify-start px-4 pt-16 pb-4">
            <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none">
                <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
              <a href="javascript:void(0);"
       onclick="window.history.back(); toggleMobileMenu();"class="block py-3 text-[#38b6ff]"> Back</a>

            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">About Us</a>
            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Workshops</a>
            <a href="{{ route('news') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">News</a>
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3  text-[#38b6ff]">Contact Us</a>

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
<div class="w-full mx-auto p-4" style="max-width: 650px;">
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
                            class="shadow appearance-none rounded-md w-full py-4 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white border-[3px] border-[#c7da30] @error('email') border-red-500 @enderror"
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
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer (UNCHANGED) -->
    <footer class="relative w-full bg-[#757573] text-white py-8 mt-auto z-30 font-[Montserrat]" style="margin-top: 4rem; width: 100vw; max-width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
<div class="w-full px-4 min-[640px]:px-6 flex flex-col items-start justify-center text-left gap-6 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:items-center lg:px-[1vw]">
                <p class="text-[13px] leading-5 font-normal text-white min-[640px]:text-[14px] lg:text-[16px] w-full min-[640px]:w-auto flex justify-center min-[640px]:justify-start">
                <span class="text-center min-[640px]:text-left">
                    &copy; {{ date('Y') }} Tekete SafeSpace From Moepi <br class="min-[640px]:hidden">Publishing. All rights reserved.
                </span>
            </p>
<div class="w-full flex items-center justify-center flex-wrap gap-4 min-[640px]:w-auto min-[640px]:justify-start min-[640px]:gap-2 lg:gap-[1vw]">                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}"
                         class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition"
                         alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
            </div>
        </div>
    </footer>
     <script>
        function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const slide = document.getElementById('mobile-menu-slide');
        
        if (!menu || !slide) return;

        const isHidden = menu.classList.contains('hidden');
        
        if (isHidden) {
            // Show background overlay and slide panel in sequence
            menu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Small timeout to allow display:block to apply before triggering CSS transition
            setTimeout(() => {
                slide.classList.remove('translate-x-full');
                slide.classList.add('translate-x-0');
            }, 10);
        } else {
            // Slide panel away first, then hide the wrapper
            slide.classList.remove('translate-x-0');
            slide.classList.add('translate-x-full');
            document.body.style.overflow = '';
            
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300); // Matches the 300ms duration-300 transition time
        }
    }
       
    </script>
</body>

</html>
