
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<style>
    body {
        margin: 0;
        padding: 0;
        background: #f5f7fb;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 500px;
        margin: 80px auto;
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        text-align: center;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: #e6f9f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-icon svg {
        width: 40px;
        height: 40px;
        color: #28a745;
    }

    h1 {
        color: #28a745;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        font-size: 15px;
        margin-bottom: 20px;
    }

    .details {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        text-align: left;
    }

    .details p {
        margin: 5px 0;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #28a745;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn:hover {
        background: #218838;
    }
</style>

</head>
<body>

<div class="container">

<div class="success-icon">
    ✔
</div>

<h1>Payment Successful!</h1>

<p>Your payment has been completed successfully.</p>

<div class="details">
    <p><strong>Order ID:</strong> #{{ $number ?? 'N/A' }}</p>
    <p><strong>Amount Paid:</strong> ₹{{ $amount ?? '0.00' }}</p>
    <p><strong>Payment ID:</strong> {{ $gateway_payment_id ?? 'N/A' }}</p>
</div>

<a href="{{ url('/') }}" class="btn">Continue Shopping</a>


</div>

</body>
</html>


