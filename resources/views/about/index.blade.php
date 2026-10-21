<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tekete SafeSpace</title>
    <x-favicon />

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/century-gothic-paneuropean" rel="stylesheet">
    <style>
        .about-desktop-nav {
            display: none;
            align-items: center;
            gap: 18px;
            margin: 0;
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-size: 15px;
            font-style: normal;
            line-height: 1;
            letter-spacing: 0;
        }

        .about-desktop-nav a {
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-size: 15px;
            font-style: normal;
            line-height: 1;
            letter-spacing: 0;
            color: #000000;
            text-decoration: none;
            white-space: nowrap;
        }

        .about-desktop-nav a:hover {
            color: #c7da30;
        }

        .about-title-lockup {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .about-heading-about,
        .about-heading-brand {
            font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif;
            font-weight: 400;
            font-style: normal;
            color: #C5D931;
            letter-spacing: 0;
            white-space: nowrap;
        }

        .about-heading-about {
            display: block;
            font-size: 52px;
            font-weight: 300;
            line-height: 0.9;
        }

        .about-heading-brand {
            display: block;
            font-size: 18px;
            line-height: 1.05;
            margin-top: 2px;
        }

        .about-intro-mobile {
            display: none;
        }

        .about-paragraph,
        .about-intro,
        .about-intro p,
        .core-value-body,
        .who-we-serve-list {
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-size: 16px;
            font-style: normal;
            line-height: 1.36;
            letter-spacing: 0;
            color: #000000;
        }

        .about-intro {
            width: 100%;
            max-width: 767px;
            margin-left: auto;
            margin-right: auto;
        }

        .about-intro p {
            margin: 0;
        }

        .about-intro p + p {
            margin-top: 22px;
        }

        .core-values-heading {
            font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif;
            font-weight: 400;
            font-size: 28px;
            line-height: 1.15;
            color: #FFFFFF;
            text-align: center;
            text-transform: uppercase;
        }

        .core-value-title {
            font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif;
            font-weight: 700;
            font-size: 18px;
            line-height: 1.2;
            color: #1E94FD;
            text-transform: uppercase;
        }

        .about-copy-column {
            width: 100%;
            max-width: 767px;
            margin-left: auto;
            margin-right: auto;
        }

        .core-value-body {
            width: 100%;
            max-width: 640px;
            margin: 8px 0 0;
        }

        .core-values-list {
            display: flex;
            flex-direction: column;
            gap: 36px;
        }

        .core-value-row {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .core-value-mark {
            width: 105px;
            height: 78px;
            flex: 0 0 105px;
        }

        .core-value-number {
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            font-size: 28px;
            line-height: 1;
            color: #1E94FD;
        }

        .about-report-heading {
            font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif;
            font-weight: 400;
            font-size: 24px;
            line-height: 1.35;
            color: #C5D931;
            width: max-content;
            max-width: 100%;
            letter-spacing: 0.03em;
        }

        .about-report-block {
            width: fit-content;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .about-report-grid {
            width: 0;
            min-width: 100%;
        }

        .about-issue-label {
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 1.25;
            color: #000000;
        }

        .who-we-serve-heading {
            font-family: "Century Gothic Paneuropean", "Century Gothic", CenturyGothic, sans-serif;
            font-weight: 400;
            font-size: 28px;
            line-height: 1.2;
            color: #C5D931;
        }

        .who-we-serve-list {
            margin: 0;
            padding-left: 1.25rem;
            line-height: 2.1;
        }

        .who-we-serve-list li {
            margin: 0;
            padding: 0;
        }

        .who-we-serve-photo {
            width: 230px;
            height: auto;
            max-width: 100%;
            aspect-ratio: 289 / 356;
            object-fit: cover;
            object-position: center center;
            align-self: flex-start;
        }

        @media (min-width: 768px) {
            .about-desktop-nav { display: flex; }
            .about-hero-mobile { display: none !important; }
            .about-hero-desktop { display: flex; }
            .about-heading-about { font-size: 92px; font-weight: 300; }
            .about-heading-brand { font-size: 33px; font-weight: 400; }
            .about-report-heading { font-size: 36px; letter-spacing: 0.06em; }
            .core-values-heading { font-size: 36px; }
            .core-value-title { font-size: 21px; }
            .core-value-number { font-size: 36px; }
            .who-we-serve-heading { font-size: 36px; }
            .who-we-serve-photo {
                width: 289px;
                height: auto;
                align-self: flex-start;
            }
        }

        @media (max-width: 767px) {
            .about-hero-mobile { display: flex; }
            .about-hero-desktop { display: none !important; }
            .about-intro-desktop { display: none !important; }
            .about-intro-mobile { display: block; }
            .about-heading-mobile {
                font-family: "Montserrat", sans-serif;
                font-weight: 700;
                font-size: 24px;
                line-height: 1.2;
                letter-spacing: 0.04em;
                color: #000000;
                text-transform: uppercase;
                text-align: center;
                display: inline-block;
                padding-bottom: 8px;
                border-bottom: 3px solid #C5D931;
            }
            .about-intro-mobile {
                font-family: "Montserrat", sans-serif;
                font-weight: 400;
                font-size: 16px;
                line-height: 1.5;
                color: #000000;
                text-align: left;
                width: max-content;
                max-width: 340px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (min-width: 1024px) {
            .about-heading-about {
                font-size: 115px;
                font-weight: 300;
                max-width: none;
                letter-spacing: 0;
            }
            .about-heading-brand {
                font-size: 42px;
                font-weight: 400;
                max-width: none;
                letter-spacing: 0;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-[Montserrat] overflow-x-hidden pt-16 md:pt-24 lg:pt-28">

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
        md:w-[240px]
        lg:w-[280px]
        xl:w-[320px]
        2xl:w-[380px]
        h-auto
        object-contain
        flex-shrink-0">
</div>

        <!-- Top Right Links -->
        <div class="flex items-center">

            <!-- Desktop Navigation -->
            <nav class="about-desktop-nav" aria-label="Primary">
                <a href="{{ route('landing-page') }}">Home</a>
                <a href="{{ route('about-us') }}">About Us</a>
                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops">Workshops</a>
                <a href="{{ route('contact-us') }}">Contact Us</a>
            </nav>

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
        
        <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]" style="font-family: 'Montserrat', sans-serif; font-weight: 400; letter-spacing: 0;">

    <a href="{{ route('landing-page') }}"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
        Home
    </a>

    <a href="{{ route('about-us') }}"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
        About Us
    </a>

    <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
        Workshops
    </a>

    <a href="{{ route('contact-us') }}"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
        Contact Us
    </a>

</nav>
    </div>
</div>
    <section class="pt-6 md:pt-24 w-full bg-white pb-10 md:py-16 px-6 lg:px-8">
        {{-- Mobile: stacked icon, black heading, lime underline --}}
        <div class="about-hero-mobile flex-col items-center text-center w-full">
            <img src="{{ asset('images/magnifying glass.png') }}" alt="Magnifying Glass"
                class="block mx-auto w-[210px] mb-1">
            <h2 class="about-heading-mobile mb-6">
                ABOUT TEKETE<br>SAFESPACE
            </h2>
        </div>

       {{-- Desktop: icon stays in place, heading nudged to the right --}}
<div class="about-hero-desktop w-full flex flex-row items-center justify-center gap-4 sm:gap-6">
    <div class="flex justify-center shrink-0">
        <img src="{{ asset('images/magnifying glass.png') }}" alt="Magnifying Glass"
            class="w-[250px] lg:w-[320px] -translate-x-6 lg:-translate-x-8">
    </div>
    <div class="text-left shrink-0">
        <h2 class="about-title-lockup">
            <span class="about-heading-about">ABOUT</span>
            <span class="about-heading-brand">TEKETE SAFESPACE</span>
        </h2>
    </div>
</div>

        <div class="about-intro-mobile mt-1">
            <p>
                A confidential platform designed to<br>
                protect and empower learners and<br>
                employees to speak out- with the<br>
                option to report anonymously.The<br>
                app is zero-rated,ensuring users can<br>
                access and submit reports without<br>
                incurring data costs. Your voice<br>
                matters. Your identity is protected.<br>
                Your voice matters. Your identity is<br>
                protected.
            </p>
            <p class="mt-5">
                Whether you choose to report with<br>
                your name or anonymously, Safe<br>
                Space by Moepi Publishing ensures<br>
                every report is handled with<br>
                confidentiality, urgency, and at no<br>
                data cost to the user.
            </p>
        </div>

        <div class="about-intro about-intro-desktop mt-8 text-left">
            <p>
                A confidential platform designed to protect and empower learners and employees to speak out,
                with the option to report anonymously. The app is zero-rated, ensuring users can access and
                submit reports without incurring data costs. Your voice matters. Your identity is protected.
            </p>
            <p>
                Whether you choose to report with your name or anonymously, Tekete SafeSpace by Moepi
                Publishing ensures every report is handled with confidentiality, urgency, and at no data cost to
                the user.
            </p>
        </div>
    </section>

    <section class="w-full bg-white py-16 px-6 lg:px-8">
        <div class="about-report-block">
       <h2 class="about-report-heading text-center mb-14 md:mb-16">
    You can report any of the following<br> through Tekete SafeSpace
</h2>
        <div class="about-report-grid grid grid-cols-2 md:grid-cols-3 gap-x-8 gap-y-12 md:gap-x-16 md:gap-y-14">
         @php
    $issues = [
        ['img' => '6.svg', 'title' => "Teenage\npregnancy"],
        ['img' => '9.svg', 'title' => 'Bullying'],
        ['img' => '10.svg', 'title' => 'Substance Addiction'],
        ['img' => '11.svg', 'title' => 'Suspected Sexual Harassment'],
        ['img' => '12.svg', 'title' => 'Weapons'],
        ['img' => '13.svg', 'title' => 'Many More'],
    ];
@endphp

           @foreach ($issues as $issue)
       <div class="flex flex-col items-center text-center">
        <div class="h-[64px] w-[64px] md:h-[76px] md:w-[76px] flex items-center justify-center mb-3">
            <img src="{{ asset('images/' . $issue['img']) }}"
                 class="max-w-full max-h-full object-contain"
                 alt="{{ str_replace("\n", ' ', $issue['title']) }}">
        </div>
        <p class="about-issue-label whitespace-pre-line">
            {{ $issue['title'] }}
        </p>
    </div>
@endforeach
        </div>
        </div>
    </section>

    <section class="relative bg-white w-full pt-6 md:pt-10 pb-12 px-6 lg:px-8">
        <div class="max-w-[1024px] mx-auto flex flex-col md:flex-row md:items-start justify-center gap-5 md:gap-10">
            <div class="md:min-w-[540px] md:max-w-[560px]">
                <h3 class="who-we-serve-heading mb-5 text-left">
                    Who we serve:
                </h3>

                <ul class="who-we-serve-list list-disc">
                    <li><span class="font-bold">Learners</span> - A safe way to speak out without fear.</li>
                    <li><span class="font-bold">Parents</span> - Peace of mind knowing concerns can be raised.</li>
                    <li><span class="font-bold">Teachers &amp; Staff</span> - A trusted channel for reporting<br>misconduct.</li>
                    <li><span class="font-bold">Schools</span> - A structured system to build safer, more<br>accountable learning environments.</li>
                    <li><span class="font-bold">Organisations</span> - A safer working environment for both<br>employer and employee.</li>
                </ul>
            </div>

            <img src="{{ asset('images/Students holding phone.png') }}"
                 alt="Students holding phone"
                 class="who-we-serve-photo rounded-lg shadow-md mx-auto md:mr-0 md:ml-4 shrink-0">
        </div>
    </section>

    <section class="bg-white w-full pt-10 pb-16 px-6 lg:px-8">
        <div class="about-copy-column">
        <div class="flex justify-center mb-12">
            <div class="relative w-[300px] h-[90px] md:w-[400px] md:h-[120px] flex items-center justify-center overflow-hidden">
                <img src="{{ asset('images/7.svg') }}"
                     alt=""
                     aria-hidden="true"
                     class="absolute left-1/2 top-1/2 w-[520px] h-[520px] max-w-none -translate-x-1/2 -translate-y-1/2 pointer-events-none select-none">
                <h3 class="core-values-heading relative z-10 px-8">
                    OUR CORE<br>VALUES
                </h3>
            </div>
        </div>

        @php
            $coreValues = [
                [
                    'num' => '01',
                    'title' => 'SAFETY FIRST',
                    'body' => 'We believe every learner has the right to feel and be safe at school, at home, and in their community. Our system is designed to protect and empower young people by creating a secure environment where they can speak up without fear.',
                ],
                [
                    'num' => '02',
                    'title' => 'CONFIDENTIALITY & TRUST',
                    'body' => 'Learners must feel confident that what they share is protected. Our platform ensures anonymity, privacy, and strict data protection. We are committed to earning and maintaining the trust of every learner who reaches out for help.',
                ],
                [
                    'num' => '03',
                    'title' => 'EMPOWERMENT THROUGH VOICE',
                    'body' => 'Silence often comes from fear. We exist to give learners their voice back - to allow them to speak their truth, raise concerns, and ask for help without shame or judgment. Every voice matters.',
                ],
                [
                    'num' => '04',
                    'title' => 'EQUITY & INCLUSION',
                    'body' => 'Every learner, regardless of gender, background, or circumstance, deserves equal access to support and protection. We pay special attention to the unique vulnerabilities of girls, LGBTQ+ youth, and others who are often left behind.',
                ],
                [
                    'num' => '05',
                    'title' => 'TECHNOLOGY WITH INTEGRITY',
                    'body' => 'Our platform is digital, encrypted, and POPIA-compliant - but more importantly, it is designed with human dignity at the center. Technology should never replace care, but it can strengthen and extend it.',
                ],
            ];
        @endphp

        <div class="core-values-list">
            @foreach ($coreValues as $value)
                <div class="core-value-row">
                    <div class="core-value-mark relative shrink-0 flex items-center justify-center">
                        <img src="{{ asset('images/8.svg') }}"
                             alt=""
                             aria-hidden="true"
                             class="absolute inset-0 w-full h-full object-contain pointer-events-none select-none">
                        <span class="core-value-number relative z-10">{{ $value['num'] }}</span>
                    </div>
                    <div class="min-w-0">
                        <h4 class="core-value-title">{{ $value['title'] }}</h4>
                        <p class="core-value-body">{{ $value['body'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </section>

    <x-site-footer class="mt-12" background="#C5D931" />

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

</body>

</html>