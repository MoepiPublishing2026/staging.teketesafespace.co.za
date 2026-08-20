<footer {{ $attributes->merge([
    'class' => 'site-footer relative w-full max-w-full bg-[#757573] text-white mt-auto z-30 font-[Montserrat] box-border overflow-x-hidden',
    'style' => '-webkit-text-size-adjust: 100%; text-size-adjust: 100%;',
]) }}>
    <div class="w-full max-w-full px-4 py-5 min-[640px]:px-6 lg:px-[2vw] lg:py-[1.5vh]
                flex flex-col items-center justify-center gap-4
                min-[640px]:flex-row min-[640px]:justify-between min-[640px]:items-center min-[640px]:gap-2">
        <p class="min-w-0 text-[13px] leading-5 text-center font-normal text-white w-full
                   min-[640px]:text-[14px] min-[640px]:text-left min-[640px]:w-auto lg:text-[16px]">
            &copy; {{ date('Y') }} Tekete SafeSpace from Moepi<br class="min-[640px]:hidden"> Publishing. All rights reserved.
        </p>

        <div class="flex items-center justify-center flex-nowrap shrink-0 gap-3 min-[640px]:gap-2 lg:gap-[1vw]">
            <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                <img src="{{ asset('images/youtube.png') }}"
                     class="w-7 h-auto min-[640px]:w-5 lg:w-[2.3vw] shrink-0 object-contain hover:opacity-80 transition"
                     alt="YouTube">
            </a>
            <a href="https://www.X.com/moepipublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/X.png') }}" alt="X"
                     class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto shrink-0 object-contain hover:opacity-80 transition">
            </a>
            <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" rel="noopener">
                <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn"
                     class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto shrink-0 object-contain hover:opacity-80 transition">
            </a>
            <a href="https://www.facebook.com/MoepiPublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                     class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto shrink-0 object-contain hover:opacity-80 transition">
            </a>
            <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank" rel="noopener">
                <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                     class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto shrink-0 object-contain hover:opacity-80 transition">
            </a>
            <a href="https://www.tiktok.com/@moepipublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/tiktok.png') }}" alt="TikTok"
                     class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto shrink-0 object-contain hover:opacity-80 transition">
            </a>
        </div>
    </div>
</footer>
