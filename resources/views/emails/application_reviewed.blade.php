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
            <p>We are thrilled to inform you that your application to study <strong>{{ strtoupper($application->course_name) }}</strong> has been officially approved!</p>
            
            <p>Your official Admission Number is: <strong>{{ $application->admission_number }}</strong></p>

            <p>You can now log in to the student portal to download your official PDF Admission Letter, which contains important details regarding your reporting date and required documents.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('login') }}" class="btn">Log In to Download Letter</a>
            </div>
            
        @elseif($application->status === 'rejected')
            <p>Your admission application has been reviewed by the Registrar. However, it requires some corrections before it can be approved.</p>

            <div class="alert">
                <strong>Reason for Return:</strong><br>
                {{ $application->rejection_reason }}
            </div>

            <p>Please log back into the admission portal, correct the issues mentioned above, and resubmit your application.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('login') }}" class="btn">Log In to Resubmit</a>
            </div>
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