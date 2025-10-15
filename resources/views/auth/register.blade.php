@extends('layouts.app')

@section('title', 'User Registration — Deshio')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-stone-50 py-16 px-6">
  <div class="w-full max-w-md bg-white border border-stone-100 shadow-xl rounded-2xl p-8">
    
    {{-- Header --}}
    <div class="text-center mb-8">
      <img src="{{ asset('template/images/deshio-logo.png') }}" alt="Deshio" class="mx-auto h-12 mb-3">
      <h2 class="text-2xl font-semibold text-stone-800">User Registration</h2>
      <p class="text-stone-500 text-sm mt-1">Create your personal Deshio account</p>
    </div>

    {{-- Registration Form --}}
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
      @csrf

      {{-- Name --}}
      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Full Name</label>
        <input type="text" name="name" required autofocus
               class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none">
      </div>

      {{-- Email --}}
      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Email Address</label>
        <input type="email" name="email" required
               class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none">
      </div>

      {{-- Password --}}
      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none">
      </div>

      {{-- Confirm Password --}}
      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none">
      </div>

      {{-- Register Button --}}
      <button type="submit"
              class="w-full bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 rounded-md shadow-md transition">
        Register
      </button>

      {{-- Footer Links --}}
      <div class="text-center mt-6 space-y-2 text-sm">
        <p class="text-stone-600">
          Already have an account?
          <a href="{{ route('login') }}" class="text-amber-700 font-medium hover:underline">Login here</a>
        </p>
        <p>
          <a href="{{ route('admin.register') }}" class="text-stone-500 hover:text-amber-700 transition">
            Register as Admin
          </a>
        </p>
      </div>
    </form>
  </div>
</section>
@endsection
