<div class="contact-page-livewire-container overflow-x-hidden w-full">

    <style>
        .store-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #000;
            color: #fff;
            border-radius: 8px;
            padding: 6px 10px;
            width: 100px;
            height: 38px;
            text-decoration: none;
            box-sizing: border-box;
            transition: opacity 0.2s;
            flex-shrink: 0;
        }

        .store-btn:hover { opacity: 0.8; }

        .store-btn .store-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .store-btn .store-icon svg,
        .store-btn .store-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .store-btn .store-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .store-btn .store-text .top-line {
            font-size: 6.5px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            color: #fff;
            letter-spacing: 0.2px;
        }

        .store-btn .store-text .bottom-line {
            font-size: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }

        /* Desktop buttons — bigger */
        .store-btn-lg {
            width: 150px;
            height: 50px;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 10px;
        }

        .store-btn-lg .store-icon {
            width: 22px;
            height: 22px;
        }

        .store-btn-lg .store-text .top-line  { font-size: 8px; }
        .store-btn-lg .store-text .bottom-line { font-size: 14px; }
    </style>

    <!-- Mobile Fixed Navbar -->
    <header class="md:hidden fixed top-0 left-0 w-full bg-white z-50 shadow-sm px-6 h-16 flex items-center font-[Montserrat]">
        <div class="flex justify-between items-center max-w-[1280px] mx-auto w-full">
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[100px] h-auto flex-shrink-0">
            <button id="mobile-menu-button" class="p-2 rounded-md text-black hover:bg-gray-100 transition">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Desktop Navbar -->
    <div class="hidden md:flex md:items-center md:justify-between px-6 lg:px-20 py-4 bg-white font-[Montserrat]">
        <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[150px] h-auto">
        <div class="flex gap-8 text-[17px] font-[Montserrat] text-black ml-auto">
            <a href="{{ url('/') }}" class="hover:text-[#c7da30] transition-colors">Home</a>
            <a href="{{ url('/about-us') }}" class="hover:text-[#c7da30] transition-colors">About Us</a>
            <a href="{{ url('/contact-us') }}" class="font-bold text-black">Contact Us</a>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-0 z-[60] hidden md:hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div id="mobile-menu-slide"
            class="absolute top-0 right-0 h-full w-64 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto">
                <button onclick="toggleMobileMenu()" class="p-2 hover:bg-gray-100 rounded-full transition">
                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-6 space-y-4 pb-8 text-[17px] font-[Montserrat]">
                <a href="{{ url('/') }}" class="block py-3 text-black border-b border-gray-100">Home</a>
                <a href="{{ url('/about-us') }}" class="block py-3 text-black border-b border-gray-100">About Us</a>
                <a href="{{ url('/contact-us') }}" class="block py-3 font-bold text-black border-b border-gray-100">Contact Us</a>
            </nav>
        </div>
    </div>

    <!-- PAGE CONTENT -->
    <section class="pt-24 md:pt-12 pb-10 px-4 sm:px-10 lg:px-16 relative">
        <div class="relative max-w-[1280px] mx-auto min-h-[700px]">

            <!-- LEFT CONTENT — relative so sun can be absolute inside -->
            <div class="relative z-20 max-w-[500px]">

                <!-- Sun graphic: top-right of the contact info block, mobile only -->
                <img src="{{ asset('images/futuristic digital frame tech.png') }}"
                    class="lg:hidden absolute top-[450px] right-[-150px] w-[250px] h-auto pointer-events-none z-0 opacity-90">

                <h1 class="font-[Montserrat] font-bold text-[40px] sm:text-[50px] text-[#000000]">CONTACT US</h1>
                <div class="w-[200px] sm:w-[345px] h-[7px] bg-[#c7da30] mt-2 mb-8"></div>
                <br>

                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ asset('images/phone icon.png') }}" class="w-[26px] h-[26px]">
                    <span class="text-[16px] sm:text-xl text-[#000000]">087 265 6716</span>
                </div>

                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ asset('images/email icon.png') }}" class="w-[26px] h-[18px]">
                    <a href="mailto:support@tekete.co.za" class="text-[16px] sm:text-xl text-[#000000] hover:text-[#c7da30]">support@tekete.co.za</a>
                </div>

                <div class="flex items-center gap-4 mb-8">
                    <img src="{{ asset('images/email icon.png') }}" class="w-[26px] h-[18px]">
                    <a href="mailto:sales@teketesafespace.co.za" class="text-[16px] sm:text-xl text-[#000000] hover:text-[#c7da30]">sales@teketesafespace.co.za</a>
                </div>

                <br>
                <br>
                <h2 class="font-[Montserrat] font-medium text-[18px] sm:text-[20px] text-[#000000] mb-4">
                    Download the Tekete SafeSpace App
                </h2>

                <!-- ===== MOBILE BUTTONS ===== -->
                <div class="lg:hidden relative pb-4">
                    <div class="flex flex-row gap-2">

                        <!-- Apple -->
                        <a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank" class="store-btn">
                            <span class="store-icon">
                                <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                                </svg>
                            </span>
                            <span class="store-text">
                                <span class="top-line">Download on the</span>
                                <span class="bottom-line">App Store</span>
                            </span>
                        </a>

                        <!-- Google Play -->
                        <a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank" class="store-btn">
                            <span class="store-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="mg1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#00C3FF"/><stop offset="100%" style="stop-color:#1DE9B6"/></linearGradient>
                                        <linearGradient id="mg2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#FFBC00"/><stop offset="100%" style="stop-color:#FF8F00"/></linearGradient>
                                        <linearGradient id="mg3" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#F44336"/><stop offset="100%" style="stop-color:#E91E63"/></linearGradient>
                                        <linearGradient id="mg4" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#4CAF50"/><stop offset="100%" style="stop-color:#8BC34A"/></linearGradient>
                                    </defs>
                                    <path fill="url(#mg1)" d="M3.18 23.76A1.94 1.94 0 0 1 2 22V2a1.94 1.94 0 0 1 1.18-1.76l11.16 11.76z"/>
                                    <path fill="url(#mg2)" d="M18.82 13.59l-2.6-1.59L14.34 12l2.48 2.61z"/>
                                    <path fill="url(#mg3)" d="M3.18 23.76l11.16-11.76L18.82 13.59 6.44 20.77a2 2 0 0 1-2 .06z"/>
                                    <path fill="url(#mg4)" d="M3.18.24A2 2 0 0 1 5.18.18l12.38 7.18-3.48 3.64z"/>
                                </svg>
                            </span>
                            <span class="store-text">
                                <span class="top-line">GET IT ON</span>
                                <span class="bottom-line">Google Play</span>
                            </span>
                        </a>

                        <!-- Huawei AppGallery -->
                        <a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank" class="store-btn">
                            <span class="store-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="mh1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#FF4D4D"/><stop offset="100%" style="stop-color:#FF0000"/></linearGradient>
                                    </defs>
                                    <path fill="url(#mh1)" d="M12 2C10.5 2 9.5 3.2 9.5 4.5c0 1.4.8 2.5 2.5 3.5 1.7-1 2.5-2.1 2.5-3.5C14.5 3.2 13.5 2 12 2z"/>
                                    <path fill="url(#mh1)" d="M12 22c1.5 0 2.5-1.2 2.5-2.5 0-1.4-.8-2.5-2.5-3.5-1.7 1-2.5 2.1-2.5 3.5C9.5 20.8 10.5 22 12 22z"/>
                                    <path fill="url(#mh1)" d="M2 12c0 1.5 1.2 2.5 2.5 2.5 1.4 0 2.5-.8 3.5-2.5-1-1.7-2.1-2.5-3.5-2.5C3.2 9.5 2 10.5 2 12z"/>
                                    <path fill="url(#mh1)" d="M22 12c0-1.5-1.2-2.5-2.5-2.5-1.4 0-2.5.8-3.5 2.5 1 1.7 2.1 2.5 3.5 2.5C20.8 14.5 22 13.5 22 12z"/>
                                </svg>
                            </span>
                            <span class="store-text">
                                <span class="top-line">EXPLORE IT ON</span>
                                <span class="bottom-line">AppGallery</span>
                            </span>
                        </a>

                    </div>
                </div>

                <!-- Mobile Phone image -->
                <div class="lg:hidden flex mt-2 mb-2">
                    <img src="{{ asset('images/social media phone1.png') }}" 
                    class="relative left-0 top-[-100px] w-[320px] sm:w-[420px] h-auto">
                </div>

                <!-- ===== DESKTOP BUTTONS ===== -->
                <div class="hidden lg:flex flex-row gap-4 items-center pt-2">

                    <!-- Apple -->
                    <a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank" class="store-btn store-btn-lg">
                        <span class="store-icon">
                            <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                        </span>
                        <span class="store-text">
                            <span class="top-line">Download on the</span>
                            <span class="bottom-line">App Store</span>
                        </span>
                    </a>

                    <!-- Google Play -->
                    <a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank" class="store-btn store-btn-lg">
                        <span class="store-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="dg1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#00C3FF"/><stop offset="100%" style="stop-color:#1DE9B6"/></linearGradient>
                                    <linearGradient id="dg2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#FFBC00"/><stop offset="100%" style="stop-color:#FF8F00"/></linearGradient>
                                    <linearGradient id="dg3" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#F44336"/><stop offset="100%" style="stop-color:#E91E63"/></linearGradient>
                                    <linearGradient id="dg4" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#4CAF50"/><stop offset="100%" style="stop-color:#8BC34A"/></linearGradient>
                                </defs>
                                <path fill="url(#dg1)" d="M3.18 23.76A1.94 1.94 0 0 1 2 22V2a1.94 1.94 0 0 1 1.18-1.76l11.16 11.76z"/>
                                <path fill="url(#dg2)" d="M18.82 13.59l-2.6-1.59L14.34 12l2.48 2.61z"/>
                                <path fill="url(#dg3)" d="M3.18 23.76l11.16-11.76L18.82 13.59 6.44 20.77a2 2 0 0 1-2 .06z"/>
                                <path fill="url(#dg4)" d="M3.18.24A2 2 0 0 1 5.18.18l12.38 7.18-3.48 3.64z"/>
                            </svg>
                        </span>
                        <span class="store-text">
                            <span class="top-line">GET IT ON</span>
                            <span class="bottom-line">Google Play</span>
                        </span>
                    </a>

                    <!-- Huawei AppGallery -->
                    <a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank" class="store-btn store-btn-lg">
                        <span class="store-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="dh1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#FF4D4D"/><stop offset="100%" style="stop-color:#FF0000"/></linearGradient>
                                </defs>
                                <path fill="url(#dh1)" d="M12 2C10.5 2 9.5 3.2 9.5 4.5c0 1.4.8 2.5 2.5 3.5 1.7-1 2.5-2.1 2.5-3.5C14.5 3.2 13.5 2 12 2z"/>
                                <path fill="url(#dh1)" d="M12 22c1.5 0 2.5-1.2 2.5-2.5 0-1.4-.8-2.5-2.5-3.5-1.7 1-2.5 2.1-2.5 3.5C9.5 20.8 10.5 22 12 22z"/>
                                <path fill="url(#dh1)" d="M2 12c0 1.5 1.2 2.5 2.5 2.5 1.4 0 2.5-.8 3.5-2.5-1-1.7-2.1-2.5-3.5-2.5C3.2 9.5 2 10.5 2 12z"/>
                                <path fill="url(#dh1)" d="M22 12c0-1.5-1.2-2.5-2.5-2.5-1.4 0-2.5.8-3.5 2.5 1 1.7 2.1 2.5 3.5 2.5C20.8 14.5 22 13.5 22 12z"/>
                            </svg>
                        </span>
                        <span class="store-text">
                            <span class="top-line">EXPLORE IT ON</span>
                            <span class="bottom-line">AppGallery</span>
                        </span>
                    </a>

                </div>

            </div>

            <!-- Desktop Graphics -->
            <div class="hidden lg:block absolute right-[-320px] top-20 z-10 pointer-events-none">
                <img src="{{ asset('images/futuristic digital frame tech.png') }}" class="w-[400px] xl:w-[459px] h-auto">
            </div>
            <div class="hidden lg:block absolute right-[200px] -top-20 z-20 pointer-events-none">
                <img src="{{ asset('images/social media phone1.png') }}" class="w-[400px] xl:w-[540px] h-auto">
            </div>

        </div>
    </section>

    <!-- FOOTER -->
<footer class="w-full bg-[#808080] text-white py-6 mt-12">

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-[14px] sm:text-[16px]"
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
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
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
            const menu = document.getElementById('mobile-menu');
            const slide = document.getElementById('mobile-menu-slide');
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                slide.classList.remove('translate-x-full');
                slide.classList.add('translate-x-0');
                document.body.style.overflow = 'hidden';
            } else {
                slide.classList.remove('translate-x-0');
                slide.classList.add('translate-x-full');
                setTimeout(() => menu.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-button');
            if (btn) btn.addEventListener('click', toggleMobileMenu);
        });
    </script>

</div>