<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full"> <!-- Header -->
    <header
        style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            <!-- Logo -->
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
            </div>
            <!-- Top Right Links -->
            <div class="flex items-center gap-4">
                <!-- Desktop Navigation -->
                <div class="hidden md:flex gap-8"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                    <!-- Back Button -->
                    <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
                        Back
                    </a>
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

                <!-- Mobile Hamburger Menu -->
                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Section -->

    <div class="flex-grow bg-white flex flex-col font-[Montserrat] items-center justify-center px-10 sm:px-6">
        <h1 class="text-[20px] sm:text-[24px] font-bold text-black uppercase tracking-wide mb-10 sm:mb-12">
            Report Anonymously?
        </h1>
        <!-- Main Content -->

        <div
            class="w-full max-w-[698px] border-2 border-[#c7da30] rounded-xl bg-white p-6 sm:p-10 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center text-center">


                <!-- Buttons -->
                <div class="flex flex-row gap-8 sm:gap-12 w-full sm:w-auto justify-center">
                    <!-- Yes Button -->
                    <button wire:click="selectReportType(true)"
                        class="w-[120px] h-[50px] sm:w-[190px] sm:h-[64px] 
               border-4 border-solid border-[#c7da30]
               rounded-[100px] text-[#38b6ff] 
               text-[15px] font-normal transition duration-200 
               hover:opacity-80 shadow-md">
                        Yes
                    </button>

                    <!-- No Button -->
                    <button wire:click="selectReportType(false)"
                        class="w-[120px] h-[50px] sm:w-[190px] sm:h-[64px] 
               border-4 border-solid border-[#c7da30]
               rounded-[100px] text-[#38b6ff] 
               text-[15px] font-normal transition duration-200 
               hover:opacity-80 shadow-md">
                        No
                    </button>
                </div>
            </div>
        </div>

    </div>



    <!-- Footer -->
    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center justify-center flex-wrap gap-4 min-[520px]:gap-2 lg:gap-[1vw]">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}"
                         class="w-9 min-[520px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0 hover:opacity-80 transition"
                         alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X"
                         class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn"
                         class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                         class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                         class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok"
                         class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                </a>
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
