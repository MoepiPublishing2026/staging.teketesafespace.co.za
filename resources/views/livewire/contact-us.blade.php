@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))
<div class="contact-page-livewire-container overflow-x-hidden w-full min-h-screen flex flex-col justify-between">
                <style>
        .zoom-stabilize {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            will-change: transform;
        }
      .store-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: #000;
            color: #fff;
            border-radius: 10px;
            padding: 8px 14px;
            width: 150px;
            height: 50px;
            text-decoration: none;
            box-sizing: border-box;
            transition: opacity 0.2s;
            flex-shrink: 0;
        }

        .store-btn:hover { opacity: 0.8; }

        .store-btn .store-icon {
            width: 22px;
            height: 22px;
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

       .store-btn .store-text .top-line  {
            font-size: 8px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            color: #fff;
            letter-spacing: 0.2px;
        }

        .store-btn .store-text .bottom-line {
            font-size: 14px;
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

    <!-- Header -->
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


                <a href="javascript:void(0);"
                    onclick="window.history.back();"
                    class="text-black transition-colors hover:!text-[#c7da30]">
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

                 
                <a href="{{ route('contact-us') }}"
                    class="text-black font-bold transition-colors hover:!text-[#c7da30]">
                    Contact Us
                </a>

            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
              <button id="mobile-menu-button"
                        
                        class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">

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


<!-- Mobile Menu -->
 <div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
    
  <div id="mobile-menu-slide"
    class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-in-out">    
        <div class="flex items-center justify-start px-4 pt-16 pb-4">
            <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none">
                <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
             <a href="javascript:void(0);"
       onclick="window.history.back(); toggleMobileMenu();"class="block py-3 text-[#38b6ff]"> Back</a>

            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">About Us</a>
            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Workshops</a>
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3 font-bold text-[#38b6ff]">Contact Us</a>

        </nav>
    </div>
</div>
    <!-- PAGE CONTENT -->
<section class="pt-0 sm:pt-36 md:pt-40 pb-0 px-4 sm:px-4 lg:px-16 relative overflow-hidden">
              <div class="relative max-w-[1280px] mx-auto min-h-[500px]">

            <div class="relative z-20 max-w-[500px]">

                <img src="{{ asset('images/futuristic digital frame tech.png') }}"
    class="lg:hidden absolute top-[540px] right-[-150px] max-h-[320px] w-[250px] object-cover object-top pointer-events-none z-0 opacity-90">    
<h1 class="font-[Montserrat] font-bold text-[40px] sm:text-[50px] text-[#000000] text-center lg:text-left underline decoration-[#c7da30] decoration-[7px] underline-offset-4 mb-2 pt-32 lg:pt-0">CONTACT US</h1>       

              <div class="lg:hidden flex flex-col gap-3 mb-0 pt-12 lg:pt-0">
<div class="flex items-center justify-start gap-2 border border-gray-300 bg-white rounded-md px-4 py-1.5 w-full">        <div class="w-[30px] h-[30px] rounded-full bg-[#f0f2f5] flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-[#c7da30]" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
        </div>
       <a href="tel:0872656716"class="text-[16px] text-[#000000] hover:text-[#c7da30]">087 265 6716
      </a>
    </div>

<div class="flex items-center justify-start gap-2 border border-gray-300 bg-white rounded-md px-4 py-1.5 w-full">        <div class="w-[30px] h-[30px] rounded-full bg-[#f0f2f5] flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-[#c7da30]" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-4V6l8 5 8-4v2z"/></svg>
        </div>
        <a href="mailto:support@tekete.co.za" class="text-[16px] text-[#000000] hover:text-[#c7da30] break-all">support@tekete.co.za</a>
    </div>

      
</div>
                <div class="hidden lg:block">
                    <div class="flex items-center gap-10 mb-4">
                        <img src="{{ asset('images/phone icon.png') }}" class="w-[26px] h-[26px]">
                        <a href="tel:0872656716"class="text-xl text-[#000000] hover:text-[#c7da30]">087 265 6716
                     </a>
                    </div>

                    <div class="flex items-center gap-10 mb-4">
                        <img src="{{ asset('images/email icon.png') }}" class="w-[26px] h-[18px]">
                        <a href="mailto:support@tekete.co.za" class="text-xl text-[#000000] hover:text-[#c7da30]">support@tekete.co.za</a>
                    </div>

                    <div class="flex items-center gap-10 mb-8">
                       <img src="{{ asset('images/email icon.png') }}" class="w-[26px] h-[18px] hidden">                    </div>
                </div>

               
<h2 class="font-[Montserrat] text-[18px] sm:text-[24px] text-[#000000] mb-4 text-center lg:text-left pt-10 sm:pt-12">    Download the Tekete Safe Space App
</h2>

                <!-- ===== MOBILE BUTTONS ===== -->
                <div class="lg:hidden relative mt-4 sm:mt-10 pb-2 sm:pb-4">
                <div class="flex flex-col items-center ml-6 sm:ml-20 gap-3">

                   <!-- Apple -->
<a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank" class="store-btn w-[220px] origin-center scale-[1.35] -ml-4 my-4">
    
    <!-- The span is inside the 'a' tag, with ml-2 added here -->
    <span class="store-icon scale-[2] ml-[-4px]">
        <svg  viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
        </svg>
    </span>

    <span class="store-text">
        <span class="top-line !text-[10px]"style="font-weight: 600;">Download on the</span>
<span class="bottom-line !text-[20px]" style="font-weight: 450;">App Store</span>
</a>

                        <!-- Google Play -->
<a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank" class="store-btn origin-right scale-[1.35] translate-x-4 mt-1 my-4">                       
         <span class="store-icon scale-[1.5]">
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
                            <span class= "store-text ">
                                <span class="top-line !text-[10px]"style="font-weight: 600;">GET IT ON</span>
                                <span class="bottom-line !text-[16px]" style="font-weight: 450;">Google Play</span>
                            </span>
                        </a>

<!-- Huawei AppGallery -->
<a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank" rel="noopener" class="-ml-4 -mt-2 inline-block my-4">
    <svg class="w-[210px] h-[80px] hover:opacity-85 transition" viewBox="0 0 450 150" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Badge Background -->
        <rect width="450" height="150" rx="28" fill="black"/>
        
        <!-- Red Icon Box -->
        <rect x="24" y="24" width="102" height="102" rx="20" fill="#C7000B"/>
        
        <!-- Huawei Bag Handle (Flipped Curve) -->
        <path d="M57 48C57 56.2843 63.7157 63 72 63C80.2843 63 87 56.2843 87 48" stroke="white" stroke-width="5" stroke-linecap="round"/>
        
        <!-- HUAWEI Text inside Red Box -->
        <text x="75" y="98" fill="white" font-family="'Montserrat', Arial, sans-serif" font-size="16" font-weight="bold" letter-spacing="2" text-anchor="middle">HUAWEI</text>
        
        <!-- Text: EXPLORE IT ON -->
        <text x="146" y="61" fill="white" font-family="'Montserrat', Arial, sans-serif" font-size="28" font-weight="600" letter-spacing="1">EXPLORE IT ON</text>
        
        <!-- Text: AppGallery -->
        <text x="144" y="112" fill="white" font-family="'Montserrat', Arial, sans-serif" font-size="52" font-weight="450" letter-spacing="-0.5">AppGallery</text>
    </svg>
</a>

                    </div>
                </div>

                <!-- Mobile Phone image -->
                <div class="lg:hidden flex mt-1 mb-1">
<img src="{{ asset('images/social media phone1.png') }}" class="hidden lg:block absolute top-[320px] right-[-80px] w-[260px] sm:w-[320px] h-auto pointer-events-none z-10">                </div>

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
                      <!-- Huawei AppGallery (Desktop) -->
<a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank" rel="noopener" class="inline-block my-4">
    <img src="{{ asset('images/appgallery-huawei.png') }}"
         alt="Explore it on AppGallery"
         class="w-[200px] h-[76px] object-contain hover:opacity-80 transition">
</a>

                </div>

            </div>

            <!-- Desktop Graphics -->
<div class="hidden lg:block absolute right-[-300px] top-20 z-10 pointer-events-none">
    <img src="{{ asset('images/futuristic digital frame tech.png') }}" class="w-[460px]  h-[400px] object-cover object-left [clip-path:inset(0_50%_0_0)]">
</div>
            <div class="hidden lg:block absolute right-[120px] -top-36 z-20 pointer-events-none">
                <img src="{{ asset('images/social media phone1.png') }}" class="w-[400px] xl:w-[540px] h-auto">
            </div>

        </div>
    </section>

    <!-- FOOTER -->
<footer class="relative w-full bg-[#757573] text-white px-4 py-6 flex flex-col items-center gap-4 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:gap-2 lg:px-[2vw] mt-auto z-30 font-[Montserrat]">
            <p class="text-[13px] leading-5 text-center font-normal text-white min-[640px]:text-[14px] lg:text-[16px] min-[640px]:text-left w-full min-[640px]:w-auto">
                &copy; {{ date('Y') }} Tekete safespace from moepi<br class="min-[640px]:hidden">Publishing.all rights reserved.
            </p>
            <div class="flex items-center justify-center flex-wrap gap-4 min-[640px]:gap-2 lg:gap-[1vw]">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}" class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition" alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
            </div>
    </footer>

   <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const slide = document.getElementById('mobile-menu-slide');
        
        if (!menu || !slide) return;

        const isHidden = menu.classList.contains('hidden');
        
        if (isHidden) {
            // Show background overlay and slide panel in sequence
            menu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Small timeout to allow display:block to apply before triggering CSS transition
            setTimeout(() => {
                slide.classList.remove('translate-x-full');
                slide.classList.add('translate-x-0');
            }, 10);
        } else {
            // Slide panel away first, then hide the wrapper
            slide.classList.remove('translate-x-0');
            slide.classList.add('translate-x-full');
            document.body.style.overflow = '';
            
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300); // Matches the 300ms duration-300 transition time
        }
    }

    // Re-initialize or attach listener safely on page load and Livewire navigation
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-button');
        if (btn) {
            // Remove old listeners to prevent stacking duplicates
            btn.removeEventListener('click', toggleMobileMenu);
            btn.addEventListener('click', toggleMobileMenu);
        }
    });
</script>

</div>