<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Case Report Confirmation</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Montserrat', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #4CAF50;">Thank You for Your Report</h2>
        <p>This email is to confirm that we have received your incident report. Your unique case number is:</p>
        
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin: 0; color: #007bff; font-size: 24px;"><?php echo e($caseNumber); ?></h3>
        </div>
        
        <p>Please keep this number safe for future reference. We will use it to track your case and provide updates.</p>
        <p>We appreciate you taking the time to report this case. We are committed to ensuring the safety and well-being of our community.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888;">This is an automated email. Please do not reply.</p>
    </div>

    <footer style="background-color: #d3d3d3; color: black; text-align: center; padding: 1rem 0; width: 100%; margin-top: 3rem;">
        <div>
            <p style="margin: 0;">© <?php echo e(date('Y')); ?> Tekete Safe Space from Moepi Publishing</p>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\monye\Documents\staging.teketesafespace.co.za\resources\views/emails/case-number-notification.blade.php ENDPATH**/ ?>