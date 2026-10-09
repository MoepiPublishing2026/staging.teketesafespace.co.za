@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div class="contact-page-livewire-container w-full min-h-screen flex flex-col overflow-x-hidden bg-white">

    <style>
        .contact-page-livewire-container {
            font-family: 'Montserrat', sans-serif;
        }

        /* =========================
           HEADER (same as About Us page)
           ========================= */
        .contact-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: #fff;
            z-index: 50;
        }

        .contact-header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0.5rem 1.5rem;
        }

        .contact-logo {
            width: 120px;
            height: auto;
            object-fit: contain;
            flex-shrink: 0;
        }

        @media (min-width: 640px) {
            .contact-logo { width: 140px; }
        }

        @media (min-width: 768px) {
            .contact-logo { width: 170px; }
        }

        @media (min-width: 1024px) {
            .contact-logo { width: 190px; }
            .contact-header-inner { padding: 0.5rem 2rem; }
        }

        @media (min-width: 1280px) {
            .contact-logo { width: 320px;
        position: relative;
        top: 12px; }
        }

        @media (min-width: 1536px) {
            .contact-logo { width: 380px; 
        width: 380px;
        top: 14px;}
        }

        .contact-desktop-nav {
            display: none;
            align-items: center;
            gap: 1.5rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 18px;
        }

        @media (min-width: 1024px) {
            .contact-desktop-nav { gap: 2rem; }
        }

        @media (min-width: 1280px) {
            .contact-desktop-nav {
                display: flex;
                gap: 2.5rem;
                font-size: 20px;
                margin-right: 3rem;
            }
        }

        .contact-desktop-nav a {
            color: #000;
            text-decoration: none;
            transition: color 0.15s;
        }

        .contact-desktop-nav a:hover {
            color: #c7da30 !important;
        }

        .contact-mobile-menu-button-wrap {
         display: block;
}

/* Keep hamburger menu on tablets */
@media (min-width: 1280px) {
    .contact-mobile-menu-button-wrap {
        display: none;
    }
}

        .contact-mobile-menu-button {
            padding: 0.5rem;
            border-radius: 0.375rem;
            color: #c7da30;
            background: transparent;
            border: 0;
        }

        .contact-mobile-menu-button:hover {
            background: #f3f4f6;
        }

        .contact-mobile-menu-button svg {
            width: 24px;
            height: 24px;
        }

        .contact-page-livewire-container {
            padding-top: 4rem;
        }

        @media (min-width: 768px) {
            .contact-page-livewire-container { padding-top: 6rem; }
        }

        @media (min-width: 1024px) {
            .contact-page-livewire-container { padding-top: 7rem; }
        }

        /* =========================
           MAIN CONTENT
           ========================= */
        .contact-main {
            position: relative;
            flex: 1 0 auto;
            min-height: 631px;
            overflow: hidden;
            background: #fff;
        }

        .contact-content {
            position: relative;
            width: 100%;
            max-width: 1340px;
            min-height: 631px;
            margin: 0 auto;
        }

        .contact-left {
            position: absolute;
            left: 80px;
            top: 83px;
            z-index: 10;
        }

        .contact-title {
            margin: 0 0 35px 50px;
            font-family: 'Century Gothic', 'Montserrat', sans-serif;
            font-size: 70px;
            font-weight: 400;
            line-height: 0.98;
            letter-spacing: -2px;
            color: #000;
           transform: translate(50px, 30px);
        }

        .contact-detail {
             display: flex;
             align-items: center;
             margin-bottom: 25px;
            color: #000;
        }

        .contact-detail:first-of-type {
         position: relative;
         top: 30px;
         left: 110px;
            
        }

        .contact-detail img {
            width: 26px;
            height: 26px;
            object-fit: contain;
            margin-right: 31px;
            
            
        }
        /* EXACT TEKETE LOGO GREEN */
.contact-icon {
    display: block;
    width: 26px;
    height: 26px;
    flex: 0 0 26px;
    margin-right: 31px;
    background-color: #C7DA30;

    -webkit-mask-repeat: no-repeat;
    -webkit-mask-position: center;
    -webkit-mask-size: contain;

    mask-repeat: no-repeat;
    mask-position: center;
    mask-size: contain;
}

/* PHONE */
.phone-icon {
    -webkit-mask-image: url("{{ asset('images/phone icon.png') }}");
    mask-image: url("{{ asset('images/phone icon.png') }}");
}

/* EMAIL */
.email-icon {
    width: 26px;
    height: 22px;

    -webkit-mask-image: url("{{ asset('images/email icon.png') }}");
    mask-image: url("{{ asset('images/email icon.png') }}");
}

        .contact-detail.email img {
            height: 22px;
        }

        .contact-detail.email {
           position: relative;
           top: 30px;
           left: 110px;
}

        .contact-detail a {
            color: #000;
            text-decoration: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 25px;
            font-weight: 400;
            line-height: 1;
        }

        .contact-detail a:hover {
            color: #c7da30;
        }

        /* App download box exactly as a single bordered block in the prototype */
        .contact-app-box {
            width: 660px;
            height: 158px;
            border: 4px solid #c7da30;
            box-sizing: border-box;
            margin-top: 120px;
            margin-left: -30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .contact-app-title {
            margin: 18px 0 19px;
            font-family: 'Montserrat', sans-serif;
            font-size: 30px;
            font-weight: 700;
            line-height: 1;
            color: #000;
        }

        .contact-store-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 17px;
        }

        .contact-store-row a {
            display: block;
            text-decoration: none;
            flex: 0 0 auto;
        }

        .contact-store-row img {
            display: block;
            object-fit: contain;
        }

        .prototype-store {
            width: 162px;
            height: 55px;
        }

        .prototype-store-huawei {
            width: 175px;
            height: 58px;
        }

        /* =========================
           RIGHT-SIDE PROTOTYPE ART
           ========================= */
        .contact-social-art {
            position: absolute;
            right: -100px;
            top: 70px;
            width: 750px;
            height: 650px;
            z-index: 5;
        }

        .contact-social-art img {
            position: absolute;
            object-fit: contain;
        }

        .social-phone {
           width: 800px;
           height: auto;
           right: -25px;
           bottom: -20px;
           z-index: 1;
        }

        /*
         * The supplied prototype already contains the social-media arrangement
         * in the image "social media phone1.png". Keep the image intact rather
         * than rebuilding the icons separately, so its proportions match the
         * prototype.
         */

        /* =========================
           MOBILE
           ========================= */
        @media (max-width: 1279px) {

    /* =========================
       MOBILE HEADER
       ========================= */
    .contact-header-inner {
        min-height: 85px;
        padding: 10px 18px;
    }

    .contact-logo {
        width: 150px;
        height: auto;
    }

    .contact-page-livewire-container {
        padding-top: 85px;
    }

    /* =========================
       MOBILE MAIN
       ========================= */
    .contact-main {
        min-height: auto;
        overflow: hidden;
    }

    .contact-content {
        width: 100%;
        min-height: auto;
        padding: 0;
    }

    .contact-left {
        position: relative;
        left: auto;
        top: auto;
        width: 100%;
        padding: 45px 20px 40px;
        box-sizing: border-box;
    }

    /* =========================
       CONTACT TITLE
       ========================= */
    .contact-title {
        margin: 0 0 40px;
        transform: none;
        text-align: center;
        font-size: 48px;
        line-height: 1;
        letter-spacing: -1px;
    }

    /* =========================
       PHONE + EMAIL
       ========================= */
    .contact-detail,
    .contact-detail:first-of-type,
    .contact-detail.email {
        position: relative;
        top: auto;
        left: auto;
        width: 100%;
        margin: 0 0 18px;
        padding: 12px 15px;
        box-sizing: border-box;
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .contact-detail img,
    .contact-detail.email img {
        width: 27px;
        height: 27px;
        flex-shrink: 0;
        margin-right: 14px;
        object-fit: contain;
    }

    .contact-detail a {
        font-size: 17px;
        line-height: 1.2;
        word-break: break-word;
    }

    /* =========================
       APP DOWNLOAD BOX
       ========================= */
    .contact-app-box {
        width: 100%;
        height: auto;
        min-height: 210px;
        margin: 45px auto 0;
        padding: 20px 15px;
        box-sizing: border-box;
    }

    .contact-app-title {
        margin: 0 0 22px;
        font-size: 22px;
        line-height: 1.2;
        text-align: center;
    }

    .contact-store-row {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }

    .prototype-store {
        width: 150px;
        height: 51px;
    }

    .prototype-store-huawei {
        width: 160px;
        height: 53px;
    }

    /* Hide desktop social phone artwork */
    .contact-social-art {
    display: block;
    position: relative;
    right: auto;
    top: auto;
    width: 100%;
    height: 420px;
    margin-top: 10px;
    overflow: visible;
}

.social-phone {
    position: absolute;
    width: 420px;
    height: auto;
    right: 50%;
    bottom: 0;
    transform: translateX(50%);
}

        @media (max-width: 480px) {

    .contact-header-inner {
        min-height: 80px;
        padding: 8px 15px;
    }

    .contact-logo {
        width: 145px;
    }

    .contact-page-livewire-container {
        padding-top: 80px;
    }

    .contact-left {
        padding: 35px 15px 30px;
    }

    .contact-title {
        font-size: 38px;
        margin-bottom: 32px;
    }

    .contact-detail,
    .contact-detail:first-of-type,
    .contact-detail.email {
        padding: 11px 12px;
        margin-bottom: 14px;
    }

    .contact-detail img,
    .contact-detail.email img {
        width: 25px;
        height: 25px;
        margin-right: 12px;
    }

    .contact-detail a {
        font-size: 15px;
    }

    .contact-app-box {
        min-height: 235px;
        margin-top: 40px;
        padding: 18px 10px;
    }

    .contact-app-title {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .contact-store-row {
        flex-direction: column;
        gap: 10px;
    }

    .prototype-store {
        width: 150px;
        height: 51px;
    }

    .prototype-store-huawei {
        width: 160px;
        height: 53px;
    }
    .contact-social-art {
    width: 100%;
    height: 350px;
    margin-top: 0;
}

.social-phone {
    width: 350px;
    right: 50%;
    bottom: 0;
    transform: translateX(50%);
}

    </style>

    <!-- =========================
         HEADER
         ========================= -->
    <header class="contact-header">
        <div class="contact-header-inner">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('landing-page') }}" aria-label="Tekete Safe Space Home">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Tekete Safe Space"
                        class="contact-logo">
                </a>
            </div>

            <!-- Top Right Links -->
            <div class="flex items-center gap-4">

                <!-- Desktop Navigation -->
                <nav class="contact-desktop-nav">
                    <a href="javascript:void(0);"
                       onclick="window.history.back();">Back</a>
                    <a href="{{ route('landing-page') }}">Home</a>
                    <a href="{{ route('about-us') }}">About Us</a>
                    <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops">Workshops</a>
                    <a href="{{ route('contact-us') }}">Contact Us</a>
                </nav>

                <!-- Mobile Hamburger Menu -->
                <div class="contact-mobile-menu-button-wrap">
                    <button
                        id="mobile-menu-button"
                        type="button"
                        class="contact-mobile-menu-button"
                        aria-label="Open menu"
                        onclick="toggleMobileMenu()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- =========================
         MOBILE MENU
         ========================= -->
    <div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

        <div id="mobile-menu-slide"
             class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-in-out">

            <div class="flex items-center justify-start px-4 pt-16 pb-4">
                <button type="button"
                        onclick="toggleMobileMenu()"
                        class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none"
                        aria-label="Close menu">
                    <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
                <a href="javascript:void(0);"
                   onclick="window.history.back(); toggleMobileMenu();"
                   class="block py-3 text-[#38b6ff]">Back</a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                   class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Home</a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()"
                   class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">About Us</a>
                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
                   onclick="toggleMobileMenu()"
                   class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Workshops</a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()"
                   class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Contact Us</a>
            </nav>
        </div>
    </div>

    <!-- =========================
         CONTACT PAGE
         ========================= -->
    <main class="contact-main">
        <div class="contact-content">

            <div class="contact-left">
                <h1 class="contact-title">CONTACT US</h1>

                <div class="contact-detail">
                     <span class="contact-icon phone-icon"></span>
                     <a href="tel:0872656716">087 265 6716</a>
                </div>

               <div class="contact-detail email">
                    <span class="contact-icon email-icon"></span>
                    <a href="mailto:support@tekete.co.za">support@tekete.co.za</a>
               </div>

                <div class="contact-app-box">
                    <div class="contact-app-title">Download the Safe Space App</div>

                    <div class="contact-store-row">
                        <a href="https://apps.apple.com/za/app/safe-space/id6756009264"
                           target="_blank" rel="noopener" aria-label="Download on the App Store"
                           class="prototype-store">
                            <div style="width:100%;height:100%;background:#000;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-family:Arial,sans-serif;">
                                <svg width="26" height="30" viewBox="0 0 24 24" fill="white" aria-hidden="true">
                                    <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                                </svg>
                                <span style="display:flex;flex-direction:column;line-height:1.05;margin-left:6px;text-align:left;">
                                    <span style="font-size:8px;font-weight:400;">Download on the</span>
                                    <span style="font-size:17px;font-weight:600;">App Store</span>
                                </span>
                            </div>
                        </a>

                        <a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace"
                           target="_blank" rel="noopener" aria-label="Get it on Google Play"
                           class="prototype-store">
                            <div style="width:100%;height:100%;background:#000;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-family:Arial,sans-serif;">
                                <svg width="25" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <defs>
                                        <linearGradient id="contact-gp1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#00C3FF"/><stop offset="100%" stop-color="#1DE9B6"/></linearGradient>
                                        <linearGradient id="contact-gp2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FFBC00"/><stop offset="100%" stop-color="#FF8F00"/></linearGradient>
                                        <linearGradient id="contact-gp3" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" stop-color="#F44336"/><stop offset="100%" stop-color="#E91E63"/></linearGradient>
                                        <linearGradient id="contact-gp4" x1="0%" y1="100%" x2="100%" y2="0%"><stop offset="0%" stop-color="#4CAF50"/><stop offset="100%" stop-color="#8BC34A"/></linearGradient>
                                    </defs>
                                    <path fill="url(#contact-gp1)" d="M3.18 23.76A1.94 1.94 0 0 1 2 22V2a1.94 1.94 0 0 1 1.18-1.76l11.16 11.76z"/>
                                    <path fill="url(#contact-gp2)" d="M18.82 13.59l-2.6-1.59L14.34 12l2.48 2.61z"/>
                                    <path fill="url(#contact-gp3)" d="M3.18 23.76l11.16-11.76L18.82 13.59 6.44 20.77a2 2 0 0 1-2 .06z"/>
                                    <path fill="url(#contact-gp4)" d="M3.18.24A2 2 0 0 1 5.18.18l12.38 7.18-3.48 3.64z"/>
                                </svg>
                                <span style="display:flex;flex-direction:column;line-height:1.05;margin-left:5px;text-align:left;">
                                    <span style="font-size:8px;font-weight:400;">GET IT ON</span>
                                    <span style="font-size:15px;font-weight:600;">Google Play</span>
                                </span>
                            </div>
                        </a>

                        <a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB"
                           target="_blank" rel="noopener">
                            <img
                                src="{{ asset('images/appgallery-huawei.png') }}"
                                alt="Explore it on AppGallery"
                                class="prototype-store-huawei">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Prototype right-side graphic -->
            <div class="contact-social-art">
                <img
                    src="{{ asset('images/social media phone1.png') }}"
                    alt=""
                    class="social-phone">
            </div>

        </div>
    </main>

    <x-site-footer />

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const slide = document.getElementById('mobile-menu-slide');

            if (!menu || !slide) return;

            const isHidden = menu.classList.contains('hidden');

            if (isHidden) {
                menu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    slide.classList.remove('translate-x-full');
                    slide.classList.add('translate-x-0');
                }, 10);
            } else {
                slide.classList.remove('translate-x-0');
                slide.classList.add('translate-x-full');
                document.body.style.overflow = '';

                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        }
    </script>

</div>
