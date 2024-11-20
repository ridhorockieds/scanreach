<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .app-name {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin: 30px 0 10px 0;
        }

        .container {
            width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #3c8dbc;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            padding: 20px;
        }

        .content p {
            margin-bottom: 20px;
        }

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
        }

        .footer {
            background-color: #3c8dbc;
            color: #fff;
            padding: 5px;
            text-align: center;
            border-radius: 0 0 10px 10px;
        }

        p {
            line-height: 1;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        @media only screen and (max-width: 768px) {
            .container {
                width: 90%;
                margin: 20px auto;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 10px;
            }

            .otp-code {
                font-size: 22px;
            }
        }

        @media only screen and (max-width: 480px) {
            .container {
                width: 80%;
                margin: 10px auto;
            }

            .header h1 {
                font-size: 20px;
            }

            .content {
                padding: 5px;
            }

            .otp-code {
                font-size: 20px;
            }
        }

        @media only screen and (max-width: 320px) {
            .container {
                width: 70%;
                margin: 5px auto;
            }

            .header h1 {
                font-size: 16px;
            }

            .content {
                padding: 2px;
            }

            .otp-code {
                font-size: 18px;
            }
        }
    </style>
    </head>
    <body>

    {{-- app name --}}
    <div class="app-name">{{ config('app.name') }}</div>
    <div class="container">
        <div class="header">
            <h1>OTP Verification</h1>
        </div>
        <div class="content">
            <p>Hi, <strong>{{ $fullname }}</strong>! Thank you for registering with our service.</p>
            <p>Please use the following OTP code to verify your account:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>This OTP code will expire in 10 minutes.</p>
            <p>If you did not request this verification, please ignore this email.</p>
        </div>
        <div class="footer">
            <p> &copy; {{ date('Y') }} <strong><a href="{{ config('app.url') }}">{{ config('app.name') }}</a></strong>. All rights reserved.</p>
        </div>
    </div>

    </body>
</html>