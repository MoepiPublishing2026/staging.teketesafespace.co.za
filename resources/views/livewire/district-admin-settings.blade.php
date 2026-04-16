<section>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
.font-montserrat-bold { font-family: 'Montserrat', sans-serif; font-weight: 700; }
.font-montserrat-regular { font-family: 'Montserrat', sans-serif; font-weight: 400; }
.bg-custom-gradient { background-image: linear-gradient(to right, #c7da30, #d7e47a); }
.hover\:bg-custom-gradient:hover { background-image: linear-gradient(to right, #c7da30, #d7e47a); color: black !important; }
</style>
<div class="flex min-h-screen bg-gray-50 font-[Montserrat]">

    <!-- Sidebar -->
  <aside class="w-64 flex flex-col justify-between sticky top-0 h-screen" style="background-color: #fffbf7;">
    <div class="flex flex-col h-full">
        <!-- Navigation Menu -->
        <nav class="flex-1 px-4" style="margin-top: 100px;">
            <ul class="space-y-3">
                <!-- Dashboard -->
                <li>
               <a href="{{ route('district.admin.dashboard') }}"
       class="flex items-center px-4 py-3 rounded-lg font-semibold text-black
              {{ request()->routeIs('district.admin.dashboard') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}">
       Dashboard
    </a>
                </li>
                <!-- Reports -->
                <li>
                    <a href="#" wire:click.prevent="setActiveTab('reports')"
       class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
       {{ $activeTab === 'reports' ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}">
       Reports
    </a>
                </li>
                <!-- My Profile -->
            <a href="{{ route('district.profile') }}"
    class="flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
    {{ Request::is('district/profile') ? 'bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' : 'hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a]' }}">
    My Profile
    </a>

                </li>
                <!-- Sign Out -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center px-4 py-3 rounded-lg transition-all font-semibold text-black
                            hover:bg-gradient-to-r from-[#c7da30] to-[#d7e47a']">
                            Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
            
            <!-- Footer -->
            <div class="p-4 text-center">
                <p class="text-sm text-gray-600">© {{ date('Y') }} Tekete SafeSpace</p>
            </div>
        </div>
    </aside>

   


    <!-- Main Content -->
    <main id="main-content" class="flex-1 p-8 overflow-auto" style="background: white; margin-top: 75px;">
        <h1 class="text-4xl font-bold text-black-800 mb-6 font-montserrat-black">MY PROFILE</h1>

        @if (session()->has('success_message'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success_message') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm p-8 border-4 border-[#c7da30]">
            <form wire:submit.prevent="updateSettings" enctype="multipart/form-data">
                <div class="flex items-start justify-between mb-8">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            @if($profile_picture)
                                <img src="{{ $profile_picture->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-4 border-[#c7da30]">
                            @elseif(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" class="w-32 h-32 rounded-full object-cover border-4 border-[#c7da30]">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center border-4 border-[#c7da30]">
                                    <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="mb-3 font-bold">Update Profile Picture</p>
                            <input type="file" wire:model="profile_picture" id="profile-picture" class="hidden" accept="image/*">
                            <label for="profile-picture" class="cursor-pointer px-6 py-2 rounded-full text-black font-semibold"
                                   style="background: linear-gradient(to bottom right, #c7da30, #d7e47a);">
                                Choose File
                            </label>
                            @error('profile_picture') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="text-right">
                        <h2 class="text-2xl font-bold mb-1">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-600">{{ Auth::user()->district }}</p> {{-- ✅ District Name Added --}}
                        <p class="text-gray-600">District Administrator</p>
                        <p class="text-gray-600">Member Since {{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Email</label>
                    <input type="email" wire:model.defer="email" class="w-full border-2 border-[#c7da30] rounded-lg px-4 py-3" readonly>
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Phone Number</label>
                    <input type="text" wire:model.defer="phone" class="w-full border-2 border-[#c7da30] rounded-lg px-4 py-3">
                </div>

                <h3 class="text-2xl font-bold text-center mb-6">Update Password</h3>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Current Password</label>
                    <input type="password" wire:model.defer="current_password" class="w-full border-2 border-[#c7da30] rounded-lg px-4 py-3">
                    @error('current_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">New Password</label>
                    <input type="password" wire:model.defer="new_password" class="w-full border-2 border-[#c7da30] rounded-lg px-4 py-3">
                    @error('new_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-bold mb-2">Confirm Password</label>
                    <input type="password" wire:model.defer="confirm_password" class="w-full border-2 border-[#c7da30] rounded-lg px-4 py-3">
                    @error('confirm_password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                            class="px-20 py-3 rounded-full font-bold text-black shadow-md transition-transform hover:scale-105"
                            style="background: linear-gradient(to bottom right, #c7da30, #d7e47a);">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
</section>
