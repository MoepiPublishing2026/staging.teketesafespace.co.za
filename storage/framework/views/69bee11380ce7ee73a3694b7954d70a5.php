<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full">
    <!-- Header -->
    <header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2"
             style="max-width: 1280px; margin: 0 auto;">
            <!-- Logo -->
            <div>
                <img src="<?php echo e(asset('images/logo.png')); ?>" 
                     alt="Safe Space Logo" 
                     style="width: 110px; height: auto;">
            </div>
            
            <!-- Top Right Links -->
            <div class="flex items-center gap-4">
                <!-- Desktop Navigation -->
                <div class="hidden md:flex gap-8" 
                     style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                    <!-- Back Button -->
                    <a href="javascript:void(0);" 
                       onclick="window.history.back();" 
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       Back
                    </a>
                    <a href="<?php echo e(route('landing-page')); ?>" 
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       Home
                    </a>
                     <a href="<?php echo e(route('about-us')); ?>"
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       About Us
                    </a>
                    <a href="<?php echo e(route('contact-us')); ?>"
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       Contact Us
                    </a>
                </div>
                
                <!-- Mobile Hamburger Menu -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="<?php echo e(route('landing-page')); ?>" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="<?php echo e(route('landing-page')); ?>#about" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="<?php echo e(route('landing-page')); ?>#section" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Section -->
    <div class="min-h-screen bg-white flex flex-col font-[Montserrat] justify-center items-center" style="padding-top: 60px; width: 100%;">
        
        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center text-center px-4">
            <!-- Heading -->
            <h1 class="text-[24px] sm:text-[24px] font-bold text-black uppercase mb-6 sm:mb-8">
                Types of Report
            </h1>

            <!-- Reporting Status -->
            <p class="text-[15px] sm:text-[15px] font-bold text-black mb-6">
                <!--[if BLOCK]><![endif]--><?php if($isAnonymous): ?>
                    You are reporting anonymously
                <?php else: ?>
                    You are reporting with details
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </p>

            <!-- Outer Box -->
            <div class="w-full max-w-[698px] border-2 border-[#c7da30] rounded-xl bg-white p-6 sm:p-10 flex flex-col items-center justify-center">
                <!-- Abuse Type Buttons -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 sm:gap-x-16 gap-y-4 sm:gap-y-8 w-full justify-items-center">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $abuseTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abuseType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button 
            wire:click="selectAbuseType(<?php echo e($abuseType->id); ?>)"
            class="w-full sm:w-[245px] h-[55px] sm:h-[65px] 
                   border-4 border-solid border-[#c7da30]
                   rounded-[100px] text-[#38b6ff] 
                   text-[14px] sm:text-[15px] font-normal 
                   transition duration-200 hover:opacity-80 shadow-md">
            <?php echo e($abuseType->type_name); ?>

        </button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
            <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 4rem;">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
                     style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
                    <div>
                        <p>&copy; <?php echo e(date('Y')); ?> Safe Space from Moepi Publishing. All rights reserved.</p>
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
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/public/resources/views/livewire/abuse-type-selection.blade.php ENDPATH**/ ?>