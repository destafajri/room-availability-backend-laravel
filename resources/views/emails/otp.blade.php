<div>
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
</div>
<!-- resources/views/emails/otp.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
        }

        strong {
            color: #ff3366;
        }

        footer {
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">

        <h2>Your One-Time Password (OTP)</h2>

        <p>Dear {{ $name }},</p>

        <p>Your OTP for authentication is: <strong>{{ $otp }}</strong></p>

        <p>This OTP is valid for a short period. Please do not share it with anyone.</p>

        <p>If you did not request this OTP, please ignore this email.</p>

        <footer>
            Thank you,<br>
            Desta
        </footer>
    </div>
</body>

</html>
