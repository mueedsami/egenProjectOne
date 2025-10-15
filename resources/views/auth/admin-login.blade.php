@extends('layouts.app')

@section('title', 'Admin Login — Deshio')

@section('content')
<section class="min-h-screen flex items-center justify-center bg-stone-50 py-16 px-6">
  <div class="w-full max-w-md bg-white border border-stone-100 shadow-xl rounded-2xl p-8">
    
    {{-- Header --}}
    <div class="text-center mb-8">
      <img src="{{ asset('template/images/deshio-logo.png') }}" alt="Deshio" class="mx-auto h-12 mb-3">
      <h2 class="text-2xl font-semibold text-stone-800">Admin Login</h2>
      <p class="text-stone-500 text-sm mt-1">Access the Deshio admin dashboard</p>
    </div>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
      @csrf

      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Email</label>
        <input type="email" name="email" required autofocus
               class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full border border-stone-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-red-500 focus:outline-none">
      </div>

      <button type="submit"
              class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded-md shadow-md transition">
        Login as Admin
      </button>

      {{-- Footer Links --}}
      <div class="text-center mt-6 space-y-2 text-sm">
        <p class="text-stone-600">
          Don’t have an admin account?
          <a href="{{ route('admin.register') }}" class="text-red-600 font-medium hover:underline">Register</a>
        </p>
        <p>
          <a href="{{ route('login') }}" class="text-stone-500 hover:text-red-600 transition">
            Login as User
          </a>
        </p>
      </div>
    </form>
  </div>
</section>
@endsection
