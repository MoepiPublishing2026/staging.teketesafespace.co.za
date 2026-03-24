<?php $__env->startComponent('mail::message'); ?>
# Report Updated

A reporter has **edited a report**.

**Case Number:**  
<?php echo new \Illuminate\Support\EncodedHtmlString($report->case_number); ?>


**Location:**  
<?php echo new \Illuminate\Support\EncodedHtmlString($report->location); ?>


**Updated At:**  
<?php echo new \Illuminate\Support\EncodedHtmlString($timestamp); ?>


<?php $__env->startComponent('mail::button', ['url' => url('/school-admin')]); ?>
View Report
<?php echo $__env->renderComponent(); ?>

Thanks,  
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\teketeApp\staging.teketesafespace.co.za\resources\views/emails/report_updated.blade.php ENDPATH**/ ?>