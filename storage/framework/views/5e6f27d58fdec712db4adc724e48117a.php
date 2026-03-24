<?php $__env->startComponent('mail::message'); ?>
# Your One-Time Password

Your one-time password for login is: **<?php echo new \Illuminate\Support\EncodedHtmlString($otp); ?>**

This code is valid for 5 minutes. Do not share it with anyone.

Thanks,
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\teketeApplication\staging.teketesafespace.co.za\resources\views/emails/login-otp.blade.php ENDPATH**/ ?>