<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Two-Factor Authentication Disabled</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #eaeaec; }
        .header { margin-bottom: 30px; font-weight: bold; font-size: 24px; color: #111827; }
        .footer { margin-top: 40px; font-size: 13px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .alert { background-color: #fffbeb; border: 1px solid #fcd34d; color: #92400e; padding: 15px; border-radius: 6px; margin-top: 25px; font-size: 14px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .info-table th { text-align: left; padding: 8px 0; color: #6b7280; font-weight: normal; width: 100px; }
        .info-table td { padding: 8px 0; font-weight: 500; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">TimeNest</div>
        
        <h2>Two-Factor Authentication Disabled</h2>
        
        <p>Hi {{ $user->first_name ?? $user->name }},</p>
        
        <p>Two-factor authentication (2FA) has been disabled on your TimeNest account. We strongly recommend keeping 2FA enabled to protect your account from unauthorized access.</p>
        
        <table class="info-table">
            <tr>
                <th>Time:</th>
                <td>{{ $time }}</td>
            </tr>
            <tr>
                <th>Device:</th>
                <td>{{ $device }} ({{ $browser }} on {{ $os }})</td>
            </tr>
            <tr>
                <th>Location:</th>
                <td>{{ $location }}</td>
            </tr>
            <tr>
                <th>IP Address:</th>
                <td>{{ $ipAddress }}</td>
            </tr>
        </table>
        
        <div class="alert">
            <strong>Security Alert:</strong> If you did not make this change, please contact support immediately as your account may be compromised.
        </div>
        
        <div class="footer">
            This is an automated security notification from TimeNest.
        </div>
    </div>
</body>
</html>
