@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5 text-center">
    <h1>Welcome, {{ Auth::user()->name }} 👋</h1>
    <p class="mb-4">You are successfully logged in to your account.</p>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ url('/') }}" class="btn btn-outline-light">🏠 Back to Home</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">🚪 Logout</button>
        </form>
    </div>
</div>
@endsection
