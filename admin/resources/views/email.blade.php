<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
            background-color: #d73d5c; /* Main color */
            color: white;
            padding: 15px;
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

        .order-details {
            margin-top: 20px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th, .order-details td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .order-details th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .order-details tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-summary {
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
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
            color: white;
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
        <!-- Header with logo and title -->
        <div class="email-header">
            <img src="https://evyapari.com/static/media/main-logo.cb4f161b219d4fc46c47b0cc6af56085.svg" alt="Logo">
            <h2>Order Confirmation</h2>
        </div>

        <!-- Email content -->
        <div class="email-content">
            <p>Hello {{ $name }},</p>

            <p>Thank you for your order! We are currently processing it and will notify you once it has been shipped.</p>

            <div class="order-details">
                <h3>Order Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

            <!-- Order summary -->
            <div class="order-summary">
                <p><strong>Total: 0</strong></p>
            </div>

            <a href="#" class="button">Track Your Order</a>

            <p>If you have any questions or concerns, feel free to reach out to us.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>e-Vyapari | VPO NADAUN, Distt. Hamirpur (HP) | evyapari@hotmail.com | +91 9817475121 </p>
            
        </div>
    </div>
</body>
</html>
