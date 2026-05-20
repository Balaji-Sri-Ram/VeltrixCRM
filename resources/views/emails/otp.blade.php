<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VeltrixCRM Verification Code</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Plus Jakarta Sans', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #FBFBF9;
            color: #1A1A1A;
            margin: 0;
            padding: 0;
            line-height: 1.65;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px -10px rgba(45, 58, 45, 0.08);
            border: 1px solid #E5E2DC;
        }
        .header {
            background-color: #2D3A2D;
            padding: 48px 32px;
            text-align: center;
            position: relative;
        }
        .logo {
            color: #ffffff;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .logo span {
            color: #9B5A46;
        }
        .subtitle {
            color: #E5E2DC;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 8px;
            margin-bottom: 0;
            font-weight: 700;
        }
        .content {
            padding: 48px 40px;
        }
        h1 {
            font-size: 24px;
            font-weight: 800;
            color: #2D3A2D;
            margin-top: 0;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }
        p {
            font-size: 15px;
            color: #706F6C;
            margin-bottom: 24px;
        }
        .otp-container {
            background-color: #F5F3EF;
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            margin: 32px 0;
            border: 1px solid #E5E2DC;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            color: #9B5A46;
            letter-spacing: 8px;
            margin: 0;
            padding-left: 8px;
        }
        .hint {
            font-size: 12.5px;
            color: #706F6C;
            margin-top: 14px;
            margin-bottom: 0;
            font-weight: 500;
        }
        .footer {
            background-color: #F5F3EF;
            padding: 32px 40px;
            text-align: center;
            border-top: 1px solid #E5E2DC;
            font-size: 12px;
            color: #706F6C;
        }
        .footer a {
            color: #9B5A46;
            text-decoration: none;
            font-weight: 600;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="logo">Veltrix<span>CRM</span></h2>
            <div class="subtitle">Access Security</div>
        </div>
        <div class="content">
            <h1>Verify your identity</h1>
            <p>Hello {{ $user->name }},</p>
            <p>A request was made to reset the password for your VeltrixCRM account. Please use the following 6-digit security verification code to authorize the access recovery:</p>
            
            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
                <p class="hint">This security code is strictly confidential and will expire in 15 minutes.</p>
            </div>
            
            <p>If you did not request this verification, you can safely ignore this email. Your workspace access remains secure.</p>
            <p style="margin-bottom: 0;">Best regards,<br>The VeltrixCRM Security Team</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} VeltrixCRM. All rights reserved.</p>
            <p>Need support? Please contact our <a href="mailto:veltrixcrm@gmail.com">Security Operations Team</a>.</p>
        </div>
    </div>
</body>
</html>
