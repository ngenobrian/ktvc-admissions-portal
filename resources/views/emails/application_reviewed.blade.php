<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-top: 4px solid #7B1818; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; border-top: 1px solid #ddd; padding-top: 10px; }
        .btn { display: inline-block; padding: 10px 20px; color: #fff; background-color: #7B1818; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .alert { padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #7B1818;">Kipkabus Technical and Vocational College</h2>
        </div>

        <p>Dear <strong>{{ strtoupper($application->first_name) }}</strong>,</p>

        @if($application->status === 'approved')
            <h2 style="color: #28a745;">Congratulations!</h2>
            <p>Your admission application to Kipkabus Technical and Vocational College has been approved.</p>
            <p>Log in to your dashboard to download your official Admission Letter.</p>
            
        @elseif($application->status === 'rejected')
            <h2 style="color: #dc3545;">Action Required on Your Application</h2>
            <p>Your application requires amendments before it can be approved. The registrar has provided the following instructions:</p>
            
            <div style="background-color: #f8d7da; padding: 15px; border-left: 5px solid #dc3545; border-radius: 5px; color: #721c24; margin: 20px 0;">
                <strong>Reason:</strong><br>
                {{ $application->rejection_reason }}
            </div>
            
            <p>Please log in to your KTVC Admissions Portal dashboard to update your details and resubmit your application.</p>
        @endif

        <p>Best regards,<br>
        <strong>The Registrar's Office</strong><br>
        KTVC</p>

        <div class="footer">
            <p>This is an automated email. Please do not reply directly to this message. For support, contact info@ktvc.ac.ke.</p>
        </div>
    </div>
</body>
</html>