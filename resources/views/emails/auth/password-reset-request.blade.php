<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset Request</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #eaeaec; }
        .header { margin-bottom: 30px; font-weight: bold; font-size: 24px; color: #111827; }
        .token-box { background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 6px; padding: 15px; margin: 25px 0; text-align: center; }
        .token { font-family: monospace; font-size: 16px; word-break: break-all; color: #4b5563; margin: 0; }
        .footer { margin-top: 40px; font-size: 13px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .security-note { font-size: 14px; color: #4b5563; margin-top: 25px; }
        .button { display: inline-block; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 500; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">TimeNest</div>
        
        <h2>Password Reset Request</h2>
        
        <p>Hi {{ $user->first_name ?? $user->name }},</p>
        
        <p>We received a request to reset your TimeNest account password.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" class="button">Reset Password</a>
        </div>
        
        <p>This link expires in <strong>{{ $expireMinutes }} minutes</strong>.</p>
        
        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
        <p style="word-break: break-all; color: #6b7280; font-size: 14px;">{{ $url }}</p>
        
        <p class="security-note">If you did not request a password reset, you can safely ignore this email. Your password will not change.</p>
        
        <div class="footer">
            This is an automated security notification from TimeNest.
        </div>
    </div>
</body>
</html>
