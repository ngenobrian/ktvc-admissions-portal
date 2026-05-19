<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border-top: 4px solid #7B1818; }
        .quote { background-color: #f9f9f9; border-left: 4px solid #ccc; padding: 10px; font-style: italic; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color: #7B1818;">Kipkabus Technical and Vocational College</h2>
        
        <p>Dear <strong>{{ $enquiry->name }}</strong>,</p>
        
        <p>Thank you for reaching out to us. Here is the response to your recent enquiry:</p>

        <p style="white-space: pre-wrap;"><strong>{{ $enquiry->admin_response }}</strong></p>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">
        
        <p style="font-size: 12px; color: #777;">Your Original Message:</p>
        <div class="quote">
            {{ $enquiry->message }}
        </div>

        <p><br>Best regards,<br><strong>KTVC Admissions Office</strong></p>
    </div>
</body>
</html>