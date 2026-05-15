<section>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat-bold { font-family: 'Montserrat', sans-serif; font-weight: 700; }
.font-montserrat-regular { font-family: 'Montserrat', sans-serif; font-weight: 400; }

.bg-custom-gradient { background-image: linear-gradient(to right, #c7da30, #d7e47a); }
.hover\:bg-custom-gradient:hover { background-image: linear-gradient(to right, #c7da30, #d7e47a); color: black !important; }

.sidebar {
    width: 235px;
    background: white;
    border-right: 1px solid #eaeaea;
    display: flex;
    flex-direction: column;
    padding-top: 120px;
    flex-shrink: 0;
}
.sidebar-list { list-style: none; padding: 0 0 0 22px; }
.sidebar-link {
    display: block;
    width: 92%;
    font-size: 15px !important;
    font-weight: 600 !important;
    color: #545454 !important;
    font-family: 'Montserrat', sans-serif !important;
    padding: 11px 18px;
    margin-bottom: 17px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.25s ease;
}
.sidebar-link:hover, .sidebar-link.active {
    background: linear-gradient(to right, #38b6ff, #38b6ff);
    color: #fff !important;
}
.main-panel { flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100vh; background: white; }

@media (max-width: 900px) {
    .sidebar { position: fixed; left: 0; width: 0; overflow-x: hidden; transition: width 0.3s; z-index: 1000; }
    .sidebar.open { width: 220px; }
    .main-panel.shifted { margin-left: 220px; }
}
@media (max-width: 640px) {
    main { padding: 1rem !important; }
    .bg-white.rounded-3xl { padding: 1.5rem !important; }
}
</style>
@include('components.school-admin-styles')

<div class="flex min-h-screen m-0 p-0" style="min-height: 100vh;">
    @include('components.school-admin-sidebar')

    <!-- Main Content -->
    <div class="main-panel">
    <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8 overflow-auto" style="background: white; margin-top: 75px;">
        <h1 class="text-4xl font-bold text-black-800 mb-6 font-montserrat-black">MY PROFILE</h1>
        
        {{-- Flash Message --}}
        @if (session()->has('success_message'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success_message') }}
            </div>
        @endif

        {{-- Profile Card --}}
        <div class="bg-white rounded-3xl shadow-sm p-8" style="border: 4px solid #c7da30;">
            <form wire:submit.prevent="updateSettings" enctype="multipart/form-data">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                        <div class="flex-shrink-0">
                            {{-- Show loading spinner while uploading --}}
                            <div wire:loading wire:target="profile_picture" 
                                 class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center"
                                 style="border: 3px solid #c7da30;">
                                <svg class="animate-spin h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            {{-- Temporary preview while file is selected --}}
                            @if($profile_picture)
                                <img wire:loading.remove wire:target="profile_picture"
                                     src="{{ $profile_picture->temporaryUrl() }}" 
                                     alt="Profile Picture Preview" 
                                     class="w-32 h-32 rounded-full object-cover bg-gray-200"
                                     style="border: 3px solid #c7da30;">
                            {{-- Display saved profile picture from database --}}
                            @elseif(auth()->user()->profile_picture)
                                <img wire:loading.remove wire:target="profile_picture"
                                     src="{{ auth()->user()->profile_picture_url }}" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover bg-gray-200"
                                     style="border: 3px solid #c7da30;">
                            {{-- Default placeholder --}}
                            @else
                                <div wire:loading.remove wire:target="profile_picture"
                                     class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center"
                                     style="border: 3px solid #c7da30;">
                                    <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col">
                            <p class="mb-3 font-montserrat-black">Update Profile Picture</p>
                            <label class="inline-block">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" wire:model="profile_picture" 
                                       class="hidden"
                                       id="profile-picture-input"
                                       accept="image/*">
                                <span class="cursor-pointer px-6 py-2 rounded-full font-semibold font-montserrat-black inline-block" 
                                      style="background: linear-gradient(to bottom right, #c7da30, #d7e47a); color: black;"
                                      onclick="document.getElementById('profile-picture-input').click()">
                                    Choose File
                                </span>
                            </label>
                            <button type="button"
    wire:click="deleteProfilePicture"
    class="mt-4 inline-flex items-center justify-center px-6 py-3 text-sm font-bold rounded-full shadow-md delete-btn">
    Delete Picture
</button>
                            <div wire:loading wire:target="profile_picture" class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>
                            
                            @if($profile_picture)
                                <p class="text-sm text-green-600 mt-2">File selected: {{ $profile_picture->getClientOriginalName() }}</p>
                            @endif
                            
                            @error('profile_picture') 
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    {{-- User Info - Right Side --}}
                    <div class="text-left lg:text-right">
                        <h2 class="text-2xl font-bold mb-1 font-montserrat-black">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-600 text-base font-montserrat-black">Administrator</p>
                        <p class="text-gray-600 text-base font-montserrat-black">Member Since {{ optional(Auth::user()->created_at)->format('M Y') ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Email Address --}}
                <div class="mb-6">
                    <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Email Address</label>
                    <input type="email" wire:model.defer="email"
                           placeholder="Email@Address"
                           class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                           style="border: 3px solid #c7da30; font-size: 15px;" 
                           readonly>
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Phone Number --}}
                <div class="mb-8">
                    <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Phone Number</label>
                    <input type="text" wire:model.defer="phone_number"
                           placeholder="0000000000"
                           class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                           style="border: 3px solid #c7da30; font-size: 15px;">
                    @error('phone_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Update Password Section --}}
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-center mb-6 font-montserrat-black">Update Password</h3>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Old password</label>
                        <input type="password" wire:model.defer="current_password"
                               class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                               style="border: 3px solid #c7da30; font-size: 15px;">
                        @error('current_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">New password</label>
                        <input type="password" wire:model.defer="new_password"
                               class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                               style="border: 3px solid #c7da30; font-size: 15px;">
                        @error('new_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Confirm Password</label>
                        <input type="password" wire:model.defer="confirm_password"
                               class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                               style="border: 3px solid #c7da30; font-size: 15px;">
                        @error('confirm_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Update Button --}}
                <div class="flex justify-center">
                    <button type="submit"
                            class="px-20 py-3 border-4 border-solid border-[#c7da30] rounded-[100px] text-[#38b6ff] font-bold flex items-center shadow-md transition-transform hover:scale-105 font-[Montserrat] text-[16px]">
                        <svg wire:loading wire:target="updateSettings" class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </main>
    </div>
</div>

@include('components.school-admin-sidebar-script')
<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</section>
