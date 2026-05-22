<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;max-width:600px;margin:0 auto;padding:20px}table{border-collapse:collapse;width:100%}th,td{padding:8px 12px;text-align:left;border-bottom:1px solid #eee}</style></head>
<body>
    <h1 style="color:#ea580c;">Moto House</h1>
    <h2>Your Order Has Been Shipped!</h2>
    <p>Great news, {{ $order->customer->name }}! Your order is on its way.</p>

    <table>
        <tr><th style="text-align:right">Order #</th><td>{{ $order->order_number }}</td></tr>
        <tr><th style="text-align:right">Date</th><td>{{ $order->created_at->format('F d, Y') }}</td></tr>
        <tr><th style="text-align:right">Status</th><td>Shipped</td></tr>
        <tr><th style="text-align:right">Total</th><td>${{ number_format($order->total, 2) }}</td></tr>
    </table>

    <h3>Shipping Address</h3>
    <p>{{ $order->customer->name }}<br>
    {{ $order->shipping_address }}<br>
    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>

    <h3>Items</h3>
    <table>
        <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px">
        <a href="{{ url('/order/track?order_number=' . $order->order_number) }}" style="background:#ea580c;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;display:inline-block">Track Your Order</a>
    </p>

    <p style="margin-top:20px;font-size:12px;color:#888;">&copy; {{ date('Y') }} Moto House. All rights reserved.</p>
</body>
</html>
