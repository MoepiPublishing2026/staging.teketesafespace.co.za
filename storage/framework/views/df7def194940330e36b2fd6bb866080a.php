<section>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

.font-montserrat-bold {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
}

.font-montserrat-regular {
    font-family: 'Montserrat', sans-serif;
    font-weight: 400;
}

.bg-custom-gradient {
    background-image: linear-gradient(to right, #c7da30, #d7e47a);
}
.hover\:bg-custom-gradient:hover {
    background-image: linear-gradient(to right, #c7da30, #d7e47a);
    color: black !important;
}
</style>

<div class="flex min-h-screen m-0 p-0">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between sticky top-0 h-screen" style="background-color: white">
        <div>
            <nav style="margin-top: 10px">
                <ul class="space-y-2">
                    <div class="flex justify-center" style="margin-bottom: 70px">
                        <img src="<?php echo e(asset('images/logo.png')); ?>" 
                             alt="Safe Space Logo" 
                             style="width: 125px; height: 110px;">
                    </div>
                    
                    <li class="flex justify-center">
                        <a href="/admin/dashboard"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                            <?php echo e(Request::is('admin/dashboard') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]'); ?>"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>Dashboard
                        </a>
                    </li>

                    <li class="flex justify-center">
                        <a href="/admin/reports"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                            <?php echo e(Request::is('admin/reports') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]'); ?>"
                            style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                            <i></i>Reports
                        </a>
                    </li>

                    <li class="flex justify-center">
                        <a href="/admin/settings"
                            class="block rounded flex items-center font-montserrat-black rounded-lg transition-all
                            <?php echo e(Request::is('admin/settings') ? 'bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]' : 'hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]'); ?>"
                            style="width: 130px; height: 41px; color: white; font-size: 15px; padding-left: 20px;">
                            <i></i>My Profile
                        </a>
                    </li>

                    <li class="flex justify-center">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="block w-full rounded flex items-center font-montserrat-black rounded-lg transition-all
                                hover:bg-gradient-to-r from-[#38b6ff] to-[#38b6ff]"
                                style="width: 130px; height: 41px; color: #545454; font-size: 15px; padding-left: 20px;">
                                Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main id="main-content" class="flex-1 p-8 overflow-auto" style="background: white; margin-top: 75px;">
        <h1 class="text-4xl font-bold text-black-800 mb-6 font-montserrat-black">MY PROFILE</h1>
        
        
        <!--[if BLOCK]><![endif]--><?php if(session()->has('success_message')): ?>
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-6">
                <?php echo e(session('success_message')); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        
        <div class="bg-white rounded-3xl shadow-sm p-8" style="border: 4px solid #c7da30;">
            <form wire:submit.prevent="updateSettings" enctype="multipart/form-data">
                <div class="flex items-start justify-between mb-8">
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            
                            <div wire:loading wire:target="profile_picture" 
                                 class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center"
                                 style="border: 3px solid #c7da30;">
                                <svg class="animate-spin h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            
                            <!--[if BLOCK]><![endif]--><?php if($profile_picture): ?>
                                <img wire:loading.remove wire:target="profile_picture"
                                     src="<?php echo e($profile_picture->temporaryUrl()); ?>" 
                                     alt="Profile Picture Preview" 
                                     class="w-32 h-32 rounded-full object-cover bg-gray-200"
                                     style="border: 3px solid #c7da30;">
                            
                            <?php elseif(auth()->user()->profile_picture): ?>
                                <img wire:loading.remove wire:target="profile_picture"
                                     src="<?php echo e(auth()->user()->profile_picture_url); ?>" 
                                     alt="Profile Picture" 
                                     class="w-32 h-32 rounded-full object-cover bg-gray-200"
                                     style="border: 3px solid #c7da30;">
                            
                            <?php else: ?>
                                <div wire:loading.remove wire:target="profile_picture"
                                     class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center"
                                     style="border: 3px solid #c7da30;">
                                    <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                            
                            <div wire:loading wire:target="profile_picture" class="text-sm text-gray-600 mt-2">
                                Uploading...
                            </div>
                            
                            <!--[if BLOCK]><![endif]--><?php if($profile_picture): ?>
                                <p class="text-sm text-green-600 mt-2">File selected: <?php echo e($profile_picture->getClientOriginalName()); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['profile_picture'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <span class="text-red-600 text-sm mt-1"><?php echo e($message); ?></span> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    
                    <div class="text-right">
                        <h2 class="text-2xl font-bold mb-1 font-montserrat-black"><?php echo e(Auth::user()->name); ?></h2>
                        <p class="text-gray-600 text-base font-montserrat-black">Administrator</p>
                        <p class="text-gray-600 text-base font-montserrat-black">Member Since <?php echo e(optional(Auth::user()->created_at)->format('M Y') ?? 'N/A'); ?></p>
                    </div>
                </div>

                
                <div class="mb-6">
                    <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Email Address</label>
                    <input type="email" wire:model.defer="email"
                           placeholder="Email@Address"
                           class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                           style="border: 3px solid #c7da30; font-size: 15px;" 
                           readonly>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                
                <div class="mb-8">
                    <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Phone Number</label>
                    <input type="text" wire:model.defer="phone_number"
                           placeholder="0000000000"
                           class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                           style="border: 3px solid #c7da30; font-size: 15px;">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-center mb-6 font-montserrat-black">Update Password</h3>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Old password</label>
                        <input type="password" wire:model.defer="current_password"
                               class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                               style="border: 3px solid #c7da30; font-size: 15px;">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">New password</label>
                        <input type="password" wire:model.defer="new_password"
                               class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                               style="border: 3px solid #c7da30; font-size: 15px;">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold mb-3 font-montserrat-black" style="font-size: 16px;">Confirm Password</label>
                        <input type="password" wire:model.defer="confirm_password"
                               class="w-full rounded-lg px-4 py-4 focus:outline-none font-montserrat-regular"
                               style="border: 3px solid #c7da30; font-size: 15px;">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                
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

<script src="https://kit.fontawesome.com/2c36e9b7b9.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</section><?php /**PATH C:\xampp\htdocs\teketeApplication\staging.teketesafespace.co.za\resources\views/livewire/admin-settings.blade.php ENDPATH**/ ?>