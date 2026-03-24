<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo e($title ?? 'Safe Space'); ?></title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/favicon.png')); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/favicon-32x32.png')); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('images/favicon-16x16.png')); ?>">

        <!-- Google Fonts - Montserrat -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-white font-[Montserrat]">

        <!-- Page Content -->
        <main>
            <?php echo e($slot); ?>

        </main>

    </body>
</html>
<?php /**PATH C:\xampp\htdocs\teketeApplication\staging.teketesafespace.co.za\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>