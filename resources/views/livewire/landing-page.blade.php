<div x-data="{ menuOpen: false }"
    class="relative w-screen min-h-screen lg:h-screen bg-white font-[Montserrat] flex flex-col justify-between overflow-x-hidden">

    <header
        class="fixed top-0 left-0 right-0 z-40 w-full flex justify-between items-center px-6 pt-6 lg:px-16 lg:pt-8">

        <div class="absolute inset-0 bg-white/40 backdrop-blur-sm"></div>

        <div class="relative z-10 flex justify-between items-center w-full">

            <nav class="hidden lg:flex gap-8 ml-auto">
                <a href="{{ route('landing-page') }}"
                    class="text-black text-[17px] transition-colors hover:text-[#c7da30]">
                    Home
                </a>

                <a href="{{ route('about-us') }}"
                    class="text-black text-[17px] transition-colors hover:text-[#c7da30]">
                    About Us
                </a>

                <a href="{{ route('contact-us') }}"
                    class="text-black text-[17px] transition-colors hover:text-[#c7da30]">
                    Contact Us
                </a>
            </nav>

            <div class="lg:hidden ml-auto">
                <button @click="menuOpen = !menuOpen" class="focus:outline-none relative z-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-8 h-8 text-black">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 5.75h16.5m-16.5 6.5h16.5m-16.5 6.5h16.5" />
                    </svg>
                </button>
            </div>

        </div>

        <div x-show="menuOpen"
            x-transition
            @click.away="menuOpen = false"
            class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg flex flex-col items-start p-6 z-50 lg:hidden">

            <button @click="menuOpen = false" class="self-end mb-4 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-7 h-7 text-black">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <a href="{{ route('landing-page') }}"
                @click="menuOpen = false"
                class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">
                Home
            </a>

            <a href="{{ route('about-us') }}"
                @click="menuOpen = false"
                class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">
                About Us
            </a>

            <a href="{{ route('contact-us') }}"
                @click="menuOpen = false"
                class="text-black text-[17px] hover:text-[#c7da30] transition-colors">
                Contact Us
            </a>

        </div>
    </header>

    <section class="relative flex-grow w-full pt-[14vh] pb-[12vh] lg:py-0 lg:h-full flex flex-col lg:block px-6 lg:px-0 overflow-hidden">

<div class="circle-bg-line absolute top-[-95vh] left-[-46vw] w-[100vw] h-[320vh] pointer-events-none z-50">
                <img src="{{ asset('images/circle6.png') }}"
                alt="Circle Background"
                class="w-full h-full object-fill opacity-75 pointer-events-none">
        </div>

        <img src="{{ asset('images/logo.png') }}"
            alt="Safe Space Logo"
            class="relative mb-6 max-w-[220px] lg:max-w-none lg:absolute lg:mb-0 lg:top-[7vh] lg:left-[6vw] w-[70vw] lg:w-[28vw] z-0">

        <h1 class="relative mb-8 text-[#c7da30] font-bold leading-[0.95] text-[32px] sm:text-[40px] lg:absolute lg:mb-0 lg:top-[40vh] lg:left-[6vw] lg:text-[5vw] z-0">
            Report Abuse<br>
            Safely and<br>
            Anonymously
        </h1>

        <img src="{{ asset('images/back-pc.png') }}"
            alt="Students"
            class="relative mx-auto mb-8 w-full max-w-[340px] sm:max-w-[400px] lg:max-w-none lg:absolute lg:mx-0 lg:mb-0 lg:top-[6vh] lg:right-[6vw] lg:w-[38vw] z-0">

        <div class="relative w-full max-w-[340px] sm:max-w-[500px] mx-auto flex flex-col sm:flex-row lg:flex-row gap-3 sm:gap-4 lg:gap-[1vw] lg:absolute lg:mx-0 lg:max-w-none lg:w-auto lg:top-[84vh] lg:right-[7vw] z-10">

            <button wire:click="redirectToReportAbuse"
                class="w-full sm:w-auto lg:w-[10vw] h-[54px] lg:h-[3.4vw] lg:min-w-[170px] lg:min-h-[58px] border-[4px] border-[#c7da30] rounded-full text-[#38b6ff] font-semibold lg:font-medium text-[15px] lg:text-[0.9vw] bg-white shadow-md hover:scale-105 transition-all cursor-pointer">
                Report Now
            </button>

            <button wire:click="redirectToStatusCheck"
                class="w-full sm:w-auto lg:w-[10vw] h-[54px] lg:h-[3.4vw] lg:min-w-[170px] lg:min-h-[58px] border-[4px] border-[#c7da30] rounded-full text-[#38b6ff] font-semibold lg:font-medium text-[15px] lg:text-[0.9vw] bg-white shadow-md hover:scale-105 transition-all cursor-pointer">
                Check Status
            </button>

            <button wire:click="redirectToAdminLogin"
                class="w-full sm:w-auto lg:w-[10vw] h-[54px] lg:h-[3.4vw] lg:min-w-[170px] lg:min-h-[58px] border-[4px] border-[#c7da30] rounded-full text-[#38b6ff] font-semibold lg:font-medium text-[15px] lg:text-[0.9vw] bg-white shadow-md hover:scale-105 transition-all cursor-pointer">
                Administrator
            </button>
        </div>

    </section>

    <footer class="absolute bottom-0 left-0 w-full bg-[#808080] text-white px-6 py-4 lg:px-[5vw] lg:py-[1.5vh] flex flex-col md:flex-row lg:flex-row justify-between items-center gap-4 lg:gap-0 z-30">

        <p class="text-[13px] lg:text-[0.9vw] text-center lg:text-left">
            &copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.
        </p>

        <div class="flex items-center justify-center flex-wrap gap-4 lg:gap-[1vw]">
            <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                <img src="{{ asset('images/youtube.png') }}" alt="YouTube" class="w-5 h-5 lg:w-[1.7vw] lg:h-auto min-w-[20px]">
            </a>
            <a href="https://www.X.com/moepipublishing" target="_blank">
                <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 lg:w-[1.7vw] lg:h-auto min-w-[20px]">
            </a>
            <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn" class="w-5 h-5 lg:w-[1.7vw] lg:h-auto min-w-[20px]">
            </a>
            <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 lg:w-[1.9vw] lg:h-auto min-w-[22px]">
            </a>
            <a href="https://www.instagram.com/moepipublishing" target="_blank">
                <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 lg:w-[1.9vw] lg:h-auto min-w-[22px]">
            </a>
            <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-5 h-5 lg:w-[1.9vw] lg:h-auto min-w-[22px]">
            </a>
        </div>
    </footer>

    @include('components.privacy-notice')
    <style>
    @media (max-width: 640px) {
        .circle-bg-line {
            display: none !important;
        }
    }
</style>

</div>