<div x-data="{ menuOpen: false }" class="flex flex-col font-[Montserrat] bg-white min-h-screen overflow-x-hidden relative">

    <!-- NAVBAR -->
    <!-- NAVBAR -->
    <header
        class="absolute top-0 left-0 right-0 z-50 w-full flex justify-between items-center px-6 pt-6 lg:pt-8 lg:right-[160px]">

        <!-- Desktop nav - only visible on large screens -->
        <nav class="hidden lg:flex gap-8 ml-auto">
            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                class="text-black text-[17px] transition-colors hover:text-[#c7da30]"
                style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                Home
            </a>
            <a href="{{ route('about-us') }}" class="text-black text-[17px] transition-colors hover:text-[#c7da30]">About
                Us</a>
            <a href="{{ route('contact-us') }}"
                class="text-black text-[17px] transition-colors hover:text-[#c7da30]">Contact Us</a>
        </nav>

        <!-- Mobile menu button - positioned on RIGHT -->
        <div class="lg:hidden ml-auto">
            <button @click="menuOpen = !menuOpen" class="focus:outline-none z-40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8 text-black">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 5.75h16.5m-16.5 6.5h16.5m-16.5 6.5h16.5" />
                </svg>
            </button>
        </div>

        <!-- Mobile menu overlay - slides from RIGHT -->
        <div x-show="menuOpen" x-transition @click.away="menuOpen = false"
            class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg flex flex-col items-start p-6 z-50 lg:hidden">
            <button @click="menuOpen = false" class="self-end mb-4 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-7 h-7 text-black">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <a href="{{ route('landing-page') }}" @click="menuOpen = false"
                class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">Home</a>
            <a href="{{ route('about-us') }}" @click="menuOpen = false"
                class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">About Us</a>
            <a href="{{ route('contact-us') }}" @click="menuOpen = false"
                class="text-black text-[17px] hover:text-[#c7da30] transition-colors">Contact Us</a>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section
        class="relative flex flex-col lg:flex-row justify-between items-start px-6 sm:px-10 lg:px-16 pt-12 pb-10 overflow-hidden">

        <!-- Circle Background -->
        <div
            class="absolute top-[-260px] left-[-520px] w-[1250px] sm:w-[1250px] lg:w-[1250px] h-[1250px] sm:h-[1250px] lg:h-[1250px] z-0 transition-all duration-500">
            <img src="{{ asset('images/circle6.png') }}" alt="Circle Background"
                class="w-full h-full object-cover opacity-75"
                style="mask-image: linear-gradient(to top, transparent 20%, black 15%);
                -webkit-mask-image: linear-gradient(to top, transparent 20%, black 15%);">
        </div>


        <!-- Hero Inner Content -->
        <div
            class="relative z-10 flex flex-col lg:flex-row justify-between items-start gap-5 w-full max-w-[1250px] mx-auto">

            <!-- Left: Logo + Heading -->
            <div class="flex flex-col items-start text-left space-y-4">

                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo"
                    class="w-[320px] sm:w-[340px] md:w-[380px] lg:w-[460px] transition-all duration-300">

                <h1 class="text-[#c7da30] font-bold text-3xl sm:text-4xl md:text-5xl lg:text-[74px] leading-tight">
                    Report Abuse<br>Safely and<br>Anonymously
                </h1>

            </div>

            <!-- Right: Image + Buttons -->
            <div class="flex flex-col items-center lg:items-end mt-3 lg:mt-2 w-full lg:w-auto">
                <div class="relative flex justify-center lg:justify-end w-full">
                    <img src="{{ asset('images/back-pc.png') }}" alt="Two Students"
                        class="w-[300px] sm:w-[400px] md:w-[500px] lg:w-[610px] h-auto transition-all duration-500 mx-auto lg:mx-0">
                </div>

                <!-- Buttons: vertical on mobile/tablet, horizontal on desktop -->
                <div
                    class="flex flex-col sm:flex-col md:flex-col lg:flex-row justify-center lg:justify-end gap-4 mt-8 w-full lg:w-auto">
                    <button wire:click="redirectToReportAbuse"
                        class="w-full sm:w-[260px] md:w-[280px] lg:w-[190px] 
               h-[50px] sm:h-[58px] md:h-[60px] lg:h-[64px] 
               text-[14px] sm:text-[15px] font-medium 
               border-4 border-solid border-[#c7da30] text-[#38b6ff] 
               rounded-[100px] shadow-md hover:scale-105 
               transition-transform">
                        Report Now
                    </button>

                    <button wire:click="redirectToStatusCheck"
                        class="w-full sm:w-[260px] md:w-[280px] lg:w-[190px] 
               h-[50px] sm:h-[58px] md:h-[60px] lg:h-[64px] 
               text-[14px] sm:text-[15px] font-medium 
               border-4 border-solid border-[#c7da30] text-[#38b6ff] 
               rounded-[100px] shadow-md hover:scale-105 
               transition-transform">
                        Check Status
                    </button>

                    <button wire:click="redirectToAdminLogin"
                        class="w-full sm:w-[260px] md:w-[280px] lg:w-[190px] 
               h-[50px] sm:h-[58px] md:h-[60px] lg:h-[64px] 
               text-[14px] sm:text-[15px] font-medium 
               border-4 border-solid border-[#c7da30] text-[#38b6ff] 
               rounded-[100px] shadow-md hover:scale-105 
               transition-transform">
                        Administrator
                    </button>

                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 1.5rem;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4 order-2">
                <a href=" https://www.youtube.com/@matauramapuputla6836"target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon"
                        style="width: 30px; height: 30px; left:1024.8; top: 701.8
;">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X Icon"
                        style="width: 30px; height: 30px;left:1024.8 ; top:701.8; ">
                </a>

                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon"
                        style="width: 30px; height: 30px;left: 1128.6
; top:701.1;">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon"
                        style="width: 35.2px; height: 30px;left: 1179.7;top: 701.1;">
                </a>

                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon"
                        style="width: 35.2px; height: 30px; left: 1225.7px; top: 701.1px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon"
                        style="width: 35.2px; height: 30px;left:1271.7 ;top:700.1;"></a>
            </div>

    </footer>
    </section>
    @include('components.privacy-notice')
