<div class="min-h-screen bg-white flex flex-col font-[Montserrat] w-full overflow-x-hidden">
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

                 <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
                        Back
                    </a>

                <a href="{{ route('landing-page') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    Home
                </a>

                <a href="{{ route('about-us') }}"
                    class="text-black transition-colors hover:!text-[#c7da30]">
                    About Us
                </a>
                <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops"  class="text-black transition-colors hover:!text-[#c7da30]">
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
        type="button"
        class="p-2 rounded-md text-[#c7da30] hover:bg-gray-100 focus:outline-none">
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
              <a href="javascript:void(0);"
       onclick="window.history.back(); toggleMobileMenu();"class="block py-3 text-[#38b6ff]"> Back</a>

            <a href="{{ route('landing-page') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Home</a>
            <a href="{{ route('about-us') }}" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">About Us</a>
            <a href="{{ rtrim(config('tekete.workshop_booking_url'), '/') }}/workshops" onclick="toggleMobileMenu()" class="block py-3 text-[#38b6ff]">Workshops</a>
           <a href="{{ route('contact-us') }}" onclick="toggleMobileMenu()" class="block py-3  text-[#38b6ff]">Contact Us</a>

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
    <p class="hidden sm:block text-center text-[15px] font-[700] text-black mb-1">
        You are reporting anonymously
    </p>
@else
    <p class="hidden sm:block text-center text-[15px] font-[700] text-black mb-1">
        You are reporting with your details
    </p>
@endif

           <p class="text-center text-[15px] font-bold sm:font-normal text-black mb-6 sm:mb-8">
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 items-start">

    {{-- SUB-TYPE FIRST --}}
    @if ($standardSubtypes->isNotEmpty() || $otherSubtype)
        <div class="w-full sm:col-span-2">
            <label for="subtypeID" class="block text-[12px] text-black mb-1">
                Sub-type
            </label>

            <select id="subtypeID"
                wire:model.live="subtypeID"
                class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white">

                <option value="">-- Select a Subtype --</option>

                @foreach ($standardSubtypes as $subtype)
                    <option value="{{ $subtype->id }}">
                        {{ $subtype->sub_type_name }}
                    </option>
                @endforeach

                @if ($otherSubtype)
                    <option value="{{ $otherSubtype->id }}">
                        {{ $otherSubtype->sub_type_name }}
                    </option>
                @endif
            </select>

            @error('subtypeID')
                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
            @enderror
        </div>
    @endif

    @if (!$isAnonymous)
                            <div class="w-full">
                                <label for="fullName" class="block text-[12px] text-black mb-1">Full Name</label>
                                <input type="text" wire:model="fullName" id="fullName"
                                    class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white">
                                @error('fullName')
                                    <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label for="age" class="block text-[12px] text-black mb-1">Age</label>
                                <input type="number" wire:model.live="age" id="age" min="0" max="115"
                                    class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white">
                                @error('age')
                                    <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="w-full">
                            <label for="schoolSearch" class="block text-[12px] text-black mb-1">Name of School</label>
                            <div class="relative" wire:ignore>
                                <input type="text" readonly onfocus="this.removeAttribute('readonly');" autocomplete="off" id="schoolSearch" placeholder="Start typing school name..."
                                    class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white"
                                    pattern="^[a-zA-Z\s.,\-&amp;']+$"
                                    title="The School Name can only contain letters, spaces, hyphens (-), apostrophes ('), commas (,), periods (.), and the ampersand (&amp;)."
                                    maxlength="100">
                                <input type="hidden" id="schoolName" wire:model.lazy="schoolName" name="schoolName" value="">
                                <input type="hidden" id="schoolProvince" wire:model.lazy="schoolProvince">
                                <input type="hidden" id="schoolId" name="schoolId" wire:model="schoolId">
                                <div id="schoolDropdown"
                                    class="absolute z-10 bg-white border border-gray-300 w-full mt-1 max-h-[200px] overflow-y-auto text-[13px]"
                                    style="display:none;"></div>
                            </div>
@error('schoolName')
                                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                            @error('schoolId')
                                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                            <p id="schoolNotExistError" class="text-red-600 text-[12px] mt-1" style="display:none;">
                                The school does not exist.
                            </p>
                        </div>

                        @if ($isAnonymous)
                            <div class="w-full">
                                <label for="age" class="block text-[12px] text-black mb-1">Age</label>
                                <input type="number" wire:model.live="age" id="age" min="0" max="115"
                                    class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white">
                                @error('age')
                                    <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
@else
                            <div class="w-full" wire:key="grade-wrapper-{{ $age }}-{{ $schoolPhase }}">
                                <label for="grade" class="block text-[12px] text-black mb-1">Grade</label>
                                <select wire:model.live="grade" id="grade"
                                    class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white">
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
                                    <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="w-full">
                            <label for="phoneNumber" class="block text-[12px] text-black mb-1">Phone Number</label>
                            <input type="text" wire:model.lazy="phoneNumber" id="phoneNumber"
                                class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white"
                                placeholder="e.g. 0789 345 687" maxlength="15">
                            @error('phoneNumber')
                                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label for="reporterEmail" class="block text-[12px] text-black mb-1">Email Address</label>
                            <input type="email" wire:model.lazy="reporterEmail" id="reporterEmail"
                                class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white"
                                placeholder="e.g. example@gmail.com"
                                title="Please enter a valid email address (e.g., user@domain.com, user@domain.co.za)"
                                maxlength="50">
                            @error('reporterEmail')
                                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                       

                        <div class="w-full">
                            <label for="location" class="block text-[12px] text-black mb-1">Address</label>
                            <input type="text" wire:model="location" id="location"
                                class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white"
                                placeholder="e.g. 123 street name, Province"
                                pattern="^\d+\s+[A-Za-z\s\-']+,\s*[A-Za-z\s\-']+$"
                                title="Format: StreetNumber Street Name, Province (e.g. 123 Main Street, Gauteng)"
                                maxlength="100">
                            @error('location')
                                <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

@if ($isAnonymous)
                            <div class="w-full" wire:key="grade-wrapper-{{ $age }}-{{ $schoolPhase }}">
                                <label for="grade" class="block text-[12px] text-black mb-1">Grade</label>
                                <select wire:model.live="grade" id="grade"
                                    class="box-border w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] px-3 text-[14.8px] text-black bg-white">
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
                                    <p class="text-red-600 text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-[12px] text-black mb-1">
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

                    <div class="form-group mt-6">
                        <label for="fileUpload" class="block text-[12px] text-black mb-1">Attachment <span class="text-gray-500">(Optional)</span></label>
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
   <footer class="relative w-full bg-[#757573] text-white py-8 mt-auto z-30 font-[Montserrat]" style="margin-top: 4rem; width: 100vw; max-width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
<div class="w-full px-4 min-[640px]:px-6 flex flex-col items-start justify-center text-left gap-6 min-[640px]:flex-row min-[640px]:justify-between min-[640px]:items-center lg:px-[1vw]">
                <p class="text-[13px] leading-5 font-normal text-white min-[640px]:text-[14px] lg:text-[16px] w-full min-[640px]:w-auto flex justify-center min-[640px]:justify-start">
                <span class="text-center min-[640px]:text-left">
                    &copy; {{ date('Y') }} Tekete SafeSpace From Moepi <br class="min-[640px]:hidden">Publishing. All rights reserved.
                </span>
            </p>
<div class="w-full flex items-center justify-center flex-wrap gap-4 min-[640px]:w-auto min-[640px]:justify-start min-[640px]:gap-2 lg:gap-[1vw]">                <a href="https://www.youtube.com/@matauramapuputla6836" target="_blank" rel="noopener">
                    <img src="{{ asset('images/youtube.png') }}"
                         class="w-7 min-[640px]:w-5 h-auto lg:w-[2.3vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0 hover:opacity-80 transition"
                         alt="YouTube">
                </a>
                <a href="https://www.X.com/moepipublishing" target="_blank">
                    <img src="{{ asset('images/X.png') }}" alt="X"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank">
                    <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.7vw] lg:h-auto min-w-[20px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.instagram.com/moepi_pub?igsh=MWJ0NWFueWM2MDZ3YQ==" target="_blank">
                    <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
                    <img src="{{ asset('images/tiktok.png') }}" alt="TikTok"
                         class="w-5 h-5 min-[640px]:w-4 min-[640px]:h-4 lg:w-[1.9vw] lg:h-auto min-w-[22px] min-[640px]:min-w-0">
                </a>
            </div>
        </div>
    </footer>


    <script>
        function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const slide = document.getElementById('mobile-menu-slide');
        
        if (!menu || !slide) return;

        const isHidden = menu.classList.contains('hidden');
        
        if (isHidden) {
            // Show background overlay and slide panel in sequence
            menu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Small timeout to allow display:block to apply before triggering CSS transition
            setTimeout(() => {
                slide.classList.remove('translate-x-full');
                slide.classList.add('translate-x-0');
            }, 10);
        } else {
            // Slide panel away first, then hide the wrapper
            slide.classList.remove('translate-x-0');
            slide.classList.add('translate-x-full');
            document.body.style.overflow = '';
            
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300); // Matches the 300ms duration-300 transition time
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('mobile-menu-button');
    if (menuBtn) {
        menuBtn.addEventListener('click', toggleMobileMenu);
    }
});
       

        (function() {
            const API_ENDPOINT = '/api/schools';
            const LS_KEY = 'schools_cache_v3';
            const CACHE_TTL = 24 * 60 * 60 * 1000;

const input = document.getElementById('schoolSearch');
            const dropdown = document.getElementById('schoolDropdown');
            const hiddenName = document.getElementById('schoolName');
            const hiddenId = document.getElementById('schoolId');
            const notExistError = document.getElementById('schoolNotExistError');

            let schools = [];
            let items = [];
            let focused = -1;
            let timer = null;
            let existsTimer = null;

            let validSchoolSelected = false;

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

            function schoolExists(name) {
                if (!name) return false;
                const low = name.trim().toLowerCase();
                return schools.some(function(s) {
                    return s && s.name && s.name.trim().toLowerCase() === low;
                });
            }

            function clearNotExistError() {
                if (notExistError) notExistError.style.display = 'none';
            }

            function checkSchoolExists(showError) {
                clearTimeout(existsTimer);
                const q = input.value.trim();
                if (!q || validSchoolSelected) {
                    clearNotExistError();
                    return;
                }
                // Check after a short delay so it runs when the user finishes typing
                existsTimer = setTimeout(function() {
                    if (validSchoolSelected) {
                        clearNotExistError();
                        return;
                    }
                    if (!schoolExists(q)) {
                        if (notExistError) notExistError.style.display = 'block';
                    } else {
                        clearNotExistError();
                    }
                }, 400);
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

                document.getElementById('schoolProvince').value =
                    it.province ?? '';

// The school was selected from the database
                validSchoolSelected = true;

                // Clear any pending "school does not exist" error
                clearTimeout(existsTimer);
                clearNotExistError();

                // Notify Livewire
                hiddenName.dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

                hiddenId.dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

                document.getElementById('schoolProvince').dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

                clearSuggestions();
            }

            input.addEventListener('input', function() {

                // User is typing manually, so no database school is selected
                validSchoolSelected = false;

                hiddenName.value = this.value;

                // Clear the selected school ID
                hiddenId.value = '';

                document.getElementById('schoolName').dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

                hiddenId.dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

clearTimeout(timer);

                const q = this.value.trim();

                if (q.length < 1) {
                    clearSuggestions();
                    clearNotExistError();
                    return;
                }

                timer = setTimeout(() => {
                    render(searchPrefix(q, 20));
                }, 120);

                // Show "school does not exist" error when the user finishes typing
                checkSchoolExists();
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