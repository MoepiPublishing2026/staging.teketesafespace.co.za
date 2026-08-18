<div class="min-h-screen flex flex-col bg-white font-[Montserrat]">
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
                        onclick="toggleMobileMenu()"
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

    <!-- Mobile Menu Overlay -->
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
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3  text-[#38b6ff]">Contact Us</a>

        </nav>
    </div>
</div>

    <!-- Main Content -->
    <main class="flex flex-col justify-center flex-1 pt-12 sm:pt-32 pb-16 sm:pb-24 px-4 w-full">
    <div class="max-w-2xl mx-auto w-full">
        @if ($showOtpForm)
            <h1 class="font-bold text-black uppercase text-2xl sm:text-3xl mb-6 sm:mb-12 text-center tracking-wide">
                {{ ucfirst($role) }} Administrator – Enter OTP
            </h1>

            <div
                 class="otp-card bg-white border-[3px] border-[#c7da30] w-full max-w-[700px] px-4 sm:px-16 py-6 sm:py-12 rounded-[20px] text-center">
                <form wire:submit.prevent="login" class="otp-form flex flex-col items-center gap-5 sm:gap-12">
                    <input type="hidden" wire:model.live="otp" id="otp">
                    <div class="flex justify-center gap-4 sm:gap-5 md:gap-6 w-full otp-container px-2 sm:px-0">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1"
                                class="otp-input w-[44px] h-[48px] sm:w-[52px] sm:h-[52px] xs:w-[48px] xs:h-[48px] md:w-[60px] md:h-[60px] lg:w-[70px] lg:h-[70px] text-center text-black border-[3px] border-[#c7da30] rounded-[12px] text-lg sm:text-xl font-semibold outline-none focus:border-[#a8c529] transition-colors flex-shrink-0"
                                oninput="updateOtp()" onkeydown="moveBack(event, {{ $i }})"
                                onpaste="handleOtpPaste(event)" id="otp-{{ $i }}">
                        @endfor
                    </div>
                    @error('admin')
                        <span class="text-red-500 text-sm block -mt-4">{{ $message }}</span>
                    @enderror
                    @error('otp')
                        <span class="text-red-500 text-sm block -mt-4">{{ $message }}</span>
                    @enderror

                    <button type="submit"
    class="otp-button w-full max-w-[550px] h-[60px] font-semibold text-[16px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] shadow-md transition-opacity hover:opacity-90">
    Verify
</button>
                </form>
            </div>
        @else
            <h1 class="font-bold text-black uppercase text-2xl sm:text-3xl mb-8 sm:mb-12 text-center tracking-wide">
                {{ ucfirst($role) }} Administrator Verification
            </h1>

            <div class="bg-white border-[3px] border-[#c7da30] w-full max-w-[600px] px-6 sm:px-12 py-12 sm:py-16 rounded-[20px] text-center mx-auto">
                <form wire:submit.prevent="sendOtp" class="flex flex-col gap-8 items-center">
                    <input type="email" id="email" wire:model.live="email" placeholder="EMAIL ADDRESS"
                        class="w-full h-[60px] px-5 text-black border-[3px] border-[#c7da30] rounded-[10px] bg-white text-sm outline-none placeholder-gray-400 focus:border-[#a8c529] placeholder:tracking-wider">
                    @error('admin')
                        <span class="text-red-500 text-sm block -mt-4">{{ $message }}</span>
                    @enderror
                    @error('email')
                        <span class="text-red-500 text-sm block -mt-4">{{ $message }}</span>
                    @enderror

                    <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendOtp"
                        class="w-full h-[60px] font-semibold text-[16px]
                                   border-4 border-solid border-[#c7da30]
                                   rounded-[100px] text-[#38b6ff]
                                   shadow-md transition-opacity hover:opacity-90 disabled:opacity-60">
                        <span wire:loading.remove wire:target="sendOtp">Send OTP</span>
                        <span wire:loading wire:target="sendOtp">Sending OTP…</span>
                    </button>
                    <p wire:loading wire:target="sendOtp" class="text-sm text-gray-500 -mt-4">This can take up to a minute. Please wait.</p>
                </form>
            </div>
        @endif
        </div>
</main>

    <!-- Footer -->
    <!-- Footer (UNCHANGED) -->
    <footer class="relative w-full bg-[#757573] text-white py-8 mt-auto z-30 font-[Montserrat]" style="margin-top: 4rem; width: 100vw; max-width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
<div class="w-full px-4 min-[640px]:px-6 flex flex-col items-start justify-center text-left gap-6 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:items-center lg:px-[1vw]">
                <p class="text-[13px] leading-5 font-normal text-white min-[640px]:text-[14px] lg:text-[16px] w-full min-[640px]:w-auto flex justify-center min-[640px]:justify-start">
                <span class="text-center min-[640px]:text-left">
                    &copy; {{ date('Y') }} Tekete SafeSpace From Moepi <br class="min-[640px]:hidden">Publishing. All rights reserved.
                </span>
            </p>
<div class="w-full flex items-center justify-center flex-wrap gap-4 min-[640px]:w-auto min-[640px]:justify-start min-[640px]:gap-2 lg:gap-[1vw]">                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}"
                         class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition"
                         alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
            </div>
        </div>
    </footer>
 
    <!-- Scripts -->
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

        // Save the email as the user types
        document.addEventListener('input', function (e) {
            if (e.target.id === 'email') {
                sessionStorage.setItem('admin_email', e.target.value);
            }
        });

        // Restore it into Livewire whenever the page is (re)shown
        window.addEventListener('pageshow', function () {
            const email = sessionStorage.getItem('admin_email');
            if (!email) return;

            const restore = function (attemptsLeft) {
                if (window.Livewire && Livewire.first && Livewire.first()) {
                    const component = Livewire.first();
                    component.set('email', email, false);

                    const emailInput = document.getElementById('email');
                    if (emailInput) {
                        emailInput.value = email;
                    }
                } else if (attemptsLeft > 0) {
                    setTimeout(function () { restore(attemptsLeft - 1); }, 50);
                }
            };

            restore(20);
        });

        // Clear the saved email once verification succeeds
        document.addEventListener('livewire:navigated', function () {
            sessionStorage.removeItem('admin_email');
        });
    </script>

    <style>
        @media (max-width: 480px) {
            .otp-card {
                min-height: 254px !important;
                padding: 60px 12px !important;
                border-radius: 12px !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .otp-form {
                gap: 32px !important;
                width: 100%;
            }

            .otp-container {
    gap: 6px !important;
    padding: 0 !important;
}

            .otp-input {
    min-width: 42px !important;
    width: 42px !important;
    height: 52px !important;
    border-width: 2px !important;
    border-radius: 7px !important;
    font-size: 14px !important;
}

            .otp-button {
    max-width: 310px !important;
    height: 44px !important;
    border-width: 3px !important;
    font-size: 11px !important;
}
        }

        @media (min-width: 481px) and (max-width: 640px) {
            .otp-card {
                min-height: 254px !important;
                padding: 60px 12px !important;
                border-radius: 12px !important;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .otp-form {
                gap: 32px !important;
                width: 100%;
            }

            .otp-container {
                gap: 6px !important;
                padding: 0 !important;
            }

            .otp-input {
                width: 42px !important;
                min-width: 42px !important;
                height: 52px !important;
                border-width: 2px !important;
                border-radius: 7px !important;
                font-size: 14px !important;
            }

            .otp-button {
                max-width: 310px !important;
                height: 44px !important;
                border-width: 3px !important;
                font-size: 11px !important;
            }
        }
    </style>
</div>
