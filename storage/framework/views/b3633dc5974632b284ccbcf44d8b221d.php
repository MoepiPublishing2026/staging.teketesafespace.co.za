<?php $__env->startComponent('mail::message'); ?>
# Report Update: Clarification Provided

The reporter for **Case #<?php echo new \Illuminate\Support\EncodedHtmlString($report->case_number); ?>** has submitted an official clarification statement in response to a flagged report.

<?php if($report->reporter_clarification): ?>
<?php $__env->startComponent('mail::panel'); ?>
**Reporter's Statement:**
<?php echo new \Illuminate\Support\EncodedHtmlString($report->reporter_clarification); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

---

### Report Details
**Case Number:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->case_number); ?>  
**Current Status:** <?php echo new \Illuminate\Support\EncodedHtmlString(ucfirst($report->status)); ?>  
**Location:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->location ?? 'N/A'); ?>


<?php if(!$report->is_anonymous): ?>
**Reporter Name:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->full_name ?? 'N/A'); ?>  
**Email:** <?php echo new \Illuminate\Support\EncodedHtmlString($report->reporter_email ?? 'N/A'); ?>

<?php else: ?>
**Reporter:** Anonymous
<?php endif; ?>

<?php $__env->startComponent('mail::button', ['url' => url('/school-admin')]); ?>
Review Clarification & Manage Report
<?php echo $__env->renderComponent(); ?>

Thanks,  
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/emails/admin_report_clarification.blade.php ENDPATH**/ ?>