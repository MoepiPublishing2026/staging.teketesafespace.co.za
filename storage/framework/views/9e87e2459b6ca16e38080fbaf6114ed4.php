<?php $__env->startComponent('mail::message'); ?>
# New Report Submitted

A reporter has submitted a **new report**.

**Case Number:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->case_number); ?>  
**Location:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->location ?? 'N/A'); ?>  
**Submitted At:** <?php echo new \Illuminate\Support\EncodedHtmlString($timestamp); ?>


<?php if(!$report->is_anonymous): ?>
**Reporter Name:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->full_name ?? 'N/A'); ?>  
**Email:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->reporter_email ?? 'N/A'); ?>  
**Phone:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->phone_number ?? 'N/A'); ?>

<?php else: ?>
**Reporter:** Anonymous
<?php endif; ?>

<?php $__env->startComponent('mail::button', ['url' => url('/school-admin')]); ?>
View Report
<?php echo $__env->renderComponent(); ?>

Thanks,  
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/emails/incident-reported.blade.php ENDPATH**/ ?>