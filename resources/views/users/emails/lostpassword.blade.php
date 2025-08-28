<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <p>Hello,</p>
    <p>You have requested a password reset. Click the link below to reset your password:</p>
    <p><a href="{{ url('/reset-password?user_id=' . $userId) }}">Reset Password</a></p>
    <p>If you didn't request this, please ignore this email.</p>
</body>
</html>
