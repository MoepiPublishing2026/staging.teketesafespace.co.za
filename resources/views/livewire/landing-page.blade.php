@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div>

    <div id="main-landing-container" x-data="{ menuOpen: false }"
        class="relative w-screen min-h-screen bg-white font-[Montserrat] flex flex-col justify-between overflow-x-hidden class-hide-scrollbar">

        <header class="fixed top-0 left-0 right-0 z-40 w-full flex justify-between items-center px-6 pt-4 lg:px-[4vw] lg:pt-[1.5vh]">
            <div class="absolute inset-0 bg-white/40 backdrop-blur-sm hidden lg:block"></div>
            <div class="relative z-10 flex justify-end items-center w-full">

                <!-- Logo -->
                <a href="{{ route('landing-page') }}" class="lg:hidden">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Safe Space Logo"
                        class="w-[140px] sm:w-[160px] md:w-[180px]">
                </a>

                <nav class="hidden lg:flex items-center gap-[2vw] font-medium" style="font-family: 'Montserrat', sans-serif;">                    
                    <a href="{{ route('landing-page') }}" class="text-black text-[1.3vw] font-bold transition-colors hover:text-[#c7da30]">Home</a>
                    <a href="{{ route('about-us') }}" class="text-black text-[1.3vw] transition-colors hover:text-[#c7da30]">About Us</a>
                    <a href="{{ $workshopBookingUrl }}/workshops" class="text-black text-[1.3vw] transition-colors hover:text-[#c7da30]">

                            Workshops
                    </a> 
                    <a href="{{ route('contact-us') }}" class="text-black text-[1.3vw] transition-colors hover:text-[#c7da30]">Contact Us</a>
                  <a href="{{ route('news') }}" class="text-black text-[1.3vw] transition-colors hover:text-[#c7da30] whitespace-nowrap">News</a>

                </nav>

                <div class="lg:hidden ml-auto -mt-8">
                    <button @click="menuOpen = !menuOpen" class="focus:outline-none relative z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-black">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.75h16.5m-16.5 6.5h16.5m-16.5 6.5h16.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="menuOpen"
                x-transition
                @click.away="menuOpen = false"
                class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg flex flex-col items-start p-3 z-50 lg:hidden">

                <div class="flex items-center justify-between w-full mb-4">
    
                    <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">

                    <button @click="menuOpen = !menuOpen" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-black">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                </div>
                <a href="{{ route('landing-page') }}" @click="menuOpen = false" class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">Home</a>
                <a href="{{ route('about-us') }}" @click="menuOpen = false" class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">About Us</a>
                <!-- <a href="{{ $workshopBookingUrl }}/workshops" class="text-black text-[1.1vw] transition-colors hover:text-[#c7da30]">

                        Workshops
                </a> -->
                <a href="{{ $workshopBookingUrl }}/workshops" @click="menuOpen = false" class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">Workshops</a>
                <a href="{{ route('contact-us') }}" @click="menuOpen = false" class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">Contact Us</a>
                <a href="{{ route('news') }}"  @click="menuOpen = false" class="text-black text-[17px] hover:text-[#c7da30] transition-colors">News</a>

            </div>
        </header>

        <section class="relative flex-grow w-full pt-[50px] sm:pt-[50px] min-[520px]:pt-[50px] pb-6 min-[520px]:pb-8 lg:py-0 lg:h-full flex flex-col justify-start min-[520px]:grid min-[520px]:grid-cols-[minmax(260px,1fr)_minmax(180px,260px)] md:grid-cols-[minmax(360px,1fr)_minmax(240px,320px)] min-[520px]:items-center min-[520px]:gap-x-4 min-[520px]:gap-y-3 lg:block px-6 lg:px-0 overflow-hidden">
            
            <div class="circle-bg-line hidden lg:block absolute top-[-95vh] left-[-46vw] w-[100vw] h-[320vh] pointer-events-none z-50">
                <img src="{{ asset('images/circle6.png') }}" alt="Circle Background" class="w-full h-full object-fill opacity-75 pointer-events-none">
            </div>

           <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo"
                class="hidden lg:block relative mb-2 min-[520px]:mb-1 max-w-[220px]
                min-[520px]:max-w-[160px] md:max-w-[220px]
                lg:max-w-none lg:absolute lg:mb-0 lg:top-[7vh]
                lg:left-[0vw] lg:w-[30vw] z-0">

            <h1 class="relative mt-8 sm:mt-15 min-[520px]:mt-0
                mb-3 min-[520px]:mb-0
                text-[#c7da30] font-bold leading-[0.95]
                text-[30px] sm:text-[38px]
                min-[520px]:text-[26px] md:text-[46px]
                lg:absolute lg:mb-0 lg:top-[42vh]
                lg:left-[2vw] lg:text-[5vw] z-0
                min-[520px]:col-start-1
                min-[520px]:row-start-2
                min-[520px]:self-start">
                Report Abuse<br>Safely and<br>Anonymously
            </h1>

            <img src="{{ asset('images/back-pc.png') }}" alt="Students"
                class="relative mx-auto mb-6 min-[520px]:mb-0 w-full max-w-[240px] sm:max-w-[300px] min-[520px]:max-w-[220px] md:max-w-[320px] lg:max-w-none lg:absolute lg:mx-0 lg:mb-0 lg:top-[4vh] lg:right-[5vw] lg:h-[37vw] lg:w-[38vw] z-0 min-[520px]:col-start-2 min-[520px]:row-start-1 min-[520px]:row-span-2">

            <div class="zoom-stabilize relative min-[520px]:justify-self-center w-full max-w-[300px] min-[520px]:max-w-[420px] md:max-w-[620px] mx-auto flex flex-col gap-3 min-[520px]:flex-row lg:flex-row min-[520px]:gap-2 md:gap-3 lg:gap-[1vw] lg:absolute lg:mx-0 lg:max-w-none lg:w-auto lg:top-[78vh] lg:right-[8vw] z-10 mb-8 min-[520px]:mb-0 lg:mb-0 min-[520px]:col-span-2 min-[520px]:row-start-3">
                <button wire:click="redirectToReportAbuse"
                    class="zoom-stabilize w-full min-[520px]:w-[130px] md:w-[160px] lg:w-[10vw] h-[48px] min-[520px]:h-[28px] md:h-[48px] lg:h-[3.4vw] border-2 lg:border-[0.27vw] border-[#c7da30] rounded-full text-[#38b6ff] font-semibold lg:font-medium text-[15px] min-[520px]:text-[10px] md:text-[15px] lg:text-[0.9vw] bg-white shadow-md hover:scale-105 transition-transform cursor-pointer">
                    Report Now
                </button>

                <button wire:click="redirectToStatusCheck"
                    class="zoom-stabilize w-full min-[520px]:w-[130px] md:w-[160px] lg:w-[10vw] h-[48px] min-[520px]:h-[28px] md:h-[48px] lg:h-[3.4vw] border-2 lg:border-[0.27vw] border-[#c7da30] rounded-full text-[#38b6ff] font-semibold lg:font-medium text-[15px] min-[520px]:text-[10px] md:text-[15px] lg:text-[0.9vw] bg-white shadow-md hover:scale-105 transition-transform cursor-pointer">
                    Check Status
                </button>

                <button wire:click="redirectToAdminLogin"
                    class="zoom-stabilize w-full min-[520px]:w-[130px] md:w-[160px] lg:w-[10vw] h-[48px] min-[520px]:h-[28px] md:h-[48px] lg:h-[3.4vw] border-2 lg:border-[0.27vw] border-[#c7da30] rounded-full text-[#38b6ff] font-semibold lg:font-medium text-[15px] min-[520px]:text-[10px] md:text-[15px] lg:text-[0.9vw] bg-white shadow-md hover:scale-105 transition-transform cursor-pointer">
                    Administrator
                </button>
            </div>
        </section>

        <footer class="custom-desktop-footer relative lg:absolute bottom-0 left-0 w-full bg-[#808080] text-white px-6 py-4 min-[520px]:px-3 min-[520px]:py-2 lg:pl-[2vw] lg:pr-[5vw] lg:py-[1.5vh] flex flex-col min-[520px]:flex-row justify-between items-center gap-4 min-[520px]:gap-2 lg:gap-0 z-30">
           <p class="text-[13px] min-[520px]:text-[14px] lg:text-[16px] text-center min-[520px]:text-left w-full min-[520px]:w-auto">
                &copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.
           </p>

            <div class="flex items-center justify-center flex-wrap gap-4 min-[520px]:gap-2 lg:gap-[1vw]">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}" class="w-9 min-[520px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0 hover:opacity-80 transition" alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn" class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                </a>
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

            /* --- REMOVE SCROLLBARS GLOBALLY FROM LAYOUT AND VIEWPORT --- */
            html, body {
                overflow-x: hidden !important;
                scrollbar-width: none !important; /* Firefox */
                -ms-overflow-style: none !important;  /* IE/Edge */
            }
            html::-webkit-scrollbar, body::-webkit-scrollbar {
                display: none !important; /* Safari/Chrome */
            }

            .class-hide-scrollbar {
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
            }
            .class-hide-scrollbar::-webkit-scrollbar {
                display: none !important;
            }

            @media (min-width: 1024px) {
                 #main-landing-container {
                    min-height: 100vh;
                }

                /* Use normal document flow for the footer to avoid extra bottom gaps/black space */
                .custom-desktop-footer {
                    position: relative !important;
                    top: auto !important;
                    bottom: auto !important;
                    padding-top: 25px;
                    padding-bottom: 25px;
                }

                /* Keep the section tall enough to fill the viewport behind the footer */
                section {
                     min-height: auto;
                     flex: 1 1 auto;
                }
            }


            /* --- EXTERNAL FORCE OVERRIDE FOR THE COOKIE COMPONENT --- */
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
    </div> <div class="force-cookie-bottom">
        @include('components.privacy-notice')
    </div>

</div>
