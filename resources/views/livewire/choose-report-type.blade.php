<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full"> <!-- Header -->
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
                    class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">

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

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div
            class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();"
                    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                
<a href="{{ route('news') }}"
   onclick="toggleMobileMenu()"
   class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors"
   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
    News
</a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Section -->
<div class="flex-grow flex items-center justify-center px-6 py-10 font-[Montserrat]">

    <!-- Rectangle -->
    <div
        class="w-[95%]
           sm:w-[85%]
           md:w-[70%]
           lg:w-[55%]
           xl:w-[45%]
           max-w-[600px]
           min-h-[180px]
           sm:min-h-[200px]
           md:min-h-[258px]
           border-2
           border-[#c7da30]
           rounded-lg
           bg-transparent
           flex
           flex-col
           items-center
           justify-center
           px-6
           sm:px-8
           py-8">

       <!-- Title -->
<h1 class="font-bold
           uppercase
           text-black
           text-center
           text-[20px]
           sm:text-[18px]
           md:text-[22px]
           lg:text-[30px]
           mb-14">
    REPORT ANONYMOUSLY?
</h1>

<!-- Buttons -->
<div class="flex justify-center gap-4 sm:gap-8 md:gap-12 w-full">

    <button
        wire:click="selectReportType(true)"
        class="w-[42%]
               max-w-[180px]
               h-[42px]
               sm:h-[46px]
               md:h-[50px]
               border-2
               border-[#c7da30]
               rounded-full
               bg-transparent
               text-[#38b6ff]
               
               text-[14px]
               sm:text-[15px]
    
               transition">
        Yes
    </button>

    <button
        wire:click="selectReportType(false)"
        class="w-[42%]
               max-w-[180px]
               h-[42px]
               sm:h-[46px]
               md:h-[50px]
               border-2
               border-[#c7da30]
               rounded-full
               bg-transparent
               text-[#38b6ff]
               
               text-[14px]
               sm:text-[15px]

               transition">
        No
    </button>

</div>

    </div>

</div>



    <!-- Footer -->
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
</div>

<script>
    // Mobile menu functionality
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        } else {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    }

    // Add event listener for the mobile menu button
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', toggleMobileMenu);
        }
    });
</script>
