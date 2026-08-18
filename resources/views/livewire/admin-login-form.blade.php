<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full">

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

    <!-- Mobile Menu -->
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

    // ---------------------------------------------------------------
    // Fix: restore login form state when navigating Back from the
    // OTP/verification page (or any back/forward-cache restore).
    //
    // Why this is needed: window.history.back() / bfcache restores the
    // *visual* DOM exactly as it looked before navigating away, but
    // Livewire reconnects to a brand-new server-side component with
    // empty/default properties. So the fields LOOK filled in, but
    // Livewire's actual `role` / `username` / `password` state is
    // empty -> clicking Login immediately fails validation.
    //
    // Fix: persist the values to sessionStorage as the user types,
    // then on pageshow (fires on every load, including bfcache
    // restores) push those values back into the live Livewire
    // component so its real state matches what's on screen.
    // ---------------------------------------------------------------

    // Save values as the user types/selects
    document.addEventListener('input', function (e) {
        if (e.target.id === 'username' || e.target.id === 'password') {
            sessionStorage.setItem('login_' + e.target.id, e.target.value);
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.name === 'role') {
            sessionStorage.setItem('login_role', e.target.value);
        }
    });

    // Restore values into Livewire whenever the page is (re)shown
    window.addEventListener('pageshow', function () {
        const username = sessionStorage.getItem('login_username');
        const password = sessionStorage.getItem('login_password');
        const role = sessionStorage.getItem('login_role');

        if (!username && !password && !role) {
            return;
        }

        const restore = function (attemptsLeft) {
            if (window.Livewire && Livewire.first && Livewire.first()) {
                const component = Livewire.first();

                if (role) {
                    component.set('role', role, false);

                    const roleRadio = document.querySelector(
                        'input[name="role"][value="' + role + '"]'
                    );
                    if (roleRadio) {
                        roleRadio.checked = true;
                    }
                }

                if (username) component.set('username', username, false);
                if (password) component.set('password', password, false);
            } else if (attemptsLeft > 0) {
                setTimeout(function () { restore(attemptsLeft - 1); }, 50);
            }
        };

        restore(20);
    });

    // Clear saved values once login succeeds so they don't linger
    // for the next person who uses this device/browser.
    document.addEventListener('livewire:navigated', function () {
        sessionStorage.removeItem('login_username');
        sessionStorage.removeItem('login_password');
        sessionStorage.removeItem('login_role');
    });
</script>

    <!-- Main Section -->
  <div class="min-h-screen bg-white flex flex-col font-[Montserrat]
            justify-center items-center
            w-full
            pt-[90px]
            sm:pt-[100px]
            md:pt-[90px]
            lg:pt-[100px]">

        <!-- Main Content -->
        <div class="w-full max-w-2xl px-4 mx-auto">
            <h1 class="text-3xl font-bold text-black mb-8 text-center uppercase" style="font-family: 'Montserrat', sans-serif; letter-spacing: 2px;">LOGIN PAGE</h1>

            @if(request()->boolean('session_expired'))
                <div class="mb-6 rounded-lg border-2 border-[#c7da30] bg-[#f7fcd4] px-4 py-3 text-center text-sm text-[#4a5e00]"
                     style="font-family: 'Montserrat', sans-serif;">
                    Your session ended due to inactivity. Please sign in again.
                </div>
            @endif

            <!-- Role Selection -->
           <div class="w-full px-2 md:px-0 md:justify-center justify-start items-start gap-4 md:gap-8 mt-2 mb-8 text-black text-[15px] flex flex-col sm:flex-row"
                 style="font-family: 'Montserrat', sans-serif;">
                <label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <input type="radio" name="role" wire:model.live="role" value="school" wire:change="resetForm" class="accent-[#c7da30]">
                    <span>School Administrator</span>
                </label>
                <!--<label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">-->
                <!--    <input type="radio" wire:model="role" value="district" wire:change="resetForm" class="accent-[#c7da30]">-->
                <!--    <span>District Administrator</span>-->
                <!--</label>-->
                <label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <input type="radio" name="role" wire:model.live="role" value="provincial" wire:change="resetForm" class="accent-[#c7da30]">
                    <span>Provincial Administrator</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <input type="radio" name="role" wire:model.live="role" value="national" wire:change="resetForm" class="accent-[#c7da30]">
                    <span>National Administrator</span>
                </label>
            </div>

            @error('role')
                <p class="text-red-500 text-sm mt-1 text-left">{{ $message }}</p>
            @enderror

            <!-- Outer Container -->
            <div class="border-4 border-[#c7da30] rounded-2xl p-8 bg-white">
                <div class="w-full">
                    <form wire:submit.prevent="login" class="flex flex-col gap-5">
                            <input type="text" id="username" wire:model.live="username" placeholder="USERNAME"
                                   class="w-full py-4 px-4 text-gray-700 rounded-lg focus:outline-none"
                                   style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">
                            @error('username') 
                                <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;">{{ $message }}</span> 
                            @enderror

                           <div>
    <div class="relative w-full">
        <input type="password" id="password" wire:model.blur="password" placeholder="PASSWORD"
               class="w-full py-4 pl-4 pr-12 text-gray-700 rounded-lg focus:outline-none"
               style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">
        
        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-black focus:outline-none">
            <svg id="eye-show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg id="eye-hide" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        </button>
    </div>

    @error('password') 
        <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;">{{ $message }}</span> 
    @enderror
    <div class="text-right mt-2">
        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline" style="font-family: 'Montserrat', sans-serif;">Forgot password?</a>
    </div>
</div>

                            @error('login') 
                                <span class="text-red-500 text-sm block" style="font-family: 'Montserrat', sans-serif;">{{ $message }}</span> 
                            @enderror

                            <button type="submit"
    class="w-full py-4 px-4
           border-4 border-solid border-[#c7da30]
           rounded-[100px] text-lg text-[#38b6ff]
           transition duration-150 ease-in-out hover:opacity-90
           font-[Montserrat]">
    Login
</button>

                        </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
            <script>
                function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeShow = document.getElementById('eye-show');
        const eyeHide = document.getElementById('eye-hide');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeShow.classList.add('hidden');
            eyeHide.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeShow.classList.remove('hidden');
            eyeHide.classList.add('hidden');
        }
    }
            </script>

</div>
