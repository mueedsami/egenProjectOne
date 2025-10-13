@component('mail::message')
# Thanks for your order, {{ optional($order->user)->name ?? 'Customer' }}!

**Order:** {{ $order->order_number }}  
**Status:** {{ ucfirst($order->status) }}  
**Total:** {{ number_format($order->total_amount,2) }} ৳

@component('mail::panel')
@foreach($order->items as $item)
- {{ $item->name_snapshot }} × {{ $item->quantity }} — {{ number_format($item->total_price,2) }} ৳
@endforeach
@endcomponent

We’ll notify you when it ships.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
