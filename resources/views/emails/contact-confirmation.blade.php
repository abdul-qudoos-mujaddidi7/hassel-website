<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thank You for Contacting Us</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #16a34a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .button { display: inline-block; background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Contacting Us</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $contact->name }},</p>
            
            <p>Thank you for reaching out to {{ $company_name }}. We have received your message and appreciate your interest in our work.</p>
            
            <p><strong>Your message summary:</strong></p>
            <p><strong>Subject:</strong> {{ $contact->subject }}</p>
            <p><strong>Submitted:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</p>
            
            <p>Our team will review your inquiry and get back to you within 2-3 business days. If your matter is urgent, please don't hesitate to call us directly.</p>
            
            <p>In the meantime, feel free to explore our website to learn more about our programs and initiatives:</p>
            
            <a href="{{ $company_website }}" class="button">Visit Our Website</a>
            
            <p>Thank you for your patience, and we look forward to connecting with you soon.</p>
            
            <p>Best regards,<br>
            The {{ $company_name }} Team</p>
        </div>
        
        <div class="footer">
            <p><strong>{{ $company_name }}</strong></p>
            <p>Email: {{ $company_email }}</p>
            <p>Website: {{ $company_website }}</p>
            <hr>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
