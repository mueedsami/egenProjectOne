<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice — {{ $order->order_number }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 13px; }
    h2 { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f3f3f3; }
    .summary { text-align: right; margin-top: 20px; }
  </style>
</head>
<body>
  <h2>Deshio Order Invoice</h2>
  <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
  <p><strong>Customer:</strong> {{ $order->user->name ?? 'Customer' }}</p>
  <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>

  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price (৳)</th>
        <th>Total (৳)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->items as $item)
      <tr>
        <td>{{ $item->name_snapshot }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ number_format($item->price_snapshot, 2) }}</td>
        <td>{{ number_format($item->total_price, 2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="summary">
    <p><strong>Subtotal:</strong> ৳{{ number_format($order->subtotal, 2) }}</p>
    <p><strong>Total:</strong> ৳{{ number_format($order->total_amount, 2) }}</p>
  </div>

  <p style="text-align:center;margin-top:30px;">Thank you for shopping with Deshio!</p>
</body>
</html>
