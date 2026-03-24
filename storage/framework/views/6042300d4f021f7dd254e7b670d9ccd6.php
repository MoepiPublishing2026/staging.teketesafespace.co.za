<div class="contact-page-livewire-container overflow-x-hidden w-full">

<!-- Mobile Fixed Navbar ONLY -->
<header class="md:hidden fixed top-0 left-0 w-full bg-white z-50 shadow-sm px-6 h-16 flex items-center font-[Montserrat]">
    <div class="flex justify-between items-center max-w-[1280px] mx-auto w-full">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="w-[135px] h-auto flex-shrink-0">

        <button id="mobile-menu-button" class="p-2 rounded-md text-black hover:bg-gray-100 transition">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</header>

<!-- Desktop Navbar -->
<div class="hidden md:flex md:items-center md:justify-between px-6 lg:px-20 py-4 bg-white font-[Montserrat]">
    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="w-[150px] h-auto">

    <div class="flex gap-8 text-[17px] font-[Montserrat] text-black ml-auto">
        <a href="<?php echo e(url('/')); ?>" class="hover:text-[#c7da30] transition-colors">Home</a>
        <a href="<?php echo e(url('/about-us')); ?>" class="hover:text-[#c7da30] transition-colors">About Us</a>
        <a href="<?php echo e(url('/contact-us')); ?>" class="font-bold text-black">Contact Us</a>
    </div>
</div>

<!-- MOBILE MENU -->
<div id="mobile-menu" class="fixed inset-0 z-[60] hidden md:hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

    <div id="mobile-menu-slide" class="absolute top-0 right-0 h-full w-64 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out">

        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <img src="<?php echo e(asset('images/logo.png')); ?>" class="h-8 w-auto">

            <button onclick="toggleMobileMenu()" class="p-2 hover:bg-gray-100 rounded-full transition">
                <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="mt-8 px-6 space-y-4 pb-8 text-[17px] font-[Montserrat]">
            <a href="<?php echo e(url('/')); ?>" class="block py-3 text-black border-b border-gray-100">Home</a>
            <a href="<?php echo e(url('/about-us')); ?>" class="block py-3 text-black border-b border-gray-100">About Us</a>
            <a href="<?php echo e(url('/contact-us')); ?>" class="block py-3 font-bold text-black border-b border-gray-100">Contact Us</a>
        </nav>

    </div>
</div>

<!-- PAGE CONTENT -->
<section class="pt-24 md:pt-12 pb-10 px-4 sm:px-10 lg:px-16 relative">

<div class="relative max-w-[1280px] mx-auto min-h-[700px]">

<!-- LEFT CONTENT -->
<div class="relative z-20 max-w-[500px]">

<h1 class="font-[Montserrat] font-bold text-[32px] sm:text-[50px] text-[#000000]">
CONTACT US
</h1>

<div class="w-[200px] sm:w-[345px] h-[7px] bg-[#c7da30] mt-2 mb-8"></div>

<div class="flex items-center gap-4 mb-4">
<img src="<?php echo e(asset('images/phone icon.png')); ?>" class="w-[26px] h-[26px]">
<span class="text-[16px] sm:text-xl text-[#000000]">087 265 6716</span>
</div>

<div class="flex items-center gap-4 mb-4">
<img src="<?php echo e(asset('images/email icon.png')); ?>" class="w-[26px] h-[18px]">
<a href="mailto:support@tekete.co.za" class="text-[16px] sm:text-xl text-[#000000] hover:text-[#c7da30]">
support@tekete.co.za
</a>
</div>

<div class="flex items-center gap-4 mb-8">
<img src="<?php echo e(asset('images/email icon.png')); ?>" class="w-[26px] h-[18px]">
<a href="mailto:sales@teketesafespace.co.za" class="text-[16px] sm:text-xl text-[#000000] hover:text-[#c7da30]">
sales@teketesafespace.co.za
</a>
</div>

<h2 class="font-[Montserrat] font-medium text-[18px] sm:text-[20px] text-[#000000] mb-6">
Download the Tekete Safe Space App
</h2>

<!-- MOBILE DOWNLOAD BUTTONS + GREEN GRAPHIC -->
<div class="lg:hidden flex items-center justify-between gap-4">

<div class="flex flex-col gap-4">

<a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank">
<img src="<?php echo e(asset('images/Apple App store.png')); ?>" class="w-[155px] h-[90px] object-contain">
</a>

<a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank">
<img src="<?php echo e(asset('images/Google Play Store.png')); ?>" class="w-[155px] h-[90px] object-contain">
</a>

<a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank">
<img src="<?php echo e(asset('images/Huawei AppGallery.png')); ?>" class="w-[155px] h-[60px] object-contain">
</a>

</div>

<img src="<?php echo e(asset('images/futuristic digital frame tech.png')); ?>" class="w-[170px] sm:w-[300px] h-auto">

</div>

<!-- MOBILE PHONE (MOVED UP MORE) -->
<div class="lg:hidden flex justify-center mt-2 mb-2">
<img src="<?php echo e(asset('images/social media phone1.png')); ?>" class="w-[360px] sm:w-[420px] h-auto">
</div>



<!-- DESKTOP DOWNLOAD BUTTONS (UNCHANGED) -->
<div class="hidden lg:flex flex-col sm:flex-row gap-6 items-center pt-2">

<a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank">
<img src="<?php echo e(asset('images/Apple App store.png')); ?>" class="w-[155px] h-[90px] object-contain">
</a>

<a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank">
<img src="<?php echo e(asset('images/Google Play Store.png')); ?>" class="w-[155px] h-[90px] object-contain">
</a>

<a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank">
<img src="<?php echo e(asset('images/Huawei AppGallery.png')); ?>" class="w-[155px] h-[60px] object-contain">
</a>

</div>

</div>

<!-- DESKTOP GRAPHICS (UNCHANGED) -->
<div class="hidden lg:block absolute right-0 top-10 z-10 pointer-events-none">
<img src="<?php echo e(asset('images/futuristic digital frame tech.png')); ?>" class="w-[400px] xl:w-[459px] h-auto">
</div>

<div class="hidden lg:block absolute right-[320px] top-0 z-20 pointer-events-none">
<img src="<?php echo e(asset('images/social media phone1.png')); ?>" class="w-[400px] xl:w-[540px] h-auto">
</div>

</div>
</section>

<!-- FOOTER -->
<footer class="w-full bg-[#808080] text-white py-6 mt-12">

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6 max-w-[1280px] mx-auto text-[14px] sm:text-[16px]">

<div>
<p>© <?php echo e(date('Y')); ?> Tekete Safe Space from Moepi Publishing. All rights reserved.</p>
</div>

<div class="flex flex-wrap items-center gap-4">

<a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
<img src="<?php echo e(asset('images/youtube.png')); ?>" class="w-[30px]">
</a>

<a href="https://x.com/moepipublishing" target="_blank">
<img src="<?php echo e(asset('images/X.png')); ?>" class="w-[30px]">
</a>

<a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
<img src="<?php echo e(asset('images/linkedIn.png')); ?>" class="w-[30px]">
</a>

<a href="https://www.facebook.com/MoepiPublishing" target="_blank">
<img src="<?php echo e(asset('images/facebook.png')); ?>" class="w-[35px]">
</a>

<a href="https://www.instagram.com/moepipublishing" target="_blank">
<img src="<?php echo e(asset('images/instagram.png')); ?>" class="w-[35px]">
</a>

<a href="https://www.tiktok.com/@moepipublishing" target="_blank">
<img src="<?php echo e(asset('images/tiktok.png')); ?>" class="w-[35px]">
</a>

</div>
</div>

</footer>

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

setTimeout(() => {
menu.classList.add('hidden');
}, 300);

document.body.style.overflow = '';

}

}

document.addEventListener('DOMContentLoaded', function() {

const btn = document.getElementById('mobile-menu-button');

if (btn) btn.addEventListener('click', toggleMobileMenu);

});

</script>

</div><?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/livewire/contact-us.blade.php ENDPATH**/ ?>