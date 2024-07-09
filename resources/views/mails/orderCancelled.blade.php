<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Created</title>
    <style>
        /* Reset styles for email consistency */
        body,
        p {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Wrapper styles */
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        /* Header styles */
        .header {
            background-color: #E08D79;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        /* Content styles */
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }

        /* Button styles */
        .button {
            display: inline-block;
            background-color: #E08D79;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <h2>Order Cancelled</h2>
        </div>
        <div class="content">
            <p>Hello {{ $customerName }},</p>
            <p>We inform you that your order has been cancelled.</p>
            <ul>
                <li><strong>Order Number:</strong> {{ $orderNumber }}</li>
            </ul>
            <p>Thank you for choosing our service.</p>
            <a href="{{ config('app.url') . "/orders" }}" class="button">View Order Details</a>
            <p>Best regards,<br>{{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>