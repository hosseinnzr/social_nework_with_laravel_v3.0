<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your One-Time Passcode</title>
  <style>
    body {
      font-family: Tahoma, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
      direction: ltr;
    }
    .email-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: auto;
    }
    .header {
      text-align: center;
      color: #2196f3;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .otp-code {
      font-size: 32px;
      font-weight: bold;
      color: #333333;
      text-align: center;
      margin: 20px 0;
      letter-spacing: 4px;
    }
    .content {
      font-size: 16px;
      color: #333333;
      line-height: 1.6;
      text-align: center;
    }
    .warning {
      margin-top: 30px;
      background-color: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
      padding: 15px;
      border-radius: 8px;
      font-size: 14px;
      text-align: left;
    }
    .footer {
      font-size: 12px;
      color: #888888;
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">🔐 Your Verification Code</div>
    <div class="content">
      Use the following code to complete your verification process.
    </div>
    <div class="otp-code">{{ $code }}</div>
    <div class="content">
      This code will expire in 10 minutes. Do not share it with anyone.
    </div>

    <div class="warning">
      ⚠️ <strong>Security Notice:</strong> Never forward this email or share your code with anyone. If you did not request this code, you can safely ignore this message. Your account is still secure.
    </div>

    <div class="footer">
      If you have any questions, please contact our support team.
    </div>
  </div>
</body>
</html>
