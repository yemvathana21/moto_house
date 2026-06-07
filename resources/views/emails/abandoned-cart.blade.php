<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;max-width:600px;margin:0 auto;padding:20px}table{border-collapse:collapse;width:100%}th,td{padding:8px 12px;text-align:left;border-bottom:1px solid #eee}</style></head>
<body>
    <h1 style="color:#ea580c;">Moto House</h1>
    <h2>You left something in your cart!</h2>
    <p>We noticed you left some items in your cart. They're waiting for you!</p>

    <table>
        <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
        <tbody>
            @foreach ($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px">
        <a href="{{ url('/cart') }}" style="background:#ea580c;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;display:inline-block">View Cart &amp; Checkout</a>
    </p>

    <p style="margin-top:20px;font-size:12px;color:#888;">&copy; {{ date('Y') }} Moto House. All rights reserved.</p>
</body>
</html>
