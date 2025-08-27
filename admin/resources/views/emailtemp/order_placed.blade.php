<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed</title>
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
        
          table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f4f4f4;
    }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Your Order Placed Successfully! </h2>
        </div>

        <div class="email-content">
            <p>Dear  {{ $name }},</p>

            <p> Thank you for shopping with us! We are pleased to confirm that your order has been successfully placed.</p>
            
            <p><b>Your order details are as follows:</b></p>
            <p>Order Number: {{$ordernumber}}</p>
            <p>Total Amount: {{$total_amount}}</p>
            
           

            
            <a href="https://evyapari.com/orderhistory" class="button">Track Your Order</a>
             

            <p>Thank you for shopping with Evyapari!</p>
        </div>

        <div class="footer">
              <p>e-Vyapari | VPO NADAUN, Distt. Hamirpur (HP) | evyapari@hotmail.com | +91 9817475121 </p>
        
        </div>
    </div>
</body>
</html>
