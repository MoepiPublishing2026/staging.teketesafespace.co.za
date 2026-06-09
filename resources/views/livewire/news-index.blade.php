<div class="min-h-screen bg-white flex flex-col font-[Montserrat] w-full overflow-x-hidden">
    <script src="//unpkg.com/alpinejs" defer></script>

    <header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 150; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
            </div>
            
            <div style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                
                <div class="hidden md:flex gap-8">
                    
                    <a href="{{ route('landing-page') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                        Home
                    </a>
                    <a href="{{ route('about-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                        About Us
                    </a>
                    <a href="{{ route('contact-us') }}" class="transition-colors hover:text-[#c7da30]" style="color: black; text-decoration: none;">
                        Contact Us
                    </a>
                     <a href="{{ route('news') }}" class="font-bold transition-colors hover:text-[#c7da30]"style="color: black; text-decoration: none;">News</a>
                </div>

                <div class="md:hidden flex items-center relative z-[160]">
                    <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30] cursor-pointer">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <div id="mobile-menu" class="fixed inset-0 z-[200] hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <div class="w-full flex-grow bg-white pt-24 pb-[10vh] px-6 lg:px-[4vw] flex flex-col items-center">
        
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none !important; }
            .no-scrollbar { -ms-overflow-style: none !important; scrollbar-width: none !important; }
        </style>
        
       <div class="flex flex-col md:flex-row justify-center items-center gap-4 md:gap-1 my-0 w-full px-4">
    
    <div class="w-full max-w-[400px] sm:max-w-[400px] md:w-[400px] h-auto md:h-[400px] flex-shrink-0">
        <img src="{{ asset('images/news-illustration.jpeg') }}" alt="News Icon" class="w-full h-full object-contain">
    </div>

    <div class="relative flex flex-col items-start justify-center">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#2f343e] tracking-wide flex items-end" style="font-family: 'Montserrat', sans-serif;">
            <span class="relative inline-block">
                New
                <span class="absolute left-0 bottom-[-4px] md:bottom-[-6px] w-full h-[4px] md:h-[5px] bg-[#c7da30]"></span>
            </span>
            <span>s.</span>
        </h1>
    </div>

</div>

        <div class="w-full max-w-5xl mt-18 border-[3px] border-[#c7da30] rounded-[4px] p-8 bg-white shadow-sm relative flex flex-col">
            
            <div class="w-full flex justify-end items-center gap-5 mb-6 pr-6">
                <span class="font-[Montserrat] text-[16px] text-[#2f343e] tracking-wider self-start mt-2">Search</span>
                
                <div class="relative w-60">
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="News, Article and Event" 
                           class="font-[Montserrat] w-full px-6 py-2 pr-8 text-xs border border-[#c7da30] rounded-full focus:outline-none focus:ring-1 focus:ring-[#c7da30] text-gray-600">
                    
                    <div class="absolute right-3 top-2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.603 10.603Z" />
                        </svg>
                    </div>

                    @if(!empty($suggestions))
                        <div class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-48 overflow-y-auto">
                            @foreach($suggestions as $suggestion)
                                <button type="button"
                                        wire:click="selectSuggestion('{{ addslashes($suggestion) }}')"
                                        class="w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-[#c7da30] hover:text-white transition-colors duration-150 block truncate">
                                    {{ $suggestion }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="relative w-full h-[475px] flex gap-4 items-start overflow-hidden">
            
                <div id="news-scroll-viewport" 
                     wire:ignore.self 
                     onscroll="updateCustomScrollbar()"
                     class="flex-1 block h-[435px] max-h-[435px] !overflow-y-auto no-scrollbar scroll-smooth space-y-5"
                     style="height: 435px; max-height: 435px; overflow-y: auto !important;">
                    
                    <div wire:key="news-static-psa-card" class="bg-[#f4f4f5] rounded-xl p-6 flex flex-col justify-center gap-4 hover:shadow-sm transition-all duration-200 w-full min-h-[160px] border border-gray-100 m-2">
                        <div class="flex flex-col md:flex-row gap-8 items-center w-full">
                            <div class="w-40 h-30 flex-shrink-0 bg-[#f4f4f5] rounded-xl flex items-center justify-center overflow-hidden border border-gray-100">
                                <img src="{{ asset('images/PSA-logo.png') }}" alt="Proudly South African" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 text-center md:text-left w-full min-w-0">
                                <h2 class="text-[19px] font-bold text-[#2f343e] text-slate-800 leading-snug mb-1 break-words">
                                    Tekete Safe Space App Receives Proudly South African Approval
                                </h2>
                                
                                <div class="text-[14px] text-[#2f343e] text-slate-800 mb-2">
                                    <span>FOR IMMEDIATE RELEASE: 04/02/2026</span> 
                                </div>

                                <button type="button" wire:click="toggleExpand('psa-static')" class="text-[23] font-bold text-[#c7da30] underline transition-colors focus:outline-none">
                                    {{ $expandedNewsletterId === 'psa-static' ? 'Show Less' : 'Read More' }}
                                </button>
                            </div>
                        </div>

                        @if($expandedNewsletterId === 'psa-static')
                            <div class="mt-2 p-4 border-t-2  rounded-b-lg transition-all duration-300 w-full">
                                <p class="text-[16px] text-[#2f343e] text-slate-800 leading-relaxed whitespace-pre-line break-words" style="word-break: break-word;">
                                Pretoria, South Africa – Tekete Safe Space is proud to announce that its digital reporting and learner wellbeing application has been officially approved by Proudly South African, marking a significant milestone in its mission to support safer, more inclusive learning environments across the country.
                                This approval recognises Tekete Safe Space as a locally developed, credible, and trusted solution, purpose-built to meet the needs of South African schools, learners, and educators. It affirms the app’s adherence to quality, ethical standards, and its commitment to creating meaningful social impact within the education sector.
                                For schools, the Proudly South African endorsement provides added assurance that Tekete Safe Space aligns with local policies, values, and the realities faced by school communities. The app supports schools in fulfilling their duty of care by offering a secure and confidential platform for reporting safety concerns, promoting learner wellbeing, and enabling early intervention.
                                Tekete Safe Space strengthens school safeguarding structures by encouraging responsible reporting and fostering a culture of trust, accountability, and transparency among learners, educators, and parents. By integrating technology into school safety strategies, the app complements existing school policies and child protection frameworks, enhancing schools’ ability to respond effectively to incidents and concerns.
                                This Proudly South African approval reinforces Tekete Safe Space’s belief that local innovation can drive real and sustainable change in education. The organisation remains committed to working collaboratively with schools, governing bodies, and education stakeholders to help create safer spaces where learners can thrive.                               
                                </p>
                            </div>
                        @endif
                    </div>

                    @forelse($newsletters as $item)
                        <div wire:key="news-item-loop-key-{{ $item->id }}" class="bg-[#f4f4f5] rounded-xl p-8 flex flex-col justify-center gap-4 hover:shadow-sm transition-all duration-200 w-full min-h-[220px] border border-gray-100">
                            
                            <div class="flex flex-col md:flex-row gap-8 items-center w-full">
                                <div class="w-40 h-30 flex-shrink-0 bg-[#f4f4f5] rounded-xl flex items-center justify-center overflow-hidden border border-gray-100">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider select-none px-2 text-center">
                                            No Cover Image
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 text-center md:text-left w-full min-w-0">
                                    <h2 class="text-[19px] font-bold text-[#2f343e] text-slate-800 leading-snug mb-1 break-words">
                                        {{ $item->title }}
                                   </h2>
                                    
                                    <div class="text-[16px] text-[#2f343e] text-slate-800 mb-2">
    <p class="font-bold">
        {{ \Carbon\Carbon::parse($item->publish_date)->format('d F Y') }}
    </p> 
    @if($item->category)
        <p class="text-sm text-gray-600 mt-0.5">
            {{ $item->category }} @if($item->author) by {{ $item->author }} @endif
        </p>
    @endif
</div>

                                    <button type="button" wire:click="toggleExpand('{{ $item->id }}')" class="text-[23] font-bold text-[#c7da30] underline transition-colors focus:outline-none">
                                        {{ (string)$expandedNewsletterId === (string)$item->id ? 'Show Less' : 'Read More' }}
                                    </button>
                                </div>
                            </div>

                            @if((string)$expandedNewsletterId === (string)$item->id)
                                <div class="mt-2 p-4 border-t-2  rounded-b-lg transition-all duration-300 w-full">
                                    <p class="text-[16px]text-[#2f343e] text-slate-800 leading-relaxed whitespace-pre-line break-words" style="word-break: break-word;">
                                        {{ $item->full_context }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    @empty
                        <div wire:key="news-empty-placeholder" class="p-8 text-center text-sm text-gray-500 italic bg-[#f1f5f9] rounded-xl w-full">
                            No recent webinar contexts logged.
                        </div>
                    @endforelse

                </div>

                <div class="w-4 h-full flex flex-col justify-between items-center py-0 flex-shrink-0 select-none bg-white relative">
                    <button type="button" 
                            onclick="document.getElementById('news-scroll-viewport').scrollTop -= 180;" 
                            class="text-[#c7da30] hover:text-black transition-colors focus:outline-none p-1 cursor-pointer bg-transparent border-0 z-20 -mt-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 pointer-events-none">
                            <path fill-rule="evenodd" d="M11.47 7.72a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06L12 9.31l-6.97 6.97a.75.75 0 0 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div id="custom-scrollbar-track" class="w-2 flex-grow bg-gray-100 rounded-full my-4 min-h-[40px] relative w-full max-w-[6px] cursor-pointer">
                        <div id="custom-scroll-thumb" 
                             class="w-full bg-[#c7da30] rounded-full absolute top-0 transition-all duration-75 cursor-grab active:cursor-grabbing" 
                             style="height: 30%; top: 0%;"></div>
                    </div>
                    
                    <button type="button" 
                            onclick="document.getElementById('news-scroll-viewport').scrollTop += 180;" 
                            class="text-[#c7da30] hover:text-black transition-colors focus:outline-none p-1 cursor-pointer bg-transparent border-0 z-20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 pointer-events-none">
                            <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                </div>
                    <div class="absolute right-9 bottom-2 z-30">
        <a href="{{ route('news.feed') }}" class="font-[Montserrat] font-bold text-sm text-[#c7da30] hover:text-[#2f343e] transition-colors flex items-center gap-2" style="text-decoration: underline;">
            Next 
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-black inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>
            </div>
        </div>
    </div>

    <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0;">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" alt="YouTube Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 35.2px; height: 30px;">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon" style="width: 35.2px; height: 30px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon" style="width: 35.2px; height: 30px;">
                </a>
            </div>
        </div>
    </footer>
</div>

<script>
    let isDragging = false;
    let startY = 0;
    let startTop = 0;

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        if (!mobileMenu) return;
        
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        } else {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto'; 
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        if (mobileMenuButton) {
            // FIXED: Standardized event framework targeting to guarantee seamless single-fire execution on touch monitors
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                toggleMobileMenu();
            });
        }
    });

    function updateCustomScrollbar() {
        const view = document.getElementById('news-scroll-viewport');
        const thumb = document.getElementById('custom-scroll-thumb');
        if (!view || !thumb) return;

        const totalScrollableHeight = view.scrollHeight - view.clientHeight;
        
        if (totalScrollableHeight <= 0) {
            thumb.style.height = "100%";
            thumb.style.top = "0%";
            return;
        }

        const visibleRatio = view.clientHeight / view.scrollHeight;
        const thumbHeightPercentage = Math.max(visibleRatio * 100, 15);
        const currentScrollPercent = (view.scrollTop / totalScrollableHeight) * (100 - thumbHeightPercentage);

        thumb.style.height = `${thumbHeightPercentage}%`;
        thumb.style.top = `${currentScrollPercent}%`;
    }

    document.addEventListener("DOMContentLoaded", () => {
        updateCustomScrollbar();
        
        if (window.Livewire) {
            Livewire.hook('morph.updated', () => {
                setTimeout(updateCustomScrollbar, 50);
            });
        }

        const thumb = document.getElementById('custom-scroll-thumb');
        const view = document.getElementById('news-scroll-viewport');
        const track = document.getElementById('custom-scrollbar-track');

        if (!thumb || !view || !track) return;

        function startDrag(e) {
            isDragging = true;
            thumb.style.cursor = 'grabbing';
            startY = e.touches ? e.touches[0].clientY : e.clientY;
            startTop = parseFloat(thumb.style.top) || 0;
            document.body.style.userSelect = 'none';
        }

        function doDrag(e) {
            if (!isDragging) return;

            const currentY = e.touches ? e.touches[0].clientY : e.clientY;
            const deltaY = currentY - startY;
            const trackHeight = track.clientHeight;
            
            const deltaPercent = (deltaY / trackHeight) * 100;
            const thumbHeightPercent = parseFloat(thumb.style.height);
            const maxTopPercent = 100 - thumbHeightPercent;

            let newTopPercent = startTop + deltaPercent;
            newTopPercent = Math.max(0, Math.min(newTopPercent, maxTopPercent));

            thumb.style.top = `${newTopPercent}%`;

            const totalScrollableHeight = view.scrollHeight - view.clientHeight;
            const scrollRatio = newTopPercent / maxTopPercent;
            view.scrollTop = scrollRatio * totalScrollableHeight;
        }

        function endDrag() {
            if (isDragging) {
                isDragging = false;
                thumb.style.cursor = 'grab';
                document.body.style.userSelect = '';
            }
        }

        thumb.addEventListener('mousedown', startDrag);
        document.addEventListener('mousemove', doDrag);
        document.addEventListener('mouseup', endDrag);

        thumb.addEventListener('touchstart', startDrag, { passive: true });
        document.addEventListener('touchmove', doDrag, { passive: false });
        document.addEventListener('touchend', endDrag);
        
        track.addEventListener('click', (e) => {
            if (e.target === thumb) return;
            const rect = track.getBoundingClientRect();
            const clickY = e.clientY - rect.top;
            const clickPercent = (clickY / track.clientHeight) * 100;
            const thumbHeightPercent = parseFloat(thumb.style.height);
            
            let targetTopPercent = clickPercent - (thumbHeightPercent / 2);
            targetTopPercent = Math.max(0, Math.min(targetTopPercent, 100 - thumbHeightPercent));
            
            const totalScrollableHeight = view.scrollHeight - view.clientHeight;
            view.scrollTop = (targetTopPercent / (100 - thumbHeightPercent)) * totalScrollableHeight;
        });
    });
</script>