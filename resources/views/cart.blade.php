@extends('layouts.app')

@section('title', 'Your Cart — Deshio')

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-3xl font-semibold text-stone-900 mb-10 border-b border-stone-200 pb-4">
      🛒 Your Cart
    </h2>

    {{-- Success Message --}}
    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-3 rounded-md">
        {{ session('success') }}
      </div>
    @endif

    {{-- Cart Items --}}
    @if(!empty($cart))
      <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-stone-200">
        <table class="min-w-full text-sm">
          <thead class="bg-stone-100 text-stone-700 uppercase text-xs tracking-wider">
            <tr>
              <th class="py-3 px-6 text-left">Product</th>
              <th class="py-3 px-6 text-center">Quantity</th>
              <th class="py-3 px-6 text-center">Price</th>
              <th class="py-3 px-6 text-center">Total</th>
              <th class="py-3 px-6 text-right">Remove</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-stone-100">
            @foreach($cart as $id => $item)
              <tr class="hover:bg-stone-50 transition">
                <td class="py-4 px-6 font-medium text-stone-800">
                  {{ $item['name'] }}
                </td>
                <td class="py-4 px-6 text-center text-stone-700">
                  {{ $item['quantity'] }}
                </td>
                <td class="py-4 px-6 text-center text-stone-700">
                  ৳{{ number_format($item['price'], 2) }}
                </td>
                <td class="py-4 px-6 text-center font-semibold text-stone-900">
                  ৳{{ number_format($item['price'] * $item['quantity'], 2) }}
                </td>
                <td class="py-4 px-6 text-right">
                  <a href="{{ route('cart.remove', $id) }}"
                     class="text-red-600 hover:text-red-800 font-medium text-sm">
                    <i class="fa fa-trash mr-1"></i> Remove
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Summary + CTA --}}
      <div class="mt-10 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ url('/shop') }}"
           class="text-stone-600 hover:text-amber-700 text-sm font-medium transition">
          ← Continue Shopping
        </a>

        <a href="{{ route('checkout.index') }}"
           class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-semibold px-8 py-3 rounded-md shadow-md transition">
          Proceed to Checkout
        </a>
      </div>
    @else
      {{-- Empty Cart View --}}
      <div class="text-center py-20">
        <img src="{{ asset('template/images/empty-cart.png') }}" class="w-48 mx-auto mb-6 opacity-80" alt="Empty Cart">
        <p class="text-stone-600 text-lg mb-6">Your cart is currently empty.</p>
        <a href="{{ url('/shop') }}"
           class="inline-block bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-md shadow-md transition font-medium">
          Start Shopping
        </a>
      </div>
    @endif
  </div>
</section>
@endsection
