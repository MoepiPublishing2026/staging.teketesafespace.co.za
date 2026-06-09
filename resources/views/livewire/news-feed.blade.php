<div class="min-h-screen bg-white flex flex-col font-[Montserrat] w-full overflow-x-hidden">
    <script src="//unpkg.com/alpinejs" defer></script>

    <header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 150; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
            </div>
            
            <div style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                <div class="hidden md:flex gap-8">
                    <a href="{{ route('landing-page') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">Home</a>
                    <a href="{{ route('about-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">About Us</a>
                    <a href="{{ route('contact-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">Contact Us</a>
                     <a href="{{ route('news') }}" class="font-bold transition-colors hover:text-[#c7da30]"style="color: black; text-decoration: none;">News</a>
                </div>

                <div class="md:hidden flex items-center relative z-[160]">
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
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Back</a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Home</a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">About Us</a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Contact Us</a>
            </nav>
        </div>
    </div>

    <main class="max-w-[1280px] w-full mx-auto px-14 py-12 flex-grow mt-8">
        
        <div class="flex justify-center items-center gap-1 my-6">
            <div class="w-48 h-auto flex-shrink-0 md:w-[200px] mt-12">
                <img src="{{ asset('images/news-element.jpeg') }}" alt="News Icon" class="w-full h-full object-contain">
            </div>
            <div class="w-48 h-auto flex-shrink-0 md:w-[400px] ml-[-2px]">
                <img src="{{ asset('images/news-illustration.jpeg') }}" alt="News Icon" class="w-full h-full object-contain">
            </div>
        </div>

<div class="text-center mb-8 px-4">
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-[#2f343e] font-[Montserrat] leading-relaxed md:leading-loose">
        <span class="border-b-4 border-[#c7da30] pb-1 md:pb-2">Tekete Safe Space </span><span class="whitespace-nowrap"><span class="border-b-4 border-[#c7da30] pb-1 md:pb-2">New</span>s.</span>
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
            <h2 class="text-[16px] font-bold text-[#2f343e] text-slate-800 mb-6 leading-snug font-[Montserrat] max-w-4xl">
                Tekete Safe Space App Receives Proudly South African Approval, Strengthening Support for School Safety and Wellbeing
            </h2>

            <div class="text-[16px] text-[#2f343e] text-slate-800 leading-relaxed space-y-0.5 mb-10 pr-2">
                <p><span class="text-[16px] text-[#2f343e] text-slate-800">FOR IMMEDIATE RELEASE:</span> 04/02/2026</p>
                <p><span class="text-[16px] text-[#2f343e] text-slate-800">Article by</span></p>
                <p>Tshepiso Smous & Priscilla Masiu</p>
                <p>Public Relations Manager & Business Development Manager</p>
                <p><span class="text-[16px] text-[#2f343e] text-slate-800">Email:</span> pr@moepipublishing.co.za | <span>Email:</span> comm@moepipubling.co.za</p>
                <p>Pretoria, South Africa</p>
            </div>

            <div class="text-[16px] text-[#2f343e] text-slate-800 leading-relaxed space-y-4 mb-10 text-justify max-w-4xl">
                <p>
                    Tekete Safe Space is proud to announce that its digital reporting and learner wellbeing application has been officially approved by Proudly South African, marking a significant milestone in its mission to support safer, more inclusive learning environments across the country.
                </p>
            </div>

            <div class="mb-4">
                <a href="{{ route('news') }}" class="font-[Montserrat] font-bold text-sm text-[#c7da30] hover:text-[#2f343e] transition-colors inline-flex items-center gap-1 underline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-black inline-block">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>

    </main>

    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6" style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank"><img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon" style="width: 30px; height: 30px;"></a>
                <a href="https://www.X.com/moepipublishing" target="_blank"><img src="{{ asset('images/X.png') }}" alt="X Icon" style="width: 30px; height: 30px;"></a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank"><img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon" style="width: 30px; height: 30px;"></a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank"><img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 35.2px; height: 30px;"></a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank"><img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon" style="width: 35.2px; height: 30px;"></a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank"><img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon" style="width: 35.2px; height: 30px;"></a>
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