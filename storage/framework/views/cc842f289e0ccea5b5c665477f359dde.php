<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full overflow-x-hidden">
    <script src="//unpkg.com/alpinejs" defer></script>

    <header style="position: fixed; top: 0; left: 0; width: 100vw; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2"
             style="max-width: 1280px; margin: 0 auto;">
            <div>
                <img src="<?php echo e(asset('images/logo.png')); ?>" 
                     alt="Safe Space Logo" 
                     style="width: 110px; height: auto;">
            </div>
          <!-- Top Right Links -->
            <div class="flex gap-8" 
                 style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                   <!-- Desktop Navigation -->
                <div class="hidden md:flex gap-8" 
                     style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                    <!-- Back Button -->
                    <a href="javascript:void(0);" 
                       onclick="window.history.back();" 
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       Back
                    </a>
                    <a href="<?php echo e(route('landing-page')); ?>" 
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       Home
                    </a>
                     <a href="<?php echo e(route('about-us')); ?>"
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       About Us
                    </a>
                    <a href="<?php echo e(route('contact-us')); ?>"
                       class="transition-colors hover:!text-[#c7da30]"
                       style="color: black; text-decoration: none;">
                       Contact Us
                    </a>
                </div>
                
                <div class="md:hidden">
                    <button id="mobile-menu-button" 
                            class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]"
                            onclick="toggleMobileMenu()"> <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <div id="mobile-menu" class="fixed inset-0 z-50 hidden md:hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileMenu()"></div>
        <div class="fixed top-0 right-0 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-between p-4 border-b">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="h-8">
                <button onclick="toggleMobileMenu()" class="p-2 rounded-md text-black hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-8 px-4">
                <a href="javascript:void(0);" onclick="window.history.back(); toggleMobileMenu();" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Back
                </a>
                <a href="<?php echo e(route('landing-page')); ?>" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                
                <a href="<?php echo e(route('landing-page')); ?>#about" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="<?php echo e(route('landing-page')); ?>#section" onclick="toggleMobileMenu()" class="block py-3 text-black hover:text-[#c7da30] transition-colors" 
                   style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>
    <div style="font-family: 'Montserrat', sans-serif; background-color: #fff; min-height: 100vh; padding: 120px 1.5rem 40px; position: relative;">
        <div style="max-width: 1280px; margin: 0 auto; width: 100%;">

            <h1 class="text-center text-[20px] sm:text-[22px] font-[700] uppercase text-black mb-2">
                Report a Case
            </h1>

            <!--[if BLOCK]><![endif]--><?php if($isAnonymous): ?>
                <p class="text-center text-[15px] font-[700] text-black mb-1">
                    You are reporting anonymously
                </p>
            <?php else: ?>
                <p class="text-center text-[15px] font-[700] text-black mb-1">
                    You are reporting with your details
                </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <p class="text-center text-[15px] text-black mb-6 sm:mb-8">
                Abuse Type: <?php echo e($selectedAbuseTypeName); ?>

            </p>

                <!--[if BLOCK]><![endif]--><?php if(session('success_message')): ?>
                <div x-data="{ open: true }" x-show="open"
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div
                        class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white 
                             flex flex-col items-center justify-center w-[90%] sm:w-[635px] 
                             h-[300px] sm:h-[342px] p-4 text-center shadow-lg relative">

                        <p class="text-[18px] sm:text-[19px] text-black mb-4">
                            REPORT SUBMITTED SUCCESSFULLY!
                        </p>

                        <img src="<?php echo e(asset('images/tick.png')); ?>" alt="Success Tick"
                            class="w-[60px] sm:w-[80px] h-auto my-4">

                        <p class="text-[18px] sm:text-[19px] text-black mb-6">
                            CASE NUMBER:
                            <?php echo e(str_replace('Your report has been submitted successfully! Case number: ', '', session('success_message'))); ?>

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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


           <!--[if BLOCK]><![endif]--><?php if(session()->has('error_message')): ?>
   <div style="background-color: #fee2e2; border-bottom: 1px solid #ef4444; color: #b91c1c; width: 100%; padding: 15px 0; text-align: center; margin-bottom: 20px; border-radius: 8px;">
            <strong style="display: block; margin-bottom: 5px;"><?php echo e(session('error_message')); ?></strong>  
     
        <?php
            // Fallback: if the property isn't set, try to get it from the session
            $expiry = $latestReport->suspended_until ?? session('expiry_date');
        ?>

        <!--[if BLOCK]><![endif]--><?php if($expiry): ?>
            <div style="font-size: 0.9rem;">
                Time Remaining: 
                <span id="timer-display" 
                      data-expiry="<?php echo e(\Carbon\Carbon::parse($expiry)->toIso8601String()); ?>" 
                      style="font-weight: bold; font-family: monospace; font-size: 1.1rem;">
                      Calculating...
                </span>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <div class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white w-full max-w-[640px] p-6 sm:p-10">
                <form wire:submit.prevent="submitReport" enctype="multipart/form-data">

                    <!--[if BLOCK]><![endif]--><?php if(($standardSubtypes->isNotEmpty() || $otherSubtype)): ?>
                        <div class="mb-5">
                            <label for="subtypeID" class="text-[12px] text-black">Sub-type</label>
                            <select id="subtypeID" wire:model.live="subtypeID"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14px] sm:text-[14.8px] text-black bg-white">
                                <option value="">-- Select a Subtype --</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $standardSubtypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subtype->id); ?>"><?php echo e($subtype->sub_type_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($otherSubtype): ?>
                                    <option value="<?php echo e($otherSubtype->id); ?>"><?php echo e($otherSubtype->sub_type_name); ?></option>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['subtypeID'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!--[if BLOCK]><![endif]--><?php if(!$isAnonymous): ?>
                            <div>
                                <label for="fullName" class="text-[12px] text-black">Full Name</label>
                                <input type="text" wire:model="fullName" id="fullName"
                                    class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fullName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                <div>
                            <label for="age" class="text-[12px] text-black">Age</label>
                            <input type="number" wire:model.live="age" id="age" min="0" max="115"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <div class="relative">
                                <label for="schoolSearch" class="text-[12px] text-black">Name of School</label>
                            
                                <input type="text"
                                    id="schoolSearch"
                                    placeholder="Start typing school name..."
                                    class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black bg-white"
                                    pattern="^[a-zA-Z\s.,\-&amp;']+$"
                                    title="The School Name can only contain letters, spaces, hyphens (-), apostrophes ('), commas (,), periods (.), and the ampersand (&amp;)."
                                    maxlength="100">
                                <input type="hidden" id="schoolName" wire:model.lazy="schoolName" name="schoolName" value="">
                                <input type="hidden" id="schoolId" name="schoolId" value="">
                            
                                <div id="schoolDropdown" class="absolute z-10 bg-white border border-gray-300 w-full mt-1 max-h-[200px] overflow-y-auto text-[13px]" style="display:none;"></div>
                            
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['schoolName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <div>
                            <label for="reporterEmail" class="text-[12px] text-black">Email Address</label>
                            <input 
                                type="email" 
                                wire:model.lazy="reporterEmail" 
                                id="reporterEmail"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 text-[14.8px] text-black"
                                placeholder="e.g. example@gmail.com"
                                title="Please enter a valid email address (e.g., user@domain.com, user@domain.co.za)"
                                maxlength="50"
                            >
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['reporterEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> 
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <label for="phoneNumber" class="text-[12px] text-black">Phone Number</label>
                            <input type="text" wire:model.lazy="phoneNumber" id="phoneNumber"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 text-[14.8px] text-black"
                                placeholder="e.g. 0789 345 687" maxlength="15"> <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phoneNumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <label for="location" class="text-[12px] text-black">Address</label>
                            <input type="text" wire:model="location" id="location"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 text-[14.8px] text-black"
                                >
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        
                                                <div>
                            <label for="grade" class="text-[12px] text-black">Grade</label>
                            <select wire:model.live="grade" id="grade"
                                class="w-full h-[50px] sm:h-[57px] border-[3px] border-[#c7da30] rounded-[6px] 
                                        p-2 sm:p-3 text-[14.8px] text-black bg-white" required>
                                <option value="">-- Select Grade --</option>
                                <!--[if BLOCK]><![endif]--><?php if($age): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->applicableGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gradeOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($gradeOption); ?>" <?php if($grade === $gradeOption): echo 'selected'; endif; ?>><?php echo e($gradeOption); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
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
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="description" class="text-[11px] text-black">
                            Description
                            <!--[if BLOCK]><![endif]--><?php if($isOtherSubtypeSelected): ?>
                                <span class="text-red-600 font-semibold">(Required)</span>
                            <?php else: ?>
                                <span class="text-gray-500">(Optional)</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </label>

                        <textarea
                            wire:model="description"
                            id="description"
                            rows="4"
                            maxlength="200"
                            <?php if($isOtherSubtypeSelected): ?> required <?php endif; ?>
                            class="w-full border-[3px] border-[#c7da30] rounded-[6px] p-3 text-[14.8px] text-black bg-white h-[120px] sm:h-[126px]"></textarea>

                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-[12px]"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                   <div class="form-group">
    <label for="fileUpload" class="text-[12px] text-black font-semibold">Attachment (Optional)</label>
    <input 
    type="file" 
    wire:model="newUploads" 
    multiple 
accept="image/*,video/*,audio/*,.mp3,.wav,.m4a,.mp4,.ogg,.webm,.amr,.aac,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"



    class="form-control border-[3px] border-[#c7da30] rounded-[6px] p-2 sm:p-3 w-full text-[14px] text-black" 
    id="fileUpload"
>


    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['newUploads.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
        <p class="text-red-600 text-[12px] mt-1"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

    <div class="mt-3">
    <!--[if BLOCK]><![endif]--><?php if($image): ?>
        <ul class="list-group space-y-2">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="flex flex-col p-3 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-start justify-between gap-3">
                        <!-- File icon + name -->
                        <div class="flex items-center gap-2 flex-1 min-w-0">
                            <!--[if BLOCK]><![endif]--><?php if(str_contains($file->getMimeType(), 'image/')): ?>
                                <img src="<?php echo e($file->temporaryUrl()); ?>" class="w-10 h-10 object-cover rounded border">
                            <?php elseif(str_contains($file->getMimeType(), 'video/')): ?>
                                <video class="w-10 h-10 object-cover rounded border" muted>
                                    <source src="<?php echo e($file->temporaryUrl()); ?>" type="<?php echo e($file->getMimeType()); ?>">
                                </video>
                            <?php elseif(str_contains($file->getMimeType(), 'audio/')): ?>
                                <svg class="w-10 h-10 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h3a2 2 0 002-2v-1.5a.5.5 0 011 0V9a1 1 0 01-1 1H6a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 011 1z"/>
                                    <path fill-rule="evenodd" d="M3 5a1 1 0 00-2 0v10a1 1 0 002 0V5zm12 2a1 1 0 110 2h3a1 1 0 110-2h-3zM9.5 13a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            <?php else: ?>
                                <svg class="w-10 h-10 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 9H5l.01-1.99L17 8v5a1 1 0 01-1 1z"/>
                                </svg>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <div class="min-w-0 flex-1 truncate">
                                <div class="font-medium text-sm truncate"><?php echo e($file->getClientOriginalName()); ?></div>
                                <div class="text-xs text-gray-500">
                                    <?php echo e(number_format($file->getSize() / 1024, 1)); ?> KB
                                    <span class="ml-1"><?php echo e(strtoupper(str_replace(['audio/', 'video/', 'image/'], '', $file->getMimeType()))); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Remove button -->
                        <button 
                            type="button" 
                            wire:click="removeImage(<?php echo e($index); ?>)" 
                            class="flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 text-sm rounded-full hover:bg-red-200 transition-colors"
                            title="Remove file"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Remove
                        </button>
                    </div>

                    <!-- Audio/Video Player Preview -->
                    <?php if(str_contains($file->getMimeType(), 'audio/')): ?>
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <audio controls class="w-full" preload="metadata">
                                <source src="<?php echo e($file->temporaryUrl()); ?>" type="<?php echo e($file->getMimeType()); ?>">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    <?php elseif(str_contains($file->getMimeType(), 'video/')): ?>
                        <div class="mt-2 pt-2 border-t border-gray-200">
                            <video controls class="w-full h-24 rounded object-contain bg-black" preload="metadata">
                                <source src="<?php echo e($file->temporaryUrl()); ?>" type="<?php echo e($file->getMimeType()); ?>">
                            </video>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Upload status -->
                    <div class="mt-2 flex gap-2">
                        <span wire:loading.remove wire:target="newUploads,removeImage(<?php echo e($index); ?>)" 
                              class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                            Ready
                        </span>
                        <span wire:loading wire:target="newUploads,removeImage(<?php echo e($index); ?>)" 
                              class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full animate-pulse hidden">
                            Processing...
                        </span>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </ul>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>


                    <div class="mt-7 text-center">
                         <button type="submit"
    wire:loading.attr="disabled"
    wire:target="submitReport"
    class="w-full h-[50px] sm:h-[52px] 
           border-4 border-solid border-[#c7da30]
           rounded-[100px] text-[#38b6ff] 
           text-[15px] font-medium cursor-pointer
           transition duration-200 hover:opacity-80 shadow-md"
>
    <span wire:loading.remove wire:target="submitReport">Submit</span>
    <span wire:loading wire:target="submitReport">Submitting...</span>
</button>


                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Footer -->
            <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 4rem;">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
                     style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
                    <div>
                        <p>&copy; <?php echo e(date('Y')); ?> Tekete Safe Space from Moepi Publishing. All rights reserved.</p>
                    </div>
                    <div class="flex items-center gap-4 order-2">
                 <a href=" https://www.youtube.com/@matauramapuputla6836"target="_blank">
                 <img src="<?php echo e(asset('images/youtube.png')); ?>" alt="YouTube Icon" style="width: 30px; height: 30px; left:1024.8; top: 701.8
;">   
</a>
                 <a href="https://www.X.com/moepipublishing" target="_blank">
               <img src="<?php echo e(asset('images/X.png')); ?>" alt="X Icon" style="width: 30px; height: 30px;left:1024.8 ; top:701.8; ">
                 </a>
               
                <a href="https://www.linkedin.com/company/moepi-publishing/" target="_blank" >
               <img src="<?php echo e(asset('images/linkedIn.png')); ?>" alt="LinkedIn Icon" style="width: 30px; height: 30px;left: 1128.6
; top:701.1;">
                </a>
               <a href="https://www.facebook.com/MoepiPublishing" target="_blank">
               <img src="<?php echo e(asset('images/facebook.png')); ?>" 
               alt="Facebook Icon" 
               style="width: 35.2px; height: 30px;left: 1179.7;top: 701.1;">
            </a>
               
               <a href="https://www.instagram.com/moepipublishing" target="_blank">
                <img src="<?php echo e(asset('images/instagram.png')); ?>" 
                alt="Instagram Icon" 
                style="width: 35.2px; height: 30px; left: 1225.7px; top: 701.1px;">
               </a>
                <a href="https://www.tiktok.com/@moepipublishing" target="_blank">
               <img src="<?php echo e(asset('images/tiktok.png')); ?>" alt="TikTok Icon" style="width: 35.2px; height: 30px;left:1271.7 ;top:700.1;"></a>
            </div>
                    
            </footer>
        
        <script>
            // Mobile Menu Toggle Function (Needed since the button uses `onclick`)
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }

            // School Search Autocomplete Logic
            (function() {
                const API_ENDPOINT = '/api/schools'; 
                const LS_KEY = 'schools_cache_v3'; // Updated cache key to v3 for database migration
                const CACHE_TTL = 24 * 60 * 60 * 1000; // 24 hours

                const input = document.getElementById('schoolSearch');
                const dropdown = document.getElementById('schoolDropdown');
                const hiddenName = document.getElementById('schoolName');
                const hiddenId = document.getElementById('schoolId');

                let schools = [];     
                let items = [];       
                let focused = -1;
                let timer = null;

                // Load from localStorage cache if fresh
                function loadCache() {
                    try {
                        const raw = localStorage.getItem(LS_KEY);
                        if (!raw) return false;
                        const parsed = JSON.parse(raw);
                        if (!parsed.data || !parsed.timestamp) return false;
                        if (Date.now() - parsed.timestamp > CACHE_TTL) return false;
                        
                        // Check if data is in the expected format
                        if (parsed.data.length > 0 && parsed.data[0].name) {
                            schools = parsed.data;
                            return true;
                        }
                        return false;

                    } catch (e) {
                        // console.error("Error loading cache:", e);
                        return false;
                    }
                }

                function saveCache(data) {
                    try {
                        localStorage.setItem(LS_KEY, JSON.stringify({ data, timestamp: Date.now() }));
                    } catch (e) { /* ignore */ }
                }

                // Load schools from database API
                async function loadFromDatabase() {
                    try {
                        const res = await fetch(API_ENDPOINT, { cache: 'no-store' });
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        const json = await res.json();
                        if (Array.isArray(json)) {
                            // API already returns data in the correct format
                            schools = json;
                            saveCache(schools);
                        }
                    } catch (e) {
                        console.warn('Failed to load schools from database', e);
                    }
                }

                // Initialize: load cache or fetch from database, then do background refresh
                (async function init() {
                    if (!loadCache()) {
                        await loadFromDatabase();
                    }
                    // background refresh, non-blocking
                    fetch(API_ENDPOINT).then(r => r.json()).then(d => {
                        if (Array.isArray(d)) { 
                            schools = d;
                            saveCache(schools); 
                        }
                    }).catch(()=>{});
                })();

                // prefix search (case-insensitive)
                function searchPrefix(q, limit = 12) {
                    if (!q) return [];
                    const low = q.toLowerCase();
                    const out = [];
                    // ðŸ”§ CLEANUP: Added a limit on the search loop for performance
                    for (let i = 0; i < schools.length && out.length < limit; i++) {
                        const s = schools[i];
                        if (!s || !s.name) continue;
                        if (s.name.toLowerCase().startsWith(low)) {
                            out.push(s);
                        }
                    }
                    return out;
                }

                // Render suggestions
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
                        // pointerdown avoids blur-before-click problem
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
                    // Fill visible + hidden inputs
                    input.value = it.name;
                    hiddenName.value = it.name;
                    hiddenId.value = it.id ?? '';

                    // Dispatch an event to tell Livewire to update the 'schoolName' property
                    // This is essential for the wire:model.lazy="schoolName" binding to work with the selected value.
                    document.getElementById('schoolName').dispatchEvent(new Event('input', { bubbles: true }));

                    clearSuggestions();
                }

                
                input.addEventListener('input', function() {
                    // Always update the hidden field on input change for Livewire validation
                    // This will also trigger Livewire to validate the custom text if no selection is made
                    hiddenName.value = this.value; 
                    
                    // Clear the ID field as the current input is not a selected school
                    hiddenId.value = ''; 

                    // Dispatch event for Livewire to pick up the typed value
                    document.getElementById('schoolName').dispatchEvent(new Event('input', { bubbles: true }));

                    clearTimeout(timer);
                    const q = this.value.trim();
                    if (q.length < 1) { clearSuggestions(); return; }
                    timer = setTimeout(() => {
                        const found = searchPrefix(q, 20);
                        render(found);
                    }, 120);
                });

                // keyboard navigation
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
                        // Only select an item if one is focused
                        if (focused >= 0) {
                            selectItem(focused);
                        } else {
                            // If no item is focused, and enter is pressed, clear suggestions but keep the text
                            clearSuggestions();
                        }
                    } else if (e.key === 'Escape') {
                        clearSuggestions();
                    }
                });

                function updateFocus() {
                    for (let i = 0; i < dropdown.children.length; i++) {
                        // ðŸ”§ CLEANUP: Use classList.toggle for Tailwind classes for better practice
                        dropdown.children[i].classList.remove('bg-[#c6d933]', 'text-black');
                        if (i === focused) {
                            dropdown.children[i].classList.add('bg-[#c6d933]', 'text-black');
                        }
                    }
                    if (focused >= 0 && dropdown.children[focused]) {
                        dropdown.children[focused].scrollIntoView({block: 'nearest'});
                    }
                }

                // close on outside click
                document.addEventListener('click', function(e) {
                    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                        clearSuggestions();
                    }
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

            // ONLY calculate Days and Hours
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            // Create the compact string
            let timerParts = [];
            if (days > 0) timerParts.push(days + "d");
            timerParts.push(hours + "h");
            
            display.innerHTML = timerParts.join(" ");
        }, 1000);
    }
    document.addEventListener('livewire:init', () => {
        // 1. Run immediately when page loads
        runSuspensionTimer();

        // 2. Also listen for the Livewire event if the user tries to submit
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
        
        // Clear any existing intervals if they exist
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

    // Run on initial load and Livewire updates
    document.addEventListener('livewire:initialized', startCountdown);
    document.addEventListener('livewire:navigated', startCountdown);
    window.addEventListener('restart-timer', () => {
        // Wait a tiny bit for the DOM to update with the new session data
        setTimeout(startCountdown, 100);
    });

        </script>
        
</div><?php /**PATH C:\Users\monye\Documents\staging.teketesafespace.co.za\resources\views/livewire/report-form.blade.php ENDPATH**/ ?>