<footer {{ $attributes->merge([
    'class' => 'relative w-full bg-[#c7da30] text-white px-4 py-4 flex flex-col items-center gap-4 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:gap-2 lg:px-[2vw] mt-auto z-30 font-[Montserrat]',
]) }}>
    <p class="text-[13px] leading-5 text-center font-normal text-white min-[640px]:text-[14px] lg:text-[20px] min-[640px]:text-left w-full min-[640px]:w-auto ml-4 sm:ml-6">
        &copy; {{ date('Y') }} Tekete SafeSpace From Moepi <br class="min-[640px]:hidden">Publishing. All rights reserved.
    </p>
<div class="flex items-center justify-start flex-wrap gap-4 min-[640px]:gap-2 lg:gap-[1vw] relative min-[640px]:-left-4 lg:-left-[2vw]">
            <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
            <img src="{{ asset('images/youtube.png') }}" class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition" alt="YouTube">
        </a>
        <a href="https://www.X.com/moepipublishing" target="_blank">
            <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
        </a>
<a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" class="inline-flex items-center">
    <img src="{{ asset('images/linkedin.png') }}" alt="Linkedin" class="w-7 h-7 min-[640px]:w-5 min-[640px]:h-auto lg:w-[2.2vw] lg:h-auto min-w-[28px] min-[640px]:min-w-0">
</a>
  <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
            <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
        <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
            <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
        </a>
         <a href="https://www.tiktok.com/@moepipublishing" target="_blank">

                        <img src="{{ asset('images/ticktock.png') }}" alt="Instagram" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">

        </a>
       
    </div>
</footer>
