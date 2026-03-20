<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Report Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #4CAF50;">Thank You for Your Report</h2>
        <p>This email is to confirm that we have received your incident report. Your unique case number is:</p>
        <div style="background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin: 0; color: #007bff; font-size: 24px;">{{ $caseNumber }}</h3>
        </div>
        <p>Please keep this number safe for future reference. We will use it to track your case and provide updates.</p>
        <p>We appreciate you taking the time to report this incident. We are committed to ensuring the safety and well-being of our community.</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888;">This is an automated email. Please do not reply.</p>
    </div>
</body>
</html>
