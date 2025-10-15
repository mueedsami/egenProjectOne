@extends('layouts.app')

@section('title', 'Checkout — Deshio')

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-5xl mx-auto px-6">
    {{-- Title --}}
    <h2 class="text-3xl font-semibold text-stone-900 mb-10 border-b border-stone-200 pb-4">
      🧾 Checkout
    </h2>

    {{-- Order Summary --}}
    <div class="bg-white rounded-xl shadow-sm border border-stone-200 mb-10 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-stone-100 text-stone-700 uppercase text-xs tracking-wider">
          <tr>
            <th class="py-3 px-6 text-left">Product</th>
            <th class="py-3 px-6 text-center">Quantity</th>
            <th class="py-3 px-6 text-center">Total</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-stone-100">
          @php $grandTotal = 0; @endphp
          @foreach($cart as $item)
            @php $grandTotal += $item['price'] * $item['quantity']; @endphp
            <tr class="hover:bg-stone-50 transition">
              <td class="py-4 px-6 font-medium text-stone-800">{{ $item['name'] }}</td>
              <td class="py-4 px-6 text-center text-stone-700">{{ $item['quantity'] }}</td>
              <td class="py-4 px-6 text-center font-semibold text-stone-900">
                ৳{{ number_format($item['price'] * $item['quantity'], 2) }}
              </td>
            </tr>
          @endforeach
          <tr class="bg-stone-100 font-semibold">
            <td colspan="2" class="py-4 px-6 text-right">Total:</td>
            <td class="py-4 px-6 text-center text-amber-700 text-lg font-bold">
              ৳{{ number_format($grandTotal, 2) }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    {{-- Checkout Form --}}
    <div class="bg-white rounded-xl shadow-sm border border-stone-200 p-8">
      <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}" class="space-y-8">
        @csrf

        {{-- Shipping Info --}}
        <div>
          <h3 class="text-xl font-semibold text-stone-900 mb-4">Shipping Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
              <input type="text" name="name" required
                     class="w-full border border-stone-300 rounded-md px-4 py-2 focus:border-amber-600 focus:ring-amber-600 focus:ring-1">
            </div>
            <div>
              <label class="block text-sm font-medium text-stone-700 mb-1">Phone Number</label>
              <input type="text" name="phone" required
                     class="w-full border border-stone-300 rounded-md px-4 py-2 focus:border-amber-600 focus:ring-amber-600 focus:ring-1">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-stone-700 mb-1">Shipping Address</label>
              <textarea name="address" rows="3" required
                        class="w-full border border-stone-300 rounded-md px-4 py-2 focus:border-amber-600 focus:ring-amber-600 focus:ring-1"></textarea>
            </div>
          </div>
        </div>

        {{-- Payment Section --}}
        <div>
          <h3 class="text-xl font-semibold text-stone-900 mb-4">Payment Method</h3>
          <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="payment_method" value="cod" checked class="accent-amber-600">
              <span class="text-stone-700 text-sm">Cash on Delivery</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="payment_method" value="online" class="accent-amber-600">
              <span class="text-stone-700 text-sm">Pay Online (SSLCommerz)</span>
            </label>
          </div>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-4 pt-4 border-t border-stone-100">
          <a href="{{ route('cart.index') }}"
             class="px-6 py-3 rounded-md border border-stone-300 text-stone-700 hover:bg-stone-100 transition">
            ← Back to Cart
          </a>

          <button id="placeOrderBtn" type="submit"
                  class="bg-amber-600 hover:bg-amber-700 text-white font-semibold px-8 py-3 rounded-md shadow-md transition">
            Complete Order
          </button>
        </div>
      </form>

      {{-- Hidden Payment Redirect Form --}}
      <form id="sslPayForm" method="POST" action="{{ route('pay') }}" class="hidden">
        @csrf
        <input type="hidden" name="amount" value="{{ $grandTotal }}">
      </form>
    </div>
  </div>
</section>

{{-- Script to handle payment method switch --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
  const checkoutForm = document.getElementById('checkoutForm');
  const sslPayForm = document.getElementById('sslPayForm');

  checkoutForm.addEventListener('submit', function(e) {
    const method = checkoutForm.querySelector('input[name="payment_method"]:checked').value;
    if (method === 'online') {
      e.preventDefault();
      sslPayForm.submit(); // 🔁 Redirects to SSLCommerz payment
    }
  });
});
</script>
@endsection
