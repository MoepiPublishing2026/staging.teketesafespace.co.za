<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Safe Space</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-[Montserrat]">

<!-- HEADER -->
<div class="w-full flex justify-between items-center px-6 lg:px-20 py-4 bg-white shadow-sm font-[Montserrat]">

    <!-- Logo -->
    <div>
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Safe Space Logo" class="w-[150px] h-auto">
    </div>

    <!-- Desktop Menu -->
    <div class="hidden md:flex gap-8 text-[17px] font-[Montserrat] text-black">
        <a href="<?php echo e(route('landing-page')); ?>" class="hover:text-[#c7da30]">Home</a>
        <a href="<?php echo e(route('about-us')); ?>" class="text-[#000000] font-bold">About Us</a>
        <a href="<?php echo e(route('contact-us')); ?>" class="hover:text-[#c7da30]">Contact Us</a>
    </div>
</div>


<!-- ABOUT HEADER SECTION -->
<section class="w-full bg-white px-6 lg:px-20 py-16 font-[Montserrat]">
    <div class="max-w-[1280px] mx-auto flex flex-col lg:flex-row items-center gap-12 font-[Montserrat]">

        <!-- Left Illustration -->
        <div class="flex justify-center lg:justify-start">
            <img src="<?php echo e(asset('images/magnifying glass.png')); ?>" 
                 alt="Magnifying Glass"
                 class="w-[220px] md:w-[260px] lg:w-[300px]">
        </div>

        <!-- Right Text -->
        <div class="flex-1 text-center lg:text-left -mt-12">
            <h2 class="text-[50px] md:text-[50px] font-extrabold text-[#333333] mb-6 font-[Montserrat]">
                ABOUT SAFE SPACE
            </h2>

            <div class="h-[6px] w-[525px] bg-[#c7da30] mx-auto lg:mx-0 -mt-10"></div>
        </div>
    </div>
    <p class="text-[17px] text-[#444444] leading-relaxed mt-9">
                A confidential platform designed to protect and empower learners 
                and employees to speak out—with the option to report anonymously.
                Your voice matters. Your identity is protected. <br> Whether you choose to report with your name or anonymously, Safe Space by Moepi Publishing ensures every
report is handled with confidentiality and urgency.
            </p>



<section class="w-full bg-white px-6 lg:px-20 py-16 font-[Montserrat]">

    <h2 class="font-[Montserrat] text-[21px] text-black text-center font-semibold mb-16">
        You can report any of the following through Safe Space
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10 text-left font-[Montserrat]">
        <?php
            $issues = [
                ['img' => 'Bullying.png', 'title' => 'Bullying'],
                ['img' => 'Substance  Abuse.png', 'title' => 'Substance Abuse'],
                ['img' => 'Sexual Abuse.png', 'title' => 'Sexual Abuse or Harassment'],
                ['img' => 'weapons.png', 'title' => 'Weapons'],
                ['img' => 'pregnancy.png', 'title' => 'Teenage Pregnancy'],
                ['img' => 'other issues.png', 'title' => 'Other Issues'],
            ];
        ?>

        <?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('choose-report-type')); ?>"
                class="flex flex-col items-start hover:opacity-80 transition">
                
                <div class="h-[80px] w-[80px] flex items-center justify-start mb-3">
                    <img src="<?php echo e(asset('images/' . $issue['img'])); ?>" 
                         class="max-w-full max-h-full object-contain"
                         alt="<?php echo e($issue['title']); ?>">
                </div>

                <p class="text-[16px] text-[#333] leading-tight text-left">
                    <?php echo e($issue['title']); ?>

                </p>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>



<!-- WHO WE ARE -->
<section class="bg-white w-full px-6 lg:pl-5 lg:pr-20 -mt-8 pb-12 max-w-[1280px] mx-auto grid grid-cols-1 md:grid-cols-[1fr_auto] gap-10 items-start font-[Montserrat]">
    
    <div class="pt-2 text-left"> 
        <h3 class="text-[#c7da30] text-[29.9px] font-bold mb-3 text-left">
            Who we serve:
        </h3>

        <ul class="list-disc list-outside font-[Montserrat] text-[16px] w-full text-black space-y-2 pl-5">
            <li class="w-full">Learners — A safe way to speak out without fear.</li>
            <li class= "w-full">Parents — Peace of mind knowing concerns can be raised.</li>
            <li class=" w-full">Teachers & Staff — A trusted channel for reporting misconduct.</li>
            <li class=" w-full">Schools — A structured system to build safer, more accountable learning environments.</li>
            <li class=" w-full">Organisations — A safer working environment for both employer and employee.</li>
        </ul>
    </div>

    <div class="flex justify-center md:justify-end">
        <img src="<?php echo e(asset('images/Students holding phone.png')); ?>" 
             alt="Students using Safe Space"
             class="w-[230px] h-auto rounded-lg shadow-md">
    </div>
</section>
 <div class="hidden lg:block absolute -left-48 top-[210%] -translate-y-1/2 w-[350px] h-[200px] overflow-hidden">
    <img src="<?php echo e(asset('images/futuristic digital frame tech.png')); ?>" 
         alt="Tech Frame Half"
         class="w-full h-full object-cover object-left">
</div>

<!-- CORE VALUES -->
<section class="bg-white w-full px-6 lg:px-20 pt-4 pb-4 font-[Montserrat]">
    <h3 class="text-[#c7da30] text-[26px] font-bold text-center mb-8">
        Our Core Values
    </h3>

    <div class="space-y-8 text-gray-800 text-[16px] md:text-[17px] flex flex-col items-start w-full">

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">1. Safety First</p>
                <p>We believe every learner has the right to feel and be safe at school, at home, and in their community. Our system is designed to protect and empower young people by creating a secure environment where they can speak up without fear.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">2. Confidentiality & Trust</p>
                <p>Learners must feel confident that what they share is protected. Our platform ensures anonymity, privacy, and strict data protection. We are committed to earning and maintaining the trust of every learner who reaches out for help.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">3. Empowerment Through Voice</p>
                <p>Silence often comes from fear. We exist to give learners their voice back — to allow them to speak their truth, raise concerns, and ask for help without shame or judgment. Every voice matters.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">4. Equity & Inclusion</p>
                <p>Every learner, regardless of gender, background, or circumstance, deserves equal access to support and protection. We pay special attention to the unique vulnerabilities of girls, LGBTQ+ youth, and others who are often left behind.</p>
            </div>

            <div class="text-center w-full">
                <p class="font-bold text-[#545454] text-[18px] mb-2 text-center ">5. Technology with Integrity</p>
                <p>Our platform is digital, encrypted, and POPIA-compliant — but more importantly, it is designed with human dignity at the center. Technology should never replace care, but it can strengthen and extend it.</p>
            </div>

        </div>
</section>
</section>

<!-- FOOTER -->

<footer class="w-full bg-[#808080] text-white py-6 -mt-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 px-6 max-w-[1280px] mx-auto text-[16px]">
            
            <div class="order-1" style="font-family: Montserrat; font-size: 16.9px; width: 697.9px; height: 45.5px; left:19.4;top:706.9;">
                <p>
                    © <?php echo e(date('Y')); ?> Safe Space from Moepi Publishing. All rights reserved.
                </p>
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

        </div>
    </footer>

</div> 
</html><?php /**PATH C:\xampp\htdocs\teketeApplication\staging.teketesafespace.co.za\resources\views/about/index.blade.php ENDPATH**/ ?>