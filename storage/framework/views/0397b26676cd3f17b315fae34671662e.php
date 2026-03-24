<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Tekete Safe Space')); ?></title>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    
   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <main>
        <?php echo e($slot); ?>

    </main>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <script src="<?php echo e(asset('js/auto-logout.js')); ?>"></script>
</body>
</html><?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/layouts/app.blade.php ENDPATH**/ ?>