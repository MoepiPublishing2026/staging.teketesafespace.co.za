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

                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
                    class="text-black transition-colors hover:!text-[#c7da30]">
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

            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">About Us</a>
            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Workshops</a>
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Contact Us</a>

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
    // Livewire's actual `username` / `password` state is
    // empty -> clicking Login immediately fails validation.
    //
    // Fix: persist the values to sessionStorage as the user types,
    // then on pageshow (fires on every load, including bfcache
    // restores) push those values back into the live Livewire
    // component so its real state matches what's on screen.
    // ---------------------------------------------------------------

    // Save credentials as the user types.
    document.addEventListener('input', function (e) {
        if (e.target.id === 'username' || e.target.id === 'password') {
            sessionStorage.setItem('login_' + e.target.id, e.target.value);
        }
    });

    // Restore values into Livewire whenever the page is (re)shown
    window.addEventListener('pageshow', function () {
        const username = sessionStorage.getItem('login_username');
        const password = sessionStorage.getItem('login_password');
        if (!username && !password) {
            return;
        }

        const restore = function (attemptsLeft) {
            if (window.Livewire && Livewire.first && Livewire.first()) {
                const component = Livewire.first();

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
    });
</script>

    <!-- Main Section -->
  <div class="min-h-screen bg-white flex flex-col font-[Montserrat]
            justify-center items-center
            w-full
            pt-[90px]
            sm:pt-[150px]
            md:pt-[130px]
            lg:pt-[150px]
            pb-[40px]
            sm:pb-[80px]">

        <!-- Main Content -->
        <div class="w-full max-w-2xl px-4 mx-auto">
            <h1 class="text-3xl font-bold text-black mb-8 text-center uppercase" style="font-family: 'Montserrat', sans-serif; letter-spacing: 2px;">LOGIN PAGE</h1>

            @if(request()->boolean('session_expired'))
                <div class="mb-6 rounded-lg border-2 border-[#c7da30] bg-[#f7fcd4] px-4 py-3 text-center text-sm text-[#4a5e00]"
                     style="font-family: 'Montserrat', sans-serif;">
                    Your session ended due to inactivity. Please sign in again.
                </div>
            @endif

            <!-- Outer Container -->
            <div class="border-4 border-[#c7da30] rounded-2xl p-8 bg-white">
                <div class="w-full">
                    <form wire:submit.prevent="login" class="flex flex-col gap-5">
                            <input type="text" id="username" wire:model="username" placeholder="USERNAME"
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
                            @if ($this instanceof \App\Livewire\AdminLoginForm && !$this->captchaPassed && !$showCaptcha)
                                <div wire:loading.flex wire:target="login" class="fixed inset-0 z-[300] items-center justify-center bg-black/60 p-4" role="status">
                                    <div class="rounded-xl bg-white px-6 py-5 font-semibold text-gray-800 shadow-xl">Preparing security check…</div>
                                </div>
                            @endif
                            @if ($this instanceof \App\Livewire\AdminLoginForm && $showCaptcha)
                                <div class="fixed inset-0 z-[300] flex items-center justify-center bg-black/60 p-4" role="dialog" aria-modal="true" aria-labelledby="captcha-title">
                                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                                        <h2 id="captcha-title" class="text-xl font-bold text-gray-900">Security check</h2>
                                        @if ($this->captchaPassed)
                                            <div class="mt-5 rounded-xl border border-green-200 bg-green-50 p-5 text-center" role="status" aria-live="polite">
                                                <span class="text-4xl text-green-700" aria-hidden="true">✓</span>
                                                <p class="mt-2 font-semibold text-green-800">Security check passed.</p>
                                                <p class="mt-1 text-sm text-green-700">Signing you in…</p>
                                            </div>
                                        @else
                                            <p class="mt-2 text-sm text-gray-600">Complete the security check to continue.</p>
                                            @if ($captchaError)
                                                <p class="mt-3 text-sm text-red-600" role="alert">{{ $captchaError }}</p>
                                            @endif
                                            <div wire:ignore class="mt-5 flex justify-center">
                                                <div id="admin-login-turnstile"
                                                     data-sitekey="{{ config('turnstile.site_key') }}"
                                                     data-component-id="{{ $this->getId() }}"></div>
                                            </div>
                                            @if (!config('turnstile.site_key'))
                                                <p class="mt-3 text-sm text-red-600" role="alert">Security verification is not configured. Please contact the site administrator.</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if ($this instanceof \App\Livewire\AdminLoginForm)
                                <div class="absolute -left-[10000px] top-auto h-px w-px overflow-hidden" aria-hidden="true">
                                    <label for="website">Leave this field empty</label>
                                    <input type="text" id="website" wire:model="website" name="website"
                                           tabindex="-1" autocomplete="off">
                                </div>
                            @endif
                            <div class="text-right mt-2">
        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline" style="font-family: 'Montserrat', sans-serif;">Forgot password?</a>
    </div>
</div>

                            @error('login') 
                                <span class="text-red-500 text-sm block" style="font-family: 'Montserrat', sans-serif;">{{ $message }}</span> 
                            @enderror
                            @if ($this instanceof \App\Livewire\AdminLoginForm && $this->isLocked)
                                <p class="text-center text-sm font-semibold text-red-700" role="timer" aria-live="off">
                                    You can try again in <span data-lockout-until="{{ $this->lockoutUntil }}" class="font-mono text-base">00:00</span>.
                                </p>
                            @endif

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

            <x-site-footer />
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

    function updateAdminLoginCountdowns() {
        document.querySelectorAll('[data-lockout-until]').forEach(function (timer) {
            const remaining = Math.max(0, Math.ceil((Number(timer.dataset.lockoutUntil) - Date.now()) / 1000));
            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;
            timer.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        });
    }

    updateAdminLoginCountdowns();
    setInterval(updateAdminLoginCountdowns, 1000);
    window.addEventListener('pageshow', updateAdminLoginCountdowns);
    (function () {
        let widgetId = null;
        let renderedContainer = null;

        function renderAdminTurnstile() {
            const container = document.getElementById('admin-login-turnstile');
            if (!container || !window.turnstile || !container.dataset.sitekey) return;
            if (renderedContainer === container && widgetId !== null) return;

            renderedContainer = container;
            widgetId = window.turnstile.render(container, {
                sitekey: container.dataset.sitekey,
                action: 'admin_login',
                callback: function (turnstileToken) {
                    const component = window.Livewire && Livewire.find(container.dataset.componentId);
                    if (component) component.call('verifyTurnstile', turnstileToken);
                },
                'error-callback': function () {
                    const component = window.Livewire && Livewire.find(container.dataset.componentId);
                    if (component) component.set('captchaError', 'The security check could not load. Please try again.');
                },
                'expired-callback': function () {
                    if (widgetId !== null && window.turnstile) window.turnstile.reset(widgetId);
                }
            });
        }

        function resetAdminTurnstile() {
            if (widgetId !== null && window.turnstile) window.turnstile.reset(widgetId);
        }

        window.addEventListener('admin-turnstile-open', function () {
            window.setTimeout(renderAdminTurnstile, 0);
            window.setTimeout(renderAdminTurnstile, 150);
        });
        window.addEventListener('admin-turnstile-reset', resetAdminTurnstile);
        window.onTurnstileLoaded = renderAdminTurnstile;
        document.addEventListener('livewire:navigated', renderAdminTurnstile);
        window.addEventListener('load', renderAdminTurnstile);
    })();
            </script>
            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit&onload=onTurnstileLoaded" async defer></script>

</div>
