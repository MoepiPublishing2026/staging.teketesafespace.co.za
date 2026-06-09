<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full">

    <!-- Header -->
     <header
    class="fixed top-0 left-0 w-full bg-white z-50 shadow-sm">

    <div class="flex justify-between items-center w-full px-6 lg:px-8 py-2">

        <!-- Logo -->
        <div>
            <img src="{{ asset('images/logo.png') }}"
                alt="Safe Space Logo"
                class="w-[143px] h-auto flex-shrink-0">
        </div>

        <!-- Top Right Links -->
        <div class="flex items-center gap-4">

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-10"
                style="font-family: 'Montserrat', sans-serif; font-size: 17px;">

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
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    About Us
                </a>

                <a href="{{ route('contact-us') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Contact Us
                </a>

            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
                <button id="mobile-menu-button"
                    class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">

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
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

        <!-- Menu Panel -->
        <div class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="{{ asset('images/logo.png') }}" alt="Tekete SafeSpace" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Links -->
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Back</a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Home</a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">About Us</a>
                <a href="{{ route('download.nomination') }}" 
                           @click="menuOpen = false" 
                           class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">
                           Nomination Form
                 </a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Contact Us</a>
            </nav>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>

    <!-- Main Section -->
    <div class="flex-grow bg-white flex flex-col font-[Montserrat]" style="padding-top: 140px; padding-bottom: 80px; width: 100%;">

        <!-- Main Content -->
        <div class="w-full max-w-2xl px-4 mx-auto">
            <h1 class="text-3xl font-bold text-black mb-8 text-center uppercase" style="font-family: 'Montserrat', sans-serif; letter-spacing: 2px;">LOGIN PAGE</h1>

            <!-- Role Selection -->
           <div class="w-full px-2 md:px-0 md:justify-center justify-start items-start gap-4 md:gap-8 mt-2 mb-8 text-black text-[15px] flex flex-col sm:flex-row"
                 style="font-family: 'Montserrat', sans-serif;">
                <label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <input type="radio" wire:model="role" value="school" wire:change="resetForm" class="accent-[#c7da30]">
                    <span>School Administrator</span>
                </label>
                <!--<label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">-->
                <!--    <input type="radio" wire:model="role" value="district" wire:change="resetForm" class="accent-[#c7da30]">-->
                <!--    <span>District Administrator</span>-->
                <!--</label>-->
                <label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <input type="radio" wire:model="role" value="provincial" wire:change="resetForm" class="accent-[#c7da30]">
                    <span>Provincial Administrator</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer whitespace-nowrap">
                    <input type="radio" wire:model="role" value="national" wire:change="resetForm" class="accent-[#c7da30]">
                    <span>National Administrator</span>
                </label>
            </div>

            @error('role')
                <p class="text-red-500 text-sm mt-1 text-left">{{ $message }}</p>
            @enderror

            <!-- Outer Container -->
            <div class="border-4 border-[#c7da30] rounded-2xl p-8 bg-white">

                @if ($showOtpForm)
                    <!-- OTP Verification Form -->
                    <div class="w-full">
                        <h2 class="text-xl font-bold text-black uppercase mb-4 text-center" style="font-family: 'Montserrat', sans-serif;">Enter OTP</h2>
                        <p class="text-gray-600 text-sm mb-6 text-center" style="font-family: 'Montserrat', sans-serif;">
                            An OTP has been sent to your email address.
                        </p>

                        <form wire:submit.prevent="sendOtp" class="flex flex-col gap-5">
                            <input type="text" id="otp" wire:model.live="otp" placeholder="ENTER OTP"
                                   class="w-full py-4 px-4 text-gray-400 rounded-lg focus:outline-none uppercase"
                                   style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;" required>
                            @error('otp') 
                                <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;">{{ $message }}</span> 
                            @enderror

                            <button type="submit"
    class="w-full py-4 px-4
           border-4 border-solid border-[#c7da30]
           rounded-[100px] text-lg text-[#38b6ff]
           transition duration-150 ease-in-out hover:opacity-90
           font-[Montserrat]">
    Verify
</button>

                        </form>
                    </div>
                @else
                    <!-- Login Form -->
                    <div class="w-full">
                        <form wire:submit.prevent="login" class="flex flex-col gap-5">
                            <input type="text" id="username" wire:model.live="username" placeholder="Username"
                                   class="w-full py-4 px-4 text-gray-700 rounded-lg focus:outline-none"
                                   style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">
                            @error('username') 
                                <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;">{{ $message }}</span> 
                            @enderror

                            <div>
                                <input type="password" id="password" wire:model.live="password" placeholder="Password"
                                       class="w-full py-4 px-4 text-gray-700 rounded-lg focus:outline-none"
                                       style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">
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
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
            <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0;">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6 px-6 lg:px-8 w-full"
     style="font-family: 'Montserrat', sans-serif; font-size: 16px;">
                    <div>
                        <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
                    </div>
                    <div class="flex items-center justify-center flex-wrap gap-4 min-[520px]:gap-2 lg:gap-[1vw]">
                        <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                            <img src="{{ asset('images/youtube.png') }}"
                                 class="w-9 min-[520px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0 hover:opacity-80 transition"
                                 alt="YouTube">
                        </a>
                        <a href="https://www.X.com/moepipublishing" target="_blank">
                            <img src="{{ asset('images/X.png') }}" alt="X"
                                 class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[520px]:min-w-0">
                        </a>
                        <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                            <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn"
                                 class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[520px]:min-w-0">
                        </a>
                        <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                            <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                                 class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                        </a>
                        <a href="https://www.instagram.com/moepipublishing" target="_blank">
                            <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                                 class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                        </a>
                        <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                            <img src="{{ asset('images/tiktok.png') }}" alt="TikTok"
                                 class="w-5 h-5 min-[520px]:w-4 min-[520px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[520px]:min-w-0">
                        </a>
                    </div>
            
            </footer>

</div>
