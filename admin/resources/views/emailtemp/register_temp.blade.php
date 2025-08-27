<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Evyapari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            background-color: #d73d5c;
            color: white;
            padding: 10px;
            border-radius: 8px;
        }
        .email-header img {
            max-width: 150px;
            margin-bottom: 15px;
        }
        .email-content {
            margin-top: 20px;
            color: #333;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .button {
            background-color: #d73d5c;
            color: #fff !important;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #b02e4a;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <!--<img src="logo.svg" alt="Evyapari Logo">-->
            <h2>Welcome to Evyapari!</h2>
        </div>

        <div class="email-content">
            <p>Hello {{ $name }},</p>

            <p>Congratulations! You’ve successfully registered on the Evyapari portal. We're excited to have you on board.</p>

            <p>With your new account, you can now:</p>
            <ul>
                <li>Browse our products</li>
                <li>Track your orders</li>
                <li>Access exclusive offers</li>
                <li>Manage your account settings</li>
            </ul>

            <p>We look forward to helping you with your needs. If you have any questions or need assistance, feel free to reach out to our support team.</p>

            <a href="https://www.evyapari.com" class="button">Go to Your Dashboard</a>

            <p>Thank you for joining Evyapari!</p>
        </div>

        <div class="footer">
            <p>If you did not create this account, please contact us immediately.</p>
              <p>e-Vyapari | VPO NADAUN, Distt. Hamirpur (HP) | evyapari@hotmail.com | +91 9817475121 </p>
        
        </div>
    </div>
</body>
</html>
