<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full overflow-x-hidden">
    <!-- Header -->
    <header
        style="position: fixed; top: 0; left: 0; width: 100vw; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <div class="flex justify-between items-center py-2" style="width: 100%; padding-left: 2vw; padding-right: 2vw;">

            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Safe Space Logo" style="width: 110px; height: auto;">
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex gap-8"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                    <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">Back</a>
                    <a href="{{ route('landing-page') }}" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">Home</a>
                    <a href="{{ route('about-us') }}" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">About Us</a>
                    <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
                        class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">Workshops</a>
                       <a href="{{ route('contact-us') }}" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">Contact Us</a>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <!-- ================= MOBILE MENU ================= -->
<div id="mobile-menu" class="fixed inset-0 z-[200] hidden">

    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>

    <div id="mobile-menu-slide"
        class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl translate-x-full transition-transform duration-300 ease-in-out">

        <div class="flex items-center justify-start px-4 pt-16 pb-4">
            <button onclick="toggleMobileMenu()"
                class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100">
                <svg class="h-8 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="3"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="mt-8 px-6 space-y-2 pb-8 text-[17px]">

            <a href="javascript:void(0);"
               onclick="window.history.back(); toggleMobileMenu();"
               class="block py-3 text-[#38b6ff]">
                Back
            </a>

            <a href="{{ route('landing-page') }}"
               onclick="toggleMobileMenu()"
               class="block py-3 text-[#38b6ff]">
                Home
            </a>

            <a href="{{ route('about-us') }}"
               onclick="toggleMobileMenu()"
               class="block py-3 text-[#38b6ff]">
                About Us
            </a>

            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"
               onclick="toggleMobileMenu()"
               class="block py-3 text-[#38b6ff]">
                Workshops
            </a>

           
            <a href="{{ route('contact-us') }}"
               onclick="toggleMobileMenu()"
               class="block py-3 text-[#38b6ff]">
                Contact Us
            </a>

        </nav>

    </div>
</div>

    <!-- Success Modal -->
    @if ($showSuccessModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div
                class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white flex flex-col items-center justify-center w-[90%] sm:w-[635px] h-[300px] sm:h-[342px] p-4 text-center shadow-lg relative">
                <p class="text-[18px] sm:text-[19px] text-black mb-4">
                    {{ $isAppeal ? 'APPEAL SUBMITTED SUCCESSFULLY!' : 'REPORT UPDATED SUCCESSFULLY!' }}
                </p>
                <img src="{{ asset('images/tick.png') }}" class="w-[60px] sm:w-[80px] h-auto my-4">
                <p class="text-[15px] sm:text-[16px] text-black mb-6">{{ $successMessage }}</p>

                <button wire:click="closeSuccessModal"
                    class="w-[190px] h-[56px] sm:h-[64px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] text-[15px] font-normal transition duration-200 hover:opacity-80 shadow-md flex items-center justify-center">
                    OK
                </button>
            </div>
        </div>
    @endif

    <!-- Main Section -->
    <div
        style="font-family: 'Montserrat', sans-serif; background-color: #fff; min-height: 100vh; padding: 120px 1.5rem 40px;">
        <div style="max-width: 1280px; margin: 0 auto; width: 100%;">

            <!-- Page Title -->
            <h1 class="text-center text-[22px] font-[700] uppercase text-black mb-8">
                Edit Your Report
            </h1>

            <!-- Form Container -->
            <div class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white w-full max-w-[640px] p-6 sm:p-10">
                @if (isset($caseNumber))
                    <p class="text-center text-[17px] text-black font-[500] mb-8">
                        Case Number: {{ $caseNumber }}
                    </p>
                    <p class="text-center text-[14px] text-gray-600 font-[400] mb-8">
                        Submitted on: {{ $report->created_at->format('Y/m/d') }}
                    </p>
                @endif

                <form wire:submit.prevent="updateReport" class="space-y-6">

                    <!-- Report Type Selection -->

                    <div>
                        <label for="abuseTypeID" class="text-[11px] text-black">Report Type <span
                                class="text-red-500">*</span></label>
                        <select wire:model.live="abuseTypeID" id="abuseTypeID"
                            class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black bg-white">
                            <option value="">Select Report Type</option>
                            @foreach ($abuseTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                        @error('abuseTypeID')
                            <p class="text-red-600 text-[12px]">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subtype Selection -->
                    @if ($abuseTypeID)
                        <div>
                            <label for="subtypeID" class="text-[11px] text-black">Subtype <span
                                    class="text-red-500">*</span></label>
                            <select wire:model.live="subtypeID" id="subtypeID"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black bg-white">
                                <option value="">Select Subtype</option>
                                @foreach ($standardSubtypes as $subtype)
                                    <option value="{{ $subtype->id }}">{{ $subtype->sub_type_name }}</option>
                                @endforeach
                                @if ($otherSubtype)
                                    <option value="{{ $otherSubtype->id }}">{{ $otherSubtype->sub_type_name }}
                                    </option>
                                @endif
                            </select>
                            @error('subtypeID')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Description -->
                        <div>
                            <label for="description" class="text-[11px] text-black">
                                Additional Details
                                @if ($this->isOtherSubtypeSelected)
                                    <span class="text-red-500">*</span>
                                    <span class="text-gray-500 text-[10px]">(Required when "Other" is selected)</span>
                                @else
                                    <span class="text-gray-500">(Optional)</span>
                                @endif
                            </label>
                            <textarea wire:model="description" id="description" rows="4"
                                class="w-full border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black bg-white h-[120px]"></textarea>

                            @if (empty($description))
                                @if ($this->isOtherSubtypeSelected)
                                @endif
                            @else
                                <p class="text-[12px] text-green-600 mt-1">Additional details added
                                    ({{ strlen($description) }} characters)</p>
                            @endif

                            @error('description')
                                <p class="text-red-600 text-[12px]">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Attachments -->
                    <div class="mt-6">
                        <label class="text-[12px] text-black font-semibold">Attachments</label>

                        @if (!empty($existingAttachments))
                            <div class="flex flex-wrap gap-4 mt-3">
                                @foreach ($existingAttachments as $index => $filePath)
                                    @php
                                        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                        $url = asset('storage/' . ltrim($filePath, '/'));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']);
                                        $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'wmv']);
                                    @endphp
                                    <div class="relative">
                                        @if ($isImage)
                                            <img src="{{ $url }}" alt="Attachment"
                                                class="w-32 h-32 object-cover border rounded shadow cursor-pointer hover:opacity-80 transition"
                                                onclick="window.open('{{ $url }}', '_blank')">
                                        @elseif ($isVideo)
                                            <video controls
                                                class="w-32 h-32 border rounded shadow cursor-pointer hover:opacity-80 transition">
                                                <source src="{{ $url }}" type="video/{{ $ext }}">
                                            </video>
                                        @else
                                            <a href="{{ $url }}" target="_blank"
                                                class="text-blue-600 underline inline-block hover:text-blue-800 transition">
                                                View {{ basename($filePath) }}
                                            </a>
                                        @endif
                                        <button type="button"
                                            wire:click="removeExistingAttachment({{ $index }})"
                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full px-1 text-xs hover:bg-red-600">✕</button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-4">
                            <input type="file" wire:model="newUploads" multiple
                                class="form-control border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 w-full text-[14px] text-black bg-white">
                            @error('newUploads.*')
                                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($image)
                            <ul class="list-group mt-3">
                                @foreach ($image as $index => $file)
                                    <li class="list-group-item flex flex-col">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                {{ $file->getClientOriginalName() }}
                                                <span wire:loading.remove wire:target="newUploads.{{ $index }}"
                                                    class="bg-green-100 text-green-800 text-[12px] font-semibold px-2 py-1 rounded-full">Uploaded</span>
                                            </div>
                                            <button type="button" wire:click="removeImage({{ $index }})"
                                                class="btn btn-sm btn-outline-danger p-1 ml-2"
                                                title="Remove">✖️</button>
                                        </div>
                                        <div class="mt-1">
                                            <span wire:loading wire:target="newUploads.{{ $index }}"
                                                class="bg-yellow-100 text-yellow-800 text-[12px] font-semibold px-2 py-1 rounded-full inline-block">Uploading...</span>
                                        </div>
                                        @php
                                            $mime = $file->getMimeType();
                                            $isImage = str_starts_with($mime, 'image/');
                                            $isVideo = str_starts_with($mime, 'video/');
                                        @endphp
                                        @if ($isImage)
                                            <img src="{{ $file->temporaryUrl() }}" alt="Preview"
                                                class="w-32 h-32 object-cover border rounded mt-2 cursor-pointer hover:opacity-80 transition"
                                                onclick="window.open('{{ $file->temporaryUrl() }}', '_blank')">
                                        @elseif ($isVideo)
                                            <video controls class="w-32 h-32 border rounded mt-2">
                                                <source src="{{ $file->temporaryUrl() }}"
                                                    type="{{ $mime }}">
                                            </video>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Personal Information -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h2 class="text-[15px] font-semibold text-black mb-3">Personal Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            @if (!$isAnonymous)
                                <div>
                                    <label for="fullName" class="text-[11px] text-black">Full Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" wire:model="fullName" id="fullName"
                                        class="w-full h-[50px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black">
                                    @error('fullName')
                                        <p class="text-red-600 text-[12px]">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                <div
                                    class="bg-blue-50 border border-blue-200 rounded-md p-3 text-[13px] text-blue-800">
                                    This report was submitted anonymously. Your full name is not required.
                                </div>
                            @endif

                            {{-- CHANGED: wire:model.live so grade dropdown reacts instantly when age is typed --}}
                            <div>
                                <label for="age" class="text-[11px] text-black">Age</label>
                                <input type="number" wire:model.live="age" id="age" min="0"
                                    max="115"
                                    class="w-full h-[50px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black">
                                @error('age')
                                    <p class="text-red-600 text-[12px]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phoneNumber" class="text-[11px] text-black">Phone Number</label>
                                <input type="text" wire:model.live="phoneNumber" id="phoneNumber"
                                    maxlength="10" inputmode="numeric"
                                    placeholder="e.g. 0821234567"
                                    class="w-full h-[50px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black">
                                @error('phoneNumber')
                                    <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- CHANGED: dynamic grade dropdown matching ReportForm exactly --}}
                             {{-- CHANGED: dynamic grade dropdown matching ReportForm exactly --}}
                            <div wire:key="grade-wrapper-{{ $age }}-{{ $schoolPhase }}">
                                <label for="grade" class="text-[11px] text-black">Grade <span
                                        class="text-red-500">*</span></label>
                                <select wire:model.live="grade" id="grade"
                                    class="w-full h-[50px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black bg-white"
                                    required>
                                    <option value="">-- Select Grade --</option>
                                   @if (!blank($age))
            {{-- Dynamic Filtered List --}}
            @foreach ($this->applicableGrades as $gradeOption)
                <option value="{{ $gradeOption }}" wire:key="edit-grade-{{ $gradeOption }}">
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
                    </div>

                    <!-- Location Information -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h2 class="text-[15px] font-semibold text-black mb-3">Location Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="location" class="text-[11px] text-black">Location</label>
                                <input type="text" wire:model.blur="location" id="location"
                                    placeholder="e.g. 123 Main Street, Gauteng"
                                    class="w-full h-[50px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black">
                                @error('location')
                                    <p class="text-red-600 text-[12px]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative">
                                <label for="schoolSearch" class="text-[11px] text-black">Name of School</label>
                                <div wire:ignore>
                                    <input type="text" id="schoolSearch" placeholder="Start typing school name..."
                                        value="{{ $schoolSearch }}"
                                        class="w-full h-[50px] border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14px] text-black">
                                    <input type="hidden" id="schoolName" wire:model.live="schoolName"
                                        name="schoolName">
                                    <input type="hidden" id="schoolProvince" wire:model.live="schoolProvince">
                                    <input type="hidden" id="schoolId" name="schoolId" wire:model="schoolId" value="">
                                    <div id="schoolDropdown"
                                        class="absolute z-10 bg-white border border-gray-300 w-full mt-1 max-h-[200px] overflow-y-auto text-[13px]"
                                        style="display:none;"></div>
                                </div>
                                @error('schoolName')
                                    <p class="text-red-600 text-[12px]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-8 flex justify-center gap-6 flex-wrap mb-4">
                        {{-- Updated Cancel Button --}}
                        <a href="{{ route('check-status', ['caseNumber' => $caseNumber]) }}"
                            class="flex-1 h-[50px] sm:h-[52px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] text-[15px] font-medium cursor-pointer flex items-center justify-center transition hover:opacity-90">
                            Cancel
                        </a>

                        <button type="submit"
                            class="flex-1 h-[50px] sm:h-[52px] border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] text-[15px] font-medium cursor-pointer transition hover:opacity-90">
                            <span wire:loading wire:target="updateReport">Updating...</span>
                            <span wire:loading.remove wire:target="updateReport">Update Report</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
   <footer class="relative w-full bg-[#757573] text-white px-4 py-6 flex flex-col items-center gap-4 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:gap-2 lg:px-[2vw] mt-auto z-30 font-[Montserrat]">
            <p class="text-[13px] leading-5 text-center font-normal text-white min-[640px]:text-[14px] lg:text-[16px] min-[640px]:text-left w-full min-[640px]:w-auto">
                &copy; {{ date('Y') }} Tekete safespace from moepi<br class="min-[640px]:hidden">Publishing.all rights reserved.
            </p>
            <div class="flex items-center justify-center flex-wrap gap-4 min-[640px]:gap-2 lg:gap-[1vw]">
                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}" class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition" alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
            </div>
    </footer>


    <script>
        (function() {
            const API_ENDPOINT = '/api/schools';
            const LS_KEY = 'schools_cache_v3';
            const CACHE_TTL = 24 * 60 * 60 * 1000;

            const input = document.getElementById('schoolSearch');
            const dropdown = document.getElementById('schoolDropdown');
            const hiddenName = document.getElementById('schoolName');
            const hiddenId = document.getElementById('schoolId');

            if (input.value && input.value.trim()) {
                hiddenName.value = input.value.trim();
                hiddenName.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }

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
                    } else {
                        schools = parsed.data.map(school => ({
                            id: school.school_id,
                            emis_no: school.emis_no,
                            name: school.school_name,
                            province: school.province,
                            district: school.district,
                            towncity: school.towncity,
                            address: school.address,
                            telephone: school.telephone,
                            phase_ped: school.phase_ped
                        }));
                        saveCache(schools);
                    }
                    return true;
                } catch (e) {
                    return false;
                }
            }

            function saveCache(data) {
                try {
                    localStorage.setItem(LS_KEY, JSON.stringify({
                        data,
                        timestamp: Date.now()
                    }));
                } catch (e) {}
            }

            async function loadFromDatabase() {
                try {
                    const res = await fetch(API_ENDPOINT, {
                        cache: 'no-store'
                    });
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
                if (!items.length) {
                    dropdown.style.display = 'none';
                    return;
                }
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

                const provinceEl = document.getElementById('schoolProvince');
                if (provinceEl) {
                    provinceEl.value = it.province ?? '';
                    provinceEl.dispatchEvent(new Event('input', { bubbles: true }));
                }

                document.getElementById('schoolName').dispatchEvent(new Event('input', {
                    bubbles: true
                }));
                hiddenId.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
                clearSuggestions();
            }

            input.addEventListener('input', function() {
                hiddenName.value = '';
                hiddenId.value = '';
                const provinceEl = document.getElementById('schoolProvince');
                if (provinceEl) {
                    provinceEl.value = '';
                    provinceEl.dispatchEvent(new Event('input', { bubbles: true }));
                }
                clearTimeout(timer);
                const q = this.value.trim();
                if (q.length < 1) {
                    clearSuggestions();
                    document.getElementById('schoolName').dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                    return;
                }
                timer = setTimeout(() => {
                    render(searchPrefix(q, 20));
                }, 200);
            });

            input.addEventListener('blur', function() {
                setTimeout(() => {
                    if (this.value.trim() && hiddenName.value !== this.value.trim()) {
                        hiddenName.value = this.value.trim();
                        document.getElementById('schoolName').dispatchEvent(new Event('input', {
                            bubbles: true
                        }));
                    }
                }, 150);
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
                } else if (e.key === 'Escape') {
                    clearSuggestions();
                }
            });

            function updateFocus() {
                for (let i = 0; i < dropdown.children.length; i++) {
                    dropdown.children[i].style.background = (i === focused) ? '#c6d933' : '';
                    dropdown.children[i].style.color = (i === focused) ? '#000' : '';
                }
                if (focused >= 0 && dropdown.children[focused]) {
                    dropdown.children[focused].scrollIntoView({
                        block: 'nearest'
                    });
                }
            }

            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !dropdown.contains(e.target)) clearSuggestions();
            });
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        })();

        function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const slide = document.getElementById('mobile-menu-slide');

    if (!menu || !slide) return;

    if (menu.classList.contains('hidden')) {

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

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-button');

    if (btn) {
        btn.addEventListener('click', toggleMobileMenu);
    }
});
    </script>

</div>
