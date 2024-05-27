<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission</title>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
        }

        .email-header {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .email-body {
            padding: 20px;
        }

        .email-footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>New Answer to support Request </h1>
        </div>
        <div class="email-body">
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Message:</strong>{{ $messageContent }}</p>

        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} CarHaven. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
