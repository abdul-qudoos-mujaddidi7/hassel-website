<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Program Registration</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc2626; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { margin-top: 5px; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #666; }
        .status { padding: 10px; background: #fef3c7; border-left: 4px solid #f59e0b; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Program Registration</h1>
        </div>
        
        <div class="content">
            <p>A new program registration has been submitted on the Mount Agro Institution website.</p>
            
            <div class="status">
                <strong>Program:</strong> {{ ucwords(str_replace('_', ' ', $registration->program_type)) }}
            </div>
            
            <div class="field">
                <div class="label">Participant Name:</div>
                <div class="value">{{ $registration->user_name }}</div>
            </div>
            
            <div class="field">
                <div class="label">Email:</div>
                <div class="value">{{ $registration->email }}</div>
            </div>
            
            <div class="field">
                <div class="label">Phone:</div>
                <div class="value">{{ $registration->phone ?? 'Not provided' }}</div>
            </div>
            
            <div class="field">
                <div class="label">Location:</div>
                <div class="value">{{ $registration->location ?? 'Not provided' }}</div>
            </div>
            
            <div class="field">
                <div class="label">Registration Date:</div>
                <div class="value">{{ $registration->registration_date->format('F j, Y \a\t g:i A') }}</div>
            </div>
            
            <div class="field">
                <div class="label">Status:</div>
                <div class="value">{{ ucfirst($registration->status) }}</div>
            </div>
            
            @if($registration->notes)
            <div class="field">
                <div class="label">Additional Notes:</div>
                <div class="value">{{ $registration->notes }}</div>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>Please review this registration and update the status accordingly.</p>
            <p>Reply directly to {{ $registration->email }} to contact the participant.</p>
        </div>
    </div>
</body>
</html>
