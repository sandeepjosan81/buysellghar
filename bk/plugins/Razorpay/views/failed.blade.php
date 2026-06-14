<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
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

    .fail-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: #fdecea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc3545;
        font-size: 40px;
        font-weight: bold;
    }

    h1 {
        color: #dc3545;
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
        margin: 5px;
        border-radius: 6px;
        text-decoration: none;
        color: #fff;
        transition: 0.3s;
    }

    .btn-retry {
        background: #dc3545;
    }

    .btn-retry:hover {
        background: #c82333;
    }

    .btn-home {
        background: #6c757d;
    }

    .btn-home:hover {
        background: #5a6268;
    }
</style>

</head>
<body>

<div class="container">

<div class="fail-icon">
    ✖
</div>

<h1>Payment Failed</h1>

<p>Unfortunately, your payment could not be processed.</p>

<div class="details">
    <p><strong>Order ID:</strong> #{{ $number ?? '12345' }}</p>
    <p><strong>Amount:</strong> ₹{{ $amount ?? '0.00' }}</p>
    <p><strong>Reason:</strong> {{ $error ?? 'Transaction declined or cancelled.' }}</p>
</div>

<a href="{{ url('/') }}" class="btn btn-home">Go to Home</a>

</div>

</body>
</html>
