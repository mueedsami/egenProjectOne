@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-3">
        <div class="card-header bg-dark text-white">
            Order #{{ $order->order_number }}
        </div>
        <div class="card-body">
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Total:</strong> ৳{{ number_format($order->total_amount, 2) }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <strong>Order Items</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->name_snapshot }}</td>
                        <td>৳{{ number_format($item->price_snapshot, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>৳{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
