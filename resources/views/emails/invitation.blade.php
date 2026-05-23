<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeNest Invitation</title>
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
        .highlight-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #4f46e5;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .highlight-box p {
            margin: 0 0 8px 0;
            font-size: 15px;
        }
        .highlight-box p:last-child {
            margin-bottom: 0;
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
                <h1>TimeNest</h1>
            </div>
            <div class="content">
                <h2>Hello!</h2>
                <p>You have been invited to join <strong>{{ $invitation->corporation->legal_name }}</strong> on TimeNest as a <strong>{{ $invitation->role->description() ?? $invitation->role->name }}</strong>.</p>
                
                <div class="highlight-box">
                    <p><strong>Invited by:</strong> {{ $invitation->invitedBy->name }} ({{ $invitation->invitedBy->email }})</p>
                    <p><strong>This invitation expires on:</strong> {{ $invitation->expires_at->format('F j, Y, g:i a') }} (UTC)</p>
                </div>

                <p>To accept this invitation and set up your workspace, click the button below:</p>

                <div class="btn-container">
                    <a href="{{ $acceptUrl }}" class="btn">Accept Invitation</a>
                </div>

                <p>If you did not expect this invitation or if you have any questions, you can safely ignore this email.</p>
                
                <p>Best regards,<br>The TimeNest Team</p>
            </div>
            <div class="footer">
                <p>This is an automated email from TimeNest. Please do not reply directly to this message.</p>
                <p>&copy; {{ date('Y') }} TimeNest. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
