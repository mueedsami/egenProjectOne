@extends('layouts.app')

@section('title', 'User Login — Deshio')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-stone-50 py-16 px-6">
  <div class="w-full max-w-md bg-white border border-stone-100 shadow-xl rounded-2xl p-8">
    
    {{-- Header --}}
    <div class="text-center mb-8">
      <img src="{{ asset('template/images/deshio-logo.png') }}" alt="Deshio" class="mx-auto h-12 mb-3">
      <h2 class="text-2xl font-semibold text-stone-800">User Login</h2>
      <p class="text-stone-500 text-sm mt-1">Access your Deshio account securely</p>
    </div>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
      @csrf

      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
        <input type="email" name="email" class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none" required autofocus>
      </div>

      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
        <input type="password" name="password" class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none" required>
      </div>

      <button type="submit"
              class="w-full bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 rounded-md shadow-md transition">
        Login
      </button>

      <div class="text-center mt-6 space-y-2 text-sm">
        <p class="text-stone-600">
          Don’t have an account?
          <a href="{{ route('register') }}" class="text-amber-700 font-medium hover:underline">Register</a>
        </p>
        <p>
          <a href="{{ route('admin.login') }}" class="text-stone-500 hover:text-amber-700 transition">
            Login as Admin
          </a>
        </p>
      </div>
    </form>
  </div>
</section>
@endsection
