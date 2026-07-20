@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div class="min-h-screen bg-white flex flex-col font-[Montserrat] w-full overflow-x-hidden">
    <script src="//unpkg.com/alpinejs" defer></script>

 <header class="fixed top-0 left-0 w-full bg-white z-50 shadow-sm font-[Montserrat]">
        <div class="flex justify-between items-center py-2" style="width: 100%; padding-left: 2vw; padding-right: 2vw;">
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">

            <div class="flex items-center gap-8">
                <nav class="hidden md:flex gap-8 text-[17px] text-black font-[Montserrat]">
                    <a href="{{ route('landing-page') }}" class="hover:text-[#c7da30] transition-colors">Home</a>
                    <a href="{{ route('about-us') }}" class="hover:text-[#c7da30] transition-colors">About Us</a>
                    <a href="{{ $workshopBookingUrl }}/workshops" class="text-black transition-colors hover:text-[#c7da30]">

                            Workshops
                    </a>
                    <a href="{{ route('contact-us') }}" class="hover:text-[#c7da30] transition-colors">Contact Us</a>
                    <a href="{{ route('news') }}" class="font-bold text-black hover:text-[#c7da30] transition-colors">News</a>
                </nav>

                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30] cursor-pointer">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
                <a href="{{ route('landing-page') }}"
                    class="block py-3  text-[#38b6ff]">Home</a>
                <a href="{{ route('about-us') }}"
                    class="block py-3  text-[#38b6ff]">About Us</a>
                     <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
                    class="block py-3  text-[#38b6ff]">Workshops</a>
                
                <a href="{{ route('contact-us') }}"
                    class="block py-3  text-[#38b6ff]">Contact Us</a>
                 <a href="{{ route('news') }}" onclick="toggleMobileMenu()" class="block py-3 font-bold  text-[#38b6ff] border-b border-gray-100">News</a>

            </nav>
        </div>
    </div>

    <main class="max-w-[1280px] w-full mx-auto px-14 py-12 flex-grow mt-8">
    
<style>
    .news-nav-link-text {
    display: inline-block;
    font-family: 'Montserrat', sans-serif;
    font-size: 21px;
    font-weight: 400;
    color: #c7da30;
    letter-spacing: -0.04em;
    
    /* FIX: Force the line height to be tight and pull the border up */
    line-height: 0.7; 
    border-bottom: 2.5px solid #c7da30;
    padding-bottom: 0px;
    margin-bottom: 2px; /* Keeps it aligned nicely with the arrow vertical center */

    transform: scaleX(0.84);
    transform-origin: left center;
    transition: color 0.15s ease, border-color 0.15s ease;
}

a:hover .news-nav-link-text {
    color: #2f343e;
    border-color: #2f343e;
}
</style>
        
        <div class="flex justify-center items-center gap-1 my-6">
            <div class="w-48 h-auto flex-shrink-0 md:w-[300px] mt-12">
                <img src="{{ asset('images/news-element.jpeg') }}" alt="News Icon" class="w-full h-full object-contain">
            </div>
            <div class="w-48 h-auto flex-shrink-0 md:w-[500px] ml-[-2px]">
                <img src="{{ asset('images/news-illustration.jpeg') }}" alt="News Icon" class="w-full h-full object-contain">
            </div>
        </div>

<div class="text-center mb-8 px-4">
    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#2f343e] tracking-wide font-[Montserrat] leading-[1.4] md:leading-tight">
        <span class="inline box-decoration-clone" style="background: linear-gradient(to top, transparent 0px, #c7da30 0px, #c7da30 8px, transparent 8px); padding-bottom: 2px; text-decoration-skip-ink: none; -webkit-text-decoration-skip-ink: none;">
            Tekete Safe S<span class="inline-block" style="clip-path: inset(0 0 10% 0);">p</span>ace New</span><span class="inline">s.</span>
    </h1>
</div>
    <div class="flex justify-center mb-8 py-8">
    <div class="w-[220px] h-[220px] flex items-center justify-center">
        <img src="{{ asset('images/PSA-logo.png') }}" 
             alt="Proudly South African" 
             class="object-contain max-h-full" 
             style="mix-blend-mode: multiply;">
    </div>
</div>

        <div class="w-full text-left py-0 mt-50">
            <h2 class="text-[16px] font-bold text-black mb-6 leading-snug font-[Montserrat] max-w-4xl">
                Tekete Safe Space App Receives Proudly South African Approval, Strengthening Support for School Safety and Wellbeing
            </h2>

            <div class="text-[16px] font-medium text-black leading-relaxed space-y-0.5 mb-10 pr-2">
                <p><span class="text-[16px] text-black">FOR IMMEDIATE RELEASE:</span> 04/02/2026</p>
                <p><span class="text-[16px] text-black">Article by</span></p>
                <p>Tshepiso Smous & Priscilla Masiu</p>
                <p>Public Relations Manager & Business Development Manager</p>
                <p><span class="text-[16px] text-black ">Email:</span> pr@moepipublishing.co.za | <span>Email:</span> comm@moepipubling.co.za</p>
                <p>Pretoria, South Africa</p>
            </div>

            <div class="text-[16px] font-medium text-black leading-relaxed space-y-4 mb-10 text-justify max-w-4xl">
                <p>
                    Tekete Safe Space is proud to announce that its digital reporting and learner wellbeing application has been officially approved by Proudly South African, marking a significant milestone in its mission to support safer, more inclusive learning environments across the country.
                </p>
            </div>


        <div class="mb-1">
    <a href="{{ route('news') }}" class="-ml-2 inline-flex items-center gap-0.5">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-black inline-block" style="width: 30px; height: 30px;">
            <path d="M10 5l-7 7 7 7v-4h11v-6h-11z"/>
        </svg>
        <span class="news-nav-link-text">Back</span>
    </a>
</div>
        </div>

    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="w-full bg-[#808080] text-white py-6 mt-12">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-[14px] sm:text-[16px]"
style="width: 100%; padding-left: 2vw; padding-right: 2vw;">
    <div>
        <p>© {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
    </div>
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
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (!mobileMenu) return;
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; 
            } else {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = 'auto'; 
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleMobileMenu();
                });
            }
        });
    </script>
</div>