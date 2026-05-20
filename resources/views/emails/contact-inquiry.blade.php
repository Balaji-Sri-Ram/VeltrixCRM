<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Inquiry | VeltrixCRM</title>
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
        .inquiry-card {
            background-color: #F5F3EF;
            border-radius: 20px;
            padding: 28px;
            margin: 32px 0;
            border: 1px solid #E5E2DC;
            transition: all 0.3s ease;
        }
        .inquiry-card:hover {
            box-shadow: 0 8px 24px rgba(45, 58, 45, 0.08);
            transform: translateY(-2px);
        }
        .inquiry-card-title {
            margin: 0 0 20px 0;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #2D3A2D;
        }
        .detail-row {
            display: flex;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #E5E2DC;
        }
        .detail-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .detail-icon {
            width: 36px;
            height: 36px;
            background: #ffffff;
            border: 1px solid #E5E2DC;
            border-radius: 10px;
            text-align: center;
            line-height: 36px;
            margin-right: 14px;
            flex-shrink: 0;
            font-size: 16px;
        }
        .detail-content {
            flex: 1;
        }
        .detail-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9B5A46;
            margin: 0 0 4px 0;
        }
        .detail-value {
            font-size: 14.5px;
            color: #2D3A2D;
            font-weight: 700;
            margin: 0;
        }
        .message-container {
            margin-top: 20px;
        }
        .message-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9B5A46;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .message-box {
            font-size: 14px;
            color: #555552;
            line-height: 1.8;
            white-space: pre-wrap;
            background: #ffffff;
            border: 1px solid #E5E2DC;
            border-radius: 16px;
            padding: 20px;
        }
        .action-container {
            text-align: center;
            margin: 36px 0 16px 0;
        }
        .btn-reply {
            display: inline-block;
            background-color: #2D3A2D;
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 36px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 50px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(45, 58, 45, 0.15);
            transition: all 0.3s ease;
        }
        .btn-reply:hover {
            background-color: #3e4e3e;
            box-shadow: 0 6px 16px rgba(45, 58, 45, 0.25);
            transform: translateY(-2px);
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
        .timestamp {
            display: inline-block;
            background: #ffffff;
            border: 1px solid #E5E2DC;
            border-radius: 50px;
            padding: 6px 16px;
            font-size: 10px;
            font-weight: 700;
            color: #706F6C;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="logo">Veltrix<span>CRM</span></h2>
            <div class="subtitle">New Contact Inquiry</div>
        </div>
        <div class="content">
            <div class="timestamp">📬 Received {{ now()->format('M d, Y · h:i A') }}</div>
            
            <h1>New Inquiry Received</h1>
            <p>Hello Ramu Parasa,</p>
            <p>A visitor has submitted a contact inquiry through the VeltrixCRM landing page. Here are the full details of the submission:</p>
            
            <div class="inquiry-card">
                <h4 class="inquiry-card-title">✦ Inquiry Details</h4>
                
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #E5E2DC;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="50" valign="top">
                                <div class="detail-icon">👤</div>
                            </td>
                            <td valign="top">
                                <p class="detail-label">Inquirer Name</p>
                                <p class="detail-value">{{ $name }}</p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="margin-bottom: 0; padding-bottom: 0;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="50" valign="top">
                                <div class="detail-icon">✉️</div>
                            </td>
                            <td valign="top">
                                <p class="detail-label">Return Email Address</p>
                                <p class="detail-value">{{ $email }}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="message-container">
                <p class="message-label">💬 Message Content</p>
                <div class="message-box">{{ $messageBody }}</div>
            </div>

            <div class="action-container">
                <a href="mailto:{{ $email }}?subject=Re: VeltrixCRM Inquiry&body=Hello {{ $name }},%0A%0AThank you for contacting us.%0A%0A" class="btn-reply">Reply to Inquirer</a>
            </div>

            <p style="margin-bottom: 0; margin-top: 32px;">Warm regards,<br>The VeltrixCRM Automation System</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} VeltrixCRM Technologies. All rights reserved.</p>
            <p>This is an automated notification from VeltrixCRM. <a href="mailto:ramuparasa02@gmail.com">Contact Support</a></p>
        </div>
    </div>
</body>
</html>
