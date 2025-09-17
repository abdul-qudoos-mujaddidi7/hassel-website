<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-top: 5px; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <p>You have received a new contact form submission on the Mount Agro Institution website.</p>
            
            <div class="field">
                <div class="label">Name:</div>
                <div class="value">{{ $contact->name }}</div>
            </div>
            
            <div class="field">
                <div class="label">Email:</div>
                <div class="value">{{ $contact->email }}</div>
            </div>
            
            <div class="field">
                <div class="label">Phone:</div>
                <div class="value">{{ $contact->phone ?? 'Not provided' }}</div>
            </div>
            
            <div class="field">
                <div class="label">Subject:</div>
                <div class="value">{{ $contact->subject }}</div>
            </div>
            
            <div class="field">
                <div class="label">Message:</div>
                <div class="value">{{ $contact->message }}</div>
            </div>
            
            <div class="field">
                <div class="label">Submitted:</div>
                <div class="value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This email was sent from the Mount Agro Institution website contact form.</p>
            <p>Please reply directly to {{ $contact->email }} to respond to this inquiry.</p>
        </div>
    </div>
</body>
</html>
