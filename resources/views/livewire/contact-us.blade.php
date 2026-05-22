<div class="contact-page-livewire-container w-full min-h-screen bg-white overflow-x-hidden relative font-[Montserrat] flex flex-col">

    <!-- ================= HEADER ================= -->
    <header class="fixed top-0 left-0 w-full bg-white z-50 shadow-sm">
        <div class="flex justify-between items-center px-[4vw] py-[1.2vh] max-w-[1440px] mx-auto">

            <img src="{{ asset('images/logo.png') }}"
                class="w-[9vw] min-w-[110px] max-w-[150px] h-auto">

            <nav class="hidden md:flex gap-[2vw] text-[clamp(12px,1vw,16px)] text-black">

                <a href="javascript:void(0);" onclick="window.history.back();" class="hover:text-[#c7da30]">Back</a>
                <a href="{{ route('landing-page') }}" class="hover:text-[#c7da30]">Home</a>
                <a href="{{ route('about-us') }}" class="hover:text-[#c7da30]">About Us</a>
                <a href="{{ route('contact-us') }}" class="hover:text-[#c7da30]">Contact Us</a>

            </nav>

        </div>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="relative flex-1 w-full pt-[18vh]">

        <!-- LEFT CONTENT -->
        <section class="relative z-20 w-[42vw] ml-[6vw]">

            <h1 class="text-[clamp(30px,3.2vw,66px)] font-bold leading-tight">
                CONTACT US
            </h1>

            <div class="w-[12vw] h-[0.6vh] bg-[#c7da30] mt-[1vh] mb-[5vh]"></div>

            <div class="space-y-[2vh] text-[clamp(14px,1.3vw,20px)]">

                <div class="flex items-center gap-[1vw]">
                    <img src="{{ asset('images/phone icon.png') }}" class="w-[1.8vw] min-w-[20px]">
                    087 265 6716
                </div>

                <div class="flex items-center gap-[1vw]">
                    <img src="{{ asset('images/email icon.png') }}" class="w-[1.8vw] min-w-[20px]">
                    support@tekete.co.za
                </div>

                <div class="flex items-center gap-[1vw]">
                    <img src="{{ asset('images/email icon.png') }}" class="w-[1.8vw] min-w-[20px]">
                    sales@teketesafespace.co.za
                </div>

            </div>

            <!-- ================= APP DOWNLOAD SECTION ================= -->
            <h2 class="mt-[5vh] text-[clamp(16px,1.6vw,26px)] mb-[3vh]">
                Download the Tekete SafeSpace App
            </h2>

            <!-- APP STORE ICONS (RESTORED) -->
            <div class="flex flex-wrap gap-[1.5vw] items-center">

                <a href="https://apps.apple.com/za/app/safe-space/id6756009264" target="_blank">
                    <img src="{{ asset('images/Apple App store.png') }}"
                        class="w-[9vw] min-w-[110px] max-w-[140px] h-auto">
                </a>

                <a href="https://play.google.com/store/apps/details?id=com.moepipublishing.safespace" target="_blank">
                    <img src="{{ asset('images/Google Play Store.png') }}"
                        class="w-[11vw] min-w-[140px] max-w-[180px] h-auto">
                </a>

                <a href="https://appgallery.cloud.huawei.com/ag/n/app/C116390043?locale=en_GB" target="_blank">
                    <img src="{{ asset('images/Huawei AppGallery.png') }}"
                        class="w-[10vw] min-w-[120px] max-w-[160px] h-auto">
                </a>

            </div>

        </section>

        <!-- ================= PHONE (ENLARGED) ================= -->
        <div class="fixed
            left-[48vw]
            top-[2vh]
            w-[32vw]
            min-w-[380px]
            max-w-[560px]
            z-30 pointer-events-none">

            <img src="{{ asset('images/social media phone1.png') }}"
                class="w-full h-auto object-contain">
        </div>

        <!-- ================= FUTURISTIC ================= -->
        <div class="fixed
            right-[-18vw]
            top-[18vh]
            w-[34vw]
            min-w-[340px]
            max-w-[600px]
            z-10 pointer-events-none">

            <img src="{{ asset('images/futuristic digital frame tech.png') }}"
                class="w-full h-auto object-contain">
        </div>

    </main>

    <!-- ================= FOOTER (RESTORED + FIXED BOTTOM) ================= -->
    <footer class="mt-auto w-full bg-[#808080] text-white py-[3vh]">

        <div class="max-w-[1440px] mx-auto px-[4vw] flex justify-between items-center">

            <p class="text-[clamp(12px,1vw,14px)]">
                © {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.
            </p>

            <!-- SOCIAL MEDIA ICONS (RESTORED) -->
            <div class="flex items-center gap-[1vw]">

                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank">
                    <img src="{{ asset('images/youtube.png') }}" class="w-[2vw] min-w-[22px]">
                </a>

                <a href="https://x.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" class="w-[2vw] min-w-[22px]">
                </a>

                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" class="w-[2vw] min-w-[22px]">
                </a>

                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" class="w-[2.2vw] min-w-[24px]">
                </a>

                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" class="w-[2.2vw] min-w-[24px]">
                </a>

                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" class="w-[2.2vw] min-w-[24px]">
                </a>

            </div>

        </div>

    </footer>

</div>