@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="container py-5" style="max-width: 400px;">
    <h3 class="mb-4 text-center">Admin Login</h3>

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Login as Admin</button>

        <div class="text-center mt-3">
            <a href="{{ route('admin.register') }}">Register as Admin</a>
        </div>

        <div class="text-center mt-2">
            <a href="{{ route('login') }}">Login as User</a>
        </div>
    </form>
</div>
@endsection
