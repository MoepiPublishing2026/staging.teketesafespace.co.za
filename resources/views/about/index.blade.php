<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tekete SafeSpace</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-white text-gray-800 font-[Montserrat] overflow-x-hidden pt-20 sm:pt-24 lg:pt-28">

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

                 <a href="{{ route('news') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    News
                </a>

                <a href="{{ route('contact-us') }}"
                    class="text-black font-bold transition-colors hover:!text-[#c7da30]">
                    Contact Us
                </a>

            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
              <button id="mobile-menu-button"
                        
                        class="p-2 rounded-md text-black hover:bg-gray-100">

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
            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 font-bold text-[#38b6ff]">About Us</a>
            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Workshops</a>
            <a href="{{ route('news') }}" onclick="toggleMobileMenu()" class="block py-3  text-[#38b6ff] border-b border-gray-100">News</a>
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3  text-[#38b6ff]">Contact Us</a>

        </nav>
    </div>
</div>
    <section class="pt-24 w-full bg-white py-16" style="padding-left: 2vw; padding-right: 2vw;">
        <div class="w-full flex flex-col lg:flex-row items-center gap-12">
<div class="flex justify-center lg:justify-start">
                <img src="{{ asset('images/magnifying glass.png') }}" alt="Magnifying Glass"
                    class="w-[220px] md:w-[260px] lg:w-[300px] -mt-14 lg:mt-0">
            </div>
            <div class="flex-1 text-center lg:text-left">
                <h2 class="text-[32px] sm:text-[40px] md:text-[50px] font-extrabold text-[#333333] mb-6 -mt-10">
                    ABOUT TEKETE SAFESPACE
                </h2>

                <div
                    class="h-[6px] bg-[#c7da30] 
                    w-[280px] sm:w-[400px] md:w-[620px] lg:w-[700px] xl:w-[740px]
                    mx-auto lg:mx-0 mt-3 md:-mt-10">
                </div>

            </div>
        </div>

        <p class="text-[17px] text-black leading-relaxed mt-9">
            A confidential platform designed to protect and empower learners
            and employees to speak out—with the option to report anonymously.
            Your voice matters. Your identity is protected. <br>
            Whether you choose to report with your name or anonymously,
            Tekete SafeSpace by Moepi Publishing ensures every report is handled with confidentiality and urgency.
        </p>
    </section>

    <section class="w-full bg-white py-16" style="padding-left: 2vw; padding-right: 2vw;">
        <h2 class="text-[21px] text-black text-center font-semibold mb-16">
            You can report any of the following through Tekete SafeSpace
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10 text-left">
            @php
                $issues = [
                    ['img' => 'Bullying.png', 'title' => 'Bullying'],
                    ['img' => 'Substance  Abuse.png', 'title' => 'Substance Addiction'],
                    ['img' => 'Sexual Abuse.png', 'title' => 'Suspected Sexual Harassment'],
                    ['img' => 'weapons.png', 'title' => 'Weapons'],
                    ['img' => 'pregnancy.png', 'title' => 'Teenage Pregnancy'],
                    ['img' => 'other issues.png', 'title' => 'Other Issues'],
                ];
            @endphp

            @foreach ($issues as $issue)
                <a href="{{ route('choose-report-type') }}"
                    class="flex flex-col items-start hover:opacity-80 transition">

                    <div class="h-[80px] w-[80px] flex items-center justify-start mb-3">
                        <img src="{{ asset('images/' . $issue['img']) }}" class="max-w-full max-h-full object-contain"
                            alt="{{ $issue['title'] }}">
                    </div>

                    <p class="text-[16px] text-black leading-tight">
                        {{ $issue['title'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="relative bg-white w-full pb-12 grid grid-cols-1 md:grid-cols-[1fr_auto] gap-10 items-start" style="padding-left: 2vw; padding-right: 2vw;">

        <div class="hidden lg:block absolute -left-56 top-[100%] -translate-y-1/2 w-[400px] h-[400px] pointer-events-none z-10">
            <img src="{{ asset('images/futuristic digital frame tech.png') }}" alt="Tech Frame Half"
                class="w-full h-full object-cover object-right [clip-path:inset(0_0_0_50%)]">
        </div>

        <div class="pt-2 relative z-10">
            <h3 class="text-[#c7da30] text-[29.9px] font-bold mb-3">
                Who we serve:
            </h3>

            <ul class="list-disc text-[16px] text-black space-y-2 pl-5">
                <li>Learners — A safe way to speak out without fear.</li>
                <li>Parents — Peace of mind knowing concerns can be raised.</li>
                <li>Teachers & Staff — A trusted channel for reporting misconduct.</li>
                <li>Schools — A structured system to build safer, more accountable learning environments.</li>
                <li>Organisations — A safer working environment for both employer and employee.</li>
            </ul>
        </div>

        <div class="flex justify-center md:justify-end relative z-10">
            <img src="{{ asset('images/Students holding phone.png') }}" class="w-[300px] h-[350px] rounded-lg shadow-md -translate-x-40">
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