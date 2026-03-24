<div class="min-h-screen bg-white flex flex-col font-[Montserrat] relative w-full">
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Header -->
    <header
        style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div class="flex flex-row justify-between items-center px-8 py-2" style="max-width: 1280px; margin: 0 auto;">
            <div>
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" style="width: 110px; height: auto;">
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex gap-8"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
                    <a href="javascript:void(0);" onclick="window.history.back();"
                        class="transition-colors hover:!text-[#c7da30]" style="color: black; text-decoration: none;">
                        Back
                    </a>
                    <a href="<?php echo e(route('landing-page')); ?>" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">
                        Home
                    </a>
                    <a href="<?php echo e(route('about-us')); ?>" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">
                        About Us
                    </a>
                    <a href="<?php echo e(route('contact-us')); ?>" class="transition-colors hover:!text-[#c7da30]"
                        style="color: black; text-decoration: none;">
                        Contact Us
                    </a>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-button"
                        class="p-2 rounded-md text-black hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#c7da30]">
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
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="h-8">
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
                <a href="<?php echo e(route('landing-page')); ?>" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Home
                </a>
                <a href="<?php echo e(route('landing-page')); ?>#about" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    About Us
                </a>
                <a href="<?php echo e(route('landing-page')); ?>#section" onclick="toggleMobileMenu()"
                    class="block py-3 text-black hover:text-[#c7da30] transition-colors"
                    style="font-family: 'Montserrat', sans-serif; font-size: 17px;">
                    Contact Us
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Section -->
    <div class="min-h-screen bg-white flex flex-col font-[Montserrat]"
        style="padding-top: 140px; padding-bottom: 80px; width: 100%;">


        <h1 class="text-3xl font-bold text-black mb-8 text-center uppercase"
            style="font-family: 'Montserrat', sans-serif; letter-spacing: 2px;">TRACK STATUS</h1>
        <div class="w-full max-w-2xl px-4 mx-auto">


            <div x-data="{
                show: false,
                message: '',
                hideMessage() {
                    setTimeout(() => {
                        this.show = false;
                    }, 5000); // 5000 milliseconds = 5 seconds
                }
            }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-10px]"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-[-10px]"
                @status-updated.window="
    message = $event.detail.message;
    show = true;
    hideMessage(); // Call the new method to hide the message automatically
"
                class="mb-6 bg-green-100 border-2 border-[#c7da30] text-green-700 px-4 py-3 rounded-lg relative"
                role="alert" style="font-family: 'Montserrat', sans-serif;">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium" x-text="message"></span>
                    </div>
                    <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>


            <div class="border-4 border-[#c7da30] rounded-2xl p-8 bg-white">



                <form wire:submit.prevent="checkStatus" class="space-y-4">
                    <div>
                        <input type="text" id="caseNumber" wire:model.live="caseNumber" placeholder="Case Number"
                            class="w-full py-4 px-4 text-gray-400 rounded-xl focus:outline-none"
                            style="border: 3px solid #c7da30; font-family: 'Montserrat', sans-serif; font-size: 14px;"
                            required>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['caseNumber'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div x-data="{ open: true }" x-show="open"
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                <div
                                    class="mx-auto border-2 border-[#c6d933] rounded-[10px] bg-white 
                                            flex flex-col items-center justify-center w-[90%] sm:w-[635px] 
                                            h-[300px] sm:h-[342px] p-4 text-center shadow-lg relative">

                                    <p class="text-[18px] sm:text-[19px] text-black mb-4"
                                        style="font-family: 'Montserrat', sans-serif;">
                                        <?php echo e($message); ?>

                                    </p>

                                    <button @click="open = false"
    class="w-[190px] h-[56px] sm:h-[64px]
           border-4 border-solid border-[#c7da30]
           rounded-[100px] text-[#38b6ff] 
           text-[15px] font-normal transition duration-200 
           hover:opacity-80 shadow-md flex items-center justify-center
           font-[Montserrat]">
    Close
</button>

                                </div>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <button type="submit"
    class="w-full py-4 px-4 
           border-4 border-solid border-[#c7da30]
           rounded-[100px] text-lg text-[#38b6ff]
           transition duration-150 ease-in-out hover:opacity-90
           font-[Montserrat]">
    Search
</button>

                </form>

                <!-- Your Case Status Section -->
                <h2 class="text-xl font-bold text-black mb-4 mt-6 text-center uppercase"
                    style="font-family: 'Montserrat', sans-serif;">
                    YOUR CASE STATUS
                </h2>


                <div class="border-3 border-[#c7da30] rounded-xl p-6 min-h-[200px] relative"
                    style="border-width: 3px; font-family: 'Montserrat', sans-serif;">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($message)): ?>
                        <div class="text-red-500 font-medium text-center mb-4">
                            <?php echo e($message); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if(!empty($reportData)): ?>
                        <!-- Case Information -->
                        <div class="text-left space-y-2">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                                <p class="text-gray-700"><strong>Case Number:</strong>
                                    <?php echo e($reportData['case_number']); ?></p>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-black text-[14px]">Status:</span>
                                    <span
                                        class="px-4 py-2 rounded-full text-sm font-bold text-black
                                        <?php switch($reportData['status']):
                                            case ('awaiting-resolution'): ?> bg-red-500 <?php break; ?>
                                            <?php case ('forwarded'): ?> bg-yellow-500 <?php break; ?>
                                            <?php case ('under-review'): ?> bg-blue-500 <?php break; ?>
                                            <?php case ('closed'): ?> bg-green-500 <?php break; ?>
                                            <?php case ('unresolved'): ?> bg-orange-500 <?php break; ?>
                                            <?php case ('false-report'): ?> bg-gray-400 <?php break; ?>
                                            <?php default: ?> bg-gray-200
                                        <?php endswitch; ?>">
                                        <?php echo e(ucfirst(str_replace('-', ' ', $reportData['status']))); ?>

                                    </span>
                                </div>
                            </div>
                            <p class="text-gray-700"><strong>Submitted on:</strong>
                                <?php echo e(\Carbon\Carbon::parse($reportData['created_at'])->format('Y/m/d')); ?></p>
                            <!--[if BLOCK]><![endif]--><?php if($reportData['is_anonymous']): ?>
                                <p class="text-gray-700"><strong>Report Type:</strong> Anonymous</p>
                            <?php else: ?>
                                <p class="text-gray-700"><strong>Report Type:</strong> With Details</p>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($reportData['full_name'])): ?>
                                    <p class="text-gray-700"><strong>Full Name:</strong>
                                        <?php echo e($reportData['full_name']); ?></p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <p class="text-gray-700"><strong>Abuse Type:</strong>
                                <?php echo e($reportData['abuse_type'] ?? ''); ?></p>
                            <p class="text-gray-700"><strong>Subtype:</strong> <?php echo e($reportData['subtype'] ?? ''); ?></p>
                            <p class="text-gray-700"><strong>Email:</strong> <?php echo e($reportData['reporter_email'] ?? ''); ?>

                            </p>
                            <p class="text-gray-700"><strong>Phone Number:</strong>
                                <?php echo e($reportData['phone_number'] ?? ''); ?></p>
                            <p class="text-gray-700"><strong>Address:</strong> <?php echo e($reportData['location'] ?? ''); ?></p>
                            <p class="text-gray-700"><strong>Grade:</strong> <?php echo e($reportData['grade'] ?? ''); ?></p>
                            <p class="text-gray-700"><strong>School Name:</strong>
                                <?php echo e($reportData['school_name'] ?? ''); ?></p>
                            <p class="text-gray-700"><strong>Age:</strong> <?php echo e($reportData['age'] ?? ''); ?></p>

                            <!--[if BLOCK]><![endif]--><?php if($reportData['latest_status_reason']): ?>
                                <div class="bg-[#f0f9e3] border-l-4 border-[#c7da30] p-4 rounded-md">
                                    <p class="font-bold text-[#c7da30] mb-1">Latest Update Reason:</p>
                                    <p class="text-[#c7da30] font-semibold italic">
                                        <?php echo e($reportData['latest_status_reason']); ?></p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            <p class="text-gray-700 pt-2"><strong>Description:</strong>
                                <?php echo e($reportData['description']); ?></p>

                            <?php
                                $attachments = $reportData['image_path']
                                    ? json_decode($reportData['image_path'], true)
                                    : [];
                            ?>

                            <!--[if BLOCK]><![endif]--><?php if(!empty($attachments)): ?>
                                <div class="mt-6">
                                    <p class="font-semibold text-black"
                                        style="font-family: 'Montserrat', sans-serif;">Attachments:</p>
                                    <div class="flex flex-wrap gap-4 mt-2">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filePath): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                              $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $publicUrl = Storage::url($filePath);  // ✅ NO ltrim()

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
                                            ?>

                                            <!--[if BLOCK]><![endif]--><?php if($isImage): ?>
                                                <img src="<?php echo e($publicUrl); ?>" alt="Attachment"
                                                    class="w-32 h-auto border rounded shadow cursor-pointer hover:opacity-80 transition"
                                                    onclick="window.open('<?php echo e($publicUrl); ?>', '_blank')">
                                            <?php elseif($isVideo): ?>
                                                <video controls
                                                    class="w-48 h-auto border rounded shadow cursor-pointer hover:opacity-80 transition">
                                                    <source src="<?php echo e($publicUrl); ?>"
                                                        type="video/<?php echo e($ext); ?>">
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php else: ?>
                                                <a href="<?php echo e($publicUrl); ?>" target="_blank"
                                                    class="text-blue-600 underline inline-block mt-2 hover:text-blue-800 transition">
                                                    View <?php echo e(basename($filePath)); ?>

                                                </a>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="mt-6 text-gray-700" style="font-family: 'Montserrat', sans-serif;">
                                    <strong>Attachment:</strong> N/A
                                </p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                            <!-- False Report Appeal Section -->
                            <!--[if BLOCK]><![endif]--><?php if($reportData['status'] === 'false-report'): ?>
                                <div class="mt-6 pt-4 border-t-2 border-purple-300 bg-purple-50 rounded-lg p-5">
                                    <div class="flex items-center justify-center mb-3">
                                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-[16px] font-semibold text-purple-800 mb-2 text-center">Report
                                        Marked as False</h3>
                                    <p class="text-[13px] text-purple-700 mb-4 text-center">
                                        If you believe this determination is incorrect, you can appeal by updating your
                                        report with additional information or evidence.
                                    </p>
                                    <div class="flex justify-center">
                                        <button wire:click="appealReport"
    class="px-6 py-3 
           border-4 border-solid border-[#c7da30]
           rounded-[100px] text-[15px] font-semibold
           text-[#38b6ff] transition hover:opacity-90
           font-[Montserrat]">
    Appeal This Report
</button>

                                    </div>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                            <!--[if BLOCK]><![endif]--><?php if($reportData['status'] === 'forwarded'): ?>

                                <!--[if BLOCK]><![endif]--><?php if(
                                    $reportData['latest_status_reason'] !== 'Reporter chose to keep the case Forwarded.' &&
                                        $reportData['latest_status_reason'] !==
                                            'Reporter chose not to keep the case forwarded, changing the status to Unresolved.'): ?>
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <p class="font-semibold text-red-600 mb-2">
                                            Do you want your case to be forwarded?
                                        </p>
                                        <div class="flex justify-center gap-4">
                                            <button wire:click="markUnresolved"
                                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                No
                                            </button>
                                            <button wire:click="markForwarded"
                                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                Yes
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                            <!--[if BLOCK]><![endif]--><?php if($reportData['status'] !== 'false-report'): ?>
    <div class="mt-4 border-t pt-4 border-gray-300">
        <a href="<?php echo e(route('edit-report', ['caseNumber' => $reportData['case_number']])); ?>"
            class="inline-block px-6 py-2
                   border-4 border-solid border-[#c7da30]
                   rounded-[100px] text-[#38b6ff]
                   transition hover:opacity-90
                   font-[Montserrat]">
            Edit Report
        </a>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

            </div>
        </div>
    </div>

     <!-- Footer -->
            <footer style="width: 100%; background-color: #808080; color: white; padding: 1.5rem 0; margin-top: 4rem;">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6"
                     style="max-width: 1280px; margin: 0 auto; font-family: 'Montserrat', sans-serif; font-size: 16px;">
                    <div>
                        <p>&copy; <?php echo e(date('Y')); ?> Safe Space from Moepi Publishing. All rights reserved.</p>
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
</div>

<script>
    // Mobile menu functionality
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', toggleMobileMenu);
        }
    });
</script>
<?php /**PATH C:\xampp\htdocs\teketeApp\staging.teketesafespace.co.za\resources\views/livewire/check-status.blade.php ENDPATH**/ ?>