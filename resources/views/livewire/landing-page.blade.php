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

            /* Enable vertical scrolling on body/html */
            html, body {
                overflow-x: hidden !important;
                overflow-y: auto !important;
            }

            /* Hide the decorative background linework on phones and tablets. */
            @media (max-width: 1023px) {
                #main-landing-container .hide-circle-on-tall-portrait {
                    display: none !important;
                }
            }

            /* Keep the landing page readable and usable on narrow phones. */
            @media (max-width: 699px) {
                #main-landing-container {
                    min-height: 100svh;
                    height: auto !important;
                    overflow-x: clip !important;
                    overflow-y: visible !important;
                }

                #main-landing-container > header {
                    flex-shrink: 0;
                }

                #main-landing-container > section {
                    min-height: 0 !important;
                    margin-top: 0 !important;
                    padding: 1.5rem 1rem 2rem !important;
                }

                #main-landing-container > section h1 {
                    margin: 0 !important;
                    font-size: clamp(2rem, 9vw, 2.65rem) !important;
                    line-height: 1.12 !important;
                    text-align: center !important;
                }

                #main-landing-container .tall-portrait-right-box > div:first-child img {
                    width: auto !important;
                    height: auto !important;
                    max-width: min(100%, 360px) !important;
                    max-height: 34svh !important;
                    object-fit: contain !important;
                }

                #main-landing-container .tall-portrait-btn-shift {
                    position: static !important;
                    top: auto !important;
                    left: auto !important;
                    width: 100% !important;
                    max-width: 320px !important;
                    margin: 0 auto !important;
                    flex-direction: column !important;
                    gap: 0.75rem !important;
                }

                #main-landing-container .tall-portrait-btn-shift button {
                    width: 100% !important;
                    max-width: 320px !important;
                    height: 3.5rem !important;
                    flex: none !important;
                }

                #main-landing-container footer {
                    width: 100%;
                    margin-top: auto;
                }

                #main-landing-container footer p {
                    margin-left: 0 !important;
                }

                #main-landing-container footer > div {
                    justify-content: center !important;
                }

                .force-cookie-bottom {
                    max-height: 45svh;
                    overflow-y: auto;
                }
            }

            /* General tablet portrait setup & button adjustments */
            @media (min-width: 700px) and (max-width: 1150px) and (orientation: portrait) {
                .hide-circle-on-tall-portrait {
                    display: none !important;
                }
                .tall-portrait-hero-fix {
                    display: flex !important;
                    flex-direction: column !important;
                    align-items: center !important;
                }
                .tall-portrait-left-box {
                    order: 1 !important;
                    width: 100% !important;
                    text-align: center !important;
                }
                .tall-portrait-right-box {
                    order: 2 !important;
                    width: 100% !important;
                    align-items: center !important;
                }
                .tall-portrait-btn-shift {
                    margin-left: auto !important;
                    margin-right: auto !important;
                    transform: translateX(0) !important;
                    justify-content: center !important;
                    width: 100% !important;
                    max-width: 100% !important;
                    top: 20px !important;
                    margin-bottom: 20px !important;
                }
                .tall-portrait-btn-shift button {
                    width: 220px !important;
                    height: 65px !important;
                    font-size: 20px !important;
                }
            }

            /* Galaxy Tab S4 (~712x1138): Move to the RIGHT */
            @media (min-width: 705px) and (max-width: 725px) and (orientation: portrait) {
                .tall-portrait-right-box img {
                    margin-left: 45px !important;
                }
            }

            /* iPad Pro 13 (1032x1376): Move to the RIGHT */
            @media (min-width: 1020px) and (max-width: 1150px) and (orientation: portrait) {
                .tall-portrait-right-box img {
                    margin-left: 25px !important;
                }
            }

            /* SCROLLABLE DESKTOP & LAPTOP LAYOUT FIX (1024px to 1439px) */
            @media (min-width: 1024px) and (max-width: 1439px) {
                #main-landing-container {
                    min-height: 100vh;
                    height: auto !important;
                    overflow-y: auto !important;
                }

                .tall-portrait-left-box {
                    text-align: left !important;
                    padding-left: 10px;
                }
                .tall-portrait-left-box h1 {
                    text-align: left !important;
                    margin-left: -30px !important;
                }

                .tall-portrait-right-box img {
                    height: auto !important;
                    max-height: 68vh !important;
                    max-width: 100% !important;
                    object-fit: contain !important;
                    position: relative !important;
                    left: -70px !important; 
                    top: 10px !important;
                }

                .tall-portrait-btn-shift {
                    top: -15px !important;
                    position: relative !important;
                    left: -20px !important;
                    margin-bottom: -8px !important;
                }
            }

            /* ULTRA-LARGE SCREEN MONITORS (1440px and up e.g., 1920x1080) */
            @media (min-width: 1440px) {
                #main-landing-container {
                    min-height: 100vh;
                    height: auto !important;
                    overflow-y: auto !important;
                }

                .tall-portrait-left-box {
                    text-align: left !important;
                    padding-left: 10px;
                }
                .tall-portrait-left-box h1 {
                    text-align: left !important;
                    margin-left: -30px !important;
                }

                /* Keep image safely bounded and prevent touching background lines on large displays */
                .tall-portrait-right-box img {
                    height: auto !important;
                    max-height: 62vh !important;
                    max-width: 90% !important;
                    object-fit: contain !important;
                    position: relative !important;
                    left: -20px !important; /* Gentle shift so it stays inside lines */
                    top: 10px !important;
                }

                .tall-portrait-btn-shift {
                    top: -15px !important;
                    position: relative !important;
                    left: 0px !important;
                    margin-bottom: -8px !important;
                }
            }
        </style>

<header class="relative w-full bg-white shadow-sm md:bg-transparent md:shadow-none z-50">
                <div class="flex justify-between items-center w-full px-6 lg:px-12 py-4">

                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Safe Space Logo"
                        class="w-[120px] sm:w-[140px] md:w-[200px] lg:w-[300px] xl:w-[300px] h-auto object-contain flex-shrink-0">
                </div>

                <!-- Top Right Links -->
                <div class="flex items-center gap-4">

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center gap-7 font-[Montserrat] text-[18px] lg:text-[20px] xl:text-[22px]" style="position: relative; top: -10px; left: -20px;">
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
            <div style="position: absolute; top: -58vh; left: -16vw; width: 72vw; height: 220vh;">
                    <img src="{{ asset('images/circle6.png') }}" 
                     alt="Circle Background" 
                     class="w-full h-full object-fill opacity-100 pointer-events-none"
                     style="mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 50%, rgba(0,0,0,0) 70%); -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 30%, rgba(0,0,0,0) 70%);">
            </div>
        </div>

        <!-- STATIC HERO SECTION -->
<section class="relative z-20 flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-8 pt-2 pb-8 -mt-20">            <!-- Fixed-width wrapper with tall portrait override -->
            <div class="w-full max-w-[1200px] mx-auto grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8 items-center tall-portrait-hero-fix">
                
                <!-- Left Side: Heading -->
                <div class="md:col-span-6 text-center md:text-left md:pt-12 tall-portrait-left-box">
                    <h1 class="font-normal text-[#c7da30] leading-tight text-[30px] sm:text-[38px] md:text-[50px] lg:text-[72px]"
                        style="font-family: 'Century Gothic Paneuropean', 'Century Gothic', sans-serif !important;">
                        Report Abuse<br>Safely and<br>Anonymously
                    </h1>
                </div>

                <!-- Right Side: Students Image & Action Buttons -->
                <div class="md:col-span-6 flex flex-col items-center md:items-end gap-4 tall-portrait-right-box">
                    <!-- Student Image -->
                    <div class="w-full flex justify-center md:justify-end">
                        <img src="{{ asset('images/back-pc.png') }}" 
                             alt="Students" 
                             class="h-[45vh] sm:h-[55vh] md:h-[65vh] lg:h-[72vh] w-auto max-w-full object-contain">
                    </div>

                    <!-- Action Buttons -->
                    <div class="w-full max-w-[420px] md:max-w-none flex flex-col sm:flex-row items-center justify-start md:justify-end gap-3 relative top-4 md:top-[15px] mb-12 tall-portrait-btn-shift">
                        <!-- Report Now Button -->
                        <button wire:click="redirectToReportAbuse"
                            class="w-[260px] sm:w-[180px] h-[60px] border-[4px] border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[18px] bg-white transition hover:scale-105"
                            style="font-family: 'Helvetica Now Display', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;">
                            Report Now
                        </button>

                        <!-- Check Status Button -->
                        <button wire:click="redirectToStatusCheck"
                            class="w-[260px] sm:w-[180px] h-[60px] border-[4px] border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[18px] bg-white transition hover:scale-105"
                            style="font-family: 'Helvetica Now Display', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;">
                            Check Status
                        </button>

                        <!-- Administrators Button -->
                        <button wire:click="redirectToAdminLogin"
                            class="w-[260px] sm:w-[180px] h-[60px] border-[4px] border-[#c7da30] rounded-full text-[#38b6ff] font-bold text-[18px] bg-white transition hover:scale-105"
                            style="font-family: 'Helvetica Now Display', 'Helvetica Neue', Helvetica, Arial, sans-serif !important;">
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