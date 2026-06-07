<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Account is Temporarily Locked</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #eaeaec; }
        .header { margin-bottom: 30px; font-weight: bold; font-size: 24px; color: #111827; }
        .footer { margin-top: 40px; font-size: 13px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .alert { background-color: #fef2f2; border: 1px solid #f87171; color: #991b1b; padding: 15px; border-radius: 6px; margin-top: 25px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">TimeNest</div>
        
        <h2>Account Temporarily Locked</h2>
        
        <p>Hi {{ $user->first_name ?? $user->name }},</p>
        
        <p>We detected multiple failed login attempts for your account. To protect your security, we have temporarily locked your account.</p>
        
        <p>You will be able to try logging in again after <strong>{{ $lockedUntil }}</strong>.</p>
        
        <div class="alert">
            <strong>Security Alert:</strong> If you did not attempt to log in recently, someone else may be trying to access your account. Consider resetting your password.
        </div>
        
        <div class="footer">
            This is an automated security notification from TimeNest.
        </div>
    </div>
</body>
</html>
