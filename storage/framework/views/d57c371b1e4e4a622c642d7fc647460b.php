<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(to right, #c7da30, #d7e47a);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #000;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
            color: #333;
            line-height: 1.6;
        }
        .case-number {
            background-color: #f5f5f5;
            border-left: 4px solid #c7da30;
            padding: 15px;
            margin: 20px 0;
            font-size: 16px;
            font-weight: 600;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin: 10px 0;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in-process { background-color: #dbeafe; color: #1e40af; }
        .status-escalated { background-color: #fee2e2; color: #991b1b; }
        .status-resolved { background-color: #d1fae5; color: #065f46; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-unresolved { background-color: #f3f4f6; color: #374151; }
        .status-false-report { background-color: #e9d5ff; color: #6b21a8; }
        .reason-box {
            background-color: #fffbf7;
            border: 3px solid #c7da30;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .reason-box h3 {
            margin-top: 0;
            color: #000;
            font-size: 16px;
        }
        .reason-box p {
            margin: 10px 0 0 0;
            color: #555;
        }
        .details-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e5e5;
        }
        .details-table td:first-child {
            font-weight: 600;
            width: 40%;
            color: #555;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 25px 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(to right, #c7da30, #d7e47a);
            color: #000;
            padding: 14px 32px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            font-size: 16px;
        }
        .alert-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        /* Appeal Box Styling */
        .appeal-box {
            background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
            border: 3px solid #a855f7;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }
        .appeal-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(to right, #c7da30, #d7e47a);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 32px;
        }
        .appeal-title {
            color: #6b21a8;
            font-size: 22px;
            font-weight: 700;
            margin: 15px 0;
        }
        .appeal-text {
            color: #7c3aed;
            font-size: 15px;
            line-height: 1.6;
            margin: 15px 0;
        }
        .appeal-button {
            display: inline-block;
            background: linear-gradient(to right, #c7da30, #d7e47a);
            color: #000;
            padding: 16px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            font-size: 18px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s;
        }
        .appeal-steps {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
        }
        .appeal-steps ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .appeal-steps li {
            margin: 8px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🔔 Case Status Update</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Dear Reporter,</p>
            
            <p>We are writing to inform you that the status of your report has been updated.</p>

            <div class="case-number">
                📋 Case Number: <strong><?php echo e($report->case_number); ?></strong>
            </div>

            <table class="details-table">
                <tr>
                    <td>Report Type:</td>
                    <td><?php echo e($report->abuseType->type_name ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Report Subtype:</td>
                    <td><?php echo e($report->subtype->sub_type_name ?? 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>New Status:</td>
                    <td>
                        <span class="status-badge status-<?php echo e($report->status); ?>">
                            <?php echo e(ucfirst(str_replace('-', ' ', $report->status))); ?>

                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Date Updated:</td>
                    <td><?php echo e($report->updated_at->format('F d, Y \a\t h:i A')); ?></td>
                </tr>
            </table>

            <?php if($reason): ?>
            <div class="reason-box">
                <h3>📝 Administrator's Note:</h3>
                <p><?php echo e($reason); ?></p>
            </div>
            <?php endif; ?>

            
           
           <?php if($report->status === 'false-report'): ?>
    <div class="alert-box" style="background-color: #fef2f2; border-left: 4px solid #dc2626; color: #991b1b; padding: 20px; margin-bottom: 25px; border-radius: 8px;">
        <h3 style="margin-top: 0; color: #b91c1c; font-size: 18px;">⚠️ CRITICAL SYSTEM WARNING</h3>
        <p style="font-size: 14px; margin-bottom: 10px; line-height: 1.5;">
            Your report has been officially flagged for providing <strong>fraudulent or false information</strong>. This is a severe violation of the Tekete Safe Space terms of service.
        </p>
    </div>

    <div class="appeal-box" style="background: #faf5ff; border: 2px solid #6b21a8; padding: 25px; text-align: center; border-radius: 12px;">
        <h2 style="color: #6b21a8; font-size: 20px; margin-bottom: 10px;">Action Required: Resolve Your Case</h2>
        <p style="color: #4b218b; font-size: 14px; margin-bottom: 20px;">
            To resolve this flag, you must provide a clarification statement or correct the details in your original report.
        </p>
        
        <div style="margin-bottom: 15px;">
            <a href="<?php echo e(url('/clarify/' . $report->case_number)); ?>" class="appeal-button" style="display: block; margin-bottom: 10px;">
                🔄 Provide Clarification Statement
            </a>
            
            <a href="<?php echo e(url('/edit-report/' . $report->case_number)); ?>" 
               style="display: block; color: #6b21a8; text-decoration: underline; font-weight: 600; font-size: 15px; margin-top: 10px;">
                ✏️ Edit My Original Report Details
            </a>
        </div>

        <div style="text-align: left; background: #ffffff; padding: 15px; margin-top: 20px; border-radius: 8px; font-size: 13px; color: #555;">
            <strong>How to resolve this:</strong>
            <ol style="margin-top: 8px;">
                <li>Use <strong>Clarification</strong> to explain a misunderstanding.</li>
                <li>Use <strong>Edit Report</strong> to fix factual errors or add missing evidence.</li>
            </ol>
            <p style="margin-top: 10px; font-style: italic; color: #991b1b;">
                *Failure to respond may result in immediate loss of system access.
            </p>
        </div>
    </div>

          
            <?php elseif(in_array($report->status, ['resolved', 'completed'])): ?>
            <div class="alert-box" style="background-color: #d1fae5; border-left: 4px solid #065f46;">
                <strong>✅ Your case has been resolved.</strong><br>
                Thank you for your patience throughout this process. If you have any questions or concerns about the resolution, please don't hesitate to contact us.
            </div>
            <?php elseif($report->status === 'escalated'): ?>
            <div class="alert-box" style="background-color: #fee2e2; border-left: 4px solid #991b1b;">
                <strong>⚠️ Your case has been escalated.</strong><br>
                This matter is now receiving priority attention from our senior team. We will keep you updated on any developments.
            </div>
            <?php endif; ?>

            <p style="margin-top: 30px;">
                We appreciate your trust in reporting this matter. Our team is committed to addressing all reports with the atmost care and attention.
            </p>

            <p>
                If you have any questions or need further assistance, please reply to this email or contact our support team.
            </p>

            <p style="margin-top: 30px;">
                <strong>Best regards,</strong><br>
                The Administration Team
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Important:</strong> This is an automated notification. Please do not reply directly to this email.</p>
            <p>For inquiries, contact us at sales@teketesafespace.co.za</p>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                 © <?php echo e(date('Y')); ?> Tekete Safe Space from Moepi Publishing
            </p>
        </div>
    </div>
</body>
</html><?php /**PATH /home/teketeq9v8o0/staging.teketesafespace.co.za/resources/views/emails/report-status-changed.blade.php ENDPATH**/ ?>