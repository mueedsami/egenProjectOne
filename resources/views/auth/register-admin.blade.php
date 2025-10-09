@extends('layouts.app')

@section('title', 'Admin Registration')

@section('content')
<div class="container py-5" style="max-width: 400px;">
    <h3 class="mb-4 text-center">Admin Registration</h3>

    <form method="POST" action="{{ route('admin.register.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Register as Admin</button>

        <div class="text-center mt-3">
            <a href="{{ route('admin.login') }}">Already an Admin? Login</a>
        </div>

        <div class="text-center mt-2">
            <a href="{{ route('register') }}">Register as User</a>
        </div>
    </form>
</div>
@endsection
