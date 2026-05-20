<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to VeltrixCRM</title>
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
        .features-container {
            background-color: #F5F3EF;
            border-radius: 20px;
            padding: 24px;
            margin: 32px 0;
            border: 1px solid #E5E2DC;
        }
        .feature-item {
            margin-bottom: 20px;
        }
        .feature-item:last-child {
            margin-bottom: 0;
        }
        .feature-title {
            font-weight: 700;
            font-size: 14px;
            color: #2D3A2D;
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .feature-desc {
            font-size: 12.5px;
            color: #706F6C;
            margin: 0;
            padding-left: 20px;
        }
        .bullet {
            color: #9B5A46;
            font-weight: 900;
        }
        .cta-container {
            text-align: center;
            margin: 40px 0 32px 0;
        }
        .btn-cta {
            display: inline-block;
            background-color: #2D3A2D;
            color: #ffffff !important;
            text-decoration: none;
            padding: 16px 36px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 50px;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(45, 58, 45, 0.15);
            transition: all 0.3s ease;
        }
        .btn-cta:hover {
            background-color: #4A5D4E;
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
            <div class="subtitle">Presence Initialized</div>
        </div>
        <div class="content">
            <h1>Welcome to the Workspace</h1>
            <p>Hello {{ $user->name }},</p>
            <p>Your administrative presence has been successfully established on **VeltrixCRM**. We are thrilled to welcome you to a platform designed for ultimate clarity, dynamic control, and intelligent customer operations.</p>
            
            <div class="features-container">
                <p style="margin-top:0; font-weight:700; font-size:13px; text-transform:uppercase; letter-spacing:1px; color:#2D3A2D;">Core Capabilities Available Now</p>
                
                <div class="feature-item">
                    <h4 class="feature-title"><span class="bullet">✦</span> Operational Clarity</h4>
                    <p class="feature-desc">Dynamically track customer leads, pipelines, and activities in real-time on our streamlined responsive dashboard.</p>
                </div>
                
                <div class="feature-item">
                    <h4 class="feature-title"><span class="bullet">✦</span> High-Fidelity Access Roles</h4>
                    <p class="feature-desc">Role-based privileges are strictly enforced. Administrators enjoy complete clearance while Staff maintain structured access to customer leads.</p>
                </div>
                
                <div class="feature-item">
                    <h4 class="feature-title"><span class="bullet">✦</span> Intelligent Assistance</h4>
                    <p class="feature-desc">Consult with our built-in AI operational companion to instantly analyze logs and generate intelligent pipeline summaries.</p>
                </div>
            </div>

            <p>To access your newly established space and start optimizing customer relations, please select the button below:</p>

            <div class="cta-container">
                <a href="http://veltrix-crm-demo.test/login" class="btn-cta">Access Your Workspace</a>
            </div>

            <p style="margin-bottom: 0;">Best regards,<br>The VeltrixCRM Operations Team</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} VeltrixCRM. All rights reserved.</p>
            <p>Need support? Please contact our <a href="mailto:veltrixcrm@gmail.com">Security Operations Team</a>.</p>
        </div>
    </div>
</body>
</html>
