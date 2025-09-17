<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #16a34a; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .program-info { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #16a34a; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .status { padding: 10px; background: #dbeafe; border-left: 4px solid #2563eb; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Registration Confirmed!</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $registration->user_name }},</p>
            
            <p>Thank you for registering for our {{ ucwords(str_replace('_', ' ', $registration->program_type)) }}. We have received your registration and are excited about your participation.</p>
            
            <div class="program-info">
                <h3>Registration Details</h3>
                <p><strong>Program:</strong> {{ ucwords(str_replace('_', ' ', $registration->program_type)) }}</p>
                <p><strong>Registration Date:</strong> {{ $registration->registration_date->format('F j, Y') }}</p>
                <p><strong>Registration ID:</strong> #{{ $registration->id }}</p>
            </div>
            
            <div class="status">
                <strong>Current Status:</strong> {{ ucfirst($registration->status) }}
                <br>
                <small>Your registration is currently under review. We will notify you once it has been processed.</small>
            </div>
            
            <h3>What's Next?</h3>
            <ul>
                <li>Our team will review your registration within 2-3 business days</li>
                <li>You will receive an email notification about the status of your application</li>
                <li>If approved, you will receive detailed program information and next steps</li>
                <li>Keep this email for your records</li>
            </ul>
            
            <h3>Questions?</h3>
            <p>If you have any questions about your registration or our programs, please don't hesitate to contact us:</p>
            <p>Email: {{ $company_email }}<br>
            Phone: +93 (0) 123 456 789</p>
            
            <p>Thank you for your interest in {{ $company_name }}. We look forward to working with you!</p>
            
            <p>Best regards,<br>
            The {{ $company_name }} Team</p>
        </div>
        
        <div class="footer">
            <p><strong>{{ $company_name }}</strong></p>
            <p>Supporting Agricultural Development in Afghanistan</p>
            <hr>
            <p>This is an automated message confirming your registration. Please keep this email for your records.</p>
        </div>
    </div>
</body>
</html>
