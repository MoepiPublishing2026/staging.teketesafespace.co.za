<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full">

    <!-- Header -->
    <header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            
            <!-- Logo -->
            <div>
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 110px; height: auto;">
            </div>

            <!-- Desktop Links -->
            <div class="hidden md:flex gap-8 text-[17px]" style="font-family: 'Montserrat', sans-serif; color: black;">
                <a href="javascript:void(0);" onclick="window.history.back();" class="transition-colors hover:text-[#c7da30]" style="text-decoration: none;">Back</a>
                <a href="<?php echo e(route('landing-page')); ?>" class="transition-colors hover:text-[#c7da30]" style="text-decoration: none;">Home</a>
                <a href="<?php echo e(route('about-us')); ?>" class="transition-colors hover:text-[#c7da30]" style="text-decoration: none;">About Us</a>
                 <a href="<?php echo e(route('download.nomination')); ?>"
                       @click="menuOpen = false" 
                       class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">
                       Nomination Form
                    </a>

                <a href="<?php echo e(route('contact-us')); ?>" class="transition-colors hover:text-[#c7da30]" style="text-decoration: none;">Contact Us</a>
            </div>

            <!-- Mobile Hamburger Menu -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
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
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Links -->
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Back</a>
                <a href="<?php echo e(route('landing-page')); ?>" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Home</a>
                <a href="<?php echo e(route('landing-page')); ?>#about" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">About Us</a>
                <a href="<?php echo e(route('download.nomination')); ?>" 
                           @click="menuOpen = false" 
                           class="text-black text-[17px] mb-4 hover:text-[#c7da30] transition-colors">
                           Nomination Form
                 </a>
                <a href="<?php echo e(route('landing-page')); ?>#section" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">Contact Us</a>
            </nav>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }
    </script>

    <!-- Main Section -->
    <div class="min-h-screen bg-white flex flex-col font-[Montserrat]" style="padding-top: 140px; padding-bottom: 80px; width: 100%;">

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

            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1 text-left"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

            <!-- Outer Container -->
            <div class="border-4 border-[#c7da30] rounded-2xl p-8 bg-white">

                <!--[if BLOCK]><![endif]--><?php if($showOtpForm): ?>
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
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

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
                <?php else: ?>
                    <!-- Login Form -->
                    <div class="w-full">
                        <form wire:submit.prevent="login" class="flex flex-col gap-5">
                            <input type="text" id="username" wire:model.live="username" placeholder="Username"
                                   class="w-full py-4 px-4 text-gray-700 rounded-lg focus:outline-none"
                                   style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                            <div>
                                <input type="password" id="password" wire:model.live="password" placeholder="Password"
                                       class="w-full py-4 px-4 text-gray-700 rounded-lg focus:outline-none"
                                       style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px; background-color: white;">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                    <span class="text-red-500 text-sm block mt-1" style="font-family: 'Montserrat', sans-serif;"><?php echo e($message); ?></span> 
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="text-right mt-2">
                                    <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-blue-600 hover:underline" style="font-family: 'Montserrat', sans-serif;">Forgot password?</a>
                                </div>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-500 text-sm block" style="font-family: 'Montserrat', sans-serif;"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

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
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!-- Footer -->
            <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 4rem;">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
                     style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
                    <div>
                        <p>&copy; <?php echo e(date('Y')); ?> Tekete Safe Space from Moepi Publishing. All rights reserved.</p>
                    </div>
                    <div class="flex items-center gap-4 order-2">
                 <a href=" https://www.youtube.com/@matauramapuputla6836"target="_blank">
                 <img src="<?php echo e(asset('images/youtube.png')); ?>" alt="YouTube Icon" style="width: 30px; height: 30px; left:1024.8; top: 701.8
;">   
</a>
                 <a href="https://www.X.com/moepipublishing" target="_blank">
               <img src="<?php echo e(asset('images/X.png')); ?>" alt="X Icon" style="width: 30px; height: 30px;left:1024.8 ; top:701.8; ">
                 </a>
               
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" >
               <img src="<?php echo e(asset('images/linkedIn.png')); ?>" alt="LinkedIn Icon" style="width: 30px; height: 30px;left: 1128.6
; top:701.1;">
                </a>
               <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
               <img src="<?php echo e(asset('images/facebook.png')); ?>" 
               alt="Facebook Icon" 
               style="width: 35.2px; height: 30px;left: 1179.7;top: 701.1;">
            </a>
               
               <a href="https://www.instagram.com/moepipublishing" target="_blank">
                <img src="<?php echo e(asset('images/instagram.png')); ?>" 
                alt="Instagram Icon" 
                style="width: 35.2px; height: 30px; left: 1225.7px; top: 701.1px;">
               </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
               <img src="<?php echo e(asset('images/tiktok.png')); ?>" alt="TikTok Icon" style="width: 35.2px; height: 30px;left:1271.7 ;top:700.1;"></a>
            </div>
                    
            </footer>

</div>
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/livewire/admin-login-form.blade.php ENDPATH**/ ?>