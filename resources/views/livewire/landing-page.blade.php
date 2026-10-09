@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div>

    <div id="main-landing-container" x-data="{ menuOpen: false }"
        class="relative w-full min-h-[100dvh] bg-white font-[Montserrat] flex flex-col justify-between overflow-x-hidden class-hide-scrollbar">

<header class="fixed top-0 left-0 w-full bg-white shadow-sm md:bg-transparent md:shadow-none z-50">
    <div class="flex justify-between items-center w-full px-6 lg:px-8 py-2">

        <!-- Logo -->
        <div class="flex items-center">
           <img
    src="{{ asset('images/logo.png') }}"
    alt="Safe Space Logo"
    class="
        relative
        xl:top-[12px]
        2xl:top-[14px]
        w-[120px]
        sm:w-[140px]
        md:w-[240px]
        lg:w-[280px]
        xl:w-[320px]
        2xl:w-[380px]
        h-auto
        object-contain
        flex-shrink-0">
        </div>

        <!-- Top Right Links -->
        <div class="flex items-center gap-4">

            <!-- Desktop Navigation -->
           <div class="hidden md:flex items-center gap-7 md:mr-4 lg:mr-8 xl:mr-12 font-[Montserrat] text-[18px] lg:text-[20px] xl:text-[22px]">
                <a href="{{ route('landing-page') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Home
                </a>

                <a href="{{ route('about-us') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    About Us
                </a>

                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Workshops
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
    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
    Home
</a>

<a href="{{ route('about-us') }}"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
    About Us
</a>

<a href="{{ $workshopBookingUrl }}/workshops"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
    Workshops
</a>

<a href="{{ route('contact-us') }}"
    @click="menuOpen = false"
    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
    Contact Us
</a>


</nav>
        </header>
    <div class="circle-bg-line hidden lg:block" style="position: fixed !important; top: -50vh; left: -20vw; width: 81vw; height: 220vh; pointer-events: none; z-index: 50;">
    <img src="{{ asset('images/circle6.png') }}" 
         alt="Circle Background" 
         class="w-full h-full object-fill opacity-75 pointer-events-none"
         style="mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 70%); -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 30%, rgba(0,0,0,0) 70%);">
</div>

        <section class="relative flex-1 flex flex-col items-center justify-start px-5 pt-16 pb-8 lg:block lg:px-10 lg:pt-0 overflow-hidden">
    <!-- Heading: order-1 on mobile so it appears safely at the top -->
    <h1 class="order-1 relative z-20 w-full text-center font-normal text-[#c7da30] leading-tight  text-[32px] sm:text-[38px] mt-4 mb-6 mx-auto lg:order-none lg:absolute lg:w-auto lg:text-left lg:text-[5vw] lg:top-[30vh] lg:left-[3vw] lg:mb-0">
        Report Abuse<br>Safely and<br>Anonymously
    </h1>

    <!-- Student Image: order-2 on mobile so it sits cleanly below the heading -->
    <img src="{{ asset('images/back-pc.png') }}" alt="Students"
        class="order-2 w-full max-w-[360px] mx-auto mb-8 object-contain lg:order-none lg:mt-0 lg:absolute lg:mx-0 lg:mb-0 lg:top-[16vh] lg:right-[4vw] lg:w-[40vw] lg:h-[33vw] lg:max-w-none">
    <!-- Buttons: order-3 on mobile -->
    <div class="order-3 w-full max-w-[320px] mx-auto flex flex-col items-center gap-4 lg:order-none lg:absolute lg:mx-0 lg:max-w-none lg:w-auto lg:top-[78vh] lg:right-[9vw] lg:flex-row lg:gap-[1vw]">
        <button wire:click="redirectToReportAbuse"
           class="w-[280px] h-[44px] border-2 border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[14px] bg-white transition hover:scale-105 lg:w-[11vw] lg:h-[3.8vw] lg:text-[1.1vw] lg:font-bold lg:border-[0.27vw]">
            Report Now
        </button>

        <button wire:click="redirectToStatusCheck"
           class="w-[280px] h-[44px] border-2 border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[14px] bg-white transition hover:scale-105 lg:w-[11vw] lg:h-[3.8vw] lg:text-[1.1vw] lg:font-bold lg:border-[0.27vw]">
            Check Status
        </button>

        <button wire:click="redirectToAdminLogin"
            class="w-[280px] h-[44px] border-2 border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[14px] bg-white transition hover:scale-105 lg:w-[11vw] lg:h-[3.8vw] lg:text-[1.1vw] lg:font-bold lg:border-[0.27vw]">
            Administrators
        </button>
    </div>

</section>

    <x-site-footer />

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
                document.documentElement.style.setProperty('--landing-viewport-height', ${window.innerHeight}px);
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