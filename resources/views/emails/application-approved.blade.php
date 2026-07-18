<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Arial', sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: linear-gradient(135deg, #0066CC, #004999); padding: 30px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; }
        .header p { color: #b3d4ff; margin: 5px 0 0; font-size: 13px; }
        .body { padding: 30px; }
        .greeting { font-size: 16px; color: #333; margin-bottom: 20px; }
        .message { font-size: 14px; color: #555; line-height: 1.7; margin-bottom: 20px; }
        .credentials { background: #f0f7ff; border: 1px solid #cce0ff; border-radius: 10px; padding: 20px; margin: 20px 0; }
        .credentials h3 { margin: 0 0 12px; color: #0066CC; font-size: 15px; }
        .credential-row { display: flex; margin-bottom: 8px; font-size: 13px; }
        .credential-row .label { color: #666; width: 130px; font-weight: 600; }
        .credential-row .value { color: #333; font-family: monospace; font-size: 14px; }
        .warning { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 12px 16px; font-size: 13px; color: #92400e; margin: 20px 0; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #94a3b8; }
        .footer a { color: #0066CC; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SISTECH COLLEGE</h1>
            <p>"Connecting People to Technology"</p>
        </div>

        <div class="body">
            <div class="greeting">Dear {{ $studentName }},</div>

            <div class="message">
                We are pleased to inform you that your application to SISTECH College has been <strong style="color: #00B050;">approved</strong>!
                You have been admitted into the <strong>{{ $programme }}</strong> programme.
            </div>

            <div class="message">
                Below are your login credentials to access the SISTECH Student Portal:
            </div>

            <div class="credentials">
                <h3>Your Login Credentials</h3>
                <div class="credential-row">
                    <span class="label">Student ID:</span>
                    <span class="value">{{ $studentId }}</span>
                </div>
                <div class="credential-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $email }}</span>
                </div>
                <div class="credential-row">
                    <span class="label">Password:</span>
                    <span class="value">{{ $password }}</span>
                </div>
            </div>

            <div class="warning">
                <strong>Important:</strong> For your security, please change your password after your first login. You can do this from the student portal settings.
            </div>

            <div class="message">
                If you have any questions, please do not hesitate to contact the admissions office at <strong>sistech2025@gmail.com</strong> or call <strong>+232 77 893 327</strong>.
            </div>

            <div class="message">
                Welcome to SISTECH College!<br>
                <strong>The Admissions Team</strong>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} SISTECH College. All rights reserved.</p>
            <p>Freetown, Sierra Leone | <a href="https://sistech.website">sistech.website</a></p>
        </div>
    </div>
</body>
</html>
