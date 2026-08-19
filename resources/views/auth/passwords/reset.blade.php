<x-layouts.app>
    <style>
        .icon-container {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .icon-container svg {
            color: #d1d5db;
        }

        .icon-container:hover svg {
            color: #9ca3af;
        }

        .password-input-wrapper {
            position: relative;
        }

        .password-requirements {
            border-left: 4px solid #c7da30;
            padding: 0.5rem 1rem;
            margin-top: 0.5rem;
            background-color: #f7ffe4;
        }
    </style>

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

    <div class="min-h-screen bg-white flex flex-col items-center justify-center font-[Montserrat] px-4 mt-20">
        
     <h2 class="text-2xl font-bold mb-6 text-gray-800 uppercase text-center">
                        Reset Password
                    </h2>
    <div class="w-full max-w-[600px] border-2 border-[#c7da30] rounded-xl bg-white p-6 sm:p-10 flex flex-col items-center justify-center">

            <div class="w-full max-w-lg mx-auto">
                
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                      <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email ?? request()->email }}">

    <div class="mb-4">
        <label for="email" class="block font-[Montserrat] text-gray-700 text-sm font-bold mb-2">
            Email Address
        </label>
        <input id="email" type="email"
            style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;"
            class="shadow appearance-none border rounded w-full py-4 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="email" value="{{ $email ?? request()->email }}" required readonly>
    </div>

                       <div class="mb-4">
    <label for="password" class="block font-[Montserrat] text-gray-700 text-sm font-bold mb-2">
       Enter new password
    </label>

    <div class="password-input-wrapper relative @error('password') border-red-500 @enderror"
        style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">

        <input id="password" type="password"
            class="shadow appearance-none border-0 w-full py-4 px-4 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-transparent"
            name="password" placeholder="New password" required autocomplete="new-password">

        <span class="icon-container" onclick="togglePasswordVisibility('password', this)">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                <path fill-rule="evenodd" d="M.661 10.322l1.642-1.996C3.993 6.002 6.784 4 10 4c3.216 0 6.007 2.002 7.697 4.326l1.642 1.996a.75.75 0 010 1.356l-1.642 1.996C16.007 16.998 13.216 19 10 19c-3.216 0-6.007-2.002-7.697-4.326l-1.642-1.996a.75.75 0 010-1.356zM10 17.5a6.5 6.5 0 100-13 6.5 6.5 0 000 13z" clip-rule="evenodd" />
            </svg>
        </span>
    </div>

    @error('password')
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>

        @php
            $isConfirmationError = strpos($message, 'confirmation does not match') !== false;
        @endphp

        @if (!$isConfirmationError)
            <div class="password-requirements text-sm text-gray-700 rounded-lg">
                <p class="font-bold text-gray-800 mb-1">Password Requirements:</p>
                <ul class="list-disc list-inside space-y-0">
                    <li>Minimum 8 characters, maximum 50 characters.</li>
                    <li>Must contain at least one uppercase letter.</li>
                    <li>Must contain at least one number.</li>
                    <li>Must contain at least one special character.</li>
                </ul>
            </div>
        @endif
    @enderror
</div>

                        <div class="mb-6">
                            <label for="password-confirm" class="block font-[Montserrat] text-gray-700 text-sm font-bold mb-2">
                                Confirm password
                            </label>

                            <div class="password-input-wrapper relative">
                                <input id="password-confirm" type="password"
                                    class="shadow appearance-none border rounded w-full py-4 px-4 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;"
                                    name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">

                                <span class="icon-container" onclick="togglePasswordVisibility('password-confirm', this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd" d="M.661 10.322l1.642-1.996C3.993 6.002 6.784 4 10 4c3.216 0 6.007 2.002 7.697 4.326l1.642 1.996a.75.75 0 010 1.356l-1.642 1.996C16.007 16.998 13.216 19 10 19c-3.216 0-6.007-2.002-7.697-4.326l-1.642-1.996a.75.75 0 010-1.356zM10 17.5a6.5 6.5 0 100-13 6.5 6.5 0 000 13z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full font-[Montserrat] py-4 px-4 border-4 border-[#c7da30] rounded-[100px] text-lg text-[#38b6ff] transition hover:opacity-90">
                            Confirm
                        </button>
                    </form>

                </div>
            
        </div>
    </div>
 <!-- ================= FOOTER ================= -->
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
        function togglePasswordVisibility(inputId, iconContainer) {
            const passwordInput = document.getElementById(inputId);
            const icon = iconContainer.querySelector('.eye-icon');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                icon.innerHTML = `<path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" /><path fill-rule="evenodd" d="M.661 10.322l1.642-1.996C3.993 6.002 6.784 4 10 4c3.216 0 6.007 2.002 7.697 4.326l1.642 1.996a.75.75 0 010 1.356l-1.642 1.996C16.007 16.998 13.216 19 10 19c-3.216 0-6.007-2.002-7.697-4.326l-1.642-1.996a.75.75 0 010-1.356zM10 17.5a6.5 6.5 0 100-13 6.5 6.5 0 000 13z" clip-rule="evenodd" />`;
            } else {
                icon.innerHTML = `<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14.5 10a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" clip-rule="evenodd" />`;
            }
        }

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
       
    </script>
</x-layouts.app>