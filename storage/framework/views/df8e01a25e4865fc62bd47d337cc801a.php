<div x-data="{
    show: false,
    init() {
        setTimeout(() => {
            if (!localStorage.getItem('privacy_accepted')) {
                this.show = true;
            }
        }, 800);
    }
}" x-show="show" x-transition:enter="transition-all ease-out duration-1000 transform"
    x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition-all ease-in duration-500 transform"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-full"
    class="fixed bottom-0 left-0 right-0 z-40" x-cloak id="privacy-notice"
    x-bind:style="{ pointerEvents: show ? 'auto' : 'none' }">

    <div x-show="show" x-transition.opacity x-cloak id="privacy-overlay"
        class="fixed inset-0 z-30 bg-transparent"
        x-bind:style="{ pointerEvents: show ? 'auto' : 'none' }"
        style="pointer-events: none;"></div>

    <script>
        // Fallback for browsers without Alpine.js support
        document.addEventListener('DOMContentLoaded', function() {
            const notice = document.getElementById('privacy-notice');
            const overlay = document.getElementById('privacy-overlay');
            if (notice && typeof window.Alpine === 'undefined') {
                setTimeout(() => {
                    if (!localStorage.getItem('privacy_accepted')) {
                        notice.style.pointerEvents = 'auto';
                        notice.style.transform = 'translateY(0)';
                        notice.style.opacity = '1';
                        notice.style.display = 'block';
                        if (overlay) {
                            overlay.style.display = 'block';
                            overlay.style.pointerEvents = 'auto';
                            overlay.style.opacity = '1';
                        }
                    }
                }, 800);
            }
        });

        function acceptPrivacy() {
            localStorage.setItem('privacy_accepted', 'true');
            hideNotice();
        }

        function hideNotice() {
            const notice = document.getElementById('privacy-notice');
            const overlay = document.getElementById('privacy-overlay');
            if (notice) {
                notice.style.pointerEvents = 'none';
                notice.style.transform = 'translateY(100%)';
                notice.style.opacity = '0';
                setTimeout(() => {
                    notice.style.display = 'none';
                }, 500);
            }
            if (overlay) {
                overlay.style.pointerEvents = 'none';
                overlay.style.opacity = '0';
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 500);
            }
        }
    </script> <!-- Privacy Notice Content -->
    <div class="bg-white border-t border-gray-200 shadow-2xl w-full relative z-40" style="pointer-events: auto;">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 sm:py-6">


            <div class="block lg:hidden space-y-4">

                <div class="text-center">
                    <h3 class="text-gray-900 text-lg sm:text-xl font-semibold mb-3">
                        Cookies Policy
                    </h3>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed px-2">
                        We use essential cookies to keep Safe Space secure and working properly.
                        This includes safety features like anonymous sessions, secure logins,
                        and improving support services by continuing, you accept these cookies.
                    </p>
                </div>
                <div class="flex flex-col gap-3 px-4">
                    <button @click="localStorage.setItem('privacy_accepted', 'true'); show = false"
                        onclick="acceptPrivacy()"
                        class="w-full py-3.5 px-6 bg-white hover:bg-gray-50 text-blue-500 
                               rounded-full transition-all duration-200 text-base font-medium 
                               border-2 border-[#c7da30] hover:border-[#b8c429]
                               focus:outline-none focus:ring-4 focus:ring-[#c7da30]/20">
                        Accept All
                    </button>

                    <button @click="show = false" onclick="hideNotice()"
                        class="w-full py-3.5 px-6 bg-white hover:bg-gray-50 text-red-500 
                               rounded-full transition-all duration-200 text-base font-medium 
                               border-2 border-[#c7da30] hover:border-[#b8c429]
                               focus:outline-none focus:ring-4 focus:ring-[#c7da30]/20">
                        Reject All
                    </button>
                </div>
            </div>
            <div class="hidden lg:flex lg:items-center lg:justify-between lg:gap-8">
                <div class="flex-1 pr-8">
                    <h3 class="text-gray-900 text-xl font-semibold mb-2">
                        Cookies Policy
                    </h3>
                    <p class="text-gray-600 text-base leading-relaxed">
                        We use essential cookies to keep Safe Space secure and working properly.
                        This includes safety features like anonymous sessions, secure logins,
                        and improving support services by continuing, you accept these cookies.
                    </p>
                </div>
                <div class="flex gap-4 flex-shrink-0">
                    <button @click="localStorage.setItem('privacy_accepted', 'true'); show = false"
                        onclick="acceptPrivacy()"
                        class="px-8 py-3 bg-white hover:bg-gray-50 text-blue-500 
                               rounded-full transition-all duration-200 text-sm font-medium 
                               border-2 border-[#c7da30] hover:border-[#b8c429]
                               focus:outline-none focus:ring-4 focus:ring-[#c7da30]/20
                               whitespace-nowrap">
                        Accept All
                    </button>

                    <button @click="show = false" onclick="hideNotice()"
                        class="px-8 py-3 bg-white hover:bg-gray-50 text-red-500 
                               rounded-full transition-all duration-200 text-sm font-medium 
                               border-2 border-[#c7da30] hover:border-[#b8c429]
                               focus:outline-none focus:ring-4 focus:ring-[#c7da30]/20
                               whitespace-nowrap">
                        Reject All
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/components/privacy-notice.blade.php ENDPATH**/ ?>