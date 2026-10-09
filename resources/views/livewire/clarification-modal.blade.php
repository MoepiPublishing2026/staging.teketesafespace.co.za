<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full overflow-x-hidden">

    <script src="//unpkg.com/alpinejs" defer></script>

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
            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">About Us</a>
            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Workshops</a>
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff] hover:text-[#c7da30] transition-colors">Contact Us</a>

        </nav>
    </div>
</div>




    <div class="flex-grow bg-white pt-40 pb-12 px-4 font-[Montserrat]">
        @if ($showSuccess)
            <div wire:key="success-message"
                class="mb-6 p-6 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-lg flex justify-between items-center ">
                <div>
                    <h3 class="text-lg font-bold">Submission Received!</h3>
                    <p>Your clarification statement has been successfully submitted for review.</p>
                </div>
                <button type="button" wire:click="$set('showSuccess', false)"
                    class="text-green-700 font-bold text-2xl px-2">&times;</button>
            </div>
        @endif
        <div class="max-w-2xl mx-auto w-full">


            <div class="bg-white border-4 border-[#c7da30] rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b-2 border-gray-200 space-y-2">
                    <h2 class="text-2xl font-bold text-black uppercase">Official Clarification Statement</h2>
                    <p class="text-s font-small text-black">Case Reference: <span
                            class="font-medium text-[#c7da30]">{{ $caseNumber }}</span></p>
                </div>

                <div class="bg-white p-8">
                    <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-500">
                                    <strong>Notice:</strong> This report was flagged during review. Please provide a
                                    detailed explanation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="submitClarification">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-s font-small text-black mb-2">Your Clarification /
                                    Explanation</label>
                                <div>
                                    <textarea wire:model="clarificationText" wire:key="clarification-input-{{ $showSuccess ? 'success' : 'reset' }}"
                                        rows="8" placeholder="Provide your detailed statement here..."
                                        class="w-full p-4 border-2 border-[#c7da30] rounded-lg shadow-sm outline-none focus:border-[#c7da30] focus:ring-2 focus:ring-[#c7da30] transition-all @error('clarificationText') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"></textarea>
                                    @error('clarificationText')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t">
                                    <a href="/" class="text-s font-small text-black">Cancel and
                                        exit</a>
                                    <button type="submit"
                                        class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-s font-small rounded-md text-white bg-[#c7da30] hover:bg-[#b8cc2a] transition">
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
    <x-site-footer />
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
</script>
