<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>

<body>
    <div class="header">
        <h1>Invoice</h1>

        <h2>Issuer</h2>
        <p><strong>RFC:</strong> {{ $issuer['rfc'] }}</p>
        <p><strong>Address:</strong> {{ $issuer['address'] }}</p>
        <p><strong>Email:</strong> {{ $issuer['email'] }}</p>
        <p><strong>Phone Number:</strong> {{ $issuer['phone_number'] }}</p>

        <h2>Receiver</h2>
        <p><strong>Invoice ID:</strong> {{ $receiver['invoice_id'] }}</p>
        <p><strong>RFC:</strong> {{ $receiver['rfc'] }}</p>
        <p><strong>Address:</strong> {{ $receiver['address'] }}</p>
        <p><strong>Phone Number:</strong> {{ $receiver['phone_number'] }}</p>
        <p><strong>Email:</strong> {{ $receiver['email'] }}</p>
        <p><strong>Name:</strong> {{ $receiver['name'] }}</p>
        <p><strong>Date:</strong> {{ $receiver['date'] }}</p>

        <h2>Items</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                @php
                $itemSubtotal = $item['stock']['product']['price'] * $item['quantity'];
                @endphp

                <tr>
                    <td>{{ $item['stock']['product']['name'] }}</td>
                    <td>{{ $item['stock']['product']['description'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['stock']['product']['price'], 2) }}</td>
                    <td>${{ number_format($itemSubtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="subtotal">Subtotal: ${{ number_format($subtotal, 2) }}</h3>
        <h3 class="iva">IVA (16%): ${{ number_format($iva, 2) }}</h3>
        <h3 class="total">Total: ${{ number_format($total, 2) }}</h3>

        <div class="footer">
            <p>Thank you for your purchase!</p>
        </div>
</body>

</html>
