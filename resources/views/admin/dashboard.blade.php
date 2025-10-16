@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="bg-stone-50 py-16 min-h-screen">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Welcome Header --}}
    <div class="mb-12">
      <h2 class="text-3xl font-bold text-stone-800 mb-2">👋 Welcome back, {{ Auth::user()->name }}</h2>
      <p class="text-stone-500">Here’s a quick overview of your store performance.</p>
    </div>

    {{-- Overview Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
      <div class="bg-amber-600 text-white rounded-2xl shadow p-6 text-center">
        <h3 class="text-3xl font-bold">{{ \App\Models\Product::count() }}</h3>
        <p class="text-sm opacity-90">Products</p>
      </div>
      <div class="bg-emerald-600 text-white rounded-2xl shadow p-6 text-center">
        <h3 class="text-3xl font-bold">{{ \App\Models\Category::count() }}</h3>
        <p class="text-sm opacity-90">Categories</p>
      </div>
      <div class="bg-sky-600 text-white rounded-2xl shadow p-6 text-center">
        <h3 class="text-3xl font-bold">{{ \App\Models\Brand::count() }}</h3>
        <p class="text-sm opacity-90">Brands</p>
      </div>
      <div class="bg-stone-800 text-white rounded-2xl shadow p-6 text-center">
        <h3 class="text-3xl font-bold">{{ \App\Models\User::count() }}</h3>
        <p class="text-sm opacity-90">Users</p>
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white border border-stone-200 rounded-xl shadow-sm p-8">
      <h3 class="text-lg font-semibold text-stone-800 mb-6">Quick Actions</h3>
      <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.products.create') }}"
           class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-md shadow transition">
          + Add New Product
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-md shadow transition">
          📦 Manage Products
        </a>
        <a href="{{ route('admin.dashboard') }}"
           class="bg-stone-700 hover:bg-stone-800 text-white px-6 py-2 rounded-md shadow transition">
          🔄 Refresh Dashboard
        </a>
      </div>
    </div>

  </div>
</section>
@endsection
