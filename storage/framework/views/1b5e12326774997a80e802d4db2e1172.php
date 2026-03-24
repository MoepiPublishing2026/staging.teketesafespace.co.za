<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full overflow-x-hidden">

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- ================= HEADER ================= -->
    <header class="fixed top-0 left-0 w-full bg-white z-50 shadow-sm">
        <div class="flex justify-between items-center px-4 sm:px-8 py-2 max-w-7xl mx-auto">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="w-[110px] h-auto">

            <div class="flex items-center gap-4">
                <!-- Desktop Nav -->
                <div class="hidden md:flex gap-8 text-[17px] text-black font-[Montserrat]">
                    <a href="javascript:void(0);" onclick="window.history.back();" class="hover:text-[#c7da30] transition-colors">Back</a>
                    <a href="<?php echo e(route('landing-page')); ?>" class="hover:text-[#c7da30] transition-colors">Home</a>
                    <a href="<?php echo e(route('about-us')); ?>" class="hover:text-[#c7da30] transition-colors">About Us</a>
                    <a href="<?php echo e(route('contact-us')); ?>" class="hover:text-[#c7da30] transition-colors">Contact Us</a>
                </div>

                <!-- Mobile Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-md text-black hover:bg-gray-100 focus:ring-2 focus:ring-[#c7da30]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= MOBILE MENU ================= -->
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

        <div class="absolute top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300">
            <div class="flex justify-between items-center p-4 border-b">
                <img src="<?php echo e(asset('images/logo.png')); ?>" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 hover:bg-gray-100 rounded">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-6 px-4 space-y-4 text-[17px] font-[Montserrat]">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();"
                    class="block text-black hover:text-[#c7da30] transition-colors">Back</a>
                <a href="<?php echo e(route('landing-page')); ?>" onclick="toggleMobileMenu()"
                    class="block text-black hover:text-[#c7da30] transition-colors">Home</a>
                <a href="<?php echo e(route('landing-page')); ?>#about" onclick="toggleMobileMenu()"
                    class="block text-black hover:text-[#c7da30] transition-colors">About Us</a>
                <a href="<?php echo e(route('landing-page')); ?>#section" onclick="toggleMobileMenu()"
                    class="block text-black hover:text-[#c7da30] transition-colors">Contact Us</a>
            </nav>
        </div>
    </div>


   

   <div class="flex-grow bg-white pt-28 pb-12 px-4 font-[Montserrat]">
     <!--[if BLOCK]><![endif]--><?php if($showSuccess): ?>
            <div wire:key="success-message" class="mb-6 p-6 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-lg flex justify-between items-center ">
                <div>
                    <h3 class="text-lg font-bold">Submission Received!</h3>
                    <p>Your clarification statement has been successfully submitted for review.</p>
                </div>
                <button type="button" wire:click="$set('showSuccess', false)" class="text-green-700 font-bold text-2xl px-2">&times;</button>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div class="max-w-2xl mx-auto w-full">
       

        <div class="bg-white border-4 border-[#c7da30] rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b-2 border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 uppercase">Official Clarification Statement</h2>
                <p class="text-sm text-gray-500">Case Reference: <span class="font-bold text-[#c7da30]"><?php echo e($caseNumber); ?></span></p>
            </div>

            <div class="bg-white p-8">
                <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-800">
                                <strong>Notice:</strong> This report was flagged during review. Please provide a detailed explanation.
                            </p>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="submitClarification">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Clarification / Explanation</label>
                         <div>
    <textarea 
        wire:model="clarificationText" 
        wire:key="clarification-input-<?php echo e($showSuccess ? 'success' : 'reset'); ?>"
        rows="8" 
        placeholder="Provide your detailed statement here..." 
        class="w-full p-4 border-2 border-[#c7da30] rounded-lg shadow-sm outline-none focus:border-[#c7da30] focus:ring-2 focus:ring-[#c7da30] transition-all <?php $__errorArgs = ['clarificationText'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 focus:border-red-500 focus:ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
    ></textarea>
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['clarificationText'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
</div>

                        <div class="flex items-center justify-between pt-4 border-t">
                            <a href="/" class="text-sm text-gray-500 hover:text-gray-700">Cancel and exit</a>
                            <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-[#c7da30] hover:bg-[#b8cc2a] transition">
                                Submit Official Statement
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
 <!-- ================= FOOTER ================= -->
    <footer class="bg-[#808080] text-white py-6 sm:py-8 mt-8 sm:mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row justify-between items-center gap-6 text-sm sm:text-base font-[Montserrat]">
            <p>&copy; <?php echo e(date('Y')); ?> Tekete Safe Space from Moepi Publishing. All rights reserved.</p>

            <div class="flex items-center gap-3 sm:gap-4 flex-wrap justify-center md:justify-end">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('images/youtube.png')); ?>" class="w-7 h-7 sm:w-8 sm:h-8 hover:opacity-80 transition" alt="YouTube">
                </a>
                <a href="https://x.com/moepipublishing" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('images/X.png')); ?>" class="w-7 h-7 sm:w-8 sm:h-8 hover:opacity-80 transition" alt="X">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('images/linkedIn.png')); ?>" class="w-7 h-7 sm:w-8 sm:h-8 hover:opacity-80 transition" alt="LinkedIn">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('images/facebook.png')); ?>" class="w-8 h-7 sm:w-9 sm:h-8 hover:opacity-80 transition" alt="Facebook">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('images/instagram.png')); ?>" class="w-8 h-7 sm:w-9 sm:h-8 hover:opacity-80 transition" alt="Instagram">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank" rel="noopener">
                    <img src="<?php echo e(asset('images/tiktok.png')); ?>" class="w-8 h-7 sm:w-9 sm:h-8 hover:opacity-80 transition" alt="TikTok">
                </a>
            </div>
        </div>
    </footer>

</div>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const isHidden = menu.classList.contains('hidden');
    if (isHidden) {
        menu.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } else {
        menu.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-button');
    if (btn) btn.addEventListener('click', toggleMobileMenu);
});
</script>
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/livewire/clarification-modal.blade.php ENDPATH**/ ?>