@php($workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/'))

<div class="contact-page bg-white text-black">
    <link href="https://fonts.cdnfonts.com/css/century-gothic-paneuropean" rel="stylesheet">
    <style>
        .contact-page { font-family: Montserrat, sans-serif; min-height: 100vh; }
        .century { font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif; }
        .art-wrap { display: none; }
        .phone-page { display: block; }
        .phone-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 16px 16px 32px; }
        .phone-header img { width: 120px; height: auto; }
        .menu-btn { border: 0; background: transparent; color: #c7da30; padding: 8px; }
        .phone-main { width: min(520px, calc(100% - 32px)); margin: 8px auto 24px; }
        .phone-title { margin: 18px 0 22px; text-align: center; font-size: 48px; font-weight: 400; line-height: 1; color: #000; }
        .detail { display: flex; align-items: center; gap: 14px; border: 1px solid #ddd; border-radius: 6px; padding: 12px 14px; margin: 0 0 12px; }
        .detail a { color: #000; text-decoration: none; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 18px; }
        .icon {
            display: block; flex: 0 0 26px; background: #C5D931;
            -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat;
            -webkit-mask-position: center; mask-position: center;
            -webkit-mask-size: contain; mask-size: contain;
        }
        .phone-icon { width: 26px; height: 26px; -webkit-mask-image: url("{{ asset('images/phone icon.png') }}"); mask-image: url("{{ asset('images/phone icon.png') }}"); }
        .email-icon { width: 26px; height: 18px; -webkit-mask-image: url("{{ asset('images/email icon.png') }}"); mask-image: url("{{ asset('images/email icon.png') }}"); }
        .app-box { border: 2px solid #C5D931; text-align: center; padding: 16px 10px 18px; }
        .app-box h2 { margin: 0 0 14px; font-family: Montserrat, sans-serif; font-size: 22px; font-weight: 700; color: #000; }
        .stores a img { display: block; width: 148px; height: 46px; object-fit: contain; }
        .stores { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
        .phone-art-frame {
            width: min(340px, 100%);
            aspect-ratio: 0.924;
            margin: 16px auto 0;
            position: relative;
            overflow: hidden;
        }
        .phone-art {
            position: absolute;
            width: 184.5%;
            height: auto;
            max-width: none;
            left: -33.6%;
            top: -82.5%;
            pointer-events: none;
        }

        @media (min-width: 900px) {
            .phone-page { display: none; }
            .art-wrap {
                display: block;
                width: 100%;
                height: 734px;
                position: relative;
                overflow: hidden;
            }
            .art-board {
                width: 1366px;
                height: 734px;
                position: absolute;
                top: 0;
                left: 0;
                background: #fff;
                transform-origin: top left;
            }
            .logo-link { position: absolute; left: 88px; top: 16px; z-index: 40; display: block; }
            .logo { width: 300px; height: auto; display: block; object-fit: contain; object-position: left center; }
            .nav { position: absolute; left: 0; top: 67px; width: 1366px; height: 24.4px; font-family: Montserrat, sans-serif; font-size: 19.97px; line-height: 24.4px; font-weight: 400; z-index: 30; }
            .nav a { position: absolute; top: 0; color: #000; text-decoration: none; white-space: nowrap; cursor: pointer; }
            .nav a:hover { color: #c7da30; }
            .nav .home { left: 851.4px; }
            .nav .about { left: 936px; }
            .nav .workshops { left: 1049.8px; }
            .nav .contact { left: 1182.6px; }
            .contact-title { position: absolute; left: 217.7px; top: 229.7px; margin: 0; font-weight: 400; font-size: 66.5px; line-height: 1; color: #000; letter-spacing: 0; }
            .art-board .phone-icon { position: absolute; left: 217.7px; top: 329.8px; width: 26.4px; height: 26.4px; }
            .art-board .email-icon { position: absolute; left: 217.7px; top: 382.8px; width: 25.9px; height: 17.9px; }
            .phone-link, .email-link { position: absolute; left: 262.2px; color: #000; text-decoration: none; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 21.3px; line-height: 24.9px; z-index: 30; cursor: pointer; }
            .phone-link { top: 330.6px; }
            .email-link { top: 379.3px; }
            .phone-link:hover, .email-link:hover { color: #C5D931; }
            .download-box { position: absolute; left: 155px; top: 464.6px; width: 528px; height: 125.4px; border: 2px solid #C5D931; box-sizing: border-box; }
            .download-title { position: absolute; left: 155px; top: 476px; width: 528px; margin: 0; text-align: center; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 24px; line-height: 28.6px; color: #000; }
            .badge { position: absolute; display: block; text-decoration: none; z-index: 30; cursor: pointer; }
            .badge-apple { left: 201px; top: 523.7px; width: 129.6px; height: 43.5px; }
            .badge-google { left: 342.9px; top: 521.3px; width: 142.1px; height: 48.4px; }
            .badge-huawei { left: 497.2px; top: 524.5px; width: 139.8px; height: 41.9px; }
            .badge img, .badge > div { width: 100%; height: 100%; object-fit: contain; }
            .art {
                position: absolute;
                left: 698.5px;
                top: -118px;
                width: 672px;
                height: 896px;
                max-width: none;
                object-fit: fill;
                pointer-events: none;
                z-index: 1;
            }
            .board-footer {
                position: absolute; left: 0; top: 662px; width: 1366px; height: 72px; background: #C5D931;
                display: flex; align-items: center; justify-content: space-between; padding: 0 79px 0 93.8px; box-sizing: border-box;
                z-index: 30;
            }
            .board-footer a { cursor: pointer; position: relative; z-index: 1; }
            .board-footer p { margin: 0; color: #fff; font-size: 14.6px; line-height: 22.8px; }
            .board-footer .socials { display: flex; align-items: center; gap: 14px; }
            .board-footer img { display: block; object-fit: contain; }
        }
    </style>

    <div class="phone-page">
        <header class="phone-header">
            <a href="{{ route('landing-page') }}"><img src="{{ asset('images/logo.png') }}" alt="Tekete Safe Space"></a>
            <button type="button" class="menu-btn" aria-label="Open menu" onclick="toggleMobileMenu()">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </header>
        <div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
            <div class="fixed inset-0 bg-black/50" onclick="toggleMobileMenu()"></div>
            <div id="mobile-menu-slide" class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl translate-x-full transition-transform duration-300">
                <div class="px-4 pt-16"><button type="button" onclick="toggleMobileMenu()" class="p-2 text-[#c7da30]" aria-label="Close menu"><svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button></div>
                <nav class="px-6 text-[17px]">
                    <a class="block py-3 text-[#38b6ff]" href="{{ route('landing-page') }}" onclick="toggleMobileMenu()">Home</a>
                    <a class="block py-3 text-[#38b6ff]" href="{{ route('about-us') }}" onclick="toggleMobileMenu()">About Us</a>
                    <a class="block py-3 text-[#38b6ff]" href="{{ $workshopBookingUrl }}/workshops" onclick="toggleMobileMenu()">Workshops</a>
                    <a class="block py-3 text-[#38b6ff]" href="{{ route('contact-us') }}" onclick="toggleMobileMenu()">Contact Us</a>
                </nav>
            </div>
        </div>
        <main class="phone-main">
            <h1 class="phone-title century">CONTACT US</h1>
            <div class="detail"><span class="icon phone-icon"></span><a href="tel:0872656716">087 265 6716</a></div>
            <div class="detail"><span class="icon email-icon"></span><a href="mailto:support@tekete.co.za">support@tekete.co.za</a></div>
            <div class="app-box">
                <h2>Download the Safe Space App</h2>
                <div class="stores">
                    <a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank" rel="noopener" aria-label="Download on the App Store"><img src="{{ asset('images/badges/app-store.png') }}" alt="Download on the App Store"></a>
                    <a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank" rel="noopener" aria-label="Get it on Google Play"><img src="{{ asset('images/badges/google-play.png') }}" alt="Get it on Google Play"></a>
                    <a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank" rel="noopener" aria-label="Explore it on AppGallery"><img src="{{ asset('images/badges/appgallery.png') }}" alt="Explore it on AppGallery"></a>
                </div>
            </div>
            <div class="phone-art-frame">
                <img class="phone-art" src="{{ asset('images/social media phone1.png') }}" alt="">
            </div>
        </main>
        <x-site-footer style="background:#C5D931" />
    </div>

    <div class="art-wrap" id="contact-wrap">
        <a class="logo-link" href="{{ route('landing-page') }}"><img class="logo" src="{{ asset('images/logo.png') }}" alt="Tekete Safe Space"></a>
        <div class="art-board" id="contact-board">
            <nav class="nav" aria-label="Primary">
                <a class="home" href="{{ route('landing-page') }}">Home</a>
                <a class="about" href="{{ route('about-us') }}">About Us</a>
                <a class="workshops" href="{{ $workshopBookingUrl }}/workshops">Workshops</a>
                <a class="contact" href="{{ route('contact-us') }}">Contact Us</a>
            </nav>
            <h1 class="contact-title century">CONTACT US</h1>
            <span class="icon phone-icon"></span>
            <a class="phone-link" href="tel:0872656716">087 265 6716</a>
            <span class="icon email-icon"></span>
            <a class="email-link" href="mailto:support@tekete.co.za">support@tekete.co.za</a>
            <div class="download-box"></div>
            <p class="download-title">Download the Safe Space App</p>
            <a class="badge badge-apple" href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank" rel="noopener" aria-label="Download on the App Store"><img src="{{ asset('images/badges/app-store.png') }}" alt=""></a>
            <a class="badge badge-google" href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank" rel="noopener" aria-label="Get it on Google Play"><img src="{{ asset('images/badges/google-play.png') }}" alt=""></a>
            <a class="badge badge-huawei" href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank" rel="noopener" aria-label="Explore it on AppGallery"><img src="{{ asset('images/badges/appgallery.png') }}" alt=""></a>
            <img class="art" src="{{ asset('images/social media phone1.png') }}" alt="">
            <footer class="board-footer">
                <p>&copy; {{ date('Y') }} Tekete SafeSpace From Moepi Publishing. All rights reserved.</p>
                <div class="socials">
                    <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener" aria-label="YouTube"><img src="{{ asset('images/youtube.png') }}" alt="" style="width:36.6px;height:24.6px;"></a>
                    <a href="https://www.X.com/moepipublishing" target="_blank" rel="noopener" aria-label="X"><img src="{{ asset('images/X.png') }}" alt="" style="width:25.3px;height:25.8px;"></a>
                    <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" rel="noopener" aria-label="LinkedIn"><img src="{{ asset('images/linkedin.png') }}" alt="" style="width:30.3px;height:25.8px;"></a>
                    <a href="https://www.facebook.com/MoepiPublishing" target="_blank" rel="noopener" aria-label="Facebook"><img src="{{ asset('images/facebook.png') }}" alt="" style="width:25.9px;height:25.8px;"></a>
                    <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank" rel="noopener" aria-label="Instagram"><img src="{{ asset('images/instagram.png') }}" alt="" style="width:25.8px;height:25.8px;"></a>
                    <a href="https://www.tiktok.com/@moepipublishing" target="_blank" rel="noopener" aria-label="TikTok"><img src="{{ asset('images/ticktock.png') }}" alt="" style="width:27.6px;height:27.6px;"></a>
                </div>
            </footer>
        </div>
    </div>
    <script>
        function fitContact() {
            var wrap = document.getElementById('contact-wrap');
            var board = document.getElementById('contact-board');
            if (!wrap || !board || getComputedStyle(wrap).display === 'none') return;
            var scale = wrap.clientWidth / 1366;
            board.style.transform = 'scale(' + scale + ')';
            wrap.style.height = (734 * scale) + 'px';
        }
        fitContact();
        window.addEventListener('resize', fitContact);
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-menu');
            var slide = document.getElementById('mobile-menu-slide');
            if (!menu || !slide) return;
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                setTimeout(function () { slide.classList.remove('translate-x-full'); }, 10);
            } else {
                slide.classList.add('translate-x-full');
                document.body.style.overflow = '';
                setTimeout(function () { menu.classList.add('hidden'); }, 300);
            }
        }
    </script>
</div>
