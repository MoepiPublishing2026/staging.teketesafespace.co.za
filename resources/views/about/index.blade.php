<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tekete SafeSpace</title>
    <x-favicon />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/century-gothic-paneuropean" rel="stylesheet">
    <style>
        html, body { margin: 0; background: #fff; }
        body { overflow-x: hidden; color: #000; font-family: Montserrat, sans-serif; }
        .century { font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif; }

        .art-wrap { display: none; }
        .phone-page { display: block; }

        .phone-header { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; }
        .phone-header img { width: 140px; height: auto; }
        .menu-btn { border: 0; background: transparent; color: #c7da30; padding: 8px; }
        .phone-hero { text-align: center; padding: 8px 20px 0; }
        .phone-hero img { width: 210px; height: auto; }
        .phone-hero h1 {
            display: inline-block;
            margin: 8px 0 0;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-bottom: 3px solid #C5D931;
            padding-bottom: 8px;
        }
        .phone-copy { width: min(340px, calc(100% - 40px)); margin: 24px auto; font-size: 16px; line-height: 1.5; }
        .phone-copy p { margin: 0 0 16px; }
        .phone-report { padding: 10px 20px 30px; text-align: center; }
        .phone-report h2, .phone-serve h2, .phone-values h2 {
            color: #C5D931; font-weight: 400; font-size: 26px; line-height: 1.3; margin: 0 0 20px;
        }
        .phone-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px 12px; }
        .phone-grid img { height: 88px; width: auto; margin: 0 auto 6px; object-fit: contain; }
        .phone-grid p { margin: 0; font-family: Poppins, sans-serif; font-size: 15px; line-height: 1.3; }
        .phone-serve, .phone-values { width: min(520px, calc(100% - 40px)); margin: 10px auto 36px; }
        .phone-serve ul { margin: 0; padding-left: 1.3rem; font-size: 18px; line-height: 1.7; }
        .phone-serve li { margin: 0 0 6px; }
        .phone-serve h2 { font-size: 36px; }
        .phone-serve img { width: min(320px, 100%); border-radius: 16px; margin-top: 16px; }
        .phone-banner { position: relative; height: 90px; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 20px; }
        .phone-banner img { position: absolute; width: 340px; max-width: none; }
        .phone-banner h2 { position: relative; color: #fff; text-align: center; margin: 0; font-size: 26px; text-transform: uppercase; }
        .phone-value { display: flex; gap: 10px; margin: 0 0 22px; }
        .phone-mark { position: relative; width: 72px; height: 54px; flex: 0 0 72px; display: flex; align-items: center; justify-content: center; }
        .phone-mark img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; }
        .phone-mark span { position: relative; color: #1E94FD; font-weight: 700; font-size: 22px; }
        .phone-value h3 { margin: 0 0 4px; color: #1E94FD; font-size: 16px; font-weight: 700; text-transform: uppercase; }
        .phone-value p { margin: 0; font-size: 15px; line-height: 1.45; }

        @media (min-width: 900px) {
            .phone-page { display: none; }
            .art-wrap {
                display: block;
                width: 100%;
                height: 3405px;
                position: relative;
                overflow: hidden;
            }
            .art-board {
                width: 1366px;
                height: 3405px;
                position: absolute;
                top: 0;
                left: 0;
                background: #fff;
                transform-origin: top left;
            }
            .art-board a { color: inherit; text-decoration: none; }
            .logo { position: absolute; left: 82.1px; top: 35.5px; width: 249.9px; height: 113px; object-fit: contain; object-position: left center; }
            .nav { position: absolute; left: 0; top: 69px; width: 1366px; height: 23px; font-size: 15px; line-height: 23px; font-weight: 400; }
            .nav a { position: absolute; top: 0; color: #000; white-space: nowrap; }
            .nav a:hover { color: #c7da30; }
            .nav .home { left: 865.1px; }
            .nav .about { left: 947.6px; }
            .nav .workshops { left: 1055.9px; }
            .nav .contact { left: 1184.6px; }
            .glass { position: absolute; left: 289.5px; top: 190.1px; width: 272.2px; height: 343.4px; object-fit: contain; }
            .word, .brand { position: absolute; left: 619.7px; margin: 0; color: #C5D931; white-space: nowrap; }
            .word { top: 278.4px; font-weight: 300; font-size: 153.1px; line-height: 1; }
            .brand { top: 421.9px; font-weight: 400; font-size: 55.7px; line-height: 1; }
            .intro { position: absolute; left: 171px; top: 603.1px; width: 1100px; margin: 0; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 21.33px; line-height: 29px; }
            .intro p { margin: 0; }
            .intro p + p { margin-top: 29px; }
            .report-h {
                position: absolute; left: 0; top: 876.1px; width: 1366px; margin: 0;
                text-align: center; font-weight: 400; font-size: 48px; line-height: 67px; color: #C5D931;
            }
            .issue { position: absolute; object-fit: contain; }
            .label {
                position: absolute; margin: 0; text-align: center;
                font-family: Poppins, sans-serif; font-weight: 400; font-size: 16px; line-height: 1.55; color: #000;
            }
            .serve-h { position: absolute; left: 160.4px; top: 1637px; margin: 0; font-weight: 400; font-size: 48px; line-height: 1; color: #C5D931; }
            .serve-list { position: absolute; left: 163.1px; top: 1714.8px; width: 670px; margin: 0; padding-left: 36px; box-sizing: border-box; font-family: Montserrat, sans-serif; font-size: 21.33px; line-height: 45px; font-weight: 400; list-style: disc; }
            .serve-list li { margin: 0; padding: 0; }
            .serve-list strong { font-weight: 700; }
            .serve-photo { position: absolute; left: 856.6px; top: 1627.1px; width: 386.2px; height: 451.6px; object-fit: cover; border-radius: 16px; }
            .chalk { position: absolute; left: 426.1px; top: 2172.7px; width: 492.7px; height: 150.3px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
            .chalk img { position: absolute; width: 520px; height: 520px; left: 50%; top: 50%; transform: translate(-50%, -50%); }
            .chalk h2 { position: relative; z-index: 1; margin: 0; text-align: center; color: #fff; font-weight: 400; font-size: 36px; line-height: 1.15; text-transform: uppercase; }
            .cv-title { position: absolute; left: 331.5px; width: 900px; margin: 0; font-weight: 700; font-size: 28px; line-height: 1; color: #1E94FD; text-transform: uppercase; }
            .cv-body { position: absolute; left: 331.4px; width: 920px; margin: 0; font-family: Montserrat, sans-serif; font-weight: 400; font-size: 21.33px; line-height: 29px; }
            .cv-mark { position: absolute; width: 149.4px; height: 105.4px; }
            .cv-mark img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: contain; }
            .cv-num { position: absolute; margin: 0; font-family: Montserrat, sans-serif; font-weight: 700; font-size: 48px; line-height: 1; color: #1E94FD; }
            .board-footer {
                position: absolute; left: 0; top: 3333px; width: 1366px; height: 72px; background: #C5D931;
                display: flex; align-items: center; justify-content: space-between; padding: 0 79px 0 93.8px; box-sizing: border-box;
            }
            .board-footer p { margin: 0; font-size: 14.6px; line-height: 22.8px; color: #fff; font-weight: 400; }
            .board-footer .socials { display: flex; align-items: center; gap: 14px; }
            .board-footer img { display: block; object-fit: contain; }
        }
    </style>
</head>

<body>
@php
    $workshopUrl = rtrim(config('tekete.workshop_booking_url'), '/') . '/workshops';
    $issues = [
        ['img' => '6.svg', 'title' => "Teenage\npregnancy", 'alt' => 'Teenage pregnancy'],
        ['img' => '9.svg', 'title' => 'Bullying', 'alt' => 'Bullying'],
        ['img' => '10.svg', 'title' => "Substance\nAddiction", 'alt' => 'Substance Addiction'],
        ['img' => '11.svg', 'title' => "Suspected Sexual\nHarassment", 'alt' => 'Suspected Sexual Harassment'],
        ['img' => '12.svg', 'title' => 'Weapons', 'alt' => 'Weapons'],
        ['img' => '13.svg', 'title' => 'Many More', 'alt' => 'Many More'],
    ];
    $coreValues = [
        ['num' => '01', 'title' => 'Safety First', 'body' => 'We believe every learner has the right to feel and be safe at school, at home, and in their community. Our system is designed to protect and empower young people by creating a secure environment where they can speak up without fear.'],
        ['num' => '02', 'title' => 'Confidentiality & Trust', 'body' => 'Learners must feel confident that what they share is protected. Our platform ensures anonymity, privacy, and strict data protection. We are committed to earning and maintaining the trust of every learner who reaches out for help.'],
        ['num' => '03', 'title' => 'Empowerment Through Voice', 'body' => 'Silence often comes from fear. We exist to give learners their voice back - to allow them to speak their truth, raise concerns, and ask for help without shame or judgment. Every voice matters.'],
        ['num' => '04', 'title' => 'Equity & Inclusion', 'body' => 'Every learner, regardless of gender, background, or circumstance, deserves equal access to support and protection. We pay special attention to the unique vulnerabilities of girls, LGBTQ+ youth, and others who are often left behind.'],
        ['num' => '05', 'title' => 'Technology with Integrity', 'body' => 'Our platform is digital, encrypted, and POPIA-compliant - but more importantly, it is designed with human dignity at the center. Technology should never replace care, but it can strengthen and extend it.'],
    ];
@endphp

<div class="phone-page">
    <header class="phone-header">
        <a href="{{ route('landing-page') }}"><img src="{{ asset('images/logo.png') }}" alt="Tekete Safe Space"></a>
        <button id="mobile-menu-button" type="button" class="menu-btn" aria-label="Open menu">
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
                <a class="block py-3 text-[#38b6ff]" href="{{ $workshopUrl }}" onclick="toggleMobileMenu()">Workshops</a>
                <a class="block py-3 text-[#38b6ff]" href="{{ route('contact-us') }}" onclick="toggleMobileMenu()">Contact Us</a>
            </nav>
        </div>
    </div>
    <section class="phone-hero">
        <img src="{{ asset('images/magnifying glass.png') }}" alt="">
        <h1>About<br>Tekete SafeSpace</h1>
    </section>
    <div class="phone-copy">
        <p>A confidential platform designed to protect and empower learners and employees to speak out, with the option to report anonymously. The app is zero-rated, ensuring users can access and submit reports without incurring data costs. Your voice matters. Your identity is protected.</p>
        <p>Whether you choose to report with your name or anonymously, Tekete SafeSpace by Moepi Publishing ensures every report is handled with confidentiality, urgency, and at no data cost to the user.</p>
    </div>
    <section class="phone-report">
        <h2 class="century">You can report any of the following through Tekete SafeSpace</h2>
        <div class="phone-grid">
            @foreach ($issues as $issue)
                <div>
                    <img src="{{ asset('images/' . $issue['img']) }}" alt="{{ $issue['alt'] }}">
                    <p class="whitespace-pre-line">{{ $issue['title'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
    <section class="phone-serve">
        <h2 class="century">Who we serve:</h2>
        <ul>
            <li><strong>Learners</strong> - A safe way to speak out without fear.</li>
            <li><strong>Parents</strong> - Peace of mind knowing concerns can be raised.</li>
            <li><strong>Teachers &amp; Staff</strong> - A trusted channel for reporting misconduct.</li>
            <li><strong>Schools</strong> - A structured system to build safer, more accountable learning environments.</li>
            <li><strong>Organisations</strong> - A safer working environment for both employer and employee.</li>
        </ul>
        <img src="{{ asset('images/Students holding phone.png') }}" alt="Students holding a phone">
    </section>
    <section class="phone-values">
        <div class="phone-banner"><img src="{{ asset('images/7.svg') }}" alt=""><h2 class="century">Our Core<br>Values</h2></div>
        @foreach ($coreValues as $value)
            <div class="phone-value">
                <div class="phone-mark"><img src="{{ asset('images/8.svg') }}" alt=""><span>{{ $value['num'] }}</span></div>
                <div><h3 class="century">{{ $value['title'] }}</h3><p>{{ $value['body'] }}</p></div>
            </div>
        @endforeach
    </section>
    <x-site-footer style="background:#C5D931" />
</div>

<div class="art-wrap" id="about-wrap">
    <div class="art-board" id="about-board">
        <a href="{{ route('landing-page') }}"><img class="logo" src="{{ asset('images/logo.png') }}" alt="Tekete Safe Space"></a>
        <nav class="nav" aria-label="Primary">
            <a class="home" href="{{ route('landing-page') }}">Home</a>
            <a class="about" href="{{ route('about-us') }}">About Us</a>
            <a class="workshops" href="{{ $workshopUrl }}">Workshops</a>
            <a class="contact" href="{{ route('contact-us') }}">Contact Us</a>
        </nav>
        <img class="glass" src="{{ asset('images/magnifying glass.png') }}" alt="">
        <p class="word century">ABOUT</p>
        <p class="brand century">TEKETE SAFESPACE</p>
        <div class="intro">
            <p>A confidential platform designed to protect and empower learners and employees to speak out,<br>with the option to report anonymously. The app is zero-rated, ensuring users can access and<br>submit reports without incurring data costs. Your voice matters. Your identity is protected.</p>
            <p>Whether you choose to report with your name or anonymously, Tekete SafeSpace by Moepi<br>Publishing ensures every report is handled with confidentiality, urgency, and at no data cost to<br>the user.</p>
        </div>
        <h1 class="report-h century">You can report any of the following<br>through Tekete SafeSpace</h1>
        <img class="issue" src="{{ asset('images/6.svg') }}" alt="Teenage pregnancy" style="left:333px;top:1055px;width:173px;height:173px;">
        <img class="issue" src="{{ asset('images/9.svg') }}" alt="Bullying" style="left:639.1px;top:1080.2px;width:125.1px;height:122.6px;">
        <img class="issue" src="{{ asset('images/10.svg') }}" alt="Substance Addiction" style="left:896px;top:1072.2px;width:138.5px;height:138.5px;">
        <img class="issue" src="{{ asset('images/11.svg') }}" alt="Suspected Sexual Harassment" style="left:360.2px;top:1342.3px;width:118.3px;height:123.2px;">
        <img class="issue" src="{{ asset('images/12.svg') }}" alt="Weapons" style="left:635.7px;top:1343.3px;width:131.9px;height:121.3px;">
        <img class="issue" src="{{ asset('images/13.svg') }}" alt="Many More" style="left:912.4px;top:1351.1px;width:105.8px;height:105.8px;">
        <p class="label" style="left:337.4px;top:1239.9px;width:164px;">Teenage<br>pregnancy</p>
        <p class="label" style="left:619.6px;top:1239.9px;width:164px;">Bullying</p>
        <p class="label" style="left:883.3px;top:1239.9px;width:164px;">Substance<br>Addiction</p>
        <p class="label" style="left:318.7px;top:1493.7px;width:201.2px;">Suspected Sexual<br>Harassment</p>
        <p class="label" style="left:619.6px;top:1493.7px;width:164px;">Weapons</p>
        <p class="label" style="left:883.3px;top:1493.7px;width:164px;">Many More</p>
        <h2 class="serve-h century">Who we serve:</h2>
        <ul class="serve-list">
            <li><strong>Learners</strong> - A safe way to speak out without fear.</li>
            <li><strong>Parents</strong> - Peace of mind knowing concerns can be raised.</li>
            <li><strong>Teachers &amp; Staff</strong> - A trusted channel for reporting<br>misconduct.</li>
            <li><strong>Schools</strong> - A structured system to build safer, more<br>accountable learning environments.</li>
            <li><strong>Organisations</strong> - A safer working environment for both<br>employer and employee.</li>
        </ul>
        <img class="serve-photo" src="{{ asset('images/Students holding phone.png') }}" alt="Students holding a phone">
        <div class="chalk"><img src="{{ asset('images/7.svg') }}" alt=""><h2 class="century">Our Core<br>Values</h2></div>
        <h3 class="cv-title century" style="top:2385.1px;">Safety First</h3>
        <div class="cv-mark" style="left:160.5px;top:2415.9px;"><img src="{{ asset('images/8.svg') }}" alt=""></div>
        <span class="cv-num" style="left:208.8px;top:2452.1px;">01</span>
        <p class="cv-body" style="top:2425.2px;">We believe every learner has the right to feel and be safe at school, at home,<br>and in their community. Our system is designed to protect and empower young<br>people by creating a secure environment where they can speak up without fear.</p>
        <h3 class="cv-title century" style="top:2560.9px;">Confidentiality &amp; Trust</h3>
        <div class="cv-mark" style="left:160.5px;top:2591.9px;"><img src="{{ asset('images/8.svg') }}" alt=""></div>
        <span class="cv-num" style="left:204.1px;top:2628.1px;">02</span>
        <p class="cv-body" style="top:2601.1px;">Learners must feel confident that what they share is protected. Our platform<br>ensures anonymity, privacy, and strict data protection. We are committed to<br>earning and maintaining the trust of every learner who reaches out for help.</p>
        <h3 class="cv-title century" style="top:2735.1px;">Empowerment Through Voice</h3>
        <div class="cv-mark" style="left:160.5px;top:2766px;"><img src="{{ asset('images/8.svg') }}" alt=""></div>
        <span class="cv-num" style="left:204.1px;top:2802.1px;">03</span>
        <p class="cv-body" style="top:2775.2px;">Silence often comes from fear. We exist to give learners their voice back - to<br>allow them to speak their truth, raise concerns, and ask for help without shame<br>or judgment. Every voice matters.</p>
        <h3 class="cv-title century" style="top:2910.9px;">Equity &amp; Inclusion</h3>
        <div class="cv-mark" style="left:160.5px;top:2941.9px;"><img src="{{ asset('images/8.svg') }}" alt=""></div>
        <span class="cv-num" style="left:201.6px;top:2978.1px;">04</span>
        <p class="cv-body" style="top:2951.1px;">Every learner, regardless of gender, background, or circumstance, deserves<br>equal access to support and protection. We pay special attention to the unique<br>vulnerabilities of girls, LGBTQ+ youth, and others who are often left behind.</p>
        <h3 class="cv-title century" style="top:3096px;">Technology with Integrity</h3>
        <div class="cv-mark" style="left:160.5px;top:3127px;"><img src="{{ asset('images/8.svg') }}" alt=""></div>
        <span class="cv-num" style="left:203.9px;top:3163.2px;">05</span>
        <p class="cv-body" style="top:3136.3px;">Our platform is digital, encrypted, and POPIA-compliant - but more<br>importantly, it is designed with human dignity at the center. Technology should<br>never replace care, but it can strengthen and extend it.</p>
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
    function fitAbout() {
        var wrap = document.getElementById('about-wrap');
        var board = document.getElementById('about-board');
        if (!wrap || !board || getComputedStyle(wrap).display === 'none') return;
        var scale = wrap.clientWidth / 1366;
        board.style.transform = 'scale(' + scale + ')';
        wrap.style.height = (3405 * scale) + 'px';
    }
    fitAbout();
    window.addEventListener('resize', fitAbout);
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
    var menuBtn = document.getElementById('mobile-menu-button');
    if (menuBtn) menuBtn.addEventListener('click', toggleMobileMenu);
</script>
</body>
</html>
