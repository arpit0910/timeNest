<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your timeNest account</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        .wrapper {
            width: 100%;
            background-color: #f3f4f6;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            padding: 32px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.05em;
        }
        .content {
            padding: 40px;
            color: #1f2937;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 20px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 16px;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .btn-container {
            text-align: center;
            margin: 32px 0;
        }
        .btn {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #4338ca;
        }
        .security-box {
            background-color: #fef9c3;
            border: 1px solid #fde68a;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .security-box p {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #92400e;
        }
        .security-box p:last-child {
            margin-bottom: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>timeNest</h1>
            </div>
            <div class="content">
                <h2>Hello {{ $user->first_name ?? $user->name }},</h2>

                <p>Welcome to <strong>timeNest</strong>! Your account has been created successfully.</p>

                <p>Please verify your email address to activate your workspace access. Click the button below to get started:</p>

                <div class="btn-container">
                    <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
                </div>

                <div class="security-box">
                    <p><strong>🔒 Security Notice</strong></p>
                    <p>This verification link is personal and unique to your account. Never share it with anyone.</p>
                    <p>If you did not create a timeNest account, you can safely ignore this email — no action will be taken.</p>
                </div>

                <p>Best regards,<br>The timeNest Team</p>
            </div>
            <div class="footer">
                <p><strong>timeNest</strong> &mdash; Enterprise Workforce &amp; Business Management Platform</p>
                <p>This is an automated email. Please do not reply directly to this message.</p>
                <p>&copy; {{ date('Y') }} timeNest. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
