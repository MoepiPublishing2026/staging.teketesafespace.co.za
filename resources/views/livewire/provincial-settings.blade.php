<section> 
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat-bold { font-family: 'Montserrat', sans-serif; font-weight: 700; }
.font-montserrat-regular { font-family: 'Montserrat', sans-serif; font-weight: 400; }
.bg-custom-gradient { background-image: linear-gradient(to right, #a2b413ff, #d7e47a); }
.hover\:bg-custom-gradient:hover { background-image: linear-gradient(to right, #c7da30, #d7e47a); color: black !important; }
</style>

<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 flex flex-col justify-between sticky top-0 h-screen" style="background-color: #fffbf7;">
        <div class="flex flex-col h-full">
            

            <nav class="flex-1 px-4 mt-24 space-y-3">
                <a href="{{ route('provincial.admin.dashboard')  }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                   Dashboard
                </a>
                <a href="{{ url('provincial/reports') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                   Reports
                </a>
                <a href="{{ url('provincial/profile') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                   My Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all font-semibold hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]">
                        Sign Out
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-auto" style="background: white; margin-top: 75px;">
        <h1 class="text-4xl font-bold mb-6 font-montserrat-bold">MY PROFILE</h1>

        {{-- Flash Message --}}
        @if (session()->has('success_message'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success_message') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm p-8" style="border: 4px solid #c7da30;">
            <form wire:submit.prevent="updateSettings" enctype="multipart/form-data">
                <div class="flex items-start justify-between mb-8">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            @if($profile_picture)
                                <img src="{{ $profile_picture->temporaryUrl() }}" 
                                     alt="Profile Picture Preview" 
                                     class="w-32 h-32 rounded-full object-cover bg-gray-200"
                                     style="border: 3px solid #c7da30;">
                            @elseif(auth()->user()->fresh()->profile_picture)
                                <img src="{{ auth()->user()->fresh()->profile_picture_url }}" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover bg-gray-200"
                                     style="border: 3px solid #c7da30;">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center"
                                     style="border: 3px solid #c7da30;">
                                    <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <p class="mb-3 font-montserrat-bold">Update Profile Picture</p>
                            <label class="inline-block">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" wire:model="profile_picture" 
                                       class="hidden"
                                       id="profile-picture-input"
                                       accept="image/*">
                                <span class="cursor-pointer px-6 py-2 rounded-full font-semibold font-montserrat-bold inline-block" 
                                      style="background: linear-gradient(to bottom right, #c7da30, #d7e47a); color: black;"
                                      onclick="document.getElementById('profile-picture-input').click()">
                                    Choose File
                                </span>
                            </label>
                            
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

                    <div class="text-right">
                        <h2 class="text-2xl font-bold mb-1 font-montserrat-bold">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-600 text-base font-montserrat-bold">Provincial Admin</p>
                        <p class="text-gray-600 text-base font-montserrat-bold">Member Since {{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-6">
                    <label class="block font-bold mb-3 font-montserrat-bold">Email Address</label>
                    <input type="email" wire:model.defer="email"
                           class="w-full rounded-lg px-4 py-4 font-montserrat-regular"
                           style="border: 3px solid #c7da30;" readonly>
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-8">
                    <label class="block font-bold mb-3 font-montserrat-bold">Phone Number</label>
                    <input type="text" wire:model.defer="phone_number"
                           class="w-full rounded-lg px-4 py-4 font-montserrat-regular"
                           style="border: 3px solid #c7da30;">
                    @error('phone_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Password Update --}}
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-center mb-6 font-montserrat-bold">Update Password</h3>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-bold">Old password</label>
                        <input type="password" wire:model.defer="current_password"
                               class="w-full rounded-lg px-4 py-4 font-montserrat-regular"
                               style="border: 3px solid #c7da30;">
                        @error('current_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-bold">New password</label>
                        <input type="password" wire:model.defer="new_password"
                               class="w-full rounded-lg px-4 py-4 font-montserrat-regular"
                               style="border: 3px solid #c7da30;">
                        @error('new_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-bold">Confirm Password</label>
                        <input type="password" wire:model.defer="confirm_password"
                               class="w-full rounded-lg px-4 py-4 font-montserrat-regular"
                               style="border: 3px solid #c7da30;">
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


</section>

