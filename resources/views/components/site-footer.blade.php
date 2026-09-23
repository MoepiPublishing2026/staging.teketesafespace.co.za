<footer {{ $attributes->merge([
    'class' => 'relative w-full bg-[#c7da30] text-white px-4 py-6 flex flex-col items-center gap-4 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:gap-2 lg:px-[2vw] mt-auto z-30 font-[Montserrat]',
]) }}>
    <p class="text-[13px] leading-5 text-center font-normal text-white min-[640px]:text-[14px] lg:text-[16px] min-[640px]:text-left w-full min-[640px]:w-auto">
        &copy; {{ date('Y') }} Tekete SafeSpace From Moepi <br class="min-[640px]:hidden">Publishing. All rights reserved.
    </p>
    <div class="flex items-center justify-center flex-wrap gap-4 min-[640px]:gap-2 lg:gap-[1vw]">
        <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
            <img src="{{ asset('images/youtube.png') }}" class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition" alt="YouTube">
        </a>
        <a href="https://www.X.com/moepipublishing" target="_blank">
            <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" class="inline-block transition-transform hover:scale-110">
            <svg class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-[1.7vw] fill-current" viewBox="0 0 24 24" aria-label="LinkedIn">
                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
            </svg>
        </a>
        <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
            <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
            <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.tiktok.com/@moepipublishing" target="_blank"
           class="w-7 h-7 rounded-full bg-white flex items-center justify-center shadow-md transition-transform hover:scale-110">
            <svg class="w-7 h-4" viewBox="0 0 24 24" fill="#c7da30" aria-label="TikTok">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-1.02-.97-.49-1.85-1.15-2.59-1.97v9.75c-.01 2.82-2.3 5.12-5.13 5.12-2.83 0-5.13-2.3-5.13-5.12 0-2.83 2.3-5.13 5.13-5.13.38 0 .76.04 1.13.12v4.02c-.37-.1-.76-.15-1.13-.15-1.04 0-1.88.84-1.88 1.88 0 1.04.84 1.88 1.88 1.88 1.04 0 1.88-.84 1.88-1.88V.02z"/>
            </svg>
        </a>
    </div>
</footer>
