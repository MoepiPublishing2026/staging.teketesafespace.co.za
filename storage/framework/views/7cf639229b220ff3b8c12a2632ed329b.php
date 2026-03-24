<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link 
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
        rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Apply Montserrat font globally */
        body {
            font-family: 'Montserrat', sans-serif;
        }
        /* Outline pill button used on landing page hero */
        .btn-outline-safe {
            border: 4px solid #c7da30;
            color: #38b6ff;
            border-radius: 9999px;
            transition: transform 0.2s ease;
        }
        .btn-outline-safe:hover {
            transform: scale(1.03);
        }
        /* Custom thick border and large rounding for the "Outer Square" effect */
        .outer-square {
            border: 3px solid #c7da30; /* Stroke weight: 3px */
            border-radius: 2.5rem; /* Large rounding */
        }
    </style>
</head>

<!-- Header -->
<header style="position: fixed; top: 0; left: 0; width: 100%; background-color: #ffffff; z-index: 50; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
    <div class="flex flex-row justify-between items-center px-8 py-2"
         style="max-width: 1280px; margin: 0 auto;">
        <!-- Logo -->
        <div>
            <img src="<?php echo e(asset('images/logo.png')); ?>" 
                 alt="Safe Space Logo" 
                 style="width: 110px; height: auto;">
        </div>

        <!-- Top Right Links -->
        <div class="flex gap-8" 
             style="font-family: 'Montserrat', sans-serif; font-size: 17px; color: black;">
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
    </div>
</header>

<body class="bg-white flex flex-col min-h-screen">

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center pt-32 px-4"> 
        <div class="w-full max-w-lg mx-auto p-4"> 
            <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-black uppercase text-center">
                Forgot Your Password
            </h2>

            <!-- Outer Square -->
            <div class="bg-white p-8 sm:p-10 shadow-2xl w-full outer-square">
                <?php if(session('status')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="<?php echo e(route('password.email')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 text-left">
                            Email Address
                        </label>
                        <input id="email" type="email" 
                               class="shadow appearance-none rounded-2xl w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-white border-2 border-[#c7da30] <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               name="email" 
                               value="<?php echo e(old('email')); ?>" 
                               required 
                               autocomplete="email" 
                               autofocus
                               placeholder="Enter your email address"
                               style="border-color: #c7da30; font-size: 13px; color: rgb(128 128 128 / 0.63);"
                        />
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs mt-1 block text-left"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex flex-col space-y-4 pt-2">
                        <!-- Submit button -->
                        <button type="submit" 
                            class="w-full mx-auto block shadow-md text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c7da30] btn-outline-safe"
                            style="height: 60px; font-size: 15px; display: flex; align-items: center; justify-content: center;">
                            Send Password Reset Link
                        </button>

                        <!-- Back button -->
                        <a href="<?php echo e(url('/school-admin')); ?>" 
                           class="w-full mx-auto block shadow-md text-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#c7da30] btn-outline-safe"
                           style="height: 60px; font-size: 15px; display: flex; align-items: center; justify-content: center;">
                            ← Back to login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

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

</body>
</html>
<?php /**PATH C:\xampp\htdocs\teketeApplication\staging.teketesafespace.co.za\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>