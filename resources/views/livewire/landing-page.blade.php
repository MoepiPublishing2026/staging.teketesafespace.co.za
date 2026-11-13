@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div>
    <div id="main-landing-container" x-data="{ menuOpen: false }"
        class="relative w-full min-h-screen bg-white font-[Montserrat] flex flex-col justify-between overflow-x-hidden overflow-y-auto">
        <style>
            @import url('https://fonts.cdnfonts.com/css/century-gothic-paneuropean');

            .font-paneuropean {
                font-family: 'Century Gothic Paneuropean', 'Century Gothic', sans-serif !important;
                font-weight: 400 !important;
            }

            html, body {
                overflow-x: hidden !important;
                overflow-y: auto !important;
            }

            /* =========================================================
               HERO BASE (phones + tablets). Desktop overrides are below.
               ========================================================= */
            .landing-h1 {
                font-family: 'Century Gothic Paneuropean', 'Century Gothic', sans-serif !important;
                font-size: clamp(32px, 9vw, 46px);
            }

            .landing-hero-img {
                position: static;
                width: auto;
                height: auto;
                max-width: min(100%, 360px);
                max-height: 32svh;
                object-fit: contain;
                margin: 0 auto;
                display: block;
            }

            .landing-actions {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                gap: 1rem;
                width: 100%;
                max-width: 100%;
                margin: 0 auto 1.5rem;
            }

            .landing-btn {
                width: min(100%, 210px);
                height: 3.5rem;
                flex-shrink: 0;
                border: 3px solid #c7da30;
                color: #00b0dc;
                font-family: 'Helvetica Now Display', 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-size: 18px;
            }

            /* Phones and tablets */
            @media (max-width: 1023px) {
                #main-landing-container .hide-circle-on-tall-portrait {
                    display: none !important;
                }

                #main-landing-container {
                    min-height: 100svh;
                    height: auto !important;
                    overflow-x: clip !important;
                    overflow-y: visible !important;
                }

                #main-landing-container > header {
                    flex-shrink: 0;
                }

                #main-landing-container > header > div {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }

                #main-landing-container > header img {
                    width: 120px !important;
                    margin-left: 0 !important;
                }

                #main-landing-container > section {
                    min-height: 0 !important;
                    margin-top: 0 !important;
                    padding: 1.5rem 1rem 2rem !important;
                }

                .landing-h1 {
                    margin: 0 !important;
                    line-height: 1.12 !important;
                    text-align: center !important;
                }

                .force-cookie-bottom {
                    max-height: 45svh;
                    overflow-y: auto;
                }
            }

            /* Tablets only (700px - 1023px) */
            @media (min-width: 700px) and (max-width: 1023px) {
                .landing-h1 {
                    font-size: clamp(44px, 7vw, 64px);
                }

                .landing-hero-img {
                    max-width: min(100%, 520px);
                    max-height: 40svh;
                }

                .landing-actions {
                    flex-direction: row;
                    max-width: 720px;
                }

                .landing-btn {
                    width: 210px;
                    height: 4rem;
                    font-size: 20px;
                    border-width: 4px;
                }
            }

            /* Phones only (under 700px) */
            @media (max-width: 699px) {
                .landing-actions {
                    flex-direction: column;
                    max-width: 320px;
                    gap: 0.75rem;
                }

                .landing-btn {
                    width: 100%;
                    max-width: 320px;
                }

                .force-cookie-bottom > div,
                .force-cookie-bottom #privacy-notice {
                    max-height: 45svh !important;
                    overflow-y: auto !important;
                }
            }

            /* =========================================================
               DESKTOP (1024px and up) — ONE layout for ALL screens.
               Everything is sized in vw (percent of screen width), so the
               design is identical on every screen, just bigger or smaller.
               Matches the prototype (measured at 1376px wide).
               ========================================================= */
            @media (min-width: 1024px) {
                #main-landing-container {
                    min-height: 0 !important;
                    height: auto !important;
                    overflow-y: visible !important;
                }

                /* HEADER — identical to the About page.
                   About uses a 1366px board scaled by width/1366, so its px
                   values translate to vw: px / 13.66 = vw.
                   logo: left 88px -> 6.44vw, top 16px -> 1.17vw, w 300px -> 21.96vw
                   nav:  top 67px -> 4.9vw, font 19.97px -> 1.46vw
                   nav links: 851.4 -> 62.33vw, 936 -> 68.52vw,
                              1049.8 -> 76.85vw, 1182.6 -> 86.54vw */
                #main-landing-container > header > div {
                    display: block !important;
                    position: relative;
                    padding: 0 !important;
                    height: 6.8vw;
                }

                #main-landing-container .landing-logo-wrap {
                    position: absolute !important;
                    left: 6.44vw !important;
                    top: 1.17vw !important;
                    margin: 0 !important;
                }

                #main-landing-container > header img {
                    width: 21.96vw !important;
                    margin-left: 0 !important;
                }

                #main-landing-container .landing-nav {
                    position: absolute !important;
                    display: block !important;
                    top: 4.9vw !important;
                    left: 0 !important;
                    width: 100% !important;
                    gap: 0 !important;
                    font-size: 1.46vw !important;
                    line-height: 1.22 !important;
                }

                #main-landing-container .landing-nav a {
                    position: absolute !important;
                    top: 0 !important;
                    font-size: 1.46vw !important;
                    white-space: nowrap;
                }

                #main-landing-container .landing-nav a:nth-child(1) { left: 62.33vw !important; }
                #main-landing-container .landing-nav a:nth-child(2) { left: 68.52vw !important; }
                #main-landing-container .landing-nav a:nth-child(3) { left: 76.85vw !important; }
                /* Right edges of Contact Us, Administrators button and the
                   TikTok icon all align at 96vw (1311.4px at 1366w).
                   Contact Us is nudged +1.46vw so its right edge matches. */
                #main-landing-container .landing-nav a:nth-child(4) { left: 88vw !important; }

                /* HERO SECTION */
                #main-landing-container > section {
                    margin-top: 0 !important;
                    min-height: 0 !important;
                    height: 52vw !important;
                    padding: 0 6vw 8.5vw 6.5vw !important;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                #main-landing-container > section > div {
                    max-width: none !important;
                }

                /* HEADING */
                .tall-portrait-left-box {
                    padding: 0 !important;
                    text-align: left !important;
                }

                #main-landing-container .landing-h1 {
                    font-size: 5.1vw !important;
                    line-height: 1.15 !important;
                    text-align: left !important;
                    margin: 0 !important;
                    transform: translate(1vw, 3vw) !important;
                }

                /* IMAGE + BUTTONS */
                .tall-portrait-right-box {
                    gap: 0 !important;
                }

                #main-landing-container .landing-hero-img {
                    position: static !important;
                    transform: translateY(2vw) !important;
                    width: 37vw !important;
                    max-width: none !important;
                    max-height: none !important;
                    height: auto;
                    margin: 0 0 0 auto !important;
                    display: block;
                }

                .tall-portrait-right-box img {
                    left: 0 !important;
                    top: 0 !important;
                }

                #main-landing-container .landing-actions {
                    position: static !important;
                    transform: translate(2vw, 1vw) !important; 
                    flex-direction: row !important;
                    flex-wrap: nowrap !important;
                    justify-content: flex-end !important;
                    gap: 1.75vw !important;
                    max-width: none !important;
                    margin: 0 !important;
                }

                .tall-portrait-btn-shift {
                    position: static !important;
                    top: 0 !important;
                    left: 0 !important;
                    margin: 0 !important;
                }

                #main-landing-container .landing-btn {
                    width: 14.3vw !important;
                    height: 4.7vw !important;
                    border-width: 0.28vw !important;
                    font-size: 1.45vw !important;
                    white-space: nowrap;
                }
            }

            /* Tall portrait tablets (iPad Pro etc.) stay stacked like tablets */
            @media (min-width: 1024px) and (orientation: portrait) {
                #main-landing-container .hide-circle-on-tall-portrait {
                    display: none !important;
                }

                #main-landing-container > section {
                    height: auto !important;
                    padding: 1.5rem 1rem 2rem !important;
                }

                #main-landing-container .tall-portrait-left-box,
                #main-landing-container .tall-portrait-right-box {
                    grid-column: 1 / -1 !important;
                    align-items: center !important;
                    text-align: center !important;
                    padding: 0 !important;
                }

                #main-landing-container .landing-h1 {
                    text-align: center !important;
                    font-size: clamp(52px, 7vw, 72px) !important;
                }

                #main-landing-container .landing-hero-img {
                    margin: 0 auto !important;
                    width: auto !important;
                    max-width: min(100%, 560px) !important;
                    max-height: 38svh !important;
                }

                #main-landing-container .landing-actions {
                    flex-wrap: wrap !important;
                    justify-content: center !important;
                    max-width: 720px !important;
                    margin: 0 auto 1.5rem !important;
                }

                #main-landing-container .landing-btn {
                    width: 210px !important;
                    height: 4rem !important;
                    font-size: 20px !important;
                    border-width: 4px !important;
                }
            }
        </style>

        <header class="relative w-full bg-white shadow-sm md:bg-transparent md:shadow-none z-50">
            <div class="flex justify-between items-center w-full px-6 lg:px-12 py-4">

                <!-- Logo -->
                <div class="flex items-center ml-4 lg:ml-10 landing-logo-wrap">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Safe Space Logo"
                        class="w-[120px] sm:w-[140px] md:w-[200px] lg:w-[300px] xl:w-[300px] h-auto object-contain flex-shrink-0">
                </div>

                <!-- Top Right Links -->
                <div class="flex items-center gap-4">

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex landing-nav items-center gap-7 font-[Montserrat] text-[18px] lg:text-[20px] xl:text-[22px]" style="position: relative; top: -10px; left: -20px;">
                        <a href="{{ route('landing-page') }}" class="text-black transition-colors hover:!text-[#c7da30]">
                            Home
                        </a>
                        <a href="{{ route('about-us') }}" class="text-black transition-colors hover:!text-[#c7da30]">
                            About Us
                        </a>
                        <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" class="text-black transition-colors hover:!text-[#c7da30]">
                            Workshops
                        </a>
                        <a href="{{ route('contact-us') }}" class="text-black transition-colors hover:!text-[#c7da30]">
                            Contact Us
                        </a>
                    </div>

                    <div class="lg:hidden ml-auto">
                        <button @click="menuOpen = !menuOpen" class="focus:outline-none relative z-50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-[#c7da30]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.75h16.5m-16.5 6.5h16.5m-16.5 6.5h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Drawer -->
                <div x-show="menuOpen"
                    x-transition:enter="transform transition ease-in-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-300"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    @click.away="menuOpen = false"
                    class="fixed top-0 right-0 h-full w-[min(18rem,85vw)] bg-white shadow-lg z-50 lg:hidden">

                    <div class="flex items-center justify-start px-4 pt-16 pb-4">
                        <button @click="menuOpen = false" class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">
                            <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
                        <a href="{{ route('landing-page') }}" @click="menuOpen = false" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Home</a>
                        <a href="{{ route('about-us') }}" @click="menuOpen = false" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">About Us</a>
                        <a href="{{ $workshopBookingUrl }}/workshops" @click="menuOpen = false" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Workshops</a>
                        <a href="{{ route('contact-us') }}" @click="menuOpen = false" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Contact Us</a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Background Decor -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-10 hidden sm:block hide-circle-on-tall-portrait">
            <div class="absolute -top-[25vw] -left-[8.2vw] w-[110vw] aspect-square">
                <img src="{{ asset('images/line for Safe Space.svg') }}"
                     alt="Circle Background"
                     class="w-full h-full object-contain opacity-100 pointer-events-none">
            </div>
        </div>

        <!-- STATIC HERO SECTION -->
        <section class="relative z-20 flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-8 pt-2 pb-24 lg:pb-20 -mt-20">
            <div class="w-full max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">

                <!-- Left Side: Heading -->
                <div class="lg:col-span-6 text-center lg:text-left lg:pt-12 tall-portrait-left-box">
                    <h1 class="landing-h1 font-normal text-[#c7da30] leading-tight">
                        Report Abuse<br>Safely and<br>Anonymously 
                    </h1>
                </div>

                <!-- Right Side: Students Image & Action Buttons -->
                <div class="lg:col-span-6 flex flex-col items-center lg:items-end gap-4 tall-portrait-right-box">
                    <div class="w-full flex justify-center">
                        <img src="{{ asset('images/back-pc.png') }}" alt="Students" class="landing-hero-img">
                    </div>

                    <div class="landing-actions tall-portrait-btn-shift">
                        <button wire:click="redirectToReportAbuse"
                            class="landing-btn rounded-full font-bold bg-white transition hover:scale-105">
                            Report Now
                        </button>

                        <button wire:click="redirectToStatusCheck"
                            class="landing-btn rounded-full font-bold bg-white transition hover:scale-105">
                            Check Status
                        </button>

                        <button wire:click="redirectToAdminLogin"
                            class="landing-btn rounded-full font-bold bg-white transition hover:scale-105">
                            Administrators
                        </button>
                    </div>
                </div>

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

            /* Footer: phones and tablets (fixed size) */
            @media (max-width: 1023px) {
                #main-landing-container footer {
                    padding-top: 25px !important;
                    padding-bottom: 22px !important;
                }
            }

            /* Footer: desktop (scales with screen width, same as the rest) */
            @media (min-width: 1024px) {
                #main-landing-container footer {
                    padding-top: 1.7vw !important;
                    padding-bottom: 1.7vw !important;
                }

                /* Footer text left edge aligns with the header logo (88px at
                   1366w = 6.44vw). Footer px padding (16px) + p margin (24px)
                   already give 40px, so add the remaining 3.52vw. */
                #main-landing-container footer p {
                    font-size: 1.4vw !important;
                    margin-left: 5vw !important;
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
    </div>

    <div class="force-cookie-bottom">
        @include('components.privacy-notice')
    </div>
</div>
