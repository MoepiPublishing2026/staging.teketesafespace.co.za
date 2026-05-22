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

<body class="bg-white text-gray-800 font-[Montserrat] overflow-x-hidden">

    <!-- ================= MOBILE NAVBAR ================= -->
    <header class="md:hidden fixed top-0 left-0 w-full bg-white z-50 shadow-sm px-6 h-16 flex items-center">
        <div class="flex justify-between items-center max-w-[1280px] mx-auto w-full">
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[135px] h-auto flex-shrink-0">
            <button id="mobile-menu-button" class="p-2 rounded-md text-black hover:bg-gray-100 transition">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <!-- ================= DESKTOP NAVBAR (UNCHANGED) ================= -->
    <div class="hidden md:flex justify-between items-center px-6 lg:px-20 py-4 bg-white shadow-sm">
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
        </div>

        <div class="flex gap-8 text-[17px] text-black">
            <a href="{{ route('landing-page') }}" class="hover:text-[#c7da30]">Home</a>
            <a href="{{ route('about-us') }}" class="font-bold">About Us</a>
            <a href="{{ route('contact-us') }}" class="hover:text-[#c7da30]">Contact Us</a>
        </div>
    </div>

    <!-- ================= MOBILE MENU OVERLAY ================= -->
    <div id="mobile-menu" class="fixed inset-0 z-[60] hidden md:hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

        <div id="mobile-menu-slide"
            class="absolute top-0 right-0 h-full w-64 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out">

            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto">
                <button onclick="toggleMobileMenu()" class="p-2 hover:bg-gray-100 rounded-full transition">
                    ✕
                </button>
            </div>

            <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
                <a href="{{ route('landing-page') }}"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">Home</a>
                <a href="{{ route('about-us') }}"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">About Us</a>
                <a href="{{ route('contact-us') }}"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">Contact Us</a>
            </nav>

        </div>
    </div>

    <!-- ================= ABOUT HEADER SECTION ================= -->
    <section class="pt-24 md:pt-0 w-full bg-white px-6 lg:px-20 py-16">
        <div class="max-w-[1280px] mx-auto flex flex-col lg:flex-row items-center gap-12">

            <div class="flex justify-center lg:justify-start">
                <img src="{{ asset('images/magnifying glass.png') }}" alt="Magnifying Glass"
                    class="w-[220px] md:w-[260px] lg:w-[300px]">
            </div>

            <div class="flex-1 text-center lg:text-left">
                <h2 class="text-[32px] sm:text-[40px] md:text-[50px] font-extrabold text-[#333333] mb-6">
                    ABOUT TEKETE SAFESPACE
                </h2>

                <!-- FIXED RESPONSIVE UNDERLINE - JUST RIGHT -->
                <div
                    class="h-[6px] bg-[#c7da30] 
            w-[280px] sm:w-[400px] md:w-[620px] lg:w-[700px] xl:w-[740px]
            mx-auto lg:mx-0 mt-3 md:-mt-10">
                </div>

            </div>
        </div>

        <p class="text-[17px] text-[#444444] leading-relaxed mt-9">
            A confidential platform designed to protect and empower learners
            and employees to speak out—with the option to report anonymously.
            Your voice matters. Your identity is protected. <br>
            Whether you choose to report with your name or anonymously,
            Tekete SafeSpace by Moepi Publishing ensures every report is handled with confidentiality and urgency.
        </p>
    </section>

    <!-- ================= REPORT TYPES ================= -->
    <section class="w-full bg-white px-6 lg:px-20 py-16">
        <h2 class="text-[21px] text-black text-center font-semibold mb-16">
            You can report any of the following through Tekete SafeSpace
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10 text-left">

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
                <a href="{{ route('choose-report-type') }}"
                    class="flex flex-col items-start hover:opacity-80 transition">

                    <div class="h-[80px] w-[80px] flex items-center justify-start mb-3">
                        <img src="{{ asset('images/' . $issue['img']) }}" class="max-w-full max-h-full object-contain"
                            alt="{{ $issue['title'] }}">
                    </div>

                    <p class="text-[16px] text-[#333] leading-tight">
                        {{ $issue['title'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- ================= WHO WE SERVE ================= -->
    <section
        class="bg-white w-full px-6 lg:px-20 pb-12 max-w-[1280px] mx-auto grid grid-cols-1 md:grid-cols-[1fr_auto] gap-10 items-start">

        <div class="pt-2">
            <h3 class="text-[#c7da30] text-[29.9px] font-bold mb-3">
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

        <div class="flex justify-center md:justify-end">
            <img src="{{ asset('images/Students holding phone.png') }}" class="w-[230px] h-auto rounded-lg shadow-md">
        </div>
    </section>

    <div class="hidden lg:block absolute -left-48 top-[210%] -translate-y-1/2 w-[350px] h-[200px] overflow-hidden">
        <img src="{{ asset('images/futuristic digital frame tech.png') }}" alt="Tech Frame Half"
            class="w-full h-full object-cover object-left">
    </div>

    <!-- ================= CORE VALUES ================= -->
    <section class="bg-white w-full px-6 lg:px-20 pt-4 pb-4">
        <h3 class="text-[#c7da30] text-[26px] font-bold text-center mb-8">
            Our Core Values
        </h3>

        <div
            class="space-y-10 text-gray-800 text-[16px] md:text-[17px] flex flex-col items-start w-full max-w-6xl mx-auto">

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">1. Safety First</p>
                <p>We believe every learner has the right to feel and be safe at school, at home, and in their
                    community. Our system is designed to protect and empower young people by creating a secure
                    environment where they can speak up without fear.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">2. Confidentiality & Trust</p>
                <p>Learners must feel confident that what they share is protected. Our platform ensures anonymity,
                    privacy, and strict data protection. We are committed to earning and maintaining the trust of every
                    learner who reaches out for help.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">3. Empowerment Through Voice</p>
                <p>Silence often comes from fear. We exist to give learners their voice back — to allow them to speak
                    their truth, raise concerns, and ask for help without shame or judgment. Every voice matters.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">4. Equity & Inclusion</p>
                <p>Every learner, regardless of gender, background, or circumstance, deserves equal access to support
                    and protection. We pay special attention to the unique vulnerabilities of girls, LGBTQ+ youth, and
                    others who are often left behind.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">5. Technology with Integrity</p>
                <p>Our platform is digital, encrypted, and POPIA-compliant — but more importantly, it is designed with
                    human dignity at the center. Technology should never replace care, but it can strengthen and extend
                    it.</p>
            </div>

        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="w-full bg-[#808080] text-white py-6 mt-12">
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6 max-w-[1280px] mx-auto text-[14px] sm:text-[16px]">
            <div>
                <p>© {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" class="w-[30px] h-[30px]">
                </a>
                <a href="https://x.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" class="w-[30px] h-[30px]">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" class="w-[30px] h-[30px]">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" class="w-[35px] h-[30px]">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" class="w-[35px] h-[30px]">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" class="w-[35px] h-[30px]">
                </a>
            </div>
        </div>
    </footer>

    <!-- ================= MOBILE MENU SCRIPT ================= -->
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

        document.getElementById('mobile-menu-button')?.addEventListener('click', toggleMobileMenu);
    </script>

</body>

</html>
