<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-top: 4px solid #7B1818;">
        <h2>Kipkabus Technical and Vocational College</h2>
        <p>Hello,</p>
        <p>Thank you for starting your application. Please use the following 6-digit code to verify your email address:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #7B1818; background: #f8f9fa; padding: 15px 25px; border-radius: 5px;">
                {{ $otpCode }}
            </span>
        </div>

        <p>This code will expire in 15 minutes.</p>
        <p>If you did not request this, please ignore this email.</p>
        <br>
        <p>Regards,<br>KTVC Admissions Office</p>
    </div>
</body>
</html>