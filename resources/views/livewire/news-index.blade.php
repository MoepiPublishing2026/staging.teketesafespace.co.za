@php
    $workshopBookingUrl = rtrim(config('tekete.workshop_booking_url'), '/');
@endphp

<div class="min-h-screen bg-white flex flex-col w-full overflow-x-hidden" style="font-family: 'Montserrat', sans-serif;">
    <script src="//unpkg.com/alpinejs" defer></script>

       
 <header class="fixed top-0 left-0 w-full bg-white z-50 shadow-sm font-[Montserrat]">
        <div class="flex justify-between items-center py-2" style="width: 100%; padding-left: 2vw; padding-right: 2vw;">
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">

            <div class="flex items-center gap-8">
                <nav class="hidden md:flex gap-8 text-[17px] text-black font-[Montserrat]">
                    <a href="{{ route('landing-page') }}" class="hover:text-[#c7da30] transition-colors">Home</a>
                    <a href="{{ route('about-us') }}" class="hover:text-[#c7da30] transition-colors">About Us</a>
                    <a href="{{ $workshopBookingUrl }}/workshops" class="text-black transition-colors hover:text-[#c7da30]">

                            Workshops
                    </a>
                    <a href="{{ route('contact-us') }}" class="hover:text-[#c7da30] transition-colors">Contact Us</a>
                    <a href="{{ route('news') }}" class="font-bold text-black hover:text-[#c7da30] transition-colors">News</a>
                </nav>

                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30] cursor-pointer">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
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
           <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">
                <a href="{{ route('landing-page') }}"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">Home</a>
                <a href="{{ route('about-us') }}"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">About Us</a>
                     <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">Workshops</a>
                
                <a href="{{ route('contact-us') }}"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors">Contact Us</a>
                 <a href="{{ route('news') }}" onclick="toggleMobileMenu()" class="block py-3 font-bold text-black hover:text-[#c7da30] transition-colors border-b border-gray-100">News</a>

            </nav>
        </div>
    </div>

    <div class="w-full flex-grow bg-white pt-20 md:pt-24 pb-10 md:pb-[10vh] px-4 md:px-6 lg:px-[4vw] flex flex-col items-center">
        
        <style>
            .no-scrollbar::-webkit-scrollbar { display: none !important; }
            .no-scrollbar { -ms-overflow-style: none !important; scrollbar-width: none !important; }

            #custom-scrollbar-track {
                width: 12px;
                background-color: #f0f0f0;
                border-radius: 9999px;
                height: 100%;
            }

            #custom-scroll-thumb {
                width: 12px;
                background-color: #c7da30;
                border-radius: 9999px;
                min-height: 40px;
            }

            .news-scroll-arrow {
                color: #c7da30;
                line-height: 1;
                font-size: 12px;
                font-weight: 900;
            }
           /* Base styles shared by both Back and Next links */
.news-nav-link-text,
.news-nav-link-text-next {
    display: inline-block;
    font-family: 'Montserrat', sans-serif;
    font-size: 21px;
    font-weight: 400;
    color: #c7da30;
    letter-spacing: -0.04em;
    line-height: 0.7; /* Pulls the underline tight to the letters */
    border-bottom: 2.5px solid #c7da30;
    padding-bottom: 1px;
    margin-bottom: 2px;
    transform: scaleX(0.84);
    transition: color 0.15s ease, border-color 0.15s ease;
}

/* Back link anchors to the left */
.news-nav-link-text {
    transform-origin: left center;
}

/* Next link anchors to the right so it doesn't push the arrow away */
.news-nav-link-text-next {
    transform-origin: right center;
}

/* Hover states for both */
a:hover .news-nav-link-text,
a:hover .news-nav-link-text-next {
    color: #2f343e;
    border-color: #2f343e;
}

/* Mobile prototype styles */
.news-mobile-card {
    border: 1px solid #c6d933;
    border-radius: 5px;
    background: transparent;
}
.news-mobile-tag {
    display: inline-flex;
    align-items: center;
    border: 1px solid #c6d933;
    border-radius: 9999px;
    color: #c7da30;
    font-size: 10px;
    line-height: 1.2;
    padding: 3px 8px;
    white-space: nowrap;
}
.news-mobile-search {
    border: 1px solid #c7da30;
    border-radius: 100px;
    background: transparent;
}
        </style>

        {{-- Hero: mobile matches prototype (centered newspaper + NEWS) --}}
        <div class="flex flex-col items-center justify-center w-full md:hidden mt-2 mb-4">
            <img src="{{ asset('images/news-illustration.jpeg') }}" alt="News Icon" class="w-[127px] h-auto object-contain">
            <h1 class="mt-3 text-[20px] font-bold text-black tracking-[0.08em] uppercase" style="font-family: 'Montserrat', sans-serif;">
                NEWS
            </h1>
        </div>

        {{-- Hero: desktop keeps existing layout --}}
        <div class="hidden md:flex flex-col md:flex-row justify-center items-center gap-4 md:gap-1 my-0 w-full px-4">
            <div class="w-full max-w-[500px] sm:max-w-[500px] md:w-[500px] h-auto md:h-[500px] flex-shrink-0">
                <img src="{{ asset('images/news-illustration.jpeg') }}" alt="News Icon" class="w-full h-full object-contain">
            </div>

            <div class="relative flex flex-col items-start justify-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#2f343e] tracking-wide flex items-end" style="font-family: 'Montserrat', sans-serif;">
                    <span class="relative inline-block">
                        New
                        <span class="absolute left-0 bottom-[-4px] md:bottom-[-6px] w-full h-[4px] md:h-[8px] bg-[#c7da30]"></span>
                    </span>
                     <span>s</span>
                </h1>
            </div>
        </div>

        {{-- Feed container: no outer frame on mobile; keep desktop frame --}}
        <div class="w-full max-w-6xl mt-0 md:mt-18 border-0 md:border-[5px] border-[#c7da30] rounded-none md:rounded-[4px] p-0 md:p-8 bg-white shadow-none md:shadow-sm relative flex flex-col">

            {{-- Shared search: mobile pill / desktop thick border --}}
            <div class="w-full flex justify-center md:justify-end items-center gap-5 mb-4 md:mb-6 md:pr-6 relative z-40" wire:key="news-search-container">
                <span wire:click="executeSearch"
                      class="hidden md:inline text-[17px] font-normal text-black subpixel-antialiased tracking-wider self-center cursor-pointer select-none hover:text-[#c7da30] transition-colors duration-150">
                    Search
                </span>
                <div class="relative w-full max-w-[379px] md:max-w-none md:w-96 flex items-center">
                    <span class="md:hidden absolute left-3 top-1/2 -translate-y-1/2 text-[#9ca3af] pointer-events-none z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.603 10.603Z" />
                        </svg>
                    </span>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           wire:keydown.enter="executeSearch"
                           placeholder="Search News, Article and Event"
                           class="w-full h-[35px] md:h-auto news-mobile-search md:border-4 md:rounded-full pl-9 md:pl-10 pr-4 md:pr-14 py-0 md:py-3 text-[12px] md:text-xs placeholder:text-gray-400 md:placeholder:text-base focus:placeholder-transparent focus:outline-none focus:ring-1 focus:ring-[#c7da30] relative z-10">
                    <button type="button"
                            wire:click="executeSearch"
                            class="hidden md:block absolute right-3 top-1/2 -translate-y-1/2 text-black hover:text-[#c7da30] transition-colors duration-150 focus:outline-none cursor-pointer z-30"
                            aria-label="Submit Search">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.603 10.603Z" />
                        </svg>
                    </button>

                    @if(!empty($suggestions))
                        <div class="absolute left-0 right-0 top-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-48 overflow-y-auto">
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

            <div class="relative w-full h-auto md:h-[490px] flex gap-0 md:gap-4 items-stretch overflow-visible md:overflow-hidden pb-2 md:pb-8">
            
                <div id="news-scroll-viewport" 
                     wire:ignore.self 
                     onscroll="updateCustomScrollbar()"
                     class="flex-1 block overflow-visible md:overflow-y-auto no-scrollbar scroll-smooth space-y-4 md:space-y-5 pr-0 md:pr-2 h-auto md:h-full">
                    
                  
               @forelse($newsletters as $item)
                    @php
                        $isPressRelease = $item->category && strtolower($item->category) === 'press release';
                        $categoryLabel = $isPressRelease
                            ? 'FOR IMMEDIATE RELEASE:'
                            : strtoupper($item->category ?? 'NEWS');
                    @endphp

                        {{-- Mobile card (prototype) --}}
                        <div wire:key="news-item-mobile-{{ $item->id }}" class="md:hidden news-mobile-card p-3 w-full">
                            <div class="flex gap-3 items-start w-full">
                                <div class="w-[74px] h-[74px] flex-shrink-0 rounded-[4px] overflow-hidden bg-gray-50 flex items-center justify-center">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-[8px] text-gray-400 uppercase text-center px-1">No Image</span>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                        <span class="news-mobile-tag">{{ $categoryLabel }}</span>
                                        <span class="text-[11px] text-black" style="font-family: 'Montserrat', sans-serif;">
                                            {{ \Carbon\Carbon::parse($item->publish_date)->format('d/m/Y') }}
                                        </span>
                                        @if(!$isPressRelease && $item->author)
                                            <span class="text-[10px] text-gray-600">by {{ $item->author }}</span>
                                        @endif
                                    </div>

                                    <h2 class="text-[14px] font-bold text-black leading-snug mb-2 break-words">
                                        {{ $item->title }}
                                    </h2>

                                    <button type="button"
                                            wire:click="toggleExpand('{{ $item->id }}')"
                                            class="inline-flex items-center gap-1.5 text-[12px] font-medium text-[#c7da30] focus:outline-none">
                                        {{ (string)$expandedNewsletterId === (string)$item->id ? 'Show Less' : 'Read More' }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.19l-2.72-2.72a.75.75 0 1 1 1.06-1.06l4 4a.75.75 0 0 1 0 1.06l-4 4a.75.75 0 1 1-1.06-1.06l2.72-2.72H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    @if((string)$expandedNewsletterId === (string)$item->id)
                                        <div class="mt-2 pt-2 border-t border-[#c6d933]/
                                            <p class="text-[12px] text-[#2f343e] leading-relaxed whitespace-pre-line break-words">
                                                {{ $item->full_context }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Desktop card (existing) --}}
                        <div wire:key="news-item-desktop-{{ $item->id }}" class="hidden md:flex bg-[#f4f4f5] rounded-xl p-8 flex-col justify-center gap-4 hover:shadow-sm transition-all duration-200 w-full min-h-[220px] border border-gray-100">
                            
                            <div class="flex flex-col md:flex-row gap-8 items-center w-full">
                                <div class="w-40 h-30 flex-shrink-0 bg-[#f4f4f5] rounded-xl flex items-center justify-center overflow-hidden border border-gray-100">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider select-none px-2 text-center">
                                            No Featured Image
                                        </div>
                                    @endif
                                </div>

            <div class="flex-1 text-center md:text-left w-full min-w-0">
                <h2 class="text-[21px] font-bold text-[#2f343e] leading-snug mb-2 break-words" style="font-family: 'Montserrat', sans-serif;">
                    {{ $item->title }}
                </h2>
                
                <div class="text-[15px] text-[#2f343e] mb-3">
                    @if($isPressRelease)
                        <p class="font-medim text[14px] uppercase tracking-wide text-gray-700">
                            FOR IMMEDIATE RELEASE: {{ \Carbon\Carbon::parse($item->publish_date)->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="font-bold">
                            {{ \Carbon\Carbon::parse($item->publish_date)->format('d F Y') }}
                        </p>
                        @if($item->category)
                            <p class="text-sm text-gray-600 mt-0.5">
                                {{ $item->category }} @if($item->author) by {{ $item->author }} @endif
                            </p>
                        @endif
                    @endif
                </div>

                <button type="button" wire:click="toggleExpand('{{ $item->id }}')" class="text-[21px] font-medium text-[#c7da30] underline transition-colors focus:outline-none hover:text-[#2f343e]">
                    {{ (string)$expandedNewsletterId === (string)$item->id ? 'Show Less' : 'Read More' }}
                </button>
            </div>
        </div>

        @if((string)$expandedNewsletterId === (string)$item->id)
            <div class="mt-2 p-4 border-t border-gray-200 transition-all duration-300 w-full">
                <p class="text-[16px] text-[#2f343e] text-slate-800 leading-relaxed whitespace-pre-line break-words" style="word-break: break-word;">
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

           <div class="hidden md:flex w-10 h-full flex-col justify-between items-center pt-0 pb-10 flex-shrink-0 select-none relative self-stretch">
    
    <button type="button" 
            onclick="document.getElementById('news-scroll-viewport').scrollTop -= 180;" 
            class="news-scroll-arrow text-xl hover:text-black transition-colors focus:outline-none p-0 cursor-pointer bg-transparent border-0 z-20"
            aria-label="Scroll up">
        ▲
    </button>
    
    <div id="custom-scrollbar-track" class="flex-grow my-4 min-h-[40px] relative cursor-pointer">
        <div id="custom-scroll-thumb" 
             class="w-full absolute top-0 left-0 transition-all duration-75 cursor-grab active:cursor-grabbing" 
             style="height: 30%; top: 0%;"  style="height: 30%; top: 0%;width: 34px;"></div>
    </div>
    
    <button type="button" 
            onclick="document.getElementById('news-scroll-viewport').scrollTop += 180;" 
            class="news-scroll-arrow text-xl hover:text-black transition-colors focus:outline-none p-0 cursor-pointer bg-transparent border-0 z-20"
            aria-label="Scroll down">
        ▼
    </button>
</div>

                <div class="hidden md:block absolute right-16 bottom-0 z-30">
    <a href="{{ route('news.feed') }}" class="inline-flex items-center gap-1">
        <span class="news-nav-link-text-next">Next</span>
        
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-black inline-block" style="width: 30px; height: 30px;">
            <path d="M14 5l7 7-7 7v-4H3v-6h11z"/>
        </svg>
    </a>
</div>

            </div>
        </div>
    </div>

      <!-- ================= FOOTER ================= -->
    <footer class="w-full bg-[#808080] text-white py-6 mt-8 md:mt-12">
        <div
            class="flex flex-col md:flex-row justify-between items-center md:items-center gap-4 text-[12px] sm:text-[14px] md:text-[16px] text-center md:text-left"
style="width: 100%; padding-left: 2vw; padding-right: 2vw;">
    <div>
        <p>© {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
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
        
        // Hide scrollbar completely if content doesn't overflow container height limits
        if (totalScrollableHeight <= 0) {
            thumb.style.height = "100%";
            thumb.style.top = "0%";
            thumb.style.opacity = "0"; 
            return;
        } else {
            thumb.style.opacity = "1";
        }

        const visibleRatio = view.clientHeight / view.scrollHeight;
        const thumbHeightPercentage = Math.max(visibleRatio * 100, 15);
        const currentScrollPercent = (view.scrollTop / totalScrollableHeight) * (100 - thumbHeightPercentage);

        thumb.style.height = `${thumbHeightPercentage}%`;
        thumb.style.top = `${currentScrollPercent}%`;
    }

    document.addEventListener("DOMContentLoaded", () => {
        updateCustomScrollbar();
        
        // CHANGED: Added a DOM structural MutationObserver to force recalculate heights when "Read More" expands details
        const observer = new MutationObserver(() => {
            updateCustomScrollbar();
        });
        
        const scrollViewport = document.getElementById('news-scroll-viewport');
        if(scrollViewport) {
            observer.observe(scrollViewport, { childList: true, subtree: true, attributes: true });
        }
        
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
            const scrollRatio = maxTopPercent > 0 ? newTopPercent / maxTopPercent : 0;
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
            const maxTopPercent = 100 - thumbHeightPercent;
            view.scrollTop = maxTopPercent > 0 ? (targetTopPercent / maxTopPercent) * totalScrollableHeight : 0;
        });
    });
</script>

