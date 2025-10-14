<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; font-size: 12px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h2>OUTFitr</h2>
        <p><strong>Invoice #{{ $order->order_number }}</strong></p>
    </div>

    <p><strong>Customer:</strong> {{ $order->user->name }}<br>
       <strong>Email:</strong> {{ $order->user->email }}<br>
       <strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}
    </p>

    <table>
        <thead>
            <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->name_snapshot }}</td>
                <td>{{ $item->quantity }}</td>
                <td>৳{{ number_format($item->price_snapshot, 2) }}</td>
                <td>৳{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align:right;margin-top:15px;">Grand Total: ৳{{ number_format($order->total_amount, 2) }}</h4>
</body>
</html>
