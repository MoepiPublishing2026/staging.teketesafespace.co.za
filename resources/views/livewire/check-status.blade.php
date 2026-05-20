<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full overflow-x-hidden">

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- ================= HEADER ================= -->
    <header class="fixed top-0 left-0 w-full bg-white z-50 shadow-sm">
        <div class="flex justify-between items-center px-4 sm:px-8 py-2 max-w-7xl mx-auto">
            <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[110px] h-auto">

            <div class="flex items-center gap-4">
                <!-- Desktop Nav -->
                <div class="hidden md:flex gap-8 text-[17px] text-black font-[Montserrat]">
                    <a href="javascript:void(0);" onclick="window.history.back();"
                        class="hover:text-[#c7da30] transition-colors">Back</a>
                    <a href="{{ route('landing-page') }}" class="hover:text-[#c7da30] transition-colors">Home</a>
                    <a href="{{ route('about-us') }}" class="hover:text-[#c7da30] transition-colors">About Us</a>
                    <a href="{{ route('contact-us') }}" class="hover:text-[#c7da30] transition-colors">Contact Us</a>
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
                <img src="{{ asset('images/logo.png') }}" class="h-8">
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
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                    class="block text-black hover:text-[#c7da30] transition-colors">Home</a>
                <a href="{{ route('about-us') }}#about" onclick="toggleMobileMenu()"
                    class="block text-black hover:text-[#c7da30] transition-colors">About Us</a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()"
                    class="block text-black hover:text-[#c7da30] transition-colors">Contact Us</a>
            </nav>
        </div>
    </div>

    <!-- ================= MAIN CONTENT ================= -->
    <div class="flex-1 pt-[120px] pb-16 px-4 sm:px-6">

        <h1 class="text-2xl sm:text-3xl font-bold text-center uppercase mb-8 tracking-wider font-[Montserrat]">TRACK
            STATUS</h1>

        <div class="max-w-2xl mx-auto w-full flex flex-col items-center">

            <!-- ================= ALERT ================= -->
            <div x-data="{
                show: false,
                message: '',
                hideMessage() {
                    setTimeout(() => {
                        this.show = false;
                    }, 5000);
                }
            }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-10px]"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-[-10px]"
                @status-updated.window="
                message = $event.detail.message;
                show = true;
                hideMessage();
            "
                class="mb-6 w-full max-w-md bg-green-100 border-2 border-[#c7da30] text-green-700 px-4 py-3 rounded-lg relative font-[Montserrat]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-sm" x-text="message"></span>
                    </div>
                    <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- ================= SEARCH CARD ================= -->
            <div class="w-full border-4 border-[#c7da30] rounded-2xl p-4 sm:p-8 bg-white">

                <form wire:submit.prevent="checkStatus" class="space-y-4 w-full">
                    <div>
                        <input type="text" id="caseNumber" wire:model.live="caseNumber" placeholder="Case Number"
                            class="w-full py-4 px-4 rounded-xl border-4 border-[#c7da30] focus:outline-none text-sm font-[Montserrat]"
                            style="font-family: 'Montserrat', sans-serif; font-size: 14px;" required>

                        @error('caseNumber')
                            <div x-data="{ open: true }" x-show="open"
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
                                <div
                                    class="w-[90vw] sm:w-[90%] md:w-[95%] max-w-[635px] h-[250px] sm:h-[300px] md:h-[342px] border-2 border-[#c6d933] rounded-[10px] bg-white flex flex-col items-center justify-center p-4 text-center shadow-lg relative font-[Montserrat]">
                                    <p class="text-sm sm:text-[18px] md:text-[19px] text-black mb-4">{{ $message }}
                                    </p>
                                    <button @click="open = false"
                                        class="w-[160px] sm:w-[190px] h-[48px] sm:h-[56px] md:h-[64px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] text-sm sm:text-[15px] font-normal transition duration-200 hover:opacity-80 shadow-md flex items-center justify-center">
                                        Close
                                    </button>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-4 px-4 border-4 border-[#c7da30] rounded-full text-[#38b6ff] hover:opacity-90 transition font-[Montserrat] text-lg">
                        Search
                    </button>
                </form>

                <!-- ================= STATUS SECTION ================= -->
                <h2 class="text-lg sm:text-xl font-bold text-center uppercase mt-8 mb-4 font-[Montserrat]">YOUR CASE
                    STATUS</h2>

                <div class="border-4 border-[#c7da30] rounded-xl p-4 sm:p-6 min-h-[200px] relative font-[Montserrat]">

                    @if (!empty($message))
                        <div class="text-red-500 font-medium text-center mb-4">
                            {{ $message }}
                        </div>
                    @endif

                    @if (!empty($reportData))
                        <!-- Case Information -->
                        <div class="text-left space-y-3 text-sm sm:text-base break-words">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                <p class="text-gray-700 font-medium"><strong>Case Number:</strong>
                                    {{ $reportData['case_number'] }}</p>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-black text-[14px]">Status:</span>
                                    <span
                                        class="px-4 py-2 rounded-full text-sm font-bold text-black
                                    @switch($reportData['status'])
                                        @case('awaiting-resolution') bg-red-500 @break
                                        @case('forwarded') bg-yellow-500 @break
                                        @case('under-review') bg-blue-500 @break
                                        @case('closed') bg-green-500 @break
                                        @case('unresolved') bg-orange-500 @break
                                        @case('false-report') bg-gray-400 @break
                                        @default bg-gray-200
                                    @endswitch">
                                        {{ ucfirst(str_replace('-', ' ', $reportData['status'])) }}
                                    </span>
                                </div>
                            </div>

                            @if ($reportData['is_anonymous'])
                                <p class="text-gray-700"><strong>Report Type:</strong> Anonymous</p>
                            @else
                                <p class="text-gray-700"><strong>Report Type:</strong> With Details</p>
                                @if (!empty($reportData['full_name']))
                                    <p class="text-gray-700"><strong>Full Name:</strong>
                                        {{ $reportData['full_name'] }}</p>
                                @endif
                            @endif

                            <p class="text-gray-700"><strong>Submitted on:</strong>
                                {{ \Carbon\Carbon::parse($reportData['created_at'])->format('Y/m/d') }}</p>
                            <p class="text-gray-700"><strong>Abuse Type:</strong>
                                {{ $reportData['abuse_type'] ?? '' }}</p>
                            <p class="text-gray-700"><strong>Subtype:</strong> {{ $reportData['subtype'] ?? '' }}</p>

                            <p class="text-gray-700"><strong>Email:</strong> {{ $reportData['reporter_email'] ?? '' }}
                            </p>
                            <p class="text-gray-700"><strong>Phone Number:</strong>
                                {{ $reportData['phone_number'] ?? '' }}</p>
                            <p class="text-gray-700"><strong>Address:</strong> {{ $reportData['location'] ?? '' }}</p>
                            <p class="text-gray-700"><strong>Grade:</strong> {{ $reportData['grade'] ?? '' }}</p>
                            <p class="text-gray-700"><strong>School Name:</strong>
                                {{ $reportData['school_name'] ?? '' }}</p>
                            <p class="text-gray-700"><strong>Age:</strong> {{ $reportData['age'] ?? '' }}</p>

                            @if ($reportData['latest_status_reason'])
                                <div class="bg-[#f0f9e3] border-l-4 border-[#c7da30] p-4 rounded-md">
                                    <p class="font-bold text-[#c7da30] mb-1">Latest Update Reason:</p>
                                    <p class="text-[#c7da30] font-semibold italic">
                                        {{ $reportData['latest_status_reason'] }}
                                    </p>
                                </div>
                            @endif

                            <p class="text-gray-700 pt-2"><strong>Description:</strong>
                                {{ !empty($reportData['description']) ? $reportData['description'] : 'N/A' }}</p>

                            <!-- Attachments -->
                            @php
                                $attachments = $reportData['image_path']
                                    ? json_decode($reportData['image_path'], true)
                                    : [];
                            @endphp

                            <!-- Replace the attachments section with this fixed version -->
                            @if (!empty($attachments))
                                <div class="mt-6">
                                    <p class="font-semibold text-black mb-2 font-[Montserrat]">Attachments:</p>
                                    <div class="flex flex-wrap gap-4 mt-2 overflow-hidden">
                                        @foreach ($attachments as $filePath)
                                            @php
                                                $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                                $publicUrl = Storage::url($filePath);
                                                $isImage = in_array($ext, [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                    'bmp',
                                                    'webp',
                                                    'svg',
                                                ]);
                                                $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'wmv']);
                                            @endphp

                                            @if ($isImage)
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $publicUrl }}"
                                                        class="w-32 h-auto border rounded shadow cursor-pointer hover:opacity-80 transition max-w-full"
                                                        onclick="window.open('{{ $publicUrl }}','_blank')">
                                                </div>
                                            @elseif ($isVideo)
                                                <div class="flex-shrink-0">
                                                    <video controls
                                                        class="w-48 h-auto border rounded shadow cursor-pointer hover:opacity-80 transition max-w-full">
                                                        <source src="{{ $publicUrl }}"
                                                            type="video/{{ $ext }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @else
                                                <div class="w-full sm:w-auto flex-shrink-0 break-words">
                                                    <a href="{{ $publicUrl }}" target="_blank"
                                                        class="text-blue-600 underline inline-block hover:text-blue-800 transition break-all max-w-full block p-2 border rounded bg-gray-50">
                                                        View {{ basename($filePath) }}
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="mt-6 text-gray-700">
                                    <strong>Attachment:</strong> N/A
                                </p>
                            @endif


                            <!-- False Report Appeal Section -->
                            @if ($reportData['status'] === 'false-report')
                                <div class="mt-6 pt-4 border-t-2 border-purple-300 bg-purple-50 rounded-lg p-5">
                                    <div class="flex items-center justify-center mb-3">
                                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h3
                                        class="text-[16px] font-semibold text-purple-800 mb-2 text-center font-[Montserrat]">
                                        Report Marked as False</h3>
                                    <p class="text-[13px] text-purple-700 mb-4 text-center">
                                        If you believe this determination is incorrect, you can appeal by updating your
                                        report with additional information or evidence.
                                    </p>
                                    <div class="mt-8 pt-6 border-t-2 border-[#c7da30]/30">
                                        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">

                                            <a href="{{ route('edit-report', ['caseNumber' => $reportData['case_number']]) }}"
                                                class="w-full sm:w-auto px-8 py-3 text-center border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] font-bold transition hover:scale-105 hover:opacity-90 bg-white shadow-sm font-[Montserrat]">
                                                EDIT REPORT
                                            </a>

                                            <a href="{{ route('report.clarify', ['caseNumber' => $reportData['case_number']]) }}"
                                                class="w-full sm:w-auto px-8 py-3 text-center border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] font-bold transition hover:scale-105 hover:opacity-90 bg-white shadow-sm font-[Montserrat]">
                                                ADD CLARIFICATION
                                            </a>

                                        </div>
                                        <p class="text-[12px] text-gray-500 mt-4 text-center italic">
                                            Use these options if you need to update your evidence or provide more
                                            details to the investigators.
                                        </p>
                                    </div>

                                </div>
                        </div>
                    @endif

                    <!-- Forwarded Status Actions -->
                    @if ($reportData['status'] === 'forwarded')
                        @if (
                            $reportData['latest_status_reason'] !== 'Reporter chose to keep the case Forwarded.' &&
                                $reportData['latest_status_reason'] !==
                                    'Reporter chose not to keep the case forwarded, changing the status to Unresolved.')
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <p class="font-semibold text-red-600 mb-2 font-[Montserrat]">
                                    Do you want your case to be forwarded?
                                </p>
                                <div class="flex flex-col sm:flex-row justify-center gap-4">
                                    <button wire:click="markUnresolved"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition w-full sm:w-auto">
                                        No
                                    </button>
                                    <button wire:click="markForwarded"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition w-full sm:w-auto">
                                        Yes
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Edit Report -->
                    @if ($reportData['status'] !== 'false-report')
                        <div class="mt-6 border-t pt-4">
                            <a href="{{ route('edit-report', ['caseNumber' => $reportData['case_number']]) }}"
                                class="inline-block w-full sm:w-auto px-6 py-2 border-4 border-[#c7da30] rounded-full text-[#38b6ff] hover:opacity-90 transition font-[Montserrat] text-center block sm:inline-block">
                                Edit Report
                            </a>
                        </div>
                    @endif

                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- ================= FOOTER ================= -->
<footer class="bg-[#808080] text-white py-6 sm:py-8 mt-8 sm:mt-12">
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row justify-between items-center gap-6 text-sm sm:text-base font-[Montserrat]">
        <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>

        <div class="flex items-center gap-3 sm:gap-4 flex-wrap justify-center md:justify-end">
            <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                <img src="{{ asset('images/youtube.png') }}"
                    class="w-7 h-7 sm:w-8 sm:h-8 hover:opacity-80 transition" alt="YouTube">
            </a>
            <a href="https://x.com/moepipublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/X.png') }}" class="w-7 h-7 sm:w-8 sm:h-8 hover:opacity-80 transition"
                    alt="X">
            </a>
            <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" rel="noopener">
                <img src="{{ asset('images/linkedIn.png') }}"
                    class="w-7 h-7 sm:w-8 sm:h-8 hover:opacity-80 transition" alt="LinkedIn">
            </a>
            <a href="https://www.facebook.com/MoepiPublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/facebook.png') }}"
                    class="w-8 h-7 sm:w-9 sm:h-8 hover:opacity-80 transition" alt="Facebook">
            </a>
            <a href="https://www.instagram.com/moepipublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/instagram.png') }}"
                    class="w-8 h-7 sm:w-9 sm:h-8 hover:opacity-80 transition" alt="Instagram">
            </a>
            <a href="https://www.tiktok.com/@moepipublishing" target="_blank" rel="noopener">
                <img src="{{ asset('images/tiktok.png') }}" class="w-8 h-7 sm:w-9 sm:h-8 hover:opacity-80 transition"
                    alt="TikTok">
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

    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-button');
        if (btn) btn.addEventListener('click', toggleMobileMenu);
    });
</script>
