@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div>

    <div id="main-landing-container" x-data="{ menuOpen: false }"
        class="relative w-full min-h-[100dvh] bg-white font-[Montserrat] flex flex-col justify-between overflow-x-hidden class-hide-scrollbar">

        <header class="fixed top-0 left-0 right-0 bg-white z-40 flex items-center justify-between px-4 py-3 lg:px-[2vw] lg:pt-[1.5vh]">
            <div class="absolute inset-0 bg-white/40 backdrop-blur-sm hidden lg:block"></div>
            <div class="relative z-10 flex justify-end items-center w-full">

                <!-- Logo -->
                <a href="{{ route('landing-page') }}" class="lg:hidden -ml-3">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Safe Space Logo"
                        class="w-[170px]">
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6 lg:gap-8 xl:gap-10
                    font-[Montserrat]
                    text-[18px]
                    lg:text-[18px]
                    xl:text-[20px] ">


                    <a href="{{ route('landing-page') }}"
                        class="text-black transition-colors font-bold hover:!text-[#c7da30]">
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

                <div class="lg:hidden ml-auto -mt-2">
                    <button @click="menuOpen = !menuOpen" class="focus:outline-none relative z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#c7da30]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.75h16.5m-16.5 6.5h16.5m-16.5 6.5h16.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="menuOpen"
    x-transition:enter="transform transition ease-in-out duration-300"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    @click.away="menuOpen = false"
    class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg z-50 lg:hidden">
    
               <div class="flex items-center justify-start px-4 pt-16 pb-4">
    <button @click="menuOpen = false"
        class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">
        <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="3"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">

   <a href="{{ route('landing-page') }}"
    @click="menuOpen = false"
    class="block py-3 font-bold text-[#38b6ff]">
    Home
</a>

<a href="{{ route('about-us') }}"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff]">
    About Us
</a>

<a href="{{ $workshopBookingUrl }}/workshops"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff]">
    Workshops
</a>

<a href="{{ route('news') }}"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff]">
    News
</a>

<a href="{{ route('contact-us') }}"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff]">
    Contact Us
</a>


</nav>
        </header>

       <section class="relative flex-1 flex flex-col items-center justify-start px-5 pt-24 pb-8 lg:block lg:px-0 lg:pt-0 overflow-hidden">
            
            <div class="circle-bg-line hidden lg:block absolute top-[-95vh] left-[-46vw] w-[100vw] h-[320vh] pointer-events-none z-50">
                <img src="{{ asset('images/circle6.png') }}" alt="Circle Background" class="w-full h-full object-fill opacity-75 pointer-events-none">
            </div>

           <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo"
                class="hidden lg:block relative mb-2 min-[520px]:mb-1 max-w-[220px]
                min-[520px]:max-w-[160px] md:max-w-[220px]
                lg:max-w-none lg:absolute lg:mb-0 lg:top-[7vh]
                lg:left-[0vw] lg:w-[30vw] z-0">

           <h1 class="w-full text-center font-bold text-[#c7da30] leading-tight text-[32px] sm:text-[38px] mb-1 mx-auto lg:absolute lg:w-auto lg:text-left lg:text-[5vw] lg:top-[42vh] lg:left-[2vw] lg:mb-0">
    Report Abuse<br>Safely and<br>Anonymously
</h1>

            <img src="{{ asset('images/back-pc.png') }}" alt="Students"
                class="w-full max-w-[370px] mx-auto -mt-6 mb-8 object-contain lg:mt-0 lg:absolute lg:mx-0 lg:mb-0 lg:top-[4vh] lg:right-[5vw] lg:w-[38vw] lg:h-[37vw] lg:max-w-none">
                
            <div class="w-full max-w-[320px] mx-auto flex flex-col items-center gap-4 lg:absolute lg:mx-0 lg:max-w-none lg:w-auto lg:top-[78vh] lg:right-[8vw] lg:flex-row lg:gap-[1vw]">
                <button wire:click="redirectToReportAbuse"
                   class="w-[280px] h-[44px] border-2 border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[14px] bg-white transition hover:scale-105 lg:w-[10vw] lg:h-[3.4vw] lg:text-[1vw] lg:font-medium lg:border-[0.27vw]">
                    Report Now
                </button>

                <button wire:click="redirectToStatusCheck"
                   class="w-[280px] h-[44px] border-2 border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[14px] bg-white transition hover:scale-105 lg:w-[10vw] lg:h-[3.4vw] lg:text-[1vw] lg:font-medium lg:border-[0.27vw]">
                    Check Status
                </button>

                <button wire:click="redirectToAdminLogin"
                    class="w-[280px] h-[44px] border-2 border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[14px] bg-white transition hover:scale-105 lg:w-[10vw] lg:h-[3.4vw] lg:text-[1vw] lg:font-medium lg:border-[0.27vw]">
                    Administrators
                </button>
            </div>
        </section>

       <footer class="custom-desktop-footer relative bg-[#757573] text-white px-4 py-5 flex flex-col items-center gap-4 min-[640px]:flex-row min-[640px]:gap-2 lg:pl-[2vw] lg:pr-[2vw] lg:py-[1.5vh] lg:justify-between lg:items-center lg:gap-0 z-30">
          <div class="inline-flex flex-col items-center gap-2 mx-auto
            min-[640px]:flex-row min-[640px]:items-center min-[640px]:gap-6 min-[640px]:w-full min-[640px]:justify-center
            lg:justify-between lg:gap-0">

    <p class="text-[13px] leading-5 text-center min-[640px]:text-[14px] lg:text-[16px]">
        &copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.
    </p>

    <div class="flex items-center justify-center flex-wrap gap-4 min-[640px]:gap-2 lg:gap-[1vw]">
        <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
            <img src="{{ asset('images/youtube.png') }}" class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition" alt="YouTube">
        </a>
        <a href="https://www.X.com/moepipublishing" target="_blank">
            <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
            <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
            <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
            <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
            <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
    </div>
</div>
        </footer>

        <style>
    .zoom-stabilize {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
        will-change: transform, width, height;
    }

    html, body {
        overflow-x: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        display: none !important;
    }

    .class-hide-scrollbar {
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    .class-hide-scrollbar::-webkit-scrollbar {
        display: none !important;
    }

    /* Desktop */
    @media (min-width: 1024px) {
        #main-landing-container {
            min-height: 100vh;
        }

        .custom-desktop-footer {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
            padding-top: 25px;
            padding-bottom: 25px;
        }

        section {
            min-height: auto;
            flex: 1 1 auto;
        }
    }

    /* Mobile */
    @media (max-width: 1023px) {
        #main-landing-container {
            /* Recalculate against the visible viewport after returning from an external app. */
            min-height: var(--landing-viewport-height, 100dvh);
            overflow-x: hidden;
        }

        section {
            min-height: auto;
        }

        footer {
            position: relative;
            margin-top: auto;
        }

        h1 {
            text-align: center;
        }

        button {
            width: 100%;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    }

    /* Cookie notice */
    .force-cookie-bottom,
    .force-cookie-bottom > div,
    .force-cookie-bottom #privacy-notice {
        position: fixed !important;
        top: auto !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 999999 !important;
        transform: translateY(0) !important;
    }
</style>
    <script>
        (() => {
            const refreshLandingViewport = () => {
                document.documentElement.style.setProperty('--landing-viewport-height', `${window.innerHeight}px`);
            };

            refreshLandingViewport();
            window.addEventListener('resize', refreshLandingViewport, { passive: true });
            window.addEventListener('orientationchange', refreshLandingViewport, { passive: true });
            window.addEventListener('pageshow', refreshLandingViewport);
        })();
    </script>
    </div> <div class="force-cookie-bottom">
        @include('components.privacy-notice')
    </div>

</div>
