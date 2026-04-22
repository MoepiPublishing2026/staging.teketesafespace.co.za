<div>
    <!-- Subscription Modal Wrapper -->
    <!--<div wire:key="subscription-modal-wrapper">-->
    <!--    @if ($this->showSubscriptionModal ?? false)
-->
    <!--        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 backdrop-blur-sm px-4">-->
    <!--            <div class="bg-[#eeeeee] -->
    <!--                        border-[3px] border-[#c7da30] -->
    <!--                        w-full max-w-[650px] -->
    <!--                        px-14 py-16 -->
    <!--                        rounded-[10px] -->
    <!--                        text-center">-->
    <!-- Heading -->
    <!--                <h2 class="text-[18px] font-semibold text-[#545454] mb-6">-->
    <!--                    Subscribe now and see payment plans:-->
    <!--                </h2>-->
    <!-- Description -->
    <!--                <p class="text-[16px] text-[#545454] leading-relaxed mb-12">-->
    <!--                    Get full access to secure reporting, case management,-->
    <!--                    and school-wide oversight.-->
    <!--                </p>-->
    <!-- Buttons -->
    <!--                <div class="flex flex-col sm:flex-row justify-center gap-8">-->
    <!--                    <button wire:click="redirectToSubscribe"-->
    <!--                        class="px-12 py-3 -->
    <!--                               border-[2px] border-[#c7da30] -->
    <!--                               rounded-[40px] -->
    <!--                               text-[#38b6ff] -->
    <!--                               font-semibold -->
    <!--                               transition duration-200-->
    <!--                               hover:bg-[#c7da30] hover:text-black">-->
    <!--                        Subscribe-->
    <!--                    </button>-->
    <!--                    <button wire:click="skipSubscription"-->
    <!--                        class="px-12 py-3 -->
    <!--                               border-[2px] border-[#c7da30] -->
    <!--                               rounded-[40px] -->
    <!--                               text-[#38b6ff] -->
    <!--                               font-semibold -->
    <!--                               transition duration-200-->
    <!--                               hover:bg-[#c7da30] hover:text-black">-->
    <!--                        Go to dashboard-->
    <!--                    </button>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--
@endif-->
    <!--</div>-->

    <!-- Header -->
    <header
        style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-4 sm:px-8 py-2"
            style="max-width: 1280px; margin: 0 auto;">
            <!-- Logo -->
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" style="width: 90px; height: auto;">
            </div>

            <!-- Top Right Links (Desktop Only) -->
            <div class="hidden md:flex gap-8"
                style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                <a href="javascript:void(0);" onclick="window.location.href = document.referrer;"
                    class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
                    Back
                </a>
                <a href="{{ route('landing-page') }}" class="transition-colors hover:!text-[#c7da30]"
                    style="color: black; text-decoration: none;">
                    Home
                </a>
                <a href="{{ route('about-us') }}#about" class="transition-colors hover:!text-[#c7da30]"
                    style="color: black; text-decoration: none;">
                    About Us
                </a>
                <a href="{{ route('contact-us') }}#section" class="transition-colors hover:!text-[#c7da30]"
                    style="color: black; text-decoration: none;">
                    Contact Us
                </a>
            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
                <button id="mobile-menu-button" onclick="toggleMobileMenu()"
                    class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div
            class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.location.href = document.referrer"; toggleMobileMenu();"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="{{ route('landing-page') }}#about" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="{{ route('landing-page') }}#section" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex flex-col justify-center items-center flex-1 pt-32 px-4 w-full min-h-screen">
        @if ($showOtpForm)
            <h1 class="font-bold text-black uppercase text-2xl sm:text-3xl mb-12 text-center tracking-wide">
                {{ ucfirst($role) }} Administrator – Enter OTP
            </h1>

            <div
                class="bg-white border-[3px] border-[#c7da30] w-full max-w-[700px] px-4 sm:px-16 py-12 sm:py-20 rounded-[20px] text-center">
                <form class="flex flex-col items-center gap-8 sm:gap-10">
                    <input type="hidden" wire:model.live="otp" id="otp">
                    <div class="flex justify-center gap-1 sm:gap-2 w-full otp-container px-2 sm:px-0">
                        @for ($i = 0; $i < 6; $i++)
                           <input type="text" maxlength="1"
    class="otp-input w-[44px] h-[48px] sm:w-[52px] sm:h-[52px] xs:w-[48px] xs:h-[48px] md:w-[60px] md:h-[60px] lg:w-[70px] lg:h-[70px] text-center text-black border-[3px] border-[#c7da30] rounded-[12px] text-lg sm:text-xl font-semibold outline-none focus:border-[#a8c529] transition-colors flex-shrink-0"
    oninput="updateOtp()"
    onkeydown="moveBack(event, {{ $i }})"
    onpaste="handleOtpPaste(event)"
    id="otp-{{ $i }}">
                        @endfor
                    </div>
                    @error('otp')
                        <span class="text-red-500 text-sm block -mt-4">{{ $message }}</span>
                    @enderror

                    <button type="button" wire:click.prevent="login"
                        class="w-full max-w-[500px] h-[60px] font-semibold text-[16px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] shadow-md uppercase transition-opacity hover:opacity-90">
                        Verify
                    </button>
                </form>
            </div>
        @else
            <h1 class="font-bold text-black uppercase text-2xl sm:text-3xl mb-12 text-center tracking-wide">
                {{ ucfirst($role) }} Administrator Verification
            </h1>

            <div
                class="bg-white border-[3px] border-[#c7da30] w-full max-w-[600px] px-6 sm:px-12 py-12 sm:py-16 rounded-[20px] text-center">
                <form wire:submit.prevent="sendOtp" class="flex flex-col gap-8 items-center">
                    <input type="email" id="email" wire:model="email" placeholder="Email Address"
                        class="w-full h-[60px] px-5 text-black border-[3px] border-[#c7da30] rounded-[10px] bg-white text-sm outline-none placeholder-gray-400 focus:border-[#a8c529] placeholder:tracking-wider">
                    @error('email')
                        <span class="text-red-500 text-sm block -mt-4">{{ $message }}</span>
                    @enderror

                    <button type="submit"
                        class="w-full h-[60px] font-semibold text-[16px]
                                   border-4 border-solid border-[#c7da30]
                                   rounded-[100px] text-[#38b6ff]
                                   shadow-md uppercase transition-opacity hover:opacity-90">
                        Send OTP
                    </button>
                </form>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 1.5rem;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4 order-2">
                <a href=" https://www.youtube.com/@matauramapuputla6836"target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon"
                        style="width: 30px; height: 30px; left:1024.8; top: 701.8
;">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X Icon"
                        style="width: 30px; height: 30px;left:1024.8 ; top:701.8; ">
                </a>

                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon"
                        style="width: 30px; height: 30px;left: 1128.6
; top:701.1;">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon"
                        style="width: 35.2px; height: 30px;left: 1179.7;top: 701.1;">
                </a>

                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon"
                        style="width: 35.2px; height: 30px; left: 1225.7px; top: 701.1px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon"
                        style="width: 35.2px; height: 30px;left:1271.7 ;top:700.1;"></a>
            </div>

    </footer>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function updateOtp() {
            let otp = '';
            for (let i = 0; i < 6; i++) {
                let val = document.getElementById('otp-' + i)?.value || '';
                otp += val;
                if (val && i < 5) document.getElementById('otp-' + (i + 1)).focus();
            }
            const hiddenInput = document.getElementById('otp');
            hiddenInput.value = otp;
            hiddenInput.dispatchEvent(new Event('input'));
        }

        function moveBack(e, index) {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                document.getElementById('otp-' + (index - 1)).focus();
            }
        }

        function handleOtpPaste(e) {
    e.preventDefault();
    const pasted = (e.clipboardData || window.clipboardData).getData('text').trim();
    const digits = pasted.replace(/\D/g, '').slice(0, 6);
    digits.split('').forEach((char, i) => {
        const input = document.getElementById('otp-' + i);
        if (input) input.value = char;
    });
    const lastFilled = digits.length < 6 ? digits.length : 5;
    const focusTarget = document.getElementById('otp-' + lastFilled);
    if (focusTarget) focusTarget.focus();
    updateOtp();
}

        window.addEventListener('load', () => {
            const firstBox = document.getElementById('otp-0');
            if (firstBox) firstBox.focus();
        });
    </script>

    <style>
        @media (max-width: 480px) {
            .otp-container {
                gap: 1px !important;
                padding: 0 4px;
            }

            .otp-input {
                min-width: 42px !important;
                width: 42px !important;
                height: 46px !important;
                font-size: 18px !important;
            }
        }

        @media (min-width: 481px) and (max-width: 640px) {
            .otp-container {
                gap: 2px !important;
            }
        }
    </style>
</div>
