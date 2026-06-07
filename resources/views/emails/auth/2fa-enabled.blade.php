<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Two-Factor Authentication Enabled</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #eaeaec; }
        .header { margin-bottom: 30px; font-weight: bold; font-size: 24px; color: #111827; }
        .footer { margin-top: 40px; font-size: 13px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">TimeNest</div>
        
        <h2>Two-Factor Authentication Enabled</h2>
        
        <p>Hi {{ $user->first_name ?? $user->name }},</p>
        
        <p>Two-factor authentication (2FA) has been successfully enabled on your TimeNest account.</p>
        
        <p>Your account is now protected with an extra layer of security. Every time you sign in, you will need your password and an authentication code from your authenticator app.</p>
        
        <p><strong>Important:</strong> Make sure you have saved your recovery codes in a secure place. You will need them to access your account if you lose your device.</p>
        
        <div class="footer">
            This is an automated security notification from TimeNest.
        </div>
    </div>
</body>
</html>
