<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Like Notification</title>
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
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: auto;
    }
    .header {
      text-align: center;
      color: #4caf50;
      font-size: 24px;
      margin-bottom: 20px;
    }
    .content {
      font-size: 16px;
      color: #333333;
      line-height: 1.6;
    }
    .like-icon {
      font-size: 48px;
      color: #e91e63;
      text-align: center;
      margin: 20px 0;
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
    <div class="header">🎉 You’ve Got a New Like!</div>
    <div class="like-icon">❤️</div>
    <div class="content">
      <strong>{{ $userName }}</strong> just liked your post.<br>
      Click the link below to view your post:
      <br><br>
      <a href="http://127.0.0.1:8000/p/{{$postId}}" style="color: #4caf50; text-decoration: none;">View Post</a>
    </div>
    <div class="footer">
      This is an automated email. Please do not reply.
    </div>
  </div>
</body>
</html>
