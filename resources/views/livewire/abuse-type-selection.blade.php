<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full max-w-full overflow-x-hidden box-border"
     style="-webkit-text-size-adjust: 100%; text-size-adjust: 100%;">
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

                
                  <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
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
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Contact Us
                </a>

            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
                <button id="mobile-menu-button"
                    class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">

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

    <!-- Mobile Menu Overlay -->
    <!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

    <div id="mobile-menu-slide"
        class="fixed top-0 right-0 h-full w-64 max-w-[80vw] bg-white shadow-lg">

        <div class="flex items-center justify-start px-4 pt-16 pb-4">
            <button type="button" onclick="toggleMobileMenu()"
                class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">
                <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="3"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
            <a href="javascript:void(0);"
               onclick="window.history.back(); toggleMobileMenu();"
               class="block py-3 text-[#38b6ff]">Back</a>

            <a href="{{ route('landing-page') }}"
               onclick="toggleMobileMenu()"
               class="block py-3 text-[#38b6ff]">
                Home
            </a>

            <a href="{{ route('about-us') }}"
               onclick="toggleMobileMenu()"
               class="block py-3 text-[#38b6ff]">
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

    <!-- Main Section -->
   <div class="flex-1 bg-white flex flex-col font-[Montserrat]
            justify-center items-center
            w-full max-w-full min-w-0 overflow-x-hidden
            pt-[88px] pb-6
            sm:pt-[100px]
            md:pt-[110px]
            lg:pt-[120px]">
        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center text-center w-full max-w-full min-w-0 px-3 sm:px-4">
            <!-- Heading -->
            <h1 class="text-[20px] sm:text-[24px] font-bold text-black uppercase mb-4 sm:mb-8">
                Types of Report
            </h1>

            <!-- Reporting Status -->
            <p class="text-[13px] sm:text-[15px] font-bold text-black mb-4 sm:mb-6 px-2">
                @if ($isAnonymous)
                    You are reporting anonymously
                @else
                    You are reporting with details
                @endif
            </p>

            <!-- Outer Box -->
            <div
                class="w-full max-w-[698px] min-w-0 border-2 border-[#c7da30] rounded-xl bg-white p-3 sm:p-6 md:p-10 flex flex-col items-center justify-center box-border">
                <!-- Abuse Type Buttons -->
                <div class="grid grid-cols-2 gap-x-7 sm:gap-x-6 md:gap-x-12 gap-y-3 sm:gap-y-6 w-full min-w-0 justify-items-stretch sm:justify-items-center">
    @foreach ($abuseTypes as $abuseType)

        <button
            wire:click="selectAbuseType({{ $abuseType->id }})"
            class="
                w-full
                min-w-0
                max-w-full
                sm:max-w-[180px]
                md:max-w-[220px]
                lg:w-[240px]

                min-h-[48px]
                sm:min-h-[58px]
                md:min-h-[65px]

                px-1.5
                py-2
                sm:px-4

                border-2
                sm:border-4
                border-[#c7da30]
                rounded-full

                flex
                items-center
                justify-center

                text-center
                text-[#00AEEF]

                text-[11px]
                sm:text-[14px]
                md:text-[16px]

                leading-[1.15]
                break-words
                [overflow-wrap:anywhere]

                transition
                duration-200">

            {{ $abuseType->type_name }}

        </button>

    @endforeach
</div>
            </div>
        </div>
    </div>

    <x-site-footer />
</div>

<script>
    // Mobile menu functionality
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        } else {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    }

    // Add event listener for the mobile menu button
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', toggleMobileMenu);
        }
    });
</script>
