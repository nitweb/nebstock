<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        .header {
            background: #1A1A1A;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
            line-height: 1.6;
            color: #333;
        }

        .content p {
            margin: 0 0 15px;
        }

        .btn {
            display: inline-block;
            background: #1A1A1A;
            color: #fff;
            padding: 12px 25px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            background: #f4f4f4;
            color: #777;
            font-size: 12px;
            text-align: center;
            padding: 15px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reset Your Password</h1>
        </div>
        <div class="content">
            <p>Hi,</p>
            <p>Click the button below to reset your password:</p>
            <p style="text-align:center;">
                <a href="{{ $url }}" class="btn">Reset Password</a>
            </p>
            <p>If you didn’t request this, simply ignore this email.</p>
            <p style="font-size:12px;color:#999;">This link will expire in 60 minutes.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>
</body>

</html>
