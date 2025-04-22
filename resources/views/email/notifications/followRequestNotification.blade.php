<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Follow Request</title>
  <style>
    body {
      font-family: Tahoma, sans-serif;
      background-color: #b35252;
      padding: 20px;
      direction: ltr;
    }
    .email-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      max-width: 600px;
      margin: auto;
    }
    .header {
      text-align: center;
      color: #2196f3;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .content {
      text-align: center;
      font-size: 16px;
      color: #333333;
      line-height: 1.6;
    }
    .follow-request-icon {
      font-size: 48px;
      color: #2196f3;
      text-align: center;
      margin: 20px 0;
    }
    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }
    .button {
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 8px;
      font-size: 14px;
    }
    .button.reject {
      background-color: #f44336;
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
    <div class="header">🔔 New Follow Request!</div>
    <div class="follow-request-icon">👥</div>
    <div class="content">
      <strong>{{ $userName }}</strong> has requested to follow you.<br>
      You can approve or decline the request below
      <br>
      <a href="{{$APP_URL}}/notifications" style="color: #4caf50; text-decoration: none;">View Requeste</a>
    </div>
    
    <div class="footer">
      This is an automated email. Please do not reply.
    </div>
  </div>
</body>
</html>
