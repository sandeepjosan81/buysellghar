<!--
// =============================
// Blade View
// =============================
-->
<!DOCTYPE html>
<html>
<head>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<form method="POST" action="{{ route('razorpay.pay') }}">
    @csrf
    <input type="number" name="amount" placeholder="Enter Amount" required>
    <button type="submit">Pay</button>
</form>

    @if(isset($order_id))
    <script>
        var options = {
            key: "{{ config('razorpay.key') }}",
            amount: "{{ $amount * 100 }}",
            currency: "INR",
            order_id: "{{ $order_id }}",
            handler: function (response){
                fetch("{{ route('razorpay.success') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(response)
                })
                .then((res) => {
                    console.log("Response from server:", res);
                    return res.text();
                })
                .then((data) => { 
                    console.log("Response from data:", data);
                    alert(data); 
                });
            }
        };
        console.log("Razorpay options:", options);
        var rzp = new Razorpay(options);

        // FAILURE HANDLER
        rzp.on('payment.failed', function (response){
            fetch("{{ route('razorpay.failed') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(response.error)
            })
            .then(res => res.text())
            .then(data => alert("Payment Failed"));
        });

        rzp.open();
    </script>
    @endif
</body>
</html>