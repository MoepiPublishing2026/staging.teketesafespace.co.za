<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tekete SafeSpace</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        @media (max-width: 767px) {
            .about-hero-mobile { display: flex; }
            .about-hero-desktop { display: none !important; }
        }
        @media (min-width: 768px) {
            .about-hero-mobile { display: none !important; }
            .about-hero-desktop { display: flex; }
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
                    class="text-black font-bold transition-colors hover:!text-[#c7da30]">
                    About Us
                </a>
                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"  class="text-black transition-colors hover:!text-[#c7da30]">
                        Workshops
                    </a>

                 

                <a href="{{ route('contact-us') }}"
                    class="text-black  transition-colors hover:!text-[#c7da30]">
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

    <!-- Back -->
    <a href="javascript:void(0);"
       onclick="window.history.back(); toggleMobileMenu();"
       class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">
        Back
    </a>

    <a href="{{ route('landing-page') }}"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff]">
        Home
    </a>

    <a href="{{ route('about-us') }}"
       onclick="toggleMobileMenu()"
       class="block py-3 font-bold text-[#38b6ff]">
        About Us
    </a>

    <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff]">
        Workshops
    </a>

    

    <a href="{{ route('contact-us') }}"
       onclick="toggleMobileMenu()"
       class="block py-3 text-[#38b6ff]">
        Contact Us
    </a>

</nav>
    </div>
</div>
    <section class="pt-6 md:pt-24 w-full bg-white pb-10 md:py-16 px-6 lg:px-8">
        {{-- Mobile: stacked, centered icon + title --}}
        <div class="about-hero-mobile flex-col items-center text-center w-full">
            <img src="{{ asset('images/magnifying glass.png') }}" alt="Magnifying Glass"
                class="block mx-auto w-[190px] mb-8">
            <h2 class="text-[28px] font-extrabold text-black leading-[1.15] mb-3 text-center">
                ABOUT TEKETE<br>SAFESPACE
            </h2>
            <div class="h-[6px] bg-[#c7da30] w-[200px] mx-auto"></div>
        </div>

        {{-- Desktop: icon beside title --}}
        <div class="about-hero-desktop w-full flex-row items-center gap-2 sm:gap-3">
            <div class="flex justify-start shrink-0">
                <img src="{{ asset('images/magnifying glass.png') }}" alt="Magnifying Glass"
                    class="w-[220px] lg:w-[280px] -mr-4 lg:-mr-6">
            </div>
            <div class="flex-1 min-w-0 text-left">
                <h2 class="text-[44px] lg:text-[50px] font-extrabold text-[#333333] mb-2 leading-tight">
                    ABOUT TEKETE SAFESPACE
                </h2>
                <div class="h-[6px] bg-[#c7da30] w-full max-w-[620px] lg:max-w-[740px]"></div>
            </div>
        </div>

        <div class="mt-8 md:mt-8 space-y-4 text-[15px] md:text-[17px] text-black leading-relaxed text-left">
            <p>
                A confidential platform designed to protect and empower learners
                and employees to speak out—with the option to report anonymously.
                The app is zero-rated, ensuring users can access and submit reports
                without incurring data costs. Your voice matters. Your identity is protected.
            </p>
            <p>
                Whether you choose to report with your name or anonymously,
                Tekete SafeSpace by Moepi Publishing ensures every report is handled with confidentiality and urgency.
            </p>
        </div>
    </section>

    <section class="w-full bg-white py-16" style="padding-left: 2vw; padding-right: 2vw;">
       <h2 class="text-[24px] text-black text-left md:text-center font-bold mb-16">
    You can report any of the following through Tekete SafeSpace
</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 w-full">
         @php
    $issues = [
        ['img' => 'Bullying.png', 'title' => 'Bullying'],
        ['img' => 'Substance  Abuse.png', 'title' => 'Substance Abuse'],
        ['img' => 'Sexual Abuse.png', 'title' => 'Sexual Abuse or Harassment'],
        ['img' => 'weapons.png', 'title' => 'Weapons'],
        ['img' => 'pregnancy.png', 'title' => 'Teenage Pregnancy'],
        ['img' => 'other issues.png', 'title' => 'Other Issues'],
    ];
@endphp

           @foreach ($issues as $issue)
       <div class="flex flex-col items-center text-center">
        <div class="h-[80px] w-[80px] flex items-center justify-center mb-3">
            <img src="{{ asset('images/' . $issue['img']) }}"
                 class="max-w-full max-h-full object-contain"
                 alt="{{ $issue['title'] }}">
        </div>
        <p class="text-[16px] text-black leading-tight min-h-[40px]">
            {{ $issue['title'] }}
        </p>
    </div>
@endforeach
        </div>
    </section>

    <section class="relative bg-white w-full pb-12 grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_230px] gap-8 items-start overflow-visible" style="padding-left: 2vw; padding-right: 2vw;">

        <div class="hidden lg:block absolute -left-56 top-[100%] -translate-y-1/2 w-[400px] h-[400px] pointer-events-none z-10">
            <img src="{{ asset('images/futuristic digital frame tech.png') }}" alt="Tech Frame Half"
                class="w-full h-full object-cover object-right [clip-path:inset(0_0_0_50%)]">
        </div>

        <div class="pt-2 -mt-10 sm:mt-0 relative z-10">
            <h3 class="text-[#c7da30] text-[29.9px] font-bold mb-3 text-center md:text-left">
                Who we serve:
            </h3>

            <ul class="list-disc text-[16px] text-black space-y-2 pl-5">
                <li>Learners — A safe way to speak out without fear.</li>
                <li>Parents — Peace of mind knowing concerns can be raised.</li>
                <li>Teachers & Staff — A trusted channel for reporting misconduct.</li>
                <li>Schools — A structured system to build safer environments.</li>
                <li>Organisations — A safer working environment.</li>
            </ul>
        </div>

        <!-- Updated container and image classes for mobile centering -->
        <div class="flex justify-center md:justify-end relative z-10 w-full max-w-[230px] mx-auto md:mx-0">
            <img src="{{ asset('images/Students holding phone.png') }}" alt="Students holding phone" class="rounded-lg shadow-md object-contain" style="width: 230px; height: auto; max-width: 100%;">
        </div>
    </section>

    <section class="bg-white w-full pt-4 pb-4" style="padding-left: 2vw; padding-right: 2vw;">
        <h3 class="text-[#c7da30] text-[26px] font-bold text-center mb-8">
            Our Core Values
        </h3>

        <div class="space-y-10 text-black text-[16px] md:text-[17px] flex flex-col items-start w-full mx-auto">

            <div class="text-center w-full">
                <p class="font-bold text-black text-[18px] mb-2 text-center">1. Safety First</p>
                <p>We believe every learner has the right to feel and be safe at school, at home, and in their community. Our system is designed to protect and empower young people by creating a secure environment where they can speak up without fear.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-black text-[18px] mb-2 text-center">2. Confidentiality & Trust</p>
                <p>Learners must feel confident that what they share is protected. Our platform ensures anonymity, privacy, and strict data protection. We are committed to earning and maintaining the trust of every learner who reaches out for help.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-black text-[18px] mb-2 text-center">3. Empowerment Through Voice</p>
                <p>Silence often comes from fear. We exist to give learners their voice back — to allow them to speak their truth, raise concerns, and ask for help without shame or judgment. Every voice matters.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-black text-[18px] mb-2 text-center">4. Equity & Inclusion</p>
                <p>Every learner, regardless of gender, background, or circumstance, deserves equal access to support and protection. We pay special attention to the unique vulnerabilities of girls, LGBTQ+ youth, and others who are often left behind.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-black text-[18px] mb-2 text-center">5. Technology with Integrity</p>
                <p>Our platform is digital, encrypted, and POPIA-compliant — but more importantly, it is designed with human dignity at the center. Technology should never replace care, but it can strengthen and extend it.</p>
            </div>

        </div>
    </section>

    <x-site-footer class="mt-12" />

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