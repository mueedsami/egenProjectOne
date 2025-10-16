@component('mail::message')
# Hello {{ $order->user->name ?? 'Customer' }} 👋

Thank you for shopping with **Deshio!**  
Your order has been successfully placed and is being processed.

---

### 🧾 Order Summary
**Order No:** {{ $order->order_number }}  
**Status:** {{ ucfirst($order->status) }}  
**Payment:** {{ ucfirst($order->payment_status) }}

@component('mail::table')
| Product | Quantity | Price |
|:--------|:---------:|------:|
@foreach($order->items as $item)
| {{ $item->name_snapshot }} | {{ $item->quantity }} | ৳{{ number_format($item->total_price, 2) }} |
@endforeach
@endcomponent

**Subtotal:** ৳{{ number_format($order->subtotal, 2) }}  
**Total:** ৳{{ number_format($order->total_amount, 2) }}

---

@component('mail::button', ['url' => url('/orders/'.$order->id)])
View Your Order
@endcomponent

We’ve also attached a copy of your **invoice PDF** for your records.  

Thanks again for supporting **local Bangladeshi fashion** 🇧🇩  
— *Team Deshio*

@endcomponent
