@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-dark text-white p-3 rounded-end shadow-sm">
            <h4 class="text-center mb-4">Admin Panel</h4>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold text-warning' : '' }}">
                        <i class="fa fa-home me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.products.index') }}" class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'fw-bold text-warning' : '' }}">
                        <i class="fa fa-box me-2"></i> Manage Products
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('admin.products.create') }}" class="nav-link text-white">
                        <i class="fa fa-plus me-2"></i> Add New Product
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger w-100">
                            <i class="fa fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="fw-bold mb-4">Welcome, {{ Auth::user()->name }} 👋</h2>

            <div class="row g-3">
                <!-- Products Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fa fa-box fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">Products</h5>
                            <p class="card-text">Manage all products in the store.</p>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Add Product Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fa fa-plus-circle fa-2x text-success mb-3"></i>
                            <h5 class="card-title">Add Product</h5>
                            <p class="card-text">Add new products to your catalog.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">Add New</a>
                        </div>
                    </div>
                </div>

                <!-- Orders Card (future-ready) -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fa fa-shopping-cart fa-2x text-warning mb-3"></i>
                            <h5 class="card-title">Orders</h5>
                            <p class="card-text">View and manage customer orders.</p>
                            <a href="#" class="btn btn-warning btn-sm disabled">Coming Soon</a>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="mt-4">
                <h5 class="fw-bold mb-3">Quick Actions</h5>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">View Products</a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">Add Product</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
