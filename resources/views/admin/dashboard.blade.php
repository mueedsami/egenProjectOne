@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">👋 Welcome back, {{ Auth::user()->name }}</h2>

    {{-- Overview Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-0">{{ \App\Models\Product::count() }}</h3>
                    <small>Products</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-0">{{ \App\Models\Category::count() }}</h3>
                    <small>Categories</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-0">{{ \App\Models\Brand::count() }}</h3>
                    <small>Brands</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-dark text-white">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-0">{{ \App\Models\User::count() }}</h3>
                    <small>Users</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-semibold">
            Quick Actions
        </div>
        <div class="card-body">
            <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary me-2">
                + Add New Product
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success me-2">
                📦 Manage Products
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">
                🔄 Refresh Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
