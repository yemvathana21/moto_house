<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;max-width:600px;margin:0 auto;padding:20px}table{border-collapse:collapse;width:100%}th,td{padding:8px 12px;text-align:left;border-bottom:1px solid #eee}</style></head>
<body>
    <h1 style="color:#ea580c;">Moto House</h1>
    <h2>Your Order Has Shipped!</h2>
    <p>Great news! Your order is on its way.</p>

    <table>
        <tr><th style="text-align:right">Order #</th><td>{{ $order->order_number }}</td></tr>
        <tr><th style="text-align:right">Shipping to</th><td>{{ $order->shipping_address }}, {{ $order->shipping_city }}</td></tr>
        <tr><th style="text-align:right">Status</th><td>{{ ucfirst($order->status) }}</td></tr>
    </table>

    <h3>Items</h3>
    <table>
        <thead><tr><th>Item</th><th>Qty</th></tr></thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr><td>{{ $item->product_name }}</td><td>{{ $item->quantity }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px">
        <a href="{{ url('/order/track?order_number=' . $order->order_number) }}" style="background:#ea580c;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;display:inline-block">Track Your Order</a>
    </p>

    <p style="margin-top:20px;font-size:12px;color:#888;">&copy; {{ date('Y') }} Moto House. All rights reserved.</p>
</body>
</html>
