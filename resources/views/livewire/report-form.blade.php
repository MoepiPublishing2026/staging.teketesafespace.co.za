<div class="min-h-screen bg-white flex flex-col font-[Montserrat] w-full overflow-x-hidden">
    <script src="//unpkg.com/alpinejs" defer></script>

    <header
        style="position: fixed; top: 0; left: 0; width: 100vw; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="w-[143px] h-auto flex-shrink-0">
            </div>
            <div class="flex gap-8" style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                <div class="hidden md:flex gap-8"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                    <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
                        Back
                    </a>
                    <a href="{{ route('landing-page') }}" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">
                        Home
                    </a>
                    <a href="{{ route('about-us') }}" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">
                        About Us
                    </a>
                    <a href="{{ route('contact-us') }}" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">
                        Contact Us
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]"
                        onclick="toggleMobileMenu()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div
            class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <main class="flex-1">
    <div style="font-family: 'Montserrat', sans-serif; background-color: #fff; min-height: auto; padding: 120px 1.5rem 40px; position: relative;">
        <div style="max-width: 1280px; margin: 0 auto; width: 100%;">

            <h1 class="text-center text-[20px] sm:text-[22px] font-[700] uppercase text-black mb-2">
                Report a Case
            </h1>

            @if ($isAnonymous)
                <p class="text-center text-[15px] font-[700] text-black mb-1">
                    You are reporting anonymously
                </p>
            @else
                <p class="text-center text-[15px] font-[700] text-black mb-1">
                    You are reporting with your details
                </p>
            @endif

            <p class="text-center text-[15px] text-black mb-6 sm:mb-8">
                Report Type: {{ $selectedAbuseTypeName }}
            </p>

            @if (session('success_message'))
                <div x-data="{ open: true }" x-show="open"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div
                        class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white 
                             flex flex-col items-center justify-center w-[90%] sm:w-[635px] 
                             h-[300px] sm:h-[342px] p-4 text-center shadow-lg relative">

                        <p class="text-[18px] sm:text-[19px] text-black mb-4">
                            REPORT SUBMITTED SUCCESSFULLY!
                        </p>

                        <img src="{{ asset('images/tick.png') }}" alt="Success Tick"
                            class="w-[60px] sm:w-[80px] h-auto my-4">

                        <p class="text-[18px] sm:text-[19px] text-black mb-6">
                            CASE NUMBER:
                            {{ str_replace('Your report has been submitted successfully! Case number: ', '', session('success_message')) }}
                        </p>

                        <button
                            @click="
                            open = false;
                            document.querySelector('form').reset();
                            window.livewire.emit('resetForm');
                        "
                            class="w-[190px] h-[56px] sm:h-[64px]
                               border-4 border-solid border-[#c7da30]
                               rounded-[100px] text-[#38b6ff] 
                               text-[15px] font-normal transition duration-200 
                               hover:opacity-80 shadow-md flex items-center justify-center">
                            Close
                        </button>
                    </div>
                </div>
            @endif

            @if (session()->has('error_message'))
                <div
                    style="background-color: #fee2e2; border-bottom: 1px solid #ef4444; color: #b91c1c; width: 100%; padding: 15px 0; text-align: center; margin-bottom: 20px; border-radius: 8px;">
                    <strong style="display: block; margin-bottom: 5px;">{{ session('error_message') }}</strong>

                    @php
                        $expiry = $latestReport->suspended_until ?? session('expiry_date');
                    @endphp

                    @if ($expiry)
                        <div style="font-size: 0.9rem;">
                            Time Remaining:
                            <span id="timer-display"
                                data-expiry="{{ \Carbon\Carbon::parse($expiry)->toIso8601String() }}"
                                style="font-weight: bold; font-family: monospace; font-size: 1.1rem;">
                                Calculating...
                            </span>
                        </div>
                    @endif
                </div>
            @endif

            <div class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white w-full max-w-[640px] p-6 sm:p-10">
                <form wire:submit.prevent="submitReport" enctype="multipart/form-data">

                    @if ($standardSubtypes->isNotEmpty() || $otherSubtype)
                        <div class="mb-5">
                            <label for="subtypeID" class="text-[12px] text-black">Sub-type</label>
                            <select id="subtypeID" wire:model.live="subtypeID"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14px] sm:text-[14.8px] text-black bg-white">
                                <option value="">-- Select a Subtype --</option>
                                @foreach ($standardSubtypes as $subtype)
                                    <option value="{{ $subtype->id }}">{{ $subtype->sub_type_name }}</option>
                                @endforeach
                                @if ($otherSubtype)
                                    <option value="{{ $otherSubtype->id }}">{{ $otherSubtype->sub_type_name }}</option>
                                @endif
                            </select>
                            @error('subtypeID')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @if (!$isAnonymous)
                            <div>
                                <label for="fullName" class="text-[12px] text-black">Full Name</label>
                                <input type="text" wire:model="fullName" id="fullName"
                                    class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black">
                                @error('fullName')
                                    <p class="text-red-600 text-[12px]">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div>
                            <label for="age" class="text-[12px] text-black">Age</label>
                            <input type="number" wire:model.live="age" id="age" min="0" max="115"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black">
                            @error('age')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="relative">
                                <label for="schoolSearch" class="text-[12px] text-black">Name of School</label>
                                <div wire:ignore>
                                    <input type="text" id="schoolSearch" placeholder="Start typing school name..."
                                        class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black bg-white"
                                        pattern="^[a-zA-Z\s.,\-&amp;']+$"
                                        title="The School Name can only contain letters, spaces, hyphens (-), apostrophes ('), commas (,), periods (.), and the ampersand (&amp;)."
                                        maxlength="100">
                                    <input type="hidden" id="schoolName" wire:model.lazy="schoolName" name="schoolName" value="">
                                    <input type="hidden" id="schoolProvince" wire:model.lazy="schoolProvince">
                                    <input type="hidden" id="schoolId" name="schoolId" value="">
                                    <div id="schoolDropdown"
                                        class="absolute z-10 bg-white border border-gray-300 w-full mt-1 max-h-[200px] overflow-y-auto text-[13px]"
                                        style="display:none;"></div>
                                </div>
                                @error('schoolName')
                                    <p class="text-red-600 text-[12px]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="reporterEmail" class="text-[12px] text-black">Email Address</label>
                            <input type="email" wire:model.lazy="reporterEmail" id="reporterEmail"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 text-[14.8px] text-black"
                                placeholder="e.g. example@gmail.com"
                                title="Please enter a valid email address (e.g., user@domain.com, user@domain.co.za)"
                                maxlength="50">
                            @error('reporterEmail')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phoneNumber" class="text-[12px] text-black">Phone Number</label>
                            <input type="text" wire:model.lazy="phoneNumber" id="phoneNumber"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 text-[14.8px] text-black"
                                placeholder="e.g. 0789 345 687" maxlength="15">
                            @error('phoneNumber')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="text-[12px] text-black">Address</label>
                            <input type="text" wire:model="location" id="location"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black"
                                placeholder="e.g. 123 street, Province">
                            @error('location')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div wire:key="grade-wrapper-{{ $age }}-{{ $schoolPhase }}">
                            <label for="grade" class="text-[12px] text-black">Grade</label>
                            <select wire:model.live="grade" id="grade"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black bg-white"
                                required>
                                <option value="">-- Select Grade --</option>
                                @if (!blank($age))
                                    @foreach ($this->applicableGrades as $gradeOption)
                                        <option value="{{ $gradeOption }}" wire:key="grade-{{ $gradeOption }}">
                                            {{ $gradeOption }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="Creche">Creche</option>
                                    <option value="Grade R">Grade R</option>
                                    <option value="Grade 1">Grade 1</option>
                                    <option value="Grade 2">Grade 2</option>
                                    <option value="Grade 3">Grade 3</option>
                                    <option value="Grade 4">Grade 4</option>
                                    <option value="Grade 5">Grade 5</option>
                                    <option value="Grade 6">Grade 6</option>
                                    <option value="Grade 7">Grade 7</option>
                                    <option value="Grade 8">Grade 8</option>
                                    <option value="Grade 9">Grade 9</option>
                                    <option value="Grade 10">Grade 10</option>
                                    <option value="Grade 11">Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                @endif
                            </select>
                            @error('grade')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="description" class="text-[11px] text-black">
                            Description
                            @if ($isOtherSubtypeSelected)
                                <span class="text-red-600 font-semibold">(Required)</span>
                            @else
                                <span class="text-gray-500">(Optional)</span>
                            @endif
                        </label>
                        <textarea wire:model="description" id="description" rows="4" maxlength="200"
                            @if ($isOtherSubtypeSelected) required @endif
                            class="w-full border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14.8px] text-black bg-white h-[120px] sm:h-[126px]"></textarea>
                        @error('description')
                            <p class="text-red-600 text-[12px]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fileUpload" class="text-[12px] text-black font-semibold">Attachment (Optional)</label>
                        <input type="file" wire:model="newUploads" multiple
                            accept="image/*,video/*,audio/*,.mp3,.wav,.m4a,.mp4,.ogg,.webm,.amr,.aac,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                            class="form-control border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 w-full text-[14px] text-black"
                            id="fileUpload">

                        @error('newUploads.*')
                            <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                        @enderror

                        <div class="mt-3">
                            @if ($image)
                                <ul class="list-group space-y-2">
                                    @foreach ($image as $index => $file)
                                        <li class="flex flex-col p-3 border border-gray-200 rounded-lg bg-gray-50">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                                    @if (str_contains($file->getMimeType(), 'image/'))
                                                        <img src="{{ $file->temporaryUrl() }}"
                                                            class="w-10 h-10 object-cover rounded border">
                                                    @elseif(str_contains($file->getMimeType(), 'video/'))
                                                        <video class="w-10 h-10 object-cover rounded border" muted>
                                                            <source src="{{ $file->temporaryUrl() }}" type="{{ $file->getMimeType() }}">
                                                        </video>
                                                    @elseif(str_contains($file->getMimeType(), 'audio/'))
                                                        <svg class="w-10 h-10 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h3a2 2 0 002-2v-1.5a.5.5 0 011 0V9a1 1 0 01-1 1H6a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 011 1z" />
                                                            <path fill-rule="evenodd" d="M3 5a1 1 0 00-2 0v10a1 1 0 002 0V5zm12 2a1 1 0 110 2h3a1 1 0 110-2h-3zM9.5 13a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-10 h-10 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 9H5l.01-1.99L17 8v5a1 1 0 01-1 1z" />
                                                        </svg>
                                                    @endif
                                                    <div class="min-w-0 flex-1 truncate">
                                                        <div class="font-medium text-sm truncate">{{ $file->getClientOriginalName() }}</div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ number_format($file->getSize() / 1024, 1) }} KB
                                                            <span class="ml-1">{{ strtoupper(str_replace(['audio/', 'video/', 'image/'], '', $file->getMimeType())) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" wire:click="removeImage({{ $index }})"
                                                    class="flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 text-sm rounded-full hover:bg-red-200 transition-colors"
                                                    title="Remove file">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Remove
                                                </button>
                                            </div>

                                            @if (str_contains($file->getMimeType(), 'audio/'))
                                                <div class="mt-2 pt-2 border-t border-gray-200">
                                                    <audio controls class="w-full" preload="metadata">
                                                        <source src="{{ $file->temporaryUrl() }}" type="{{ $file->getMimeType() }}">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                </div>
                                            @elseif(str_contains($file->getMimeType(), 'video/'))
                                                <div class="mt-2 pt-2 border-t border-gray-200">
                                                    <video controls class="w-full h-24 rounded object-contain bg-black" preload="metadata">
                                                        <source src="{{ $file->temporaryUrl() }}" type="{{ $file->getMimeType() }}">
                                                    </video>
                                                </div>
                                            @endif

                                            <div class="mt-2 flex gap-2">
                                                <span wire:loading.remove wire:target="newUploads,removeImage({{ $index }})"
                                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                                                    Ready
                                                </span>
                                                <span wire:loading wire:target="newUploads,removeImage({{ $index }})"
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full animate-pulse hidden">
                                                    Processing...
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="mt-7 text-center">
                            <button type="submit" wire:loading.attr="disabled" wire:target="submitReport"
                                class="w-full h-[50px] sm:h-[52px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] text-[15px] font-medium cursor-pointer transition duration-200 hover:opacity-80 shadow-md">
                                <span wire:loading.remove wire:target="submitReport">Submit</span>
                                <span wire:loading wire:target="submitReport">Submitting...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main

    <!-- Footer -->
    
    <footer class="w-full bg-[#808080] text-white py-6 mt-auto">
        <div class="max-w-[1280px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6"
            style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
            <div>
                <p>&copy; {{ date('Y') }} Tekete SafeSpace from Moepi Publishing. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-4 order-2">
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
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.instagram.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram Icon" style="width: 30px; height: 30px;">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok Icon" style="width: 30px; height: 30px;">
                </a>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        (function() {
            const API_ENDPOINT = '/api/schools';
            const LS_KEY = 'schools_cache_v3';
            const CACHE_TTL = 24 * 60 * 60 * 1000;

            const input = document.getElementById('schoolSearch');
            const dropdown = document.getElementById('schoolDropdown');
            const hiddenName = document.getElementById('schoolName');
            const hiddenId = document.getElementById('schoolId');

            let schools = [];
            let items = [];
            let focused = -1;
            let timer = null;

            function loadCache() {
                try {
                    const raw = localStorage.getItem(LS_KEY);
                    if (!raw) return false;
                    const parsed = JSON.parse(raw);
                    if (!parsed.data || !parsed.timestamp) return false;
                    if (Date.now() - parsed.timestamp > CACHE_TTL) return false;
                    if (parsed.data.length > 0 && parsed.data[0].name) {
                        schools = parsed.data;
                        return true;
                    }
                    return false;
                } catch (e) {
                    return false;
                }
            }

            function saveCache(data) {
                try {
                    localStorage.setItem(LS_KEY, JSON.stringify({ data, timestamp: Date.now() }));
                } catch (e) {}
            }

            async function loadFromDatabase() {
                try {
                    const res = await fetch(API_ENDPOINT, { cache: 'no-store' });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const json = await res.json();
                    if (Array.isArray(json)) {
                        schools = json;
                        saveCache(schools);
                    }
                } catch (e) {
                    console.warn('Failed to load schools from database', e);
                }
            }

            (async function init() {
                if (!loadCache()) {
                    await loadFromDatabase();
                }
                fetch(API_ENDPOINT).then(r => r.json()).then(d => {
                    if (Array.isArray(d)) {
                        schools = d;
                        saveCache(schools);
                    }
                }).catch(() => {});
            })();

            function searchPrefix(q, limit = 12) {
                if (!q) return [];
                const low = q.toLowerCase();
                const out = [];
                for (let i = 0; i < schools.length && out.length < limit; i++) {
                    const s = schools[i];
                    if (!s || !s.name) continue;
                    if (s.name.toLowerCase().startsWith(low)) out.push(s);
                }
                return out;
            }

            function render(arr) {
                dropdown.innerHTML = '';
                items = arr || [];
                focused = -1;
                if (!items.length) { dropdown.style.display = 'none'; return; }
                for (let i = 0; i < items.length; i++) {
                    const it = items[i];
                    const el = document.createElement('div');
                    el.className = 'p-2 cursor-pointer hover:bg-[#c6d933]';
                    el.textContent = it.name + (it.province ? (' (' + it.province + ')') : '');
                    el.dataset.index = i;
                    el.addEventListener('pointerdown', function(e) {
                        e.preventDefault();
                        selectItem(parseInt(this.dataset.index, 10));
                    });
                    dropdown.appendChild(el);
                }
                dropdown.style.display = 'block';
            }

            function clearSuggestions() {
                dropdown.innerHTML = '';
                dropdown.style.display = 'none';
                items = [];
                focused = -1;
            }

            function selectItem(index) {
                const it = items[index];
                if (!it) return;
                input.value = it.name;
                hiddenName.value = it.name;
                hiddenId.value = it.id ?? '';
                document.getElementById('schoolName').dispatchEvent(new Event('input', { bubbles: true }));
                clearSuggestions();
            }

            input.addEventListener('input', function() {
                hiddenName.value = this.value;
                hiddenId.value = '';
                document.getElementById('schoolName').dispatchEvent(new Event('input', { bubbles: true }));
                clearTimeout(timer);
                const q = this.value.trim();
                if (q.length < 1) { clearSuggestions(); return; }
                timer = setTimeout(() => { render(searchPrefix(q, 20)); }, 120);
            });

            input.addEventListener('keydown', function(e) {
                if (dropdown.style.display === 'none') return;
                const count = dropdown.children.length;
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    focused = Math.min(count - 1, Math.max(0, focused + 1));
                    updateFocus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    focused = Math.max(0, focused - 1);
                    updateFocus();
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (focused >= 0) selectItem(focused);
                    else clearSuggestions();
                } else if (e.key === 'Escape') {
                    clearSuggestions();
                }
            });

            function updateFocus() {
                for (let i = 0; i < dropdown.children.length; i++) {
                    dropdown.children[i].classList.remove('bg-[#c6d933]', 'text-black');
                    if (i === focused) dropdown.children[i].classList.add('bg-[#c6d933]', 'text-black');
                }
                if (focused >= 0 && dropdown.children[focused]) {
                    dropdown.children[focused].scrollIntoView({ block: 'nearest' });
                }
            }

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) clearSuggestions();
            });
        })();

        function runSuspensionTimer() {
            const display = document.getElementById('timer-display');
            if (!display || !display.dataset.expiry) return;
            const expiryDate = new Date(display.dataset.expiry).getTime();
            if (window.suspensionInterval) clearInterval(window.suspensionInterval);
            window.suspensionInterval = setInterval(function() {
                const now = new Date().getTime();
                const distance = expiryDate - now;
                if (distance < 0) {
                    clearInterval(window.suspensionInterval);
                    display.innerHTML = "EXPIRED";
                    setTimeout(() => { window.location.reload(); }, 1000);
                    return;
                }
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let timerParts = [];
                if (days > 0) timerParts.push(days + "d");
                timerParts.push(hours + "h");
                display.innerHTML = timerParts.join(" ");
            }, 1000);
        }

        document.addEventListener('livewire:init', () => {
            runSuspensionTimer();
            Livewire.on('start-suspension-countdown', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                const display = document.getElementById('timer-display');
                if (display) {
                    display.dataset.expiry = data.expiresAt;
                    runSuspensionTimer();
                }
            });
        });

        let countdownInterval;

        function startCountdown() {
            const display = document.getElementById('timer-display');
            if (!display) return;
            const expiryDate = new Date(display.getAttribute('data-expiry')).getTime();
            if (window.activeTimer) clearInterval(window.activeTimer);
            window.activeTimer = setInterval(function() {
                const now = new Date().getTime();
                const distance = expiryDate - now;
                if (distance < 0) {
                    clearInterval(window.activeTimer);
                    display.innerHTML = "Suspension Expired. Please refresh.";
                    return;
                }
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                display.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            }, 1000);
        }

        document.addEventListener('livewire:initialized', startCountdown);
        document.addEventListener('livewire:navigated', startCountdown);
        window.addEventListener('restart-timer', () => { setTimeout(startCountdown, 100); });
    </script>

</div>
